<?php

include_once('inc/init.inc.php');

//Ouverture du fichier
$myfile = fopen("communes1.csv", "r") or die("Unable to open file!");
$maChaine = fread($myfile,filesize("communes1.csv"));

//On crée une liste, en creant un nouvel element a chaque oint virgule
$maListe = explode(";", $maChaine);
array_shift($maListe);
//echo $maChaine;
//echo count($maListe);
//echo '<pre>';
//print_r($maListe);
//echo '</pre>';
//fclose($myfile);

//On crée une liste qui contient toute les informations d'une ville'
$lesVilles = [];
$maPetiteListe = [];
for ($i=0; $i<count($maListe);$i++){
    if ($i%7 == 0){
//        Tout les 6 tours, j'ajoute le contenue de ma petite liste dans ma super liste
        array_push($lesVilles, $maPetiteListe);
        $maPetiteListe = [];
    }
//    A chaque tour, j'ajoute l'element a ma petite liste
    array_push($maPetiteListe, $maListe[$i]);
}
//array_shift($lesVilles);
//echo '<pre>';
//print_r($lesVilles);
//echo '</pre>';

//echo $lesVilles[2][1];

//On recupere ici la liste de toutes les regions
$listeRegions = [];
for ($i=2; $i<count($lesVilles);$i++){
    if (!empty($lesVilles[$i][1])){
        if (!in_array($lesVilles[$i][1], $listeRegions)){
    array_push($listeRegions, $lesVilles[$i][1]);  
        }
    }      
}


$tab = array();
$tab['reponseRequete'] = '';





if (isset($_POST['rechercher']) && isset($_POST['categorie']) && isset($_POST['region']) && isset($_POST['departement']) && isset($_POST['ville']) && isset($_POST['prixMin']) && isset($_POST['prixMax']) && isset($_POST['trie'])){
    //Pour le champs recherche
    $pourLaRecherche = "%" . $_POST['rechercher'] . '%';
    
    //Pour le champs categorie
    if ($_POST['categorie'] != 'toutes'){
        $pourLaCategorie = $_POST['categorie'];
    }else{
        $pourLaCategorie = '%';
    }
    
    //Calcul de la chaine de caractere a renvoyer pour la region
    $pourLaRegion = "(";
    foreach(cpEnFonctionDeRegion($_POST['region'], $lesVilles) as $leCp){
        $pourLaRegion .= $leCp . ',';
    }
//    Enleve le dernier élement de la chaine, et on ajoute la parenthese fermante
    $pourLaRegion = substr($pourLaRegion,0, strlen($pourLaRegion)-1);
    $pourLaRegion .= ')'; 
    
    
    //Calcul de la chaine de caractere a renvoyer pour le departement
        $pourLeDepartement = "(";
    foreach(cpEnFonctionDeDepartement($_POST['departement'], $lesVilles) as $leCp){
        $pourLeDepartement .= $leCp . ',';
    }
//    Enleve le dernier élement de la chaine, et on ajoute la parenthese fermante
    $pourLeDepartement = substr($pourLeDepartement,0, strlen($pourLeDepartement)-1);
    $pourLeDepartement .= ')';
    
    
//        Calcul de la chaine de caractere a renvoyer pour la ville
    if (!empty($_POST['ville'])){
        $pourLaVille = cpEnFonctionDeVille('Paris', $lesVilles)[0];
    }{
        $pourLaVille = '%';
    }
      
    
    //Pour le champs prix max
    
    if ($_POST['prixMax'] != 'Illimite'){
        $pourPrixMax = $_POST['prixMax'];
    }else{
        $pourPrixMax = 1000000;
    }
    
    if ($_POST['trie'] == 'parDateDesc' || empty($_POST['trie'])){
        $pourTrie = 'a.date_enregistrement DESC';
    }elseif($_POST['trie'] == 'parDateAsc'){
        $pourTrie = 'a.date_enregistrement ASC';    
    }elseif($_POST['trie'] == 'parPrixDesc'){
        $pourTrie = 'a.prix ASC';        
    }elseif($_POST['trie'] == 'parPrixAsc'){
        $pourTrie = 'a.prix DESC';        
    }elseif($_POST['trie'] == 'parVendeur'){
          $pourTrie = 'AVG(n.note) DESC';      
    }else{
        $pourTrie = 'a.date_enregistrement DESC';
        
    }
    $requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.photo, m.pseudo, AVG(n.note) as moyenneNote
                                            FROM annonce a
                                            LEFT JOIN membre m ON m.id_membre = a.membre_id
                                            LEFT JOIN note n ON n.membre_id2 = m.id_membre
                                            WHERE (a.titre LIKE :rechercher
                                            OR a.description_courte LIKE :rechercher
                                            OR a.description_longue LIKE :rechercher
                                            OR a.prix LIKE :rechercher
                                            OR a.pays LIKE :rechercher
                                            OR a.ville LIKE :rechercher
                                            OR a.adresse LIKE :rechercher
                                            OR a.cp LIKE :rechercher
                                            OR m.pseudo LIKE :rechercher
                                            OR m.nom LIKE :rechercher
                                            OR m.prenom LIKE :rechercher
                                            OR m.telephone LIKE :rechercher
                                            OR m.email LIKE :rechercher)
                                            AND a.categorie_id LIKE :categorie
                                            AND SUBSTRING(a.cp,1,2) IN " . $pourLaRegion . 
                                            " AND SUBSTRING(a.cp,1,2) IN " . $pourLeDepartement . 
                                            " AND a.cp LIKE :ville
                                            AND a.prix BETWEEN :prixMin AND :prixMax
                                            GROUP BY a.id_annonce
                                            ORDER BY " . $pourTrie);

    

    
    
    
	$requeteAffichage->bindParam(':rechercher', $pourLaRecherche, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':categorie', $pourLaCategorie, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':ville', $pourLaVille, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':prixMin', $_POST['prixMin'], PDO::PARAM_STR);
	$requeteAffichage->bindParam(':prixMax', $pourPrixMax, PDO::PARAM_STR);
	$requeteAffichage->execute();
    
//Si il existe au moins une requete qui corresponds a la demande, c'est cool et on affiche les annocnes, sinon on envoie un message
    if($requeteAffichage->rowCount() > 0) {
        
        $requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach($requeteAffichage as $laLigne){
            $tab['reponseRequete'] .= '<div class="blocRequete row no-gutters bg-light position-relative mx-auto">
                            <div class="col-md-6 mb-md-0 p-md-4">
                                <a href="' . URL . 'annonce?id_annonce=' . $laLigne['id_annonce'] . '"><img src="' . $laLigne['photo'] . '" class="w-100 img-fluid" alt="..."></a>' . 
                            '</div>
                            <div class="col-md-6 texte position-relative p-0 pl-md-0">
                                <h5 class="mt-0 p-0 pt-3 text-center text-md-left">' . ucfirst($laLigne['titre']) . '</h5>
                                <p class="p-0 text-center text-md-left w-100 mx-auto">' . ucfirst($laLigne['description_courte']) . '</p>
                                <div class="footerAnnonce row mx-auto w-100 pb-4 mb-2 pr-3">' . 
                                    '<span class="d-inline-block col-md-6 m-0 p-0 pb-1 text-center text-md-left">' . ucfirst($laLigne['pseudo']) . ': ' . round($laLigne['moyenneNote'],1) . '/5</span>
                                    <span class="d-inline-block m-0 p-0 pb-1 col-md-6 text-center text-md-right">' . $laLigne['prix'] . ' <i class="fas fa-euro-sign"></i></span>' .                                    
                                '</div>
                            </div>
                         </div>';
        }

                    
	}
    else{
        $tab['reponseRequete'] = '<div class="alert alert-info mt-2" role="alert">La recherche que vous avez effectué ne présente pas de correspondance.';
    }
//
}

echo json_encode($tab);




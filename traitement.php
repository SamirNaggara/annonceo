<?php

include_once('inc/init.inc.php');
    
    //*****************************************************
    //Recupération et exploitation de la liste des communes
    //*****************************************************


//Ouverture du fichier
$myfile = fopen("communes1.csv", "r") or die("Unable to open file!");
$maChaine = fread($myfile,filesize("communes1.csv"));

//On crée une liste, en creant un nouvel element a chaque point virgule
$maListe = explode(";", $maChaine);
array_shift($maListe);


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


//On recupere ici la liste de toutes les regions
$listeRegions = [];
for ($i=2; $i<count($lesVilles);$i++){
    if (!empty($lesVilles[$i][1])){
        if (!in_array($lesVilles[$i][1], $listeRegions)){
    array_push($listeRegions, $lesVilles[$i][1]);  
        }
    }      
}

//DEMARRAGE DU TRAIEMENT AJAX


$tab = array();
$tab['reponseRequete'] = '';
$tab['test'] = '';

//Si chacun des champs POST existe, on fait le traitement de chaque parameter pour les préparer pour la requete, et ensuite on effectue la requete
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
        
        $pourLaVille = cpEnFonctionDeVille($_POST['ville'], $lesVilles)[0];
        if(strlen($pourLaVille)>5){
            //Dans certaines ville, il y a plusieurs codes postals. Il faudrais les decouper, mais pour le moment cette solution permet de tout afficher si on se retrouve dans un de ces cas, plutot que de ne rien afficher du tout
            $pourLaVille = '%';
        }
    }else{
        $pourLaVille = '%';
    }
    $tab['test'] .= $_POST['ville'];
    $tab['test'] .= $pourLaVille;
    
    //Pour le champs prix max
    
    if ($_POST['prixMax'] != ''){
        $pourPrixMax = $_POST['prixMax'];
    }else{
        $pourPrixMax = 1000000;
    }
    
    //Pour la gestion du boutton radio "trie"
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
//  ***********************************
//  La requette d'affichage des annonces
//  ***********************************
$perPage = 5;
$req = $pdo->query("SELECT COUNT(*) AS total FROM annonce");
$result = $req->fetch(PDO::FETCH_ASSOC);
$total = $result['total'];
$nbPage = ceil($total/$perPage);
if(isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']) == 1) {
    if($_GET['page'] > $nbPage) {
        $current = $nbPage;
    } else {
        $current = $_GET['page'];
    }
} else {
    $current = 1;
}
$firstOfPage = ($current-1)*$perPage;
    $requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.ville, a.photo, m.pseudo, AVG(n.note) as moyenneNote
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
                                            AND SUBSTRING(a.cp,1,2) IN " . htmlspecialchars($pourLaRegion) . 
                                            " AND SUBSTRING(a.cp,1,2) IN " . htmlspecialchars($pourLeDepartement) . 
                                            " AND a.cp LIKE :ville
                                            AND a.prix BETWEEN :prixMin AND :prixMax
                                            GROUP BY a.id_annonce
                                            ORDER BY " . $pourTrie .
                                            " LIMIT $firstOfPage, $perPage");

	$requeteAffichage->bindParam(':rechercher', $pourLaRecherche, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':categorie', $pourLaCategorie, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':ville', $pourLaVille, PDO::PARAM_STR);
	$requeteAffichage->bindParam(':prixMin', $_POST['prixMin'], PDO::PARAM_STR);
	$requeteAffichage->bindParam(':prixMax', $pourPrixMax, PDO::PARAM_STR);
	$requeteAffichage->execute();
    
    //Si il existe au moins une requete qui corresponds a la demande, c'est cool et on affiche les annonces, sinon on envoie un message
    if($requeteAffichage->rowCount() > 0) {
        
        $requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);
//        Affichage de chacune des annonces


        foreach($requeteAffichage as $laLigne){
            if($laLigne['moyenneNote'] == '') {
                $maMoyenne = 'Aucune note' ;
            }   
            if($laLigne['moyenneNote'] >= '0') {
                $maMoyenne = 'Notes : '. round($laLigne['moyenneNote'],1).'/5';
            }
            $tab['reponseRequete'] .= '<div class="blocRequete no-gutters bg-light col-sm-10 mx-auto col-12 mb-4 shadow">
                                            <div class="row">
                                                <div class="col-md-4 imgAnnonce">
                                                    <a href="' . URL . 'annonce.php?id_annonce=' . $laLigne['id_annonce'] . '">
                                                        <div class="picture">
                                                            <img src="' . $laLigne['photo'] . '" class="py-1 d-block" alt="photo annonceo">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-8 textAnnonce">
                                                    <div class="headerAnnonce mx-auto w-100 mb-2 d-flex ">'.
                                                        '<span><i class="fas fa-map-marker-alt"></i> '. ucfirst($laLigne['ville']).'</span>
                                                        <span class="vendeurAnnonce"><i class="far fa-user"></i> '. ucfirst($laLigne['pseudo']).'</span>
                                                        <span class="note">'. $maMoyenne .'</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8 mt-2">     
                                                            <h5 class="colorLetter">' . ucfirst($laLigne['titre']) . 
                                                        '</h5>
                                                        <p class="descAnnonces">' . ucfirst($laLigne['description_courte']) . '</p>
                                                    </div>
                                                    <div class="col-lg-4 mt-2 d-flex flex-column">
                                                        <p class="euroText text-right">'. $laLigne['prix'].' <i class="fas fa-euro-sign"></i></p>
                                                        <a href="'. URL.'annonce.php?id_annonce='.$laLigne['id_annonce'].'" class="btn btn-outline-dark">Voir l\'annonce</a>'.         
                                                    '</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>';
        }       
	}
    else{
        $tab['reponseRequete'] = '<div class="alert alert-info mt-2" role="alert">La recherche que vous avez effectué ne présente pas de correspondance.';
    }
}
//Encode et renvoie du resultat
echo json_encode($tab);




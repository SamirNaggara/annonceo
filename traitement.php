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
$tab['afficher'] = '';
$tab['reponseRequete'] = '';

if (isset($_POST['rechercher'])){
    $tab['afficher'] .= $_POST['rechercher'];
}
if (isset($_POST['categorie'])){
    $tab['afficher'] .= $_POST['categorie'];
}

if (isset($_POST['region'])){
    $tab['afficher'] .= $_POST['region'];
}

if (isset($_POST['departement'])){
    $tab['afficher'] .= $_POST['departement'];
}

if (isset($_POST['ville'])){
    $tab['afficher'] .= $_POST['ville'];
}

if (isset($_POST['prixMin'])){
    $tab['afficher'] .= $_POST['prixMin'];
}

if (isset($_POST['prixMax'])){
    $tab['afficher'] .= $_POST['prixMax'];
}

if (isset($_POST['trie'])){
    $tab['afficher'] .= $_POST['trie'];
}



if (isset($_POST['rechercher']) && isset($_POST['categorie']) && isset($_POST['region']) && isset($_POST['departement']) && isset($_POST['ville']) && isset($_POST['prixMin']) && isset($_POST['prixMax']) && isset($_POST['trie'])){
    $requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.photo, m.pseudo, AVG(n.note) as moyenneNote
                                            FROM annonce a
                                            LEFT JOIN membre m ON m.id_membre = a.membre_id
                                            LEFT JOIN note n ON n.membre_id2 = m.id_membre
                                            WHERE a.titre LIKE :rechercher
                                            GROUP BY a.id_annonce
                                            ORDER BY a.date_enregistrement DESC");
    $pourLaRecherche = "%" . $_POST['rechercher'] . '%';
	$requeteAffichage->bindParam(':rechercher', $pourLaRecherche, PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':categorie', $_POST['categorie'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':region', $_POST['region'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':departement', $_POST['departement'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':prixMin', $_POST['prixMin'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':prixMax', $_POST['prixMax'], PDO::PARAM_STR);
//	$requeteAffichage->bindParam(':trie', $_POST['trie'], PDO::PARAM_STR);
	$requeteAffichage->execute();
//    
//    //Si il existe au moins une requete qui corresponds a la demande, c'est cool et on affiche les annocnes, sinon on envoie un message
    if($requeteAffichage->rowCount() > 0) {
        
        $requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);
        
//        $tab['reponseRequete'] = '<div class="alert alert-success mt-2" role="alert">La recherche fonctionne.' . $requeteAffichage['prix'];
        foreach($requeteAffichage as $laLigne){
            $tab['reponseRequete'] .= '<div class="blocRequete row no-gutters bg-light position-relative mx-auto">
                            <div class="col-md-6 mb-md-0 p-md-4">
                                <a href="' . URL . 'annonce?id_annonce=' . $laLigne['id_annonce'] . '"><img src="' . $laLigne['photo'] . '" class="w-100 img-fluid" alt="..."></a>' . 
                            '</div>
                            <div class="col-md-6 texte position-relative p-0 pl-md-0">
                                <h5 class="mt-0 p-3 text-center text-md-left">' . ucfirst($laLigne['titre']) . '</h5>
                                <p class="p-3 text-center text-md-left w-100 mx-auto">' . ucfirst($laLigne['description_courte']) . '</p>
                                <div class="footerAnnonce row mx-auto w-100 p-3 mb-2">' . 
                                    '<span class="d-inline-block col-md-6 m-0 p-2 text-center text-md-left">' . ucfirst($laLigne['pseudo']) . ': ' . round($laLigne['moyenneNote'],1) . '/5</span>
                                    <span class="d-inline-block m-0 p-2 col-md-6 text-center text-md-right">' . $laLigne['prix'] . ' <i class="fas fa-euro-sign"></i></span>' .                                    
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




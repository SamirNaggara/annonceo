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

$tab['listeAutocompletion'] = [];
if (isset($_POST['premieresLettres']) && !empty($_POST['premieresLettres'])){
    $tab['afficher'] .= $_POST['premieresLettres'];

//    ------------------------REQUETE POUR LES TITRES--------------------
    $premieresLettres = '%' . $_POST['premieresLettres'] . '%';
    $requeteTitre = $pdo->prepare(" SELECT
                                            a.titre
                                        FROM
                                            annonce a
                                        WHERE
                                            a.titre LIKE :premieresLettres
                                            limit 5");
    $requeteTitre->bindParam(':premieresLettres', $premieresLettres, PDO::PARAM_STR);
    $requeteTitre->execute();
    
    if($requeteTitre->rowCount() > 0) {
        $requeteTitre = $requeteTitre -> fetchAll(PDO::FETCH_ASSOC);
        foreach($requeteTitre as $laLigne){
            array_push($tab['listeAutocompletion'], $laLigne['titre']);
        }
    }
            $nombreLimit = 10 - count($tab['listeAutocompletion']);
        array_push($tab['listeAutocompletion'], $nombreLimit);
//    -----------------------------REQUETE POUR LE PSEUDO-----------------------------
    if (count($tab['listeAutocompletion']) <10){

        $requetePseudo = $pdo->prepare("SELECT
                                            m.pseudo
                                        FROM
                                            membre m
                                        LEFT JOIN annonce a ON
                                            m.id_membre = a.membre_id
                                        WHERE
                                            m.pseudo LIKE :premieresLettres
                                        GROUP BY m.pseudo
                                        LIMIT 5");
        
        $requetePseudo->bindParam(':premieresLettres', $premieresLettres, PDO::PARAM_STR);
//        $requetePseudo->bindParam(':nombreLimit', $nombreLimit, PDO::PARAM_STR);
        $requetePseudo->execute();
        
        if($requetePseudo->rowCount() > 0) {
            $requetePseudo = $requetePseudo -> fetchAll(PDO::FETCH_ASSOC);
            foreach($requetePseudo as $laLigne){
                array_push($tab['listeAutocompletion'], $laLigne['pseudo']);
            }
        }
    }
}

//    $requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.photo, m.pseudo, AVG(n.note) as moyenneNote
//                                            FROM annonce a
//                                            LEFT JOIN membre m ON m.id_membre = a.membre_id
//                                            LEFT JOIN note n ON n.membre_id2 = m.id_membre
//                                            WHERE (a.titre LIKE :rechercher
//                                            OR a.description_courte LIKE :rechercher
//                                            OR a.description_longue LIKE :rechercher
//                                            OR a.prix LIKE :rechercher
//                                            OR a.pays LIKE :rechercher
//                                            OR a.ville LIKE :rechercher
//                                            OR a.adresse LIKE :rechercher
//                                            OR a.cp LIKE :rechercher
//                                            OR m.pseudo LIKE :rechercher
//                                            OR m.nom LIKE :rechercher
//                                            OR m.prenom LIKE :rechercher
//                                            OR m.telephone LIKE :rechercher
//                                            OR m.email LIKE :rechercher)
//                                            AND a.categorie_id LIKE :categorie
//                                            AND SUBSTRING(a.cp,1,2) IN " . $pourLaRegion . 
//                                            " AND SUBSTRING(a.cp,1,2) IN " . $pourLeDepartement . 
//                                            " AND a.cp LIKE :ville
//                                            AND a.prix BETWEEN :prixMin AND :prixMax
//                                            GROUP BY a.id_annonce
//                                            ORDER BY " . $pourTrie);

//	$requeteAffichage->bindParam(':rechercher', $pourLaRecherche, PDO::PARAM_STR);
//	$requeteAffichage->execute();
//    if($requeteAffichage->rowCount() > 0) {};
//        $requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);
        
echo json_encode($tab);




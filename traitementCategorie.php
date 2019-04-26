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


if (isset($_POST['categorie'])){
    $tab['afficher'] .= $_POST['categorie'];       
}



echo json_encode($tab);




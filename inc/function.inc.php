<?php
// Renvoie true si un utilisateur est connecter, false sion
function user_is_connected() {
	if(isset($_SESSION['utilisateur'])) {
		return true;
	}
	return false;
}

function user_is_admin() {
	if(user_is_connected() && $_SESSION['utilisateur']['statut'] == 2) {
		return true;
	}
	return false;
}

function jourDeLaSemaine($dateFormatSql){
    // Renvoie le nom du jour en fonction de la date format SQL
    
    $listeJour = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
    
    $jourNombre = date("n", strtotime($dateFormatSql));
    return $listeJour[$jourNombre];
    
    
}

function numeroDuMois($dateFormatSql){
    
    $numeroMois = date("j", strtotime($dateFormatSql));
    return $numeroMois;
}

function mois($dateFormatSql){
    $listeMois = ["janvier","fevrier","Mars","Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
    $numeroMois = date("n", strtotime($dateFormatSql));
    return $listeMois[$numeroMois];
}

function annee($dateFormatSql){
    
    $annee = date("Y", strtotime($dateFormatSql));
    return $annee;
}

function heure($dateFormatSql){
    
    $heure = date("G", strtotime($dateFormatSql));
    return $heure;
}

function minute($dateFormatSql){
    
    $minute = date("i", strtotime($dateFormatSql));
    return $minute;
}

function formatStandardTotal($dateFormatSql){
    return numeroDuMois($dateFormatSql) . " " . mois($dateFormatSql) . " " . annee($dateFormatSql) . " - " . heure($dateFormatSql) . ":" . minute($dateFormatSql);
}

function checkInput ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
<?php
// Renvoie true si un utilisateur est connecter, false sion
function user_is_connected() {
	if(isset($_SESSION['utilisateur']['statut'])) {
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
function isEmail($data) {
    return filter_var($data, FILTER_VALIDATE_EMAIL);
}
// regex contenant les caractères autorisé dans nos champs
function nickName($data) {
    return preg_match('#^[a-zA-Z0-9._-]+$#', $data);
}

function departements($region, $lesVilles){
//    Renvoie la liste des depatements de la region rentré en premiere argument, dans la liste $lesVilles rentré en deuxieme arguments
    $listeDepartements = [];
    for ($i=2; $i<count($lesVilles);$i++){
        if ((!empty($lesVilles[$i][2]) && $lesVilles[$i][1] == $region) || $region == 'toutes'){
            if (!in_array($lesVilles[$i][2], $listeDepartements)){
                array_push($listeDepartements, $lesVilles[$i][2]);  
            }
        }      
    }
    sort($listeDepartements);
    return $listeDepartements;
}

function villes($departement, $lesVilles){
//    Renvoie la liste des depatements de la region rentré en premiere argument, dans la liste $lesVilles rentré en deuxieme arguments
    $listeVilles = [];
    for ($i=2; $i<count($lesVilles);$i++){
        if ((!empty($lesVilles[$i][3]) && $lesVilles[$i][2] == $departement) || $departement == 'toutes'){
            if (!in_array($lesVilles[$i][3], $listeVilles)){
                array_push($listeVilles, $lesVilles[$i][3]);  
            }
        }      
    }
    sort($listeVilles);
    return $listeVilles;
}

//J'ai besoin d'un fonction ou je donne une regions, et il me sors la liste de tout les codes postaux correspondant
    
function cpEnFonctionDeRegion($region, $lesVilles){
    $listeVilles = [];

    for ($i=2; $i<count($lesVilles);$i++){
        if ((!empty($lesVilles[$i][4]) && $lesVilles[$i][1] == $region) || $region == 'toutes'){
            //Si les
            if (strlen(trim($lesVilles[$i][4])) >= 5){
                $cpSansEspace=substr(str_replace(' ','',$lesVilles[$i][4]),0,2);
            }else{
                $cpSansEspace=substr(str_replace(' ','',$lesVilles[$i][4]),0,1);
            }
            
            if (!in_array($cpSansEspace, $listeVilles)){
                array_push($listeVilles,$cpSansEspace);  
            }
        }
    }
    return $listeVilles;
    
}

//J'ai besoin d'un fonction ou je donne un departement, et il me sors la liste de tout les codes postaux correspondant
    
function cpEnFonctionDeDepartement($departement, $lesVilles){
    $listeVilles = [];

    for ($i=2; $i<count($lesVilles);$i++){
        if ((!empty($lesVilles[$i][4]) && $lesVilles[$i][2] == $departement) || $departement == 'toutes'){
            if (strlen(trim($lesVilles[$i][4])) >= 5){
                $cpSansEspace=substr(str_replace(' ','',$lesVilles[$i][4]),0,2);
            }else{
                $cpSansEspace=substr(str_replace(' ','',$lesVilles[$i][4]),0,1);
            }
            if (!in_array($cpSansEspace, $listeVilles)){
                array_push($listeVilles,$cpSansEspace);  
            }
        }
    }
    return $listeVilles;
}
   
//J'ai besoin d'un fonction ou je donne une ville, et il me sors le code postal entier
    
function cpEnFonctionDeVille($ville, $lesVilles){
    $listeVilles = [];

    for ($i=2; $i<count($lesVilles);$i++){
        if ((!empty($lesVilles[$i][4]) && $lesVilles[$i][3] == $ville) || $ville == 'toutes'){
            if (strlen(trim($lesVilles[$i][4])) >= 5){
                $cpSansEspace=str_replace(' ','',$lesVilles[$i][4]);
            }else{
                $cpSansEspace=str_replace(' ','',$lesVilles[$i][4]);
            }
            if (!in_array($cpSansEspace, $listeVilles)){
                array_push($listeVilles,$cpSansEspace);  
            }
        }
    }
    return $listeVilles;
}

/**
* La fonction darkroom() renomme et redimensionne les photos envoyées lors de l'ajout d'un objet.
* @param $img String Chemin absolu de l'image d'origine.
* @param $to String Chemin absolu de l'image générée (.jpg).
* @param $width Int Largeur de l'image générée. Si 0, valeur calculée en fonction de $height.
* @param $height Int Hauteur de l'image génétée. Si 0, valeur calculée en fonction de $width.
* Si $height = 0 et $width = 0, dimensions conservées mais conversion en .jpg
*/
//function darkroom($img, $to, $width = 0, $height = 0, $useGD = TRUE){
// 
//	$dimensions = getimagesize($img);
//	$ratio      = $dimensions[0] / $dimensions[1];
// 
//	// Calcul des dimensions si 0 passé en paramètre
//	if($width == 0 && $height == 0){
//		$width = $dimensions[0];
//		$height = $dimensions[1];
//	}elseif($height == 0){
//		$height = round($width / $ratio);
//	}elseif ($width == 0){
//		$width = round($height * $ratio);
//	}
// 
//	if($dimensions[0] > ($width / $height) * $dimensions[1]){
//		$dimY = $height;
//		$dimX = round($height * $dimensions[0] / $dimensions[1]);
//		$decalX = ($dimX - $width) / 2;
//		$decalY = 0;
//	}
//	if($dimensions[0] < ($width / $height) * $dimensions[1]){
//		$dimX = $width;
//		$dimY = round($width * $dimensions[1] / $dimensions[0]);
//		$decalY = ($dimY - $height) / 2;
//		$decalX = 0;
//	}
//	if($dimensions[0] == ($width / $height) * $dimensions[1]){
//		$dimX = $width;
//		$dimY = $height;
//		$decalX = 0;
//		$decalY = 0;
//	}
// 
//	// Création de l'image avec la librairie GD
//	if($useGD){
//		$pattern = imagecreatetruecolor($width, $height);
//		$type = mime_content_type($img);
//		switch (substr($type, 6)) {
//			case 'jpeg':
//				$image = imagecreatefromjpeg($img);
//				break;
//			case 'gif':
//				$image = imagecreatefromgif($img);
//				break;
//			case 'png':
//				$image = imagecreatefrompng($img);
//				break;
//		}
//		imagecopyresampled($pattern, $image, 0, 0, 0, 0, $dimX, $dimY, $dimensions[0], $dimensions[1]);
//		imagedestroy($image);
//		imagejpeg($pattern, $to, 100);
// 
//		return TRUE;
// 
//        // Création de l'image avec ImageMagick
//	}else{
//		$cmd = '/usr/bin/convert -resize '.$dimX.'x'.$dimY.' "'.$img.'" "'.$dest.'"';
//       		shell_exec($cmd);
// 
//       		$cmd = '/usr/bin/convert -gravity Center -quality '.self::$quality.' -crop '.$largeur.'x'.$hauteur.'+0+0 -page '.$largeur.'x'.$hauteur.' "'.$dest.'" "'.$dest.'"';
//            		shell_exec($cmd);	
//	}
//	return TRUE;
/*}*/




















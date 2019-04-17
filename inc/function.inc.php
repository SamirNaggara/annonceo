<?php
// fonction pour savoir si l'utilisateur est connecte
function user_is_connected() {
	if(isset($_SESSION['utilisateur'])) {
		return true;
	}
	return false;
}

function checkInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    } 

// /*function ajouterMessage($genre) {
//     $reponse = "";
//     if(isset($_SESSION['inscription_ok'])) {
//         $reponse = '<div class="alert alert-'. $genre .' mt-2" role="alert">'. $_SESSION['inscription_ok'] .'</div>';
//         unset($_SESSION['inscription_ok']);
//     }
//     return $reponse;
//     }
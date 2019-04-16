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

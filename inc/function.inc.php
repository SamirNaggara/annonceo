<?php
// fonction pour savoir si l'utilisateur est connecte
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


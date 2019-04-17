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


function calculMoyenneNote($id_membre){
    //Retourne la moyenne de toutes les notes qui ont été déposées à un vendeur"
        
        //On recupere les informations sur les notes
        $infosNotes = $pdo->prepare("SELECT note FROM note WHERE membre_id2 = :id_membre");
        $infosNotes->bindParam(':id_membre', $id_membre, PDO::PARAM_STR);
        $infosNotes->execute();
        
    //On parcours toute les notes, on calcule la sommes de toutes les notes dans la variables $notes, on increment un compteur qui compte le nombre de notes, et le resultat est la division des deux
        foreach($infosNotes as $uneNote){
            $notes += $uneNote["note"];
            $compteur += 1;
        }
    
        $resultat = round($notes/$compteur, 1);
    
    return $resultat;
}
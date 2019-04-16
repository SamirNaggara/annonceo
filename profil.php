<?php
include_once('inc/init.inc.php');


//if(!user_is_connected()) {
//	// si l'utilisateur n'est pas connecté
//	header("location:" . URL);
//}



// déclaration de variable pour afficher les valeurs dans les values de nos champs egales aux sessions 

$id_membre = $_SESSION['utilisateur']['id_membre'];
$pseudo = $_SESSION['utilisateur']['pseudo'];
$nom = $_SESSION['utilisateur']['nom'];
$prenom = $_SESSION['utilisateur']['prenom'];
$telephone = $_SESSION['utilisateur']['telephone'];
$email = $_SESSION['utilisateur']['email'];
$civilite = $_SESSION['utilisateur']['civilite'];
$statut = $_SESSION['utilisateur']['statut'];
$date_enregistrement = $_SESSION['utilisateur']['date_enregistrement'];








    
    

if(isset($_POST['id_membre']) && isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['statut']) && isset($_POST['date_enregistrement'])) {
	
    
    // on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	}
    
    // si ça existe, on place la saisie du formulaire dans ces variables.
	$id_membre = $_POST['id_membre'];
	$pseudo = $_POST['pseudo'];
	$nom = $_POST['nom']; 
	$prenom = $_POST['prenom'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$civilite = $_POST['civilite'];
	$date_enregistrement = $_POST['date_enregistrement'];
    
    
    // Controle sur l'id membre et la date d'enregistrement, pour etre certains qu'il n'a pas été changé
    
    if ($_POST['id_membre'] != $_SESSION['utilisateur']['id_membre'] || $_POST['date_enregistrement'] != $_SESSION['utilisateur']['date_enregistrement']){
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, une information non modifiable à été modifié. Petit malin.<br>Veuillez recommencer</div>';
        
    }
    
    // Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
    if (($pseudo != $_SESSION['utilisateur']['pseudo'] || $nom != $_SESSION['utilisateur']['nom'] || $prenom != $_SESSION['utilisateur']['prenom'] || $telephone != $_SESSION['utilisateur']['telephone'] || $email != $_SESSION['utilisateur']['email'] || $civilite != $_SESSION['utilisateur']['civilite']) && empty($msg)){

        
        $enregistrement = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite");
        $enregistrement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
        $enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $enregistrement->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
        $enregistrement->bindParam(':civilite', $civilite, PDO::PARAM_STR);
        $enregistrement->execute();
        
        //actualisation de la session
        $_SESSION['utilisateur']['pseudo'] = $pseudo;
        $_SESSION['utilisateur']['nom'] = $nom;
        $_SESSION['utilisateur']['prenom'] = $prenom;
        $_SESSION['utilisateur']['telephone'] = $telephone;
        $_SESSION['utilisateur']['email'] = $email;
        $_SESSION['utilisateur']['civilite'] = $civilite;
        
        //message que les informations ont été modifiées

        $msg .= '<div class="alert alert-succes mt-2" role="alert">Une ou plusieurs de vos informations personnelles ont correctement été modifiée</div>';

        
    }
    
    

}




include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>

<!--Titre et boutons de navigations-->

<div class="starter-template">
    <h1>Profil</h1>
    <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
    <hr>
    <a href="?action=informationsPersonnels" class="btn btn-warning text-white">Informations personnels</a> 
    <a href="?action=mesCommentaires" class="btn btn-primary">Mes commentaires</a>
    <a href="?action=mesNotes" class="btn btn-primary">Mes notes</a>
    <hr>
</div>


<!--Formulaires des informations personnels-->

<?php

// Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
if ((isset($_GET['action']) && $_GET['action'] == "informationsPersonnels") || !isset($_GET['action'])){    
    
    
?>
<div class="col-6 mx-auto">

    <div class="form-group">
        <label for="id_membre">Identifiant</label>
        <input type="text" disabled="disabled" class="form-control" id="id_membre" name="id_membre" value="<?php echo $id_membre; ?>">
    </div>

    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
    </div>

    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
    </div>

    <div class="form-group">
        <label for="prenom">Prenom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
    </div>

    <div class="form-group">
        <label for="telephone">Telephone</label>
        <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone; ?>">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    </div>

    <div class="form-group">
        <label for="sexe">Sexe</label>
        <select class="form-control" id="civilite" name="civilite">
            <option value="m">masculin</option>
            <option value="f" <?php if($civilite == 'f') echo 'selected'; ?>>féminin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="date_enregistrement">Date d'inscription</label>
        <input type="text" disabled="disabled" class="form-control" id="date_enregistrement" name="date_enregistrement" value="<?php echo $date_enregistrement; ?>">
    </div>

</div>

<?php
    //Fermeture du if de l'onglet informations personnels
}
?>

<?php
include_once('inc/footer.inc.php');

?>

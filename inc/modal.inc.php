<?php
//***********************
// Modal d'inscription
//***********************
// restriction d'acces

if(user_is_connected()) {

// si l'utilisateur est connecté, on l'envoie vers profil.php
// header('location:profil.php');
}

// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par defaut.
$pseudo = "";
$mdp = "";
$nom = "";
$prenom = "";
$email = "";
$civilite = "";
$telephone ="";
$pseudo_connexion="";
$mdp_connexion="";



// vérification si les champs existe deja
if(isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && 
isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['telephone'])) {

// enlève ses espaces.
	foreach($_POST AS $indice => $valeur ) {
		$_POST[$indice] = trim($_POST[$indice]);
	}

// placement des saisies du formulaire dans les variables.
	$pseudo = $_POST['pseudo'];
	$mdp = $_POST['mdp'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$civilite = $_POST['civilite'];
	$telephone = $_POST['telephone'];

// controle sur la taille du pseudo entre 4 et 14 caractères inclus

	if(iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 14) {
		$msg .= 'Le pseudo doit avoir entre 4 et 14 caractères inclus. Veuillez recommencer';
	}

    // vérification des caractères présent dans le pseudo
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre pseudo est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le prenom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $prenom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le nom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $nom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}

// verification si le pseudo est disponible en BDD car unique
	$verif_pseudo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$verif_pseudo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$verif_pseudo->execute();

	if($verif_pseudo->rowCount() > 0) {
		// s'il y a au moins une ligne alors le pseudo existe en BDD
		$msg .= 'Attention pseudo déjà utilisé. Veuillez choisir un autre pseudo';
	}

// vérification du format de l'email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$msg .= "Attention le format du mail n'est pas valide. Veuillez recommencer";
	}
	
// vérification du format telephone
    if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $telephone)) {
        $msg .= "Attentionn le format du téléphone n'est pas valide.";
    }  


// enregistrement dans la BDD
    if(empty($msg)) {
        
// hashage du mot de passe
		$mdp = password_hash($mdp, PASSWORD_DEFAULT);
		$enregistrement = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, telephone, date_enregistrement, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :telephone, NOW(), 1)");
		$enregistrement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
		$enregistrement->bindParam(':mdp', $mdp, PDO::PARAM_STR);
		$enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
		$enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
		$enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
		$enregistrement->bindParam(':civilite', $civilite, PDO::PARAM_STR);
		$enregistrement->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $enregistrement->execute();
		// Enregistrement est OK renvoi vers index.php pour connexion
		header('location:index.php');
	} 
}
//***********************
// Modal de connexion
//***********************

// deconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
    session_destroy();
    header('location:index.php');
	// unset($_SESSION);
}
if(isset($_POST['pseudo_connexion']) && isset($_POST['mdp_connexion'])) {
	$pseudo_connexion = trim($_POST['pseudo_connexion']);
    $mdp_connexion = trim($_POST['mdp_connexion']);
    echo 'je suis dans le 1er if';
	
    // on demande à la BDD de nous renvoyer les informations d'un utilisateur sur la base du pseudo saisie dans le champ.
	$connexion = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$connexion->bindParam(':pseudo', $pseudo_connexion, PDO::PARAM_STR);
    $connexion->execute();
    
	
	// s'il y a une ligne alors le pseudo existe en BDD
	if($connexion->rowCount() > 0) {
		echo 'je suis dans le 2eme if';
		// si le pseudo est ok, on vérifie le mot de passe
        $utilisateur = $connexion->fetch(PDO::FETCH_ASSOC);
		//echo '<pre>'; print_r($utilisateur); echo '</pre>';
		if(password_verify($mdp_connexion, $utilisateur['mdp'])) {
			
			// on place les informations utilisateur dans la $_SESSION afin de les conserver tant que l'utilisateur est connecté.
			$_SESSION['utilisateur'] = array();
			foreach($utilisateur AS $indice => $valeur) {		
				if($indice != 'mdp') {
                    $_SESSION['utilisateur'][$indice] = $valeur;
                }
			}
			header("location:profil.php");
		} else {
			$msg .= 'Erreur sur le pseudo ou le mot de passe. Veuillez recommencer';
		}
	} else {
		$msg .= 'Erreur sur le pseudo ou le mot de passe';
	}
}
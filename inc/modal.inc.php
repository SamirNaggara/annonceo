<?php
include_once('inc/init.inc.php');
// deconnexion

//Affiche un message de succes quand une inscription vient d'etre réalisé. Le message apparait une fois, puis ne réapparaitra plus
if (isset($_SESSION['inscription_ok']) && $_SESSION['inscription_ok'] = 'Inscription ok'){
    $msg .= '<div class="alert alert-success mt-2" role="alert">Vous avez été inscrit avec succes!<br>Connectez-vous!</div>';
    session_destroy();
    
}



//***********************
// Modal d'inscription
//***********************


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
	$pseudo = strtolower($_POST['pseudo']);
	$mdp = $_POST['mdp'];
	$nom = strtolower($_POST['nom']);
	$prenom = strtolower($_POST['prenom']);
	$email = $_POST['email'];
	$civilite = $_POST['civilite'];
	$telephone = $_POST['telephone'];

// controle sur la taille du pseudo entre 4 et 14 caractères inclus

	if(iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 14) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Le pseudo doit avoir entre 4 et 14 caractères inclus.<br>Veuillez recommencer</div>';
	}

    // vérification des caractères présent dans le pseudo
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre pseudo ne doit contenir que des caractères autorisés., les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le prenom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $prenom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom ne doit contenir que des caractères autorisés., les caractères autorisés sont: a-z A-Z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le nom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $nom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom ne doit contenir que des caractères autorisés., les caractères autorisés sont: a-z A-Z 0-9.<br>Veuillez recommencer</div>';
	}

// verification si le pseudo est disponible en BDD car unique
	$verif_pseudo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$verif_pseudo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$verif_pseudo->execute();

	if($verif_pseudo->rowCount() > 0) {
		// s'il y a au moins une ligne alors le pseudo existe en BDD
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention ce pseudo est deja utilisé.<br>Veuillez en choisir un autre</div>';
	}
// controle sur le password doit contenir au minimum 8 caractères 1 majuscule 1 chiffre
	if (!preg_match('#^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#', $mdp)) {
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Votre mot de passe doit contenir au minimum, 8 caratères, 1 majuscule et 1 chiffre<br> Veuillez recommencer</div>';
	}
// vérification du format de l'email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
	}
	
// vérification du format telephone
    if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $telephone)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format de votre numéro de téléphone n\'est pas valide.<br>Veuillez recommencer</div>';
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
        
        $msg .= '<div class="alert alert-success mt-2" role="alert">Bravo, vous etes inscrit.<br>Veuillez recommencer</div>';
		// Enregistrement est OK renvoi vers index.php pour connexion
		$_SESSION['inscription_ok'] = 'Inscription ok';
		header('location:index.php');
	} 
}
//***********************
// Modal de connexion
//***********************


   
//Formulaire se connecter
if(isset($_POST['pseudo_connexion']) && isset($_POST['mdp_connexion'])) {
	$pseudo_connexion = strtolower(trim($_POST['pseudo_connexion']));
    $mdp_connexion = trim($_POST['mdp_connexion']);
	
    // on demande à la BDD de nous renvoyer les informations d'un utilisateur sur la base du pseudo saisie dans le champ.
	$connexion = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$connexion->bindParam(':pseudo', $pseudo_connexion, PDO::PARAM_STR);
    $connexion->execute();
    
	
	// s'il y a une ligne alors le pseudo existe en BDD
	if($connexion->rowCount() > 0) {
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Erreur sur le pseudo ou le mot de passe<br>Veuillez recommencer</div>';
            
		}
	} else {
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Erreur sur le pseudo ou le mot de passe<br>Veuillez recommencer</div>';
	}
}
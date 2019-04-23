<?php
include_once('inc/init.inc.php');







echo '<pre>';
print_r($_POST);
echo '</pre>';

// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par defaut.
$contactNom = "";
$contactPrenom = "";
$contactEmail = "";
$contactObjet = "";
$contactMessage ="";



// vérification si les champs existe deja
if(isset($_POST['contactNom']) && isset($_POST['contactPrenom']) && isset($_POST['contactEmail']) && isset($_POST['contactObjet']) && isset($_POST['contactMessage']) &&  
isset($_POST['contactEnvoyer'])) {

    // enlève ses espaces.
	foreach($_POST AS $indice => $valeur ) {
		$_POST[$indice] = trim($_POST[$indice]);
	}

    // placement des saisies du formulaire dans les variables.
    $contactNom = $_POST['contactNom'];
    $contactPrenom = $_POST['contactPrenom'];
    $contactEmail = $_POST['contactEmail'];
    $contactObjet = $_POST['contactObjet'];
    $contactMessage = $_POST['contactMessage'];

    // vérification des caractères présent dans le nom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $contactNom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom ne doit contenir que des caractères autorisés. Les caractères autorisés sont: a-z A-Z 0-9.<br>Veuillez recommencer</div>';
	}
    // vérification des caractères présent dans le prenom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $contactPrenom)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom ne doit contenir que des caractères autorisés, les caractères autorisés sont: a-z A-Z 0-9.<br>Veuillez recommencer</div>';
	}

    // vérification du format de l'email
	if(!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
	}
    //Si un des champs n'est pas remplie, on renvoie un message d'erreur, si,o,
    if (empty($_POST['contactNom']) || empty($_POST['contactPrenom']) || empty($_POST['contactEmail']) || empty($_POST['contactObjet']) || empty($_POST['contactMessage'])){
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Tout les champs sont obligatoires.<br>Veuillez recommencer</div>';
        
        
    }
    //S'il n'y a pas de messages d'erreur, on envoie le mail
    if (empty($msg)){
        
    // Envoyer le mail
       $destinataire = EMAILANNONCEO;
       $expediteur = $contactEmail;
       $sujet = 'Message de annonceo: ' . $contactObjet;
       $message = 'Message de '  . $contactPrenom . " " . $contactNom . "<br>" . $contactMessage; 

        $expediteur = 'From: ' . $expediteur;

        mail($destinataire, $sujet, $message, $expediteur);
    }
    
}





include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

    <div class="starter-template">
        <h1>Contact</h1>
<!--        Attention!!! Important pour ecrire les messages d'erreurs-->
        <p class="lead"><?php echo $msg;?></p>
    </div>
    
<div class="row">
    <div class="col-6 mx-auto">
        <form id="contactForm" method="post" action="">
            <div class="form-group">
                <label for="contactNom">Nom</label>
                <input type="text" class="form-control" id="contactNom" name="contactNom" placeholder="Votre Nom" value="<?php echo $contactNom; ?>">
            </div>
            <div class="form-group">
                <label for="contactPrenom">Prenom</label>
                <input type="text" class="form-control" id="contactPrenom" name="contactPrenom" placeholder="Votre Prénom" value="<?php echo $contactPrenom; ?>">
            </div>
            <div class="form-group">
                <label for="contactEmail">Email</label>
                <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Votre Email" value="<?php echo $contactEmail; ?>">
            </div>
            <div class="form-group">
                <label for="contactObjet">Objet</label>
                <input type="text" class="form-control" id="contactObjet" name="contactObjet" placeholder="Objet de votre mail" value="<?php echo $contactObjet; ?>">
            </div>
            <div class="form-group">
                <label for="contactMessage">Message</label>
                <textarea id="contactMessage" name="contactMessage" cols="74" rows="5" placeholder="Votre message"><?php echo $contactNom; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="contactEnvoyer">Envoyer</button>
        </form>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');

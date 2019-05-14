<?php 
include_once('inc/init.inc.php');
// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par defaut.
$array = array("contactNom" => "", "contactPrenom" => "", "contactEmail" => "", "contactObjet" => "","contactMessage" => "", "contactNomError" => "", "contactPrenomError" => "", "contactEmailError" => "", "contactObjetError" => "", "contactMessageError" => "", "contactAllError" => "", "isSuccess" => false);

// $emailTo = EMAILANNONCEO;

// vérification si les champs existe deja
/* if(isset($_POST['contactNom']) && isset($_POST['contactPrenom']) && isset($_POST['contactEmail']) && isset($_POST['contactObjet']) && isset($_POST['contactMessage']) &&  
isset($_POST['contactEnvoyer']))  */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // placement des saisies du formulaire dans les variables.
    $array["contactNom"] = checkInput($_POST["contactNom"]);
    $array["contactPrenom"] = checkInput($_POST["contactPrenom"]);
    $array["contactEmail"] = checkInput($_POST["contactEmail"]);
    $array["contactObjet"] = checkInput($_POST["contactObjet"]);
    $array["contactMessage"] = checkInput($_POST["contactMessage"]);
    $array["isSuccess"] = true;
    $emailText = "";
    // vérification des caractères présent dans le nom
	if (empty($array["contactNom"])) {
        $array["contactNomError"] = "Et oui je veux tout savoir. Même ton nom !";
        $array["isSuccess"] = false;
	} else {
        $emailText .= "Nom: {$array["contactNom"]}\n";
    }

    // vérification des caractères présent dans le prenom
	if (empty($array["contactPrenom"])) {
        $array["contactPrenomError"] = "Je veux connaitre ton prénom !";
        $array["isSuccess"] = false;
	} else {
        $emailText .= "Prénom: {$array["contactPrenom"]}\n";
    }

    // vérification du format de l'email
	if(!isEmail($array["contactEmail"])) {
        $array["contactEmailError"] = "T'essaies de me rouler ? C'est pas un email ça  !";
        $array["isSuccess"] = false;
	} else {
        $emailText .= "Email: {$array["contactEmail"]}\n";
    }

    // vérification du format de l'Objet
	if(empty($array["contactObjet"])) {
        $array["contactObjetError"] = "Hop hop hop !!! Ce ne sont pas des caractères autorisés !";
        $array["isSuccess"] = false;
	} else {
        $emailText .= "Objet: {$array["contactObjet"]}\n";
    }

    // vérification du format du message
	if(empty($array["contactMessage"])) {
        $array["contactMessageError"] = "Soit pas timide ! Qu'est-ce que tu veux me dire ?";
        $array["isSuccess"] = false;
	} else {
        $emailText .= "Message: {$array["contactMessage"]}\n";
    }

    //Si un des champs n'est pas remplie, on renvoie un message d'erreur, si,o,
    if (empty($_POST["contactNom"]) || empty($_POST["contactPrenom"]) || empty($_POST["contactEmail"]) || empty($_POST["contactObjet"]) || empty($_POST["contactMessage"])){
        $array["contactAllError"] = "Tout les champs sont obligatoires !";
        $array["isSuccess"] = false;
    } 

    //S'il n'y a pas de messages d'erreur, on envoie le mail
    if ($array["isSuccess"]){
        
    // Envoyer le mail

        //$expediteur = "From: {$array["contactNom"]} {$array["contactPrenom"]} <{$array["contactEmail"]}>\r\nReply-To: {$array["contactEmail"]}";

        $to = "{$array["contactNom"]} {$array["contactPrenom"]} <{$array["contactEmail"]}>\r\n";
        $subject = "{$array["contactObjet"]}\r\n";
        $message = "{$array["contactEmail"]}\r\n";
        $headers = "From:{$array["contactEmail"]}\r\n";
        $headers .= "Reply-To:{$array["contactEmail"]}\r\n";
        $headers .= "Content-type: text/html\r\n";
        $headers .= 'Content-Transfer-Encoding: 8bit';

    mail(EMAILANNONCEO, $to, $subject, $message, $headers);
        //mail(EMAILANNONCEO, $headers, "Un message d'Annonceo", $emailText, $expediteur);
        
    }
    echo json_encode($array);
}
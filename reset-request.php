<?php
include_once('inc/init.inc.php');

if (isset($_POST['request-reset-submit'])) {
    echo 'texs';
    // création de 2 tokens pour minimiser les attaques en brute force (timing attaque)
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    // création du lien qui enverra l'email à l'utilisateur
    $url = "".URL."nouveau-mot-de-passe.php?selector=".$selector."&validator=".bin2hex($token);

    // création d'une variable d'expiration du token
    $expires = date("U") + 1800; //Le token sera valide pendant 1h apres sa création.


    // Création dans la BDD d'une table pour changer le mot de passe
    /* CREATE TABLE pwdReset (
        pwdResetId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        pwdResetEmail TEXT NOT NULL,
        pwdResetSelector TEXT NOT NULL,
        pwdResetToken LONGTEXT NOT NULL,
        pwdResetExpires TEXT NOT NULL
    ); */


    // vérification que l'utilisateur ayant demandé une reinitialisation de mot de passe n'a pas deja 1 token d'attribué si c'est le cas nous supprimons en premier lieux le token existant avant de lui en attribuer un nouveau afin d'éviter les doublons.
    $userEmail = $_POST['email'];

    $sql = $pdo->prepare("SELECT * FROM pwdreset WHERE pwdResetEmail = :pwdResetEmail");
    $sql->bindParam(':pwdResetEmail',$userEmail, PDO::PARAM_STR);
    $sql->execute();
    
    if($sql->rowCount() > 0) {

        $deleteToken = $pdo->prepare("DELETE FROM pwdreset WHERE pwdResetEmail = :pwdResetEmail");
        $deleteToken->bindParam(':pwdResetEmail', $userEmail, PDO::PARAM_STR);
        $deleteToken ->execute();

    } else {

        $hashedToken = password_hash($token, PASSWORD_DEFAULT);

        $insertToken = $pdo->prepare("INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (:pwdResetEmail, :pwdResetSelector, :pwdResetToken, :pwdResetExpires)");
        $insertToken->bindParam(':pwdResetEmail', $userEmail, PDO::PARAM_STR);
        $insertToken->bindParam(':pwdResetSelector', $selector, PDO::PARAM_STR);
        $insertToken->bindParam(':pwdResetToken', $hashedToken, PDO::PARAM_STR);
        $insertToken->bindParam(':pwdResetExpires', $expires, PDO::PARAM_STR);
        $insertToken ->execute();
    }

    //Envoi du mail
    $to = $userEmail;
    $subject = "Changer votre mot de passe";
    $message = "<html><body><p>Nous avons reçu une demande de réinitialistion de mot de passe.\r\n</p> <p>Si ce n'est pas une demande de votre part\r\n. Veuillez ignorer cette email\r\n</p>";
    $message .= "<p>Voici le lien pour rénitialiser votre mot de passe:\r\n</p>";
    $message .= "<a href=". $url .">$url</a></body></html>";

    $headers = "From:". EMAILANNONCEO ."\r\n";
    $headers .= "Reply-To:". EMAILANNONCEO ."\r\n";
    $headers .= "Content-type: text/html\r\n";
    $headers .= 'Content-Transfer-Encoding: 8bit';

    mail($to, $subject, $message, $headers);

    header("location: reset-password.php?reset=success");

} else {
    header("location: http://localhost/teamRocket/trunk/");
} 
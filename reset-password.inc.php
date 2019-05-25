<?php 
include_once('inc/init.inc.php');
echo '<pre>'; print_r($_POST); echo '</pre>';   
if(isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordReapeat = $_POST["pwd-repeat"];
    echo 'test';
    echo '<pre>'; print_r($_POST); echo '</pre>'; 
    if(empty($password) || empty($passwordReapeat)) {
        header("Location: nouveau-mot-de-passe.php?newpwd=empty");
    } elseif($password != $passwordReapeat) {
        header("Location: nouveau-mot-de-passe.php?newpwd=pwdnotsame");
    }

    $currentDate = date("U");
    echo $currentDate;

    $sql = $pdo->prepare("SELECT * FROM pwdReset WHERE pwdResetSelector = :pwdResetSelector AND pwdResetExpires >= :pwdResetExpires");
    $sql->bindParam(':pwdResetSelector', $selector, PDO::PARAM_STR);
    $sql->bindParam(':pwdResetExpires', $currentDate, PDO::PARAM_STR);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

    if ($tokenCheck === false) {
        echo 'Veuillez renouveller votre demande de réinitialisation';
    } elseif($tokenCheck === true) {
        $tokenEmail = $row['pwdResetEmail'];
        $sql = $pdo->prepare("SELECT * FROM membre WHERE email= :email");
        $sql->bindParam(':email', $tokenEmail, PDO::PARAM_STR);
        $sql->execute();

        $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = $pdo->prepare("UPDATE membre SET mdp = :mdp WHERE email = :email");
        $sql->bindParam(':mdp', $newPwdHash, PDO::PARAM_STR);
        $sql->bindParam(':email', $tokenEmail, PDO::PARAM_STR);
        $sql->execute();

        $sql = $pdo->prepare("DELETE FROM pwdReset WHERE pwdResetEmail = :pwdResetEmail");
        $sql->bindParam(':pwdResetEmail', $tokenEmail, PDO::PARAM_STR);
        $sql ->execute();
        header("Location: reset-password.php?newpwd=passwordupdated");
    }
} //else {
    //echo 'NOK';
    //header('location:'. URL .''); 
//}
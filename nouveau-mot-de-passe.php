<?php 
include_once('inc/init.inc.php');
if(isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordReapeat = $_POST["pwd-repeat"]; 
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
        $msg .= '<div class="alert alert-danger col-8 mx-auto ">Veuillez renouveller votre demande de réinitialisation</div>';
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
        $msg .= '<div class="alert alert-success mt-2 col-6 mx-auto" role="alert">Votre mot de passe à bien été modifié. Redirection dans <span id="crono"></span></div>';
		header("Refresh:4; url=". URL ."");
    }
}
include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>
<div class="container">
        <?php 
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if(empty($selector) || empty($validator)){
                echo 'Nous ne pouvons valider votre requete';
            } else {
                if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                    <form method="post" class="col-8 mx-auto newPass">
                        <div class="starter-template">
                        <?php echo $msg; ?>
                        </div>
                    <h1 class="text-center mb-4">Modifiez votre mot de passe</h1>
                        <input type="hidden" class="form-control" name="selector" value="<?php echo $selector;?>">
                        <input type="hidden" class="form-control" name="validator" value="<?php echo $validator;?>">
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="password" class="form-control" name="pwd" id="pwd1" placeholder="Entrez votre nouveau mot de passe">
                            </div>
                            <div class="form-group col-6">
                                <input type="password" class="form-control" name="pwd-repeat" id="pwd2" placeholder="Confirmer votre nouveau mot de passe">
                            </div>
                        </div>
                        <button type="submit" class="form-control btn btn-warning col-md-12" name="reset-password-submit">Réinitialiser votre mot de passe</button>
                    </form>
                    <?php
                }
            }
        ?>
<?php
include_once('inc/footer.inc.php');
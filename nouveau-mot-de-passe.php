<?php 
include_once('inc/init.inc.php');
include('app_logic.php'); 

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>

<div class="starter-template">
    <h1>Renouveller votre mot de passe</h1>
		<p>Un email va vous être envoyé avec les instructions à suivre pour changer votre mot de passe</p>
</div>
        <?php 
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if(empty($selector) || empty($validator)){
                echo 'Nous ne pouvons valider votre requete';
            } else {
                if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                    <form action="reset-password.php" method="post">
                        <input type="hidden" name="selector" valure="<?php echo $selector;?>">
                        <input type="hidden" name="validator" valure="<?php echo $validator;?>">
                        <input type="password" name="pwd" placeholder="Entrer votre nouveau mot de passe">
                        <input type="password" name="pwd-repeat" placeholder="Confirmer votre nouveau mot de passe">
                        <button type="submit" name="reset-password-submit">Réinitialiser votre mot de passe</button>
                    </form>


                    <?php
                }
            }

        ?>
</body>
</html>
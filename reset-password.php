<?php 
include_once('inc/init.inc.php');


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>

<div class="starter-template">
    <h1>Renouveller votre mot de passe</h1>
		<p>Un email va vous être envoyé avec les instructions à suivre pour changer votre mot de passe</p>
</div>
		<!-- action="reset-request.php" renvoie vers la page de traitement du renvoie de mot de passe -->
    <form method="post" action="reset-request.php">
		<p>Enter Email Address To Send Password Link</p>
		<input type="text" name="email" placeholder="Entrer votre adresse e-mail...">
		<button type="submit" name="request-reset-submit">Recevez votre nouveau mot de passe par e-mail</button>
    </form>
		<?php
		if (isset($_GET["reset"])) {
			if ($_GET["reset"] == "success") {
				echo '<p class="signupsuccess">Vérifier vos e-mail!</p>';
			}
		}
		?>
</body>
</html>
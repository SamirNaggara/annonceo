<?php 
include_once('inc/init.inc.php');
include('app_logic.php'); 

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>

	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Renouveller le mot de passe</h2>
		<!-- form validation messages -->
		<?php include('messages.php'); ?>
		<div class="form-group">
			<label>Votre adresse email</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>
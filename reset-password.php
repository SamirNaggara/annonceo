<?php 
include_once('inc/init.inc.php');
include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
<div class="container">
	<div class="starter-template">
			<p class="lead"><?php echo $msg;?></p>
	</div>
	<!-- action="reset-request.php" renvoie vers la page de traitement du renvoie de mot de passe -->
	<div class="row">
		<form method="post" action="reset-request.php" class="col-8 mx-auto rstPswd">
		<h1 class="text-center mb-4">Renouveller votre mot de passe</h1>
			<div class="col-auto">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">@</div>
					</div>
					<input type="text" class="form-control" id="inlineFormInputGroup" name="email" placeholder="Entrez votre e-mail">
				</div>
			</div>
			<div class="form-group col-md-12">
				<button type="submit" name="request-reset-submit" class="form-control btn btn-warning col-md-12">Envoyer</button>
			</div>
			<?php
				if (isset($_GET["reset"])) {
					if ($_GET["reset"] == "success") {
						$success .= '<em>Un email vous a été envoyé avec les instructions à suivre pour changer votre mot de passe</em>';
					}
				}
			?>
		</form>
		<div class="text-center text-success mx-auto col-12">
			<?php
			echo $success;
			?>
		</div>
	</div>
<?php
include_once('inc/footer.inc.php');

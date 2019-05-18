<?php 
include_once('inc/init.inc.php');
include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

<div class="starter-template">
	<?php
		if(isset($_GET['newpwd']) && $_GET['newpwd'] == 'passwordupdated') {
			echo '<div class="alert alert-success mt-2" role="alert">Votre mot de passe à bien été modifié. Redirection dans 2sec.</div>';
			echo '<a></a>';
		}
		?>
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
						<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Entrez votre e-mail">
					</div>
			</div>
				<div class="form-group col-md-12">
					<button type="submit" name="request-reset-submit" class="form-control btn btn-warning col-md-12">Envoyer</button>
				</div>
				<?php
					if (isset($_GET["reset"])) {
						if ($_GET["reset"] == "success") {
							$success .= '<div class="text-center"><em>Un email vous a été envoyé avec les instructions à suivre pour changer votre mot de passe</em></div>';
						}
					}
				?>
				<p>
					<?php
					echo $success;
					?>
				</p>
			
			</form>
		</div>
		
<?php
include_once('inc/footer.inc.php');

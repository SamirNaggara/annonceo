<?php
include_once('inc/init.inc.php');

if (!user_is_connected()){
	// si l'utilisateur n'est pas connecté on le redirige vers l'index
    header('location:' . URL);
    exit();
}

if(!user_is_admin()) {
	// si l'utilisateur n'est pas admin on le redirige vers l'index
		header("location:" . URL);
		exit();
	}
//***************************
// ENREGISTREMENT ANNONCE
//***************************
// déclaration des variables de reception
$id_annonce = '';
$titre = '';
$descriptionCourte = '';
$descriptionLongue = '';
$prix = ''; 
$categorie = '';
$pays = '';
$ville = '';
$photo_bdd_base = '';
$photo_bdd1 = '';
$photo_bdd2 = '';
$photo_bdd3 = '';
$photo_bdd4 = '';
$photo_bdd5 = '';
$adresse = '';
$cp = '';

if(isset($_POST['titre']) && isset($_POST['descriptionCourte']) && isset($_POST['descriptionLongue']) && isset($_POST['prix']) && isset($_POST['categorie']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp'])) {

	// vérification des valeurs saisie dans les différents input
	$id_annonce = checkInput($_POST['id_annonce']);
	$titre = checkInput($_POST['titre']);
	$descriptionCourte = checkInput($_POST['descriptionCourte']);
	$descriptionLongue = checkInput($_POST['descriptionLongue']); 
	$prix = checkInput($_POST['prix']);
	$categorie = checkInput($_POST['categorie']);
	$pays = checkInput($_POST['pays']);
	$ville = checkInput($_POST['ville']);
	$adresse = checkInput($_POST['adresse']);
	$cp = checkInput(is_numeric($_POST['cp']));
	$photo_bdd_base = checkInput($_FILES['photo']['name']);
	$photo_bdd1 = checkInput($_FILES['photo1']['name']);
	$photo_bdd2 = checkInput($_FILES['photo2']['name']);
	$photo_bdd3 = checkInput($_FILES['photo3']['name']);
	$photo_bdd4 = checkInput($_FILES['photo4']['name']);
	$photo_bdd5 = checkInput($_FILES['photo5']['name']);
	
	// Controle sur l'id_annonce car unique en BDD
	if(empty($id_annonce)) {
		// si id_annonce n'est pas vide, nous sommes dans le cas d'une modif
		$verif_ref = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
		$verif_ref->bindParam(":id_annonce", $id_annonce, PDO::PARAM_STR);
		$verif_ref->execute();
		if($verif_ref->rowCount() > 0) {
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'annonce existe déjà.';
		}
	}
	// Controle sur le prix
	if(!is_numeric($prix)) {
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Veuillez entrer des chiffres pour le prix.';
	}
	// 2 décimales autorisées pour le prix
	number_format($prix, 2,',','.');

	///////////////////////////////////////////
	// Début vérification des extensions photo
	///////////////////////////////////////////

	// verification de la photo principal avant enregistrement
	if(empty($msg2) && !empty($_FILES['photo']['name'])) {
		
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd_base = $_FILES['photo'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			//$nom_photo = $id_annonce . '-' . $_FILES['photo_base']['name'];
			$nom_photo = time() . '0-' . $_FILES['photo']['name'];
			$photo_bdd_base = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd_base; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo']['tmp_name'], $photo_dossier);
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo principale n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}	
	// vérification de la photo1 avant enregistrement
	if(!empty($_FILES['photo1']['name'])) {

		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd1 = $_FILES['photo1']['name'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo1']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = time() . '1-' . $_FILES['photo1']['name'];
			$photo_bdd1 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd1; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo1']['tmp_name'], $photo_dossier);
			echo 'je suis dans le else de verif extension';
			
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°1 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}
	// vérification de la photo2 avant enregistrement
	if(!empty($_FILES['photo2']['name'])) {

		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd2 = $_FILES['photo2']['name'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo2']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = time() . '2-' . $_FILES['photo2']['name'];
			$photo_bdd2 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd2; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo2']['tmp_name'], $photo_dossier);
			
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°2 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}
	// vérification de la photo3 avant enregistrement	
	if(!empty($_FILES['photo3']['name'])) {

		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd3 = $_FILES['photo3']['name'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo3']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = time() . '3-' . $_FILES['photo3']['name'];
			$photo_bdd3 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd3; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo3']['tmp_name'], $photo_dossier);
			
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°3 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}
	// vérification de la photo4 avant enregistrement	
	if(!empty($_FILES['photo4']['name'])) {

		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd4 = $_FILES['photo4']['name'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo4']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = time() . '4-' . $_FILES['photo4']['name'];
			$photo_bdd4 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd4; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo4']['tmp_name'], $photo_dossier);
			
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°4 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}
	// vérification de la photo5 avant enregistrement	
	if(!empty($_FILES['photo5']['name'])) {

		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd5 = $_FILES['photo5']['name'];

		// verification de l'extension photo
		$extension = strrchr($_FILES['photo5']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = time() . '5-' . $_FILES['photo5']['name'];
			$photo_bdd5 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd5; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo5']['tmp_name'], $photo_dossier);
			
		} else {
			$msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°5 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}	
	///////////////////////////////////////////
	// Fin vérification des extensions photo
	///////////////////////////////////////////
	// enregistrement annonce en bdd
	if(!empty($_POST['titre']) && !empty($_POST['descriptionCourte']) && !empty($_POST['descriptionLongue']) && !empty($_POST['prix']) && !empty($_POST['categorie']) && !empty($_POST['pays']) && !empty($_POST['ville']) && !empty($_POST['adresse']) && !empty($_POST['cp']) && isset($_POST['enregistrement']) && empty($msg)) {
		echo 'je suis dans enregistrement en bdd';
		// if(!empty($id_annonce)) {
		// 	// modification de l'annonce
		// 	$enregistrement_annonce = $pdo->prepare("UPDATE annonce SET id_annonce = :id_annonce, categorie = :categorie, titre = :titre, descriptionCourte = :descriptionCourte, descriptionLongue = :descriptionLongue, prix = :prix, pays = :pays, ville = :ville, photo = :photo WHERE id_annonce = :id_annonce");
		// 	$enregistrement_annonce->bindParam(':id_annonce', $id_annonce, PDO::PARAM_STR);
		// } else {
			// enregistrement des 5 photos dans la table photo
			$enregistrement_photo = $pdo->prepare("INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUES (:photo1, :photo2, :photo3, :photo4, :photo5)");
			$enregistrement_photo->bindParam(':photo1', $photo_bdd1, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo2', $photo_bdd2, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo3', $photo_bdd3, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo4', $photo_bdd4, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo5', $photo_bdd5, PDO::PARAM_STR);
			$enregistrement_photo ->execute();
			
			// récupération du dernier id inséré dans la table photo pour la lier à la table annonce
			$photo_id = $pdo->lastInsertId();

			// enregistrement de l'annonce dans la table annonce
			$enregistrement_annonce = $pdo->prepare ("INSERT INTO annonce (id_annonce, photo_id, categorie_id, titre, description_courte, description_longue, prix, pays, photo, ville, cp, membre_id, adresse, date_enregistrement ) VALUES (:id_annonce, :photo_id, :categorie_id, :titre, :description_courte, :description_longue, :prix, :pays, :photo, :ville, :cp, :membre_id, :adresse, NOW())");
			$enregistrement_annonce ->bindParam(':id_annonce', $id_annonce, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':photo_id', $photo_id, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':categorie_id', $categorie, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':titre', $titre, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':description_courte', $descriptionCourte, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':description_longue', $descriptionLongue, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':prix', $prix, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':pays', $pays, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':ville', $ville, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':cp', $cp, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':photo', $photo_bdd_base, PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':membre_id', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
			$enregistrement_annonce ->bindParam(':adresse', $adresse, PDO::PARAM_STR);
			$enregistrement_annonce ->execute();
			if(!empty($_POST['enregistrement'])) {
				$liste_annonce = $pdo->query("SELECT * FROM annonce ORDER BY id_annonce DESC LIMIT 1");
				$liste_annonce->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
				$liste_annonce->execute();
					
					if($liste_annonce->rowCount() > 0) {
						$infos_annonce = $liste_annonce->fetch(PDO::FETCH_ASSOC);
						$id_annonce = $infos_annonce['id_annonce'];
					}
					$msg .= '<div class="alert alert-success mt-2" role="alert">Votre annonce à bien été enregistrée redirection dans 2sec.</div>';
				header('Refresh:2; url='. URL . 'annonce.php?id_annonce=' . $id_annonce);
			}
		}	
	}


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>
	<div class="starter-template col-lg-10 mx-auto text-center">
		<h1>Déposer une annonce</h1>
		<p class="lead"><?php echo $msg;?></p>
		<p class="lead"><?php echo $msg2;?></p>
	</div>
	<div class="row">
		<div class="col-lg-12 mx-auto">
			<form id="newAnnonce" method="post" action="" enctype="multipart/form-data" >
				<div class="row">
					<div class="form-group col-md-6">
						<label for="reference">Titre de l'annonce</label>
						<input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="categorie">Catégorie</label>
							<select name="categorie" class="form-control">
								<?php 
									$recup_categorie = $pdo->query("SELECT * FROM categorie ORDER BY titre");
									while($categorie = $recup_categorie->fetch(PDO::FETCH_ASSOC)) {
										echo '<option value="' . $categorie['id_categorie'] . '">'. $categorie['titre'].'</option>';
									}
								?>
							</select>
					</div>
					<div class="form-group col-md-6">
						<label for="reference">Prix</label>
						<input type="text" class="form-control" id="prix" name="prix" value="<?php echo $prix; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="pays">Pays</label>
						<input type="text" class="form-control" id="pays" name="pays" value="<?php echo $pays; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="reference">Ville</label>
						<input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="cp">Code postal</label>
						<input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="descriptionCourte">Description Courte</label>
						<textarea name="descriptionCourte" id="descriptionCourte" class="w-100" rows="5"><?php echo $descriptionCourte; ?></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="adresse">Adresse</label>
						<textarea name="adresse" id="adresse" class="w-100" rows="5"><?php echo $adresse; ?></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="descriptionLongue">Description Longue</label>
						<textarea name="descriptionLongue" id="descriptionLongue" class="w-100" rows="9"><?php echo $descriptionLongue; ?></textarea>
					</div>
					<div class="form-group col-md-6">
						<div class="formPhoto">
							<span>Photos</i></span>
						</div>
						<div class="pdPhoto">
						<label for="photo" class="label-file" ><div id="preview"></div><div>Pincipale</div></label>
						<input type="file" class="form-control input-file" id="photo" name="photo" onchange="handleFiles(files)" value="<?php echo $_FILES['photo']['name']; ?>">
						<?php 
						if(isset($_FILES['photo'])) {?> 
							<span><?php echo $_FILES['photo']['name'];?></span>
						<?php } ?>
						<label for="photo1" class="label-file"><i class="fas fa-camera"></i></label>
						<input type="file" class="form-control input-file" id="photo1" name="photo1" value="<?php echo $_FILES['photo1']['name']; ?>">
						<?php 
						if(isset($_FILES['photo1'])) {?> 
							<span><?php echo $_FILES['photo1']['name'];?></span>
						<?php } ?>
						<label for="photo2" class="label-file"><i class="fas fa-camera"></i></label>
						<input type="file" class="form-control input-file" id="photo2" name="photo2" value="<span><?php echo $_FILES['photo2']['name']; ?>">
						<?php 
						if(isset($_FILES['photo2'])) {?> 
							<span><?php echo $_FILES['photo2']['name'];?></span>
						<?php } ?>
						<label for="photo3" class="label-file"><i class="fas fa-camera"></i></label>
						<input type="file" class="form-control input-file" id="photo3" name="photo3" value="<?php echo $_FILES['photo3']['name']; ?>"><span>
						<?php 
						if(isset($_FILES['photo3'])) {?> 
							<span><?php echo $_FILES['photo3']['name'];?></span>
						<?php } ?>
						<label for="photo4" class="label-file"><i class="fas fa-camera"></i></label>
						<input type="file" class="form-control input-file" id="photo4" name="photo4" value="<?php echo $_FILES['photo4']['name']; ?>">
						<?php 
						if(isset($_FILES['photo4'])) {?> 
							<span><?php echo $_FILES['photo4']['name'];?></span>
						<?php } ?>
						<label for="photo5" class="label-file"><i class="fas fa-camera"></i></label>
						<input type="file" class="form-control input-file" id="photo5" name="photo5" value="<?php echo $_FILES['photo5']['name']; ?>">
						<?php 
						if(isset($_FILES['photo5'])) {?> 
							<span><?php echo $_FILES['photo5']['name'];?></span>
						<?php } ?>
						</div>
					</div>
					<hr>
					<div class="form-group col-md-6">
						<input type="hidden" class="form-control" id="id_annonce" name="id_annonce" value="<?php echo $id_annonce; ?>">
					</div>
					<div class="form-group col-md-12">
						<input type="submit" class="form-control btn btn-warning col-md-12" id="enregistrement" name="enregistrement" value="Enregistrement">
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<?php
include_once('inc/footer.inc.php');

?>

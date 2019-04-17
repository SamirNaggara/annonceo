<?php
include_once('inc/init.inc.php');

//***************************
// ENREGISTREMENT ANNONCE
//***************************
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
//$categorie_hidden = $categorie['id_categorie'];
echo '<pre>'; print_r($_POST); echo '</pre>';
echo '<pre>'; print_r($_FILES); echo '</pre>';

if(isset($_POST['titre']) && isset($_POST['descriptionCourte']) && isset($_POST['descriptionLongue']) && isset($_POST['prix']) && isset($_POST['categorie']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp'])) {

	$titre = $_POST['titre'];
	$descriptionCourte = $_POST['descriptionCourte'];
	$descriptionLongue = $_POST['descriptionLongue']; 
	$prix = $_POST['prix'];
	$categorie = $_POST['categorie'];
	$pays = $_POST['pays'];
	$ville = $_POST['ville'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	
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
	if(empty($msg) && !empty($_FILES['photo'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd_base = $_FILES['photo'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">test 1234</div>';
			echo 'je suis dans le else de verif extension';
		}
	}	
	if(empty($msg) && !empty($_FILES['photo1'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd1 = $_FILES['photo1'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">test 1234789</div>';
		}
	}	
	if(empty($msg) && !empty($_FILES['photo2'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd2 = $_FILES['photo2'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo principale n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}	
	if(empty($msg) && !empty($_FILES['photo3'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd3 = $_FILES['photo3'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo principale n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}	
	if(empty($msg) && !empty($_FILES['photo4'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd4 = $_FILES['photo4'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">test 1234</div>';
		}
	}	
	if(empty($msg) && !empty($_FILES['photo5'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd5 = $_FILES['photo5'];
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
			$msg .= '<div class="alert alert-danger mt-2" role="alert">test 1234</div>';
		}
	}	
	
	// vérification de l'extension photo	
	// enregistrement annonce en bdd
	if(empty($msg)) {
		echo 'je suis dans enregistrement en bdd';
		if(!empty($id_annonce)) {
			// modification
			$enregistrement_annonce = $pdo->prepare("UPDATE annonce SET id_annonce = :id_annonce, categorie = :categorie, titre = :titre, descriptionCourte = :descriptionCourte, descriptionLongue = :descriptionLongue, prix = :prix, pays = :pays, ville = :ville, photo = :photo WHERE id_annonce = :id_annonce");
			$enregistrement_annonce->bindParam(':id_annonce', $id_annonce, PDO::PARAM_STR);
		} else {
			// insert into photo les 5 
			// lastInsertId()
			$enregistrement_photo = $pdo->prepare("INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUES (:photo1, :photo2, :photo3, :photo4, :photo5)");
			$enregistrement_photo->bindParam(':photo1', $photo_bdd1, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo2', $photo_bdd2, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo3', $photo_bdd3, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo4', $photo_bdd4, PDO::PARAM_STR);
			$enregistrement_photo->bindParam(':photo5', $photo_bdd5, PDO::PARAM_STR);
			$enregistrement_photo ->execute();
			// ajouter ds requete en dessous photo_id
			// Ajout
			echo '<pre>'; print_r($enregistrement_photo); echo '</pre>';
			echo '<pre>'; print_r($_FILES); echo '</pre>';
			echo '<pre>'; print_r($_POST); echo '</pre>';

			$photo_id = $pdo->lastInsertId();

			echo '<pre>'; print_r($id_annonce); echo '</pre>';
			$enregistrement_annonce = $pdo->prepare ("INSERT INTO annonce (photo_id, categorie_id, titre, description_courte, description_longue, prix, pays, photo, ville, cp, membre_id, adresse, date_enregistrement ) VALUES (:photo_id, :categorie_id, :titre, :description_courte, :description_longue, :prix, :pays, :photo, :ville, :cp, :membre_id, :adresse, NOW())");
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
		}
	}
}
//***************************
// FIN ENREGISTREMENT PRODUIT
//***************************

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>
	<div class="starter-template">
		<h1>Bootstrap starter template</h1>
		<p class="lead"><?php echo $msg;?></p>
	</div>
	<div class="col-6 mx-auto">
		<form method="post" action="" enctype="multipart/form-data" >
		<!--  28 - 1 champs caché pour la récupération de l'id_article lors qu'une modification -->
			<div class="form-group">
				<label for="reference">Titre de l'annonce</label>
				<input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
			</div>
			<div class="form-group">
				<label for="descriptionCourte">Description Courte</label>
				<textarea name="descriptionCourte" id="descriptionCourte" class="w-100" rows="5" value="<?php echo $descriptionCourte; ?>"></textarea>
			</div>
			<div class="form-group">
				<label for="descriptionLongue">Description Longue</label>
				<textarea name="descriptionLongue" id="descriptionLongue" class="w-100" rows="5" value="<?php echo $descriptionLongue; ?>"></textarea>
			</div>
			<div class="form-group">
				<label for="reference">Prix</label>
				<input type="text" class="form-control" id="prix" name="prix" value="<?php echo $prix; ?>">
			</div>
			<div class="form-group">
				<label for="categorie">Catégorie</label>
				<div class="form-group">
				<input type="text" name="categorie" value="<?php echo $categorie['id_categorie']; ?>">
					<select name="categorie" class="form-control">
						<?php 
							$recup_categorie = $pdo->query("SELECT * FROM categorie ORDER BY titre");
							while($categorie = $recup_categorie->fetch(PDO::FETCH_ASSOC)) {
								echo '<option value="' . $categorie['id_categorie'] . '">'. $categorie['titre'].'</option>';
								echo 'probleme dans le while';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="photo">Photo</label>
				<input type="file" class="form-control" id="photo" name="photo" value="<?php echo $photo_bdd_base; ?>">
				<input type="file" class="form-control" id="photo1" name="photo1" value="<?php echo $photo_bdd1; ?>">
				<input type="file" class="form-control" id="photo2" name="photo2" value="<?php echo $photo_bdd2; ?>">
				<input type="file" class="form-control" id="photo3" name="photo3" value="<?php echo $photo_bdd3; ?>">
				<input type="file" class="form-control" id="photo4" name="photo4" value="<?php echo $photo_bdd4; ?>">
				<input type="file" class="form-control" id="photo5" name="photo5" value="<?php echo $photo_bdd5; ?>">
			</div>
			<div class="form-group">
				<label for="pays">Pays</label>
				<input type="text" class="form-control" id="pays" name="pays" value="<?php echo $pays; ?>">
			</div>
			<div class="form-group">
				<label for="reference">Ville</label>
				<input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>">
			</div>
			<div class="form-group">
				<label for="adresse">Adresse</label>
				<textarea name="adresse" id="adresse" class="w-100" rows="5" value="<?php echo $adresse; ?>"></textarea>
			</div>
			<div class="form-group">
				<label for="cp">Code postal</label>
				<input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
			</div>
			<hr>
			<input type="submit" class="form-control btn btn-warning" id="enregistrement" name="enregistrement" value="Enregistrement">		
		</form>
	</div>
<?php
include_once('inc/footer.inc.php');

?>

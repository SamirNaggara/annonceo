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
$photo_bdd = '';
$adresse = '';
$cp = '';

if(isset($_POST['id_annonce']) && isset($_POST['titre']) && isset($_POST['descriptionCourte']) && isset($_POST['descriptionLongue']) && isset($_POST['prix']) && isset($_POST['categorie']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['photo_base']) && isset($_POST['photo_miniature1']) && isset($_POST['photo_miniature2']) && isset($_POST['photo_miniature3']) && isset($_POST['photo_miniature4']) && isset($_POST['photo_miniature5']) && isset($_POST['adresse']) && isset($_POST['cp'])) {
	
	$id_annonce = $_POST['id_annonce'];
	$titre = $_POST['titre'];
	$descriptionCourte = $_POST['descriptionCourte'];
	$descriptionLongue = $_POST['descriptionLongue']; 
	$prix = $_POST['prix'];
	$categorie = $_POST['categorie'];
	$pays = $_POST['pays'];
	$ville = $_POST['ville'];
	$photo_bdd_base = $_POST['photo_base'];
	$photo_bdd1 = $_POST['photo_miniature1'];
	$photo_bdd2 = $_POST['photo_miniature2'];
	$photo_bdd3 = $_POST['photo_miniature3'];
	$photo_bdd4 = $_POST['photo_miniature4'];
	$photo_bdd5 = $_POST['photo_miniature5'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	
	// Controle sur l'id_annonce car unique en BDD
	if(empty($id_annonce)) {
		// si id_annonce n'est pas vide, nous sommes dans le cas d'une modif et la référence est présente en BDD
		$verif_ref = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
		$verif_ref->bindParam(":id_annonce", $id_annonce, PDO::PARAM_STR);
		$verif_ref->execute();
		
		if($verif_ref->rowCount() > 0) {
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'annonce existe déjà.';
		}
	}
	
	if(!empty($_POST['photo_base'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_base'];
	}	
	if(!empty($_POST['photo_miniature1'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_miniature1'];
	}	
	if(!empty($_POST['photo_miniature2'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_miniature2'];
	}	
	if(!empty($_POST['photo_miniature3'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_miniature3'];
	}	
	if(!empty($_POST['photo_miniature4'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_miniature4'];
	}	
	if(!empty($_POST['photo_miniature5'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_miniature5'];
	}	
	
	// vérification de l'extension photo
	if(empty($msg) && !empty($_FILES['photo']['name'])) {

		$extension = strrchr($_FILES['photo']['name'], '.');
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = $id_annonce . '-' . $_FILES['photo']['name'];
			$photo_bdd = 'photo/' . $nom_photo; // src que l'on va enregistrer dans la BDD
			$photo_dossier = RACINE_SERVEUR . $photo_bdd; // l'emplacement où on va copier la photo
			
			// copy() permet de copier un fichier depuis un emplacement 1er argument, vers un autre emplacement 2eme argument
			copy($_FILES['photo']['tmp_name'], $photo_dossier);
			
		} else {
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
		}
	}
	
	// enregistrement produit en bdd
	if(empty($msg)) {
		
		if(!empty($id_annonce)) {
			// modification
			$enregistrement_annonce = $pdo->prepare("UPDATE annonce SET id_annonce = :id_annonce, categorie = :categorie, titre = :titre, descriptionCourte = :descriptionCourte, descriptionLongue = :descriptionLongue, prix = :prix, pays = :pays, ville = :ville, photo = :photo WHERE id_annonce = :id_annonce");
			$enregistrement_annonce->bindParam(':id_annonce', $id_annonce, PDO::PARAM_STR);
			$_GET['action'] = 'afficher';
		} else {
			// Ajout
			$enregistrement_annonce = $pdo->prepare("INSERT INTO annonce (categorie, titre, descriptionCourte, descriptionLongue, prix, pays, ville, photo ) VALUES (:categorie, :titre, :descriptionCourte, :descriptionLongue, :prix, :pays, :photo, :ville)");
		}
		
		
		$enregistrement_produit->bindParam(':categorie', $categorie, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':titre', $titre, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':descriptionCourte', $descriptionCourte, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':descriptionLongue', $descriptionLongue, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':prix', $prix, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':pays', $pays, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':ville', $ville, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd_base, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd1, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd2, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd3, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd4, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd5, PDO::PARAM_STR);
		$enregistrement_produit->execute();

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
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titreAnnonce" aria-describedby="titreAnnonce" placeholder="Titre de l'annonce" name="titreAnnonce" value="<?php echo $titreAnnonce; ?>">
                    </div>
                    <div class="form-group">
                            <textarea name="descriptionCourte" id="descriptionCourte" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                            <textarea name="descriptionLongue" id="descriptionLongue" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="prix" aria-describedby="prix" placeholder="Prix figurant dans l'annonce" name="prix" value="<?php echo $prix; ?>">
                    </div>
                    <select name="quantite" class="form-control">
						<?php 
							for($i = 1; $i <= $produit['stock'] && $i <= 5; $i++) {
							for($i = 1; $i <= $produit['stock'] && $i <= 5; $i++) {
								echo '<option>' . $i . '</option>';
							}
						?>
					</select>	
                </form>
            </div>
        </div>
        <div class="row"></div>
    
    </div>
    

<?php
include_once('inc/footer.inc.php');

?>

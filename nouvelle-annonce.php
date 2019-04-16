<?php
include_once('inc/init.inc.php');
// restriction d'accès si l'utilisateur n'est pas admin il ne doit pas pouvoir venir sur cette page
// if(!user_is_admin()) {
// 	header("location:" . URL . "profil.php");
// 	exit(); // permet de bloquer l'exécution de la suite du script
// }


//***************************
// ENREGISTREMENT PRODUIT
//***************************
$id_article = '';
$reference = '';
$categorie = '';
$titre = ''; 
$description = '';
$couleur = '';
$taille = '';
$photo_bdd = '';
$prix = '';
$sexe = '';
$stock = '';

if(isset($_POST['reference']) && isset($_POST['categorie']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['couleur']) && isset($_POST['prix']) && isset($_POST['sexe']) && isset($_POST['stock']) && isset($_POST['taille']) && isset($_POST['id_article'])) {
	
	$id_article = $_POST['id_article'];
	$reference = $_POST['reference'];
	$categorie = $_POST['categorie'];
	$titre = $_POST['titre']; 
	$description = $_POST['description'];
	$couleur = $_POST['couleur'];
	$taille = $_POST['taille'];
	$prix = $_POST['prix'];
	$sexe = $_POST['sexe'];
	$stock = $_POST['stock'];
	
	// Controle sur la référence car unique en BDD
	if(empty($id_article)) {
		// si id_article n'est pas vide, nous sommes dans le cas d'une modif et la référence est présente en BDD
		$verif_ref = $pdo->prepare("SELECT * FROM article WHERE reference = :reference");
		$verif_ref->bindParam(":reference", $reference, PDO::PARAM_STR);
		$verif_ref->execute();
		
		if($verif_ref->rowCount() > 0) {
			$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, la référence existe déjà.<br>Veuillez recommencer</div>';
		}
	}
	
	if(!empty($_POST['photo_actuelle'])) {
		// dans le cas d'une modif, on conserve l'ancienne photo avant de tester si une nouvelle photo a été chargé dans le formulaire
		$photo_bdd = $_POST['photo_actuelle'];
	}	
	
	// vérification de l'extension photo
	if(empty($msg) && !empty($_FILES['photo']['name'])) {
		// on récupère l'extension du fichier avec le point
		// la fonction strrchr() permet de découper une chaine depuis la fin jusqu'à un caractère fourni en deuxième argument.
		$extension = strrchr($_FILES['photo']['name'], '.');
		// exemple: ma_photo.jpg => .jpg
		
		// on passe l'information en minuscule et on enlève le point
		$extension = strtolower(substr($extension, 1));
		// exemple: .PNG => png
		// exemple: .Jpeg => jpeg
		
		// on défini toutes les valeurs acceptées dans un tableau array
		$extension_valide = array('jpg', 'jpeg', 'png', 'gif');
		
		// in_array() permet de tester si une valeur fait partie d'un ensemble de valeur présentent dans un tableau array => true / false
		$verif_extension = in_array($extension, $extension_valide);
		
		if($verif_extension) {
			// l'extension est valide, on copie la photo dans notre projet.
			$nom_photo = $reference . '-' . $_FILES['photo']['name'];
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
		
		if(!empty($id_article)) {
			// modification
			$enregistrement_produit = $pdo->prepare("UPDATE article SET reference = :reference, categorie = :categorie, titre = :titre, description = :description, couleur = :couleur, taille = :taille, sexe = :sexe, photo = :photo, prix = :prix, stock = :stock WHERE id_article = :id_article");
			$enregistrement_produit->bindParam(':id_article', $id_article, PDO::PARAM_STR);
			$_GET['action'] = 'afficher';
		} else {
			// Ajout
			$enregistrement_produit = $pdo->prepare("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :sexe, :photo, :prix, :stock)");
		}
		
		
		$enregistrement_produit->bindParam(':reference', $reference, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':categorie', $categorie, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':titre', $titre, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':description', $description, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':couleur', $couleur, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':taille', $taille, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':sexe', $sexe, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':photo', $photo_bdd, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':prix', $prix, PDO::PARAM_STR);
		$enregistrement_produit->bindParam(':stock', $stock, PDO::PARAM_STR);
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

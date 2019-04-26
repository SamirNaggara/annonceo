<?php
include_once('../inc/init.inc.php');
include_once('../inc/function.inc.php');

if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}
if(!user_is_connected()) {
// si l'utilisateur n'est pas connecté on le redirige vers l'accueil
  header("location:" . URL);
}
// récuperation des categories dans la base de données

if (isset($_GET['supprimer'])) {
  $supprimerLigne= $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");
  $supprimerLigne->bindParam(':id_annonce', $_GET['supprimer'], PDO::PARAM_STR);
  $supprimerLigne->execute();
  header("location:" . URL . "admin/annonces.php");
}

// récupération des informations de l'annonce pour modification

if(isset($_GET['modifier'])) {

  $recupAnnonces = $pdo->prepare("SELECT * FROM annonce, photo, membre WHERE id_annonce = :id_annonce AND id_photo = photo_id");
  $recupAnnonces->bindParam(':id_annonce', $_GET['modifier'], PDO::PARAM_STR);
  $recupAnnonces->execute();
  $laRecupAnnonces = $recupAnnonces->fetch(PDO::FETCH_ASSOC);
  echo '<pre>'; print_r($laRecupAnnonces); echo '</pre>';
  $id = checkInput($laRecupAnnonces['id_annonce']);
  $titre = checkInput($laRecupAnnonces['titre']);
  $pseudo = checkInput($laRecupAnnonces['pseudo']);
  $date = checkInput($laRecupAnnonces['date_enregistrement']);
  $desCourte = checkInput($laRecupAnnonces['description_courte']);
  $desLongue = checkInput($laRecupAnnonces['description_longue']);
  $prix = checkInput($laRecupAnnonces['prix']);
  $pays = checkInput($laRecupAnnonces['pays']);
  $ville = checkInput($laRecupAnnonces['ville']);
  $adresse = checkInput($laRecupAnnonces['adresse']);
  $cp = checkInput($laRecupAnnonces['cp']);
  $photo = checkInput($laRecupAnnonces['photo']);
  $photo1 = $laRecupAnnonces['photo1'];
  $photo2 = $laRecupAnnonces['photo2'];
  $photo3 = $laRecupAnnonces['photo3'];
  $photo4 = $laRecupAnnonces['photo4'];
  $photo5 = $laRecupAnnonces['photo5'];

  //actualisation de l'annonce
  // Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
  if (($titre != $_POST['titre'] || $pseudo != $_POST['pseudo'] || $date != $_POST['date'] || $desCourte != $_POST['descriptionCourte'] || $desLongue != $_POST['descriptionLongue'] || $prix != $_POST['prix'] || $pays != $_POST['pays'] || $ville != $_POST['ville'] || $adresse != $_POST['adresse'] || $cp != $_POST['cp'])) {
    $enregistrement = $pdo->prepare("UPDATE annonce SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp WHERE id_annonce = :id_annonce");
    $enregistrement->bindParam(':titre', $titre, PDO::PARAM_STR);
    $enregistrement->bindParam(':description_courte', $desCourte, PDO::PARAM_STR);
    $enregistrement->bindParam(':description_longue', $desLongue, PDO::PARAM_STR);
    $enregistrement->bindParam(':prix', $prix, PDO::PARAM_STR);
    $enregistrement->bindParam(':pays', $pays, PDO::PARAM_STR);
    $enregistrement->bindParam(':ville', $ville, PDO::PARAM_STR);
    $enregistrement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $enregistrement->bindParam(':cp', $cp, PDO::PARAM_STR);
    $enregistrement->bindParam(':id_annonce', $id, PDO::PARAM_STR);
    $enregistrement->execute();
    //message que les informations ont été modifiées
    $msg .= '<div class="alert alert-success mt-2" role="alert">Une ou plusieurs de vos informations personnelles ont correctement été modifiée</div>';
  }
  echo '<pre>'; print_r($_POST); echo '</pre>';
}
// récuperation des categories
$recup_categorie = $pdo->query(
  "SELECT * FROM categorie 
  ORDER BY titre"
);
// récupération des informations des annonces en fonction de leur categorie
if(isset($_GET['categorie'])) {
    $annonces = $pdo->prepare(
    "SELECT a.id_annonce, a.titre AS titre_annonce, a.description_courte, a.description_longue, a.prix, a.photo, a.pays, a.ville, a.adresse, a.cp, m.pseudo, c.titre, a.date_enregistrement  
    FROM annonce a, membre m, categorie c 
    WHERE c.titre = :titre
    AND m.id_membre = a.membre_id   
    AND a.categorie_id = c.id_categorie"
    );
    $annonces->bindParam(':titre', $_GET['categorie'], PDO::PARAM_STR);
    $annonces->execute();
} else {
  // recuperation des informations des annonces au complet
  $annonces = $pdo->prepare(
    "SELECT a.id_annonce, a.titre AS titre_annonce, a.description_courte, a.description_longue, a.prix, a.photo, a.pays, a.ville, a.adresse, a.cp, m.pseudo, c.titre, a.date_enregistrement  
    FROM annonce a, membre m, categorie c 
    WHERE m.id_membre = a.membre_id   
    AND a.categorie_id = c.id_categorie"
  );
  $annonces->execute();
}
  include_once('inc/header.inc.php');
  include_once('inc/nav.inc.php');

?>

<?php 

if(!empty($_GET['modifier'])) {
  ?>
  <div class="container">
	<div class="starter-template">
		<h1>Modification annonces</h1>
		<p class="lead"><?php echo $msg;?></p>
	</div>
	<div class="col-6 mx-auto">
		<form method="post" action="" enctype="multipart/form-data" >
		<!--  affichage de l'annonce pour modification -->
      <div class="form-group">
				<input type="hidden" class="form-control" id="id_annonce" name="id_annonce" value="<?php echo $id; ?>">
			</div>
      <div class="form-group">
				<label for="titre">Titre de l'annonce :</label>
				<input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
			</div>
			<div class="form-group">
				<label for="pseudo">Auteur de l'annonce :</label>
				<input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
			</div>
			<div class="form-group">
				<label for="date">Publié le :</label>
				<input type="text" class="form-control" id="date" name="date" value="<?php echo formatStandardTotal($date); ?>">
			</div>
			<div class="form-group">
				<label for="descriptionCourte">Description courte :</label>
				<textarea name="descriptionCourte" id="descriptionCourte" class="w-100" rows="5"><?php echo $desCourte; ?></textarea>
			</div>
      <div class="form-group">
				<label for="descriptionLongue">Description longue :</label>
				<textarea name="descriptionLongue" id="descriptionLongue" class="w-100" rows="5"><?php echo $desLongue; ?></textarea>
			</div>
			<div class="form-group">
				<label for="prix">Prix :</label>
				<input type="text" class="form-control" id="prix" name="prix" value="<?php echo $prix; ?>">
			</div>
			<div class="form-group">
				<label for="pays">Pays :</label>
				<input type="text" class="form-control" id="pays" name="pays" value="<?php echo $pays; ?>">
			</div>
      <div class="form-group">
				<label for="ville">Ville :</label>
				<input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>">
			</div>
			<div class="form-group">
				<label for="photo">Photos :</label>
				<input type="file" class="form-control" id="photo" name="photo"><span><?php echo $photo; ?></span>
				<input type="file" class="form-control" id="photo1" name="photo1"><span><?php echo $photo1; ?></span>
				<input type="file" class="form-control" id="photo2" name="photo2"><span><?php echo $photo2; ?></span>
				<input type="file" class="form-control" id="photo3" name="photo3"><span><?php echo $photo3; ?></span>
				<input type="file" class="form-control" id="photo4" name="photo4"><span><?php echo $photo4; ?></span>
				<input type="file" class="form-control" id="photo5" name="photo5"><span><?php echo $photo5; ?></span>
			</div>
			<div class="form-group">
				<label for="adresse">Adresse :</label>
				<input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $adresse; ?>">
			</div>
			<div class="form-group">
				<label for="cp">Code postal :</label>
				<input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
			</div>
			<hr>
			<input type="submit" class="form-control btn btn-warning" id="enregistrement" name="enregistrement" value="Enregistrement">		
		</form>
	</div>
</div>

<?php  } else { 
 // Affichage des annonces
        echo '<div class="tableAnnonces">';
          echo '<div class="row">';
        // lien des catégories
            echo '<a class="nav-link dropdown-toggle btn btn-default" href="" id="categorieAnnonces" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Trier par categories';
            echo '</a>';
            echo '<div class="dropdown-menu categoriesAnnonce" aria-labelledby="navbarDropdown">';
              echo '<a class="dropdown-item" href="'. URL. 'admin/annonces.php">Toutes les categories</a>';
              echo '<div class="dropdown-divider"></div>';
							while($categorie = $recup_categorie->fetch(PDO::FETCH_ASSOC)) {
                    $cat = checkInput($categorie['titre']);
              echo '<a class="dropdown-item" href="?categorie=' . $cat . '">'. $cat . '</a>';
              echo '<div class="dropdown-divider"></div>';
              }
            echo '</div>';
          echo '</div>';
        echo '<div class="row tableauAnnonces">';
        // création du tableau
          echo '<table class="table table-hover table-responsive-sm table-responsive-md col-12" >';
          echo '<tr>
                  <th>Id annonce</th>
                  <th>Titre</th>
                  <th>Description courte</th>
                  <th>Description longue</th>
                  <th>Prix</th>
                  <th>Photo</th>
                  <th>Pays</th>
                  <th>Ville</th>
                  <th>Adresse</th>
                  <th>Code postal</th>
                  <th>Membre</th>
                  <th>Categorie</th>
                  <th>Date enregistrement</th>
                  <th>Actions</th>
                </tr>';
                while($mesAnnonces = $annonces->fetch(PDO::FETCH_ASSOC)) {
                // Affichage des produits dans le tableau
                  echo '<tr>';
                  foreach($mesAnnonces AS $indice => $valeur ) {
                    if($indice == 'photo') {
                      echo '<td><img src="' . URL . $valeur . '" alt="image produit" style="width: 100px;"></td>';
                    } elseif ($indice == 'description_courte') {
                      echo '<td>' . substr($valeur, 0, 21). '<a class="dropdown-item" href">lire la suite</a></td>';
                    } elseif ($indice == 'description_longue') {
                      echo '<td>' . substr($valeur, 0, 21). '<a href="">...</a></td>';
                    } else {
                      echo '<td>' . $valeur . '</td>';
                    }
                  }  
                  //echo '<pre>'; print_r($ligne); echo '</pre>';


//24 - 2 - création des bouttons de modification et supression , ajouter ?action=modification&id_article='. $ligne['id_article'] .' et 
// ?action=supression&id_article='. $ligne['id_article'] .' dans le href=""
                    echo '<td>'; 
                    echo '<a href="?categorie='.checkInput($mesAnnonces['id_annonce']).'"><i class="fas fa-search"></i></a>';
                    echo '<a href="?modifier='.checkInput($mesAnnonces['id_annonce']).'"><i class="fas fa-edit"></i></a>';
                    echo '<a href="?supprimer=' . checkInput($mesAnnonces['id_annonce']) . '" onclick="return(confirm(\'Etes vous sûr ?\'))"><i class="fas fa-trash"></i></a>';
                    echo '</td>';
                  echo '</tr>';
                }
          echo '</table>';
      echo '</div>';
    echo '</div>';
  }
?>

<?php
include_once('inc/footer.inc.php');
?>
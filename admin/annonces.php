<?php
include_once('../inc/init.inc.php');

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
  echo '<pre>';print_r($laRecupAnnonces);echo'</pre>';
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
  echo '<pre>'; print_r($annonces); echo '</pre>';
}
// Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
/*if (($pseudo_profil != $_SESSION['utilisateur']['pseudo'] || $nom_profil != $_SESSION['utilisateur']['nom'] || $prenom_profil != $_SESSION['utilisateur']['prenom'] || $telephone_profil != $_SESSION['utilisateur']['telephone'] || $email_profil != $_SESSION['utilisateur']['email'] || $civilite_profil != $_SESSION['utilisateur']['civilite']) && empty($msg)){

  $enregistrement = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_membre_profil");
  $enregistrement->bindParam(':id_membre_profil', $id_membre_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':pseudo', $pseudo_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':nom', $nom_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':prenom', $prenom_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':telephone', $telephone_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':email', $email_profil, PDO::PARAM_STR);
  $enregistrement->bindParam(':civilite', $civilite_profil, PDO::PARAM_STR);
  $enregistrement->execute();
  
  //actualisation de la session
  $_SESSION['utilisateur']['pseudo'] = $pseudo_profil;
  $_SESSION['utilisateur']['nom'] = $nom_profil;
  $_SESSION['utilisateur']['prenom'] = $prenom_profil;
  $_SESSION['utilisateur']['telephone'] = $telephone_profil;
  $_SESSION['utilisateur']['email'] = $email_profil;
  $_SESSION['utilisateur']['civilite'] = $civilite_profil;
  
  //message que les informations ont été modifiées

  $msg .= '<div class="alert alert-success mt-2" role="alert">Une ou plusieurs de vos informations personnelles ont correctement été modifiée</div>';
}
*/
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
				<label for="titre">Titre de l'annonce :</label>
				<input type="text" class="form-control" id="titre" name="titre" value="<?php echo $laRecupAnnonces['titre']; ?>">
			</div>
			<div class="form-group">
				<label for="pseudo">Auteur de l'annonce :</label>
				<input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $laRecupAnnonces['pseudo']; ?>">
			</div>
			<div class="form-group">
				<label for="date">Publié le :</label>
				<input type="text" class="form-control" id="date" name="date" value="<?php echo date("Le d F Y  à H:i:s", strtotime($laRecupAnnonces['date_enregistrement'])); ?>">
			</div>
			<div class="form-group">
				<label for="descriptionCourte">Description courte :</label>
				<textarea name="descriptionCourte" id="descriptionCourte" class="w-100" rows="5"><?php echo $laRecupAnnonces['description_courte']; ?></textarea>
			</div>
      <div class="form-group">
				<label for="descriptionLongue">Description longue :</label>
				<textarea name="descriptionLongue" id="descriptionLongue" class="w-100" rows="5"><?php echo $laRecupAnnonces['description_longue']; ?></textarea>
			</div>
			<div class="form-group">
				<label for="prix">Prix :</label>
				<input type="text" class="form-control" id="prix" name="prix" value="<?php echo $laRecupAnnonces['prix']; ?>">
			</div>
			<div class="form-group">
				<label for="pays">Pays :</label>
				<input type="text" class="form-control" id="pays" name="pays" value="<?php echo $laRecupAnnonces['pays']; ?>">
			</div>
      <div class="form-group">
				<label for="ville">Ville :</label>
				<input type="text" class="form-control" id="ville" name="ville" value="<?php echo $laRecupAnnonces['ville']; ?>">
			</div>
			<div class="form-group">
				<label for="photo">Photos :</label>
				<input type="file" class="form-control" id="photo" name="photo"><span><?php echo $laRecupAnnonces['photo']; ?></span>
				<input type="file" class="form-control" id="photo1" name="photo1"><span><?php echo $laRecupAnnonces['photo1']; ?></span>
				<input type="file" class="form-control" id="photo2" name="photo2"><span><?php echo $laRecupAnnonces['photo2']; ?></span>
				<input type="file" class="form-control" id="photo3" name="photo3"><span><?php echo $laRecupAnnonces['photo3']; ?></span>
				<input type="file" class="form-control" id="photo4" name="photo4"><span><?php echo $laRecupAnnonces['photo4']; ?></span>
				<input type="file" class="form-control" id="photo5" name="photo5"><span><?php echo $laRecupAnnonces['photo5']; ?></span>
			</div>
			<div class="form-group">
				<label for="adresse">Adresse :</label>
				<input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $laRecupAnnonces['adresse']; ?>">
			</div>
			<div class="form-group">
				<label for="cp">Code postal :</label>
				<input type="text" class="form-control" id="cp" name="cp" value="<?php echo $laRecupAnnonces['cp']; ?>">
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
              echo '<a class="dropdown-item" href="?categorie=' . $categorie['titre'] . '">'. $categorie['titre'] . '</a>';
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
                while($ligne = $annonces->fetch(PDO::FETCH_ASSOC)) {
                // Affichage des produits dans le tableau
                  echo '<tr>';
                  foreach($ligne AS $indice => $valeur ) {
                    if($indice == 'photo') {
                      echo '<td><img src="' . URL . $valeur . '" alt="image produit" style="width: 100px;"></td>';
                    } elseif ($indice == 'description_courte') {
                      echo '<td>' . substr($valeur, 0, 21). '<a href="">...</a></td>';
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
                    echo '<a href="?categorie='.$ligne['id_annonce'].'"><i class="fas fa-search"></i></a>';
                    echo '<a href="?modifier='.$ligne['id_annonce'].'"><i class="fas fa-edit"></i></a>';
                    echo '<a href="?supprimer=' . $ligne['id_annonce'] . '" onclick="return(confirm(\'Etes vous sûr ?\'))"><i class="fas fa-trash"></i></a>';
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
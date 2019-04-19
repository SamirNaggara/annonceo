<?php
include_once('../inc/init.inc.php');

if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}
//Recuperation des categories dans la base de données

    
    
    

    if (isset($_GET['supprimer'])){
        $supprimerLigne= $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");
        $supprimerLigne->bindParam(':id_annonce', $_GET['supprimer'], PDO::PARAM_STR);
        $supprimerLigne->execute();
        header("location:" . URL . "admin/annonces.php");
    }

    if(isset($_GET['modifier'])) {
      // $recupAnnonces = $pdo->prepare("SELECT a.id_annonce, a.titre AS titre_annonce, a.description_courte, a.description_longue, a.prix, a.photo, p.photo1, p.photo2, p.photo3, p.photo4, p.photo5, a.pays, a.ville, a.adresse, a.cp, m.pseudo, c.titre, a.date_enregistrement  
      // FROM annonce a, membre m, categorie c, photo p
      // WHERE m.id_membre = a.membre_id   
      // AND a.categorie_id = c.id_categorie
      // AND a.photo_id = p.id_photo");
      // echo 'je suis dans le if';
      $recupAnnonces = $pdo->prepare("SELECT * FROM annonce, photo WHERE id_annonce = :id_annonce AND id_photo = photo_id");
      $recupAnnonces->bindParam(':id_annonce', $_GET['modifier'], PDO::PARAM_STR);
      $recupAnnonces->execute();
      // echo '<pre>'; print_r($recupAnnonces); echo '</pre>';
      echo 'je suis dans le if';
      // $recupAnnonces->bindParam(':id_annonce', $_GET['modifier'], PDO::PARAM_STR);

      $laRecupAnnonces = $recupAnnonces->fetch(PDO::FETCH_ASSOC);
        //Ici, une categorie du meme nom existe deja, on procede a l'update
        echo '<pre>'; print_r($laRecupAnnonces); echo '</pre>';

        // $updateAnnonce = $pdo->query("UPDATE annonce SET titre = :titre, description_courte = :descripition_courte, description_longue = :description_longue, prix = :prix, photo = :photo, photo1 = :photo1, photo2 = :photo2, photo3 = :photo3, photo4 = :photo4, photo5 = :photo5, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp WHERE id_annonce = :id_annonce");
        // $updateAnnonce->bindParam(':titre', $nouveauTitre, PDO::PARAM_STR);
        // $updateAnnonce->bindParam(':motscles', $nouveauxMotsCles, PDO::PARAM_STR);
        // $updateAnnonce->execute();
        
        //header("location:" . URL . "admin/categories.php");
        $_GET['modifier']['id_annonce']
    }
    // récuperation des categories
    $recup_categorie = $pdo->query(
      "SELECT * FROM categorie 
      ORDER BY titre"
    );
    // récupération des informations des annonces en fonction des categorie
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
    } else  {
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

 if(isset($_GET['modifier']))
 {
     echo $laRecupAnnonces['titre'];
   ?>
form

<?php
include_once('inc/footer.inc.php');
?>
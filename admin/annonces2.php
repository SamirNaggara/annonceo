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

    if(isset($_POST['nouveauTitre']) && isset($_POST['nouveauxMotsCles'])) {
        //Ici, une categorie du meme nom existe deja, on procede a l'update

        $updateAnnonce = $pdo->prepare("UPDATE annonce SET motscles = :motscles WHERE titre = :titre");
        $updateAnnonce->bindParam(':titre', $nouveauTitre, PDO::PARAM_STR);
        $updateAnnonce->bindParam(':motscles', $nouveauxMotsCles, PDO::PARAM_STR);
        $updateAnnonce->execute();
        
        header("location:" . URL . "admin/categories.php");
    }
    $annonces = $pdo->query("SELECT a.id_annonce, a.titre AS titre_annonce, a.description_courte, a.description_longue, a.prix, a.photo, a.pays, a.ville, a.adresse, a.cp, m.pseudo, c.titre, a.date_enregistrement  FROM annonce a 
    LEFT JOIN membre m ON m.id_membre = a.membre_id   
    LEFT JOIN categorie c ON a.categorie_id = c.id_categorie ");
  include_once('inc/header.inc.php');
  include_once('inc/nav.inc.php');

?>

<?php 
//*****************************
// AFFICHAGE DES ANNONCES
//*****************************
        echo '<div class="d-flex flex-column col-12">';
        echo '<div class="row">';
        echo '<select name="categorie" class="form-control col-2 my-2">';
							$recup_categorie = $pdo->query("SELECT * FROM categorie ORDER BY titre");
							while($categorie = $recup_categorie->fetch(PDO::FETCH_ASSOC)) {
								echo '<option value="' . $categorie['id_categorie'] . '">'. $categorie['titre'].'</option>';
								echo 'probleme dans le while';
							}
        echo '	</select>';
        echo '</div>';
        echo '<div class="row">';
        echo '<table class="table table-hover table-responsive-sm table-responsive-md">';
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
            //24 - 1 - chaque tour de boucle permet d'afficher un produit dans le tableau
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


//24 - 2 - création des bouttons de modification et supression , ajouter ?action=modification&id_article='. $ligne['id_article'] .' et 
// ?action=supression&id_article='. $ligne['id_article'] .' dans le href=""
echo '<td><a href="?action=modification&id_article='. $ligne['id_annonce'] .'" class="btn btn-warning"><i class="fas fa-sync-alt"></i></a></td>';
echo '<td><a href="?action=suppression&id_article='. $ligne['id_annonce'] .'" onclick="return(confirm(\'Etes vous sûr ?\'));" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>';
echo '</tr>';
}

echo '</table>';
echo '</div>';
echo '</div>';
?>
<?php
include_once('inc/footer.inc.php');
?>
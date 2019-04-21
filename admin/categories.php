<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Recuperation des categories dans la base de données

    $categories = $pdo->prepare("SELECT * FROM categorie ORDER BY titre");
    $categories->execute();

    $lesCategories = $categories->fetchAll(PDO::FETCH_ASSOC);




// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par défaut
$nouveauTitre = '';
$nouveauxMotsCles = '';

if (isset($_GET['supprimer'])){
    $supprimerLigne= $pdo->prepare("DELETE FROM categorie WHERE titre = :titre");
    $supprimerLigne->bindParam(':titre', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    
    header("location:" . URL . "admin/categories.php");
}


if(isset($_POST['nouveauTitre']) && isset($_POST['nouveauxMotsCles'])) {

        
	// on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	}
    



	// si ça existe, on place la saisie du formulaire dans ces variables.
	$nouveauTitre = $_POST['nouveauTitre'];
	$nouveauxMotsCles = $_POST['nouveauxMotsCles'];

    
    //Verification de si la categorie existe
    
    $verif_categorie = $pdo->prepare("SELECT * FROM categorie WHERE titre=:titre");
	$verif_categorie -> bindParam(':titre', $nouveauTitre, PDO::PARAM_STR);
	$verif_categorie -> execute();
    
    if($verif_categorie->rowCount() < 1) {
        //Ici, il n'y a pas de nouvelle categorie, on procede a l'enregistrerment
        		
        $enregistrement = $pdo->prepare("INSERT INTO categorie (titre, motscles) VALUES (:titre, :motscles)");
		$enregistrement->bindParam(':titre', $nouveauTitre, PDO::PARAM_STR);
		$enregistrement->bindParam(':motscles', $nouveauxMotsCles, PDO::PARAM_STR);

		$enregistrement->execute();
        
        header("location:" . URL . "admin/categories.php");
    }
    else{
        //Ici, une categorie du meme nom existe deja, on procede a l'update

        $updateCategorie = $pdo->prepare("UPDATE categorie SET motscles = :motscles WHERE titre = :titre");
        $updateCategorie->bindParam(':titre', $nouveauTitre, PDO::PARAM_STR);
        $updateCategorie->bindParam(':motscles', $nouveauxMotsCles, PDO::PARAM_STR);
        $updateCategorie->execute();
        
        header("location:" . URL . "admin/categories.php");

    }
    
}




include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>



<div id="content-wrapper">
 

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Liste des categories
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id categorie</th>
                            <th>Titre</th>
                            <th>Mots cles</th>
                            <th>Action</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach($lesCategories as $laCategorie){
                            echo '<tr>';
                            echo '<td>' . $laCategorie['id_categorie'] . '</td>';
                            echo '<td>' . $laCategorie['titre'] . '</td>';
                            echo '<td>' . $laCategorie['motscles'] . '</td>';
                            ?>
                            <td> 
                                <a href="annonces.php?categorie=<?php echo $laCategorie['titre'] ?>"><i class="fas fa-search"></i></a>
                                <a href="?modifier=<?php echo $laCategorie['titre'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="?supprimer=<?php echo $laCategorie['titre'] ?>" onclick="return(confirm('Etes vous sûr ?'))"><i class="fas fa-trash"></i></a>
                            </td>
                            <?php
                            echo '</tr>';
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Catégories</a>
            </li>
            <li class="breadcrumb-item active">Gestion des catégories</li>
        </ol>


        <div class="col-6 mx-auto">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nouveauTitre">Titre de la nouvelle categorie</label>
                    <input type="text" class="form-control" id="nouveauTitre" name="nouveauTitre" <?php if (isset($_GET["modifier"])){
                        echo 'value="' . $_GET["modifier"] . '"';} ?>>
                </div>

                <div class="form-group">
                    <label for="nouveauxMotsCles">Mots clefs</label>
                    <input type="text" class="form-control" id="nouveauxMotsCles" name="nouveauxMotsCles">
                </div>


                <button type="submit" class="btn btn-primary">Valider</button>
            </form>

        </div>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');
?>
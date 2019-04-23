<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Recuperation des categories dans la base de données

    $infosCommentaires = $pdo->prepare("SELECT c.id_commentaire, c.commentaire, c.date_enregistrement, m.id_membre, m.pseudo, a.id_annonce, a.titre  
    FROM commentaire c
    LEFT JOIN membre m ON m.id_membre = c.membre_id
    LEFT JOIN annonce a ON a.id_annonce = c.annonce_id
    ORDER BY c.date_enregistrement DESC;");
    $infosCommentaires->execute();

    $lesCommentaires = $infosCommentaires->fetchAll(PDO::FETCH_ASSOC);




// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par défaut
$inputIdCommentaire = '';
$inputNouveauCommentaire = '';

if (isset($_GET['supprimer'])){

    //Supprimer un membre dans la base de donnée
    $supprimerLigne= $pdo->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
    $supprimerLigne->bindParam(':id_commentaire', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    
    header("location:" . URL . "admin/commentaires.php");
}


$inputIdCommentaire = "";
$inputIdMembre = "";
$inputIdAnnonce = "";
$inputCommentaire = "";

if (isset($_GET['modifier'])){

    //Recuperation des données du commentaire concerné pour les placer dans le formulaire
  $recuperationCommentaire= $pdo->prepare("SELECT c.id_commentaire, c.commentaire, c.date_enregistrement, m.id_membre, m.pseudo, a.id_annonce, a.titre  
    FROM commentaire c
    LEFT JOIN membre m ON m.id_membre = c.membre_id
    LEFT JOIN annonce a ON a.id_annonce = c.annonce_id
    WHERE c.id_commentaire = :id_commentaire
    ORDER BY c.date_enregistrement DESC;");
  $recuperationCommentaire->bindParam(':id_commentaire', $_GET['modifier'], PDO::PARAM_STR);
  $recuperationCommentaire->execute();
  
  $commentaireAModifier = $recuperationCommentaire->fetch(PDO::FETCH_ASSOC);
    

    $inputIdCommentaire = $commentaireAModifier['id_commentaire'];
    $inputIdMembre = $commentaireAModifier['id_membre'] . " - " . $commentaireAModifier['pseudo'];
    $inputIdAnnonce = $commentaireAModifier['id_annonce'] . " - " . $commentaireAModifier['titre'];
    $inputCommentaire = $commentaireAModifier['commentaire'];


}



//Une fois que le formulaire est validée, les données sont enregistrer dans la base de données si l'id existe
$nouveauIdCommentaire = "";
$nouveauCommentaire = "";



if(isset($_POST['inputIdCommentaire']) && isset($_POST['inputCommentaire']) && isset($_POST['validationModeration']) ) {
    
        
	// on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	}
    



	// si ça existe, on place la saisie du formulaire dans ces variables.
	$nouveauIdCommentaire = $_POST['inputIdCommentaire'];
	$nouveauCommentaire = $_POST['inputCommentaire'];
    
    
    
    //Verification de si l'id existe
    
    $verif_commentaire = $pdo->prepare("SELECT * FROM commentaire WHERE id_commentaire=:id_commentaire");
	$verif_commentaire -> bindParam(':id_commentaire', $nouveauIdCommentaire, PDO::PARAM_STR);
	$verif_commentaire -> execute();
    
    if($verif_commentaire->rowCount() > 0) {
        //Ici, l'id commentaire existe bel et bien, on update les changement
        $enregistrement = $pdo->prepare("UPDATE commentaire SET commentaire = :nouveauCommentaire WHERE id_commentaire=:id_commentaire");
		$enregistrement->bindParam(':id_commentaire', $nouveauIdCommentaire, PDO::PARAM_STR);
		$enregistrement->bindParam(':nouveauCommentaire', $nouveauCommentaire, PDO::PARAM_STR);

		$enregistrement->execute();
        
        header("location:" . URL . "admin/commentaires.php");
    }
    else{
        //Ici, l'id n'existe pas, on renvoie un message d'erreur

        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, le commentaire que vous avez essayé de modérer n\'existe pas.<br>Veuillez recommencer</div>';
        

    }
    
}


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>



<div id="content-wrapper">
    <!--Pour afficher des message -->
    <p class="lead"><?php echo $msg;?></p>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Liste des commentaires
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id commentaires</th>
                            <th>Id membre</th>
                            <th>Id Annonce</th>
                            <th>Commentaire</th>
                            <th>Date d'enregistrement</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach($lesCommentaires as $leCommentaire){
                            
                            
                            echo '<tr>';
                            echo '<td>' . $leCommentaire['id_commentaire'] . '</td>';
                            echo '<td>' . $leCommentaire['id_membre'] . " - " . ucfirst($leCommentaire['pseudo']) . '</td>';
                            echo '<td>' . $leCommentaire['id_annonce'] . " - " . ucfirst($leCommentaire['titre']) . '</td>';
                            echo '<td>' . $leCommentaire['commentaire'] . '</td>';
                            echo '<td>' . formatStandardTotal($leCommentaire['date_enregistrement']) . '</td>';
                            ?>
                            <td> 
                                <a href="?modifier=<?php echo $leCommentaire['id_commentaire'] ?>#inputCommentaire"><i class="fas fa-edit"></i></a>

                                <a href="?supprimer=<?php echo $leCommentaire['id_commentaire'] ?>" onclick="return(confirm('Etes vous sûr de vouloir supprimer?'))"><i class="fas fa-trash"></i></a>
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
                <a href="#">Note</a>
            </li>
            <li class="breadcrumb-item active">Modérer un commentaire</li>
        </ol>

        <div class="col-6 mx-auto">
            <form action="<?php echo URL . 'admin/commentaires.php' ?>" method="post">
                <div class="form-group">
                    <label for="nouvelleIdCommentaire">ID Commentaire</label>
                    <input type="text" class="form-control" id="inputIdCommentaire" name="inputIdCommentaire" <?php echo 'value="' . $inputIdCommentaire . '"'; ?>>
                </div>
                <div class="form-group">
                    <label for="inputIdMembre">Id Membre</label>
                    <input type="text" class="form-control" id="inputIdMembre" name="inputIdMembre" disabled <?php echo 'value="' . $inputIdMembre . '"'; ?>>
                </div>
                <div class="form-group">
                    <label for="inputIdAnnonce">Id annonce</label>
                    <input type="text" class="form-control" id="inputIdAnnonce" name="inputIdAnnonce" disabled <?php echo 'value="' . $inputIdAnnonce . '"'; ?>>
                </div>

                <div class="form-group">
                    <label for="inputCommentaire">Commentaire</label>
                    <input type="text" class="form-control" id="inputCommentaire" name="inputCommentaire" <?php echo 'value="' . $inputCommentaire . '"'; ?>>
                </div>

                <button type="submit" class="btn btn-primary" name="validationModeration">Moderer l'avis</button>
            </form>

        </div>
    </div>

</div>

<?php
include_once('inc/footer.inc.php');
?>
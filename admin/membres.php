<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Recuperation des categories dans la base de données

    $infosMembre = $pdo->prepare("SELECT * FROM membre ORDER BY date_enregistrement DESC");
    $infosMembre->execute();

    $lesMembres = $infosMembre->fetchAll(PDO::FETCH_ASSOC);




// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par défaut
$inputIdMembre = '';
$inputNouveauStatut = '';

if (isset($_GET['supprimer'])){

    //Supprimer un membre dans la base de donnée
    $supprimerLigne= $pdo->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
    $supprimerLigne->bindParam(':id_membre', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    
    header("location:" . URL . "admin/membres.php");
}

$changementAdmin = "";
if (isset($_GET['changementAdmin'])){
  $changementAdmin = $_GET['changementAdmin']; 
}

if (isset($_GET['modifierAdmin'])){

    //Recuperation du statut du membre concerné
  $recuperationStatut= $pdo->prepare("SELECT statut FROM membre WHERE id_membre = :id_membre");
  $recuperationStatut->bindParam(':id_membre', $_GET['modifierAdmin'], PDO::PARAM_STR);
  $recuperationStatut->execute();
  
  $statut = $recuperationStatut->fetch(PDO::FETCH_ASSOC);

    //Si l'utilisateur est un membre, on update le statut a 2
  if ($statut['statut'] == 1){
    $updateStatut= $pdo->prepare("UPDATE membre SET statut = 2 WHERE id_membre = :id_membre");
    $updateStatut->bindParam(':id_membre', $_GET['modifierAdmin'], PDO::PARAM_STR);
    $updateStatut->execute();
  } else{
    $updateStatut= $pdo->prepare("UPDATE membre SET statut = 1 WHERE id_membre = :id_membre");
    $updateStatut->bindParam(':id_membre', $_GET['modifierAdmin'], PDO::PARAM_STR);
    $updateStatut->execute();
  }

   header("location:" . URL . "admin/membres.php");
}







include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>



<div id="content-wrapper">
    <!--Pour afficher des message -->
    <p class="lead"><?php echo $msg;?></p>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Liste des membres
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id membre</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Civilité</th>
                            <th>Statut</th>
                            <th>Date d'enregistrement</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach($lesMembres as $leMembre){
                            echo '<tr>';
                            echo '<td>' . $leMembre['id_membre'] . '</td>';
                            echo '<td>' . $leMembre['pseudo'] . '</td>';
                            echo '<td>' . $leMembre['nom'] . '</td>';
                            echo '<td>' . $leMembre['prenom'] . '</td>';
                            echo '<td>' . $leMembre['telephone'] . '</td>';
                            echo '<td>' . $leMembre['email'] . '</td>';
                            echo '<td>' . $leMembre['civilite'] . '</td>';
                            echo '<td>' . $leMembre['statut'] . '</td>';
                            echo '<td>' . formatStandardTotal($leMembre['date_enregistrement']) . '</td>';
                            ?>
                            <td> 
                                <a href="?changementAdmin=<?php echo $leMembre['id_membre'] ?>#modifierAdmin"><i class="fas fa-edit"></i></a>

                                <a href="?supprimer=<?php echo $leMembre['id_membre'] ?>" onclick="return(confirm('Etes vous sûr ?'))"><i class="fas fa-trash"></i></a>
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
                <a href="#">Administrateur</a>
            </li>
            <li class="breadcrumb-item active">Nommer ou supprimer un administrateur</li>
        </ol>


        <div class="col-6 mx-auto">
            <form action="" method="get">
                <div class="form-group">
                    <label for="nouveauTitre">ID membre</label>
                    <input type="text" class="form-control" id="modifierAdmin" name="modifierAdmin" <?php echo 'value="' . $changementAdmin . '"'; ?>>
                </div>

                <button type="submit" class="btn btn-primary">Changer le statut</button>
            </form>

        </div>
    </div>

</div>

<?php
include_once('inc/footer.inc.php');
?>
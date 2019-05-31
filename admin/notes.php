<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Recuperation des categories dans la base de données

    $infosNotes = $pdo->prepare("SELECT n.id_note, m.pseudo as pseudoDonneur, m.id_membre as idDonneur, a.pseudo as pseudoReceveur, a.id_membre as idReceveur,  n.note, n.avis, n.date_enregistrement
    FROM note n
    LEFT JOIN membre m ON m.id_membre = n.membre_id1
    LEFT JOIN membre a ON a.id_membre = n.membre_id2
    ORDER BY n.date_enregistrement DESC;");
    $infosNotes->execute();

    $lesNotes = $infosNotes->fetchAll(PDO::FETCH_ASSOC);




// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par défaut
$inputIdMembre = '';
$inputNouveauStatut = '';

if (isset($_GET['supprimer'])){

    //Supprimer un membre dans la base de donnée
    $supprimerLigne= $pdo->prepare("DELETE FROM note WHERE id_note = :id_note");
    $supprimerLigne->bindParam(':id_note', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    
    header("location:" . URL . "admin/notes.php/#");
}


$inputIdNote = "";
$inputPseudoDonneur = "";
$inputPseudoReceveur = "";
$inputNote = "";
$inputAvis = "";

if (isset($_GET['modifier'])){

    //Recuperation des données de la notes concernées
  $recuperationNote= $pdo->prepare("SELECT n.id_note, m.pseudo as pseudoDonneur, m.id_membre as idDonneur, a.pseudo as pseudoReceveur, a.id_membre as idReceveur,  n.note, n.avis, n.date_enregistrement
    FROM note n
    LEFT JOIN membre m ON m.id_membre = n.membre_id1
    LEFT JOIN membre a ON a.id_membre = n.membre_id2
    WHERE n.id_note = :id_note
    ORDER BY n.date_enregistrement DESC;");
  $recuperationNote->bindParam(':id_note', $_GET['modifier'], PDO::PARAM_STR);
  $recuperationNote->execute();
  
  $noteAModifier = $recuperationNote->fetch(PDO::FETCH_ASSOC);
    

    $inputIdNote = $noteAModifier['id_note'];
    $inputPseudoDonneur = $noteAModifier['idDonneur'] . " - " . $noteAModifier['pseudoDonneur'];
    $inputPseudoReceveur = $noteAModifier['idReceveur'] . " - " . $noteAModifier['pseudoReceveur'];
    $inputAvis = $noteAModifier['avis'];
    $inputNote = $noteAModifier['note'];


}



$nouvelleIdNote = "";
$nouvelletNote = "";
$nouvelleAvis = "";



if(isset($_POST['inputIdNote']) && isset($_POST['inputNote']) && isset($_POST['inputAvis']) && isset($_POST['validationModeration']) ) {
    
        
	// on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	}
    



	// si ça existe, on place la saisie du formulaire dans ces variables.
	$nouvelleIdNote = $_POST['inputIdNote'];
	$nouvelleNote = $_POST['inputNote'];
	$nouvelleAvis = $_POST['inputAvis'];

    
    //Verification de si l'id existe
    
    $verif_note = $pdo->prepare("SELECT * FROM note WHERE id_note=:id_note");
	$verif_note -> bindParam(':id_note', $nouvelleIdNote, PDO::PARAM_STR);
	$verif_note -> execute();
    
    if($verif_note->rowCount() > 0) {
        //Ici, l'id note existe bel et bien, on update les changement
        $enregistrement = $pdo->prepare("UPDATE note SET note = :nouvelleNote, avis = :nouvelleAvis WHERE id_note=:id_note");
		$enregistrement->bindParam(':id_note', $nouvelleIdNote, PDO::PARAM_STR);
		$enregistrement->bindParam(':nouvelleNote', $nouvelleNote, PDO::PARAM_STR);
		$enregistrement->bindParam(':nouvelleAvis', $nouvelleAvis, PDO::PARAM_STR);

		$enregistrement->execute();
        
        header("location:" . URL . "admin/notes.php");
    }
    else{
        //Ici, l'id n'existe pas, on renvoie un message d'erreur

        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, la note que vous avez essayer de modérer n\'existe pas.<br>Veuillez recommencer</div>';
        

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
            Liste des notes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id notes</th>
                            <th>Id/Pseudo donneur</th>
                            <th>Id/Pseudo receveur</th>
                            <th>Note</th>
                            <th>Avis</th>
                            <th>Date</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach($lesNotes as $laNote){
                            
                            
                            echo '<tr>';
                            echo '<td>' . $laNote['id_note'] . '</td>';
                            echo '<td>' . $laNote['idDonneur'] . " - " . ucfirst($laNote['pseudoDonneur']) . '</td>';
                            echo '<td>' . $laNote['idReceveur'] . " - " . ucfirst($laNote['pseudoReceveur']) . '</td>';
                            echo '<td>' . $laNote['note'] . "/5" . '</td>';
                            echo '<td>' . $laNote['avis'] . '</td>';
                            echo '<td>' . formatStandardTotal($laNote['date_enregistrement']) . '</td>';
                            ?>
                            <td class="btn-note"> 
                                <a href="?modifier=<?php echo $laNote['id_note'] ?>#inputAvis"><i class="fas fa-edit"></i></a>

                                <a href="?supprimer=<?php echo $laNote['id_note'] ?>" onclick="return(confirm('Etes vous sûr ?'))"><i class="fas fa-trash"></i></a>
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
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Note</a>
        </li>
        <li class="breadcrumb-item active">Modérer une note ou un avis</li>
    </ol>
    <div class="col-sm-8 col-6 mx-auto">
        <form action="<?php echo URL . 'admin/notes.php' ?>" method="post">
            <div class="form-group">
                <label for="nouvelleIdNote">ID Note</label>
                <input type="text" class="form-control" id="inputIdNote" name="inputIdNote" <?php echo 'value="' . $inputIdNote . '"'; ?>>
            </div>
            <div class="form-group">
                <label for="inputPseudoAcheteur">Pseudo Donneur</label>
                <input type="text" class="form-control" id="inputPseudoAcheteur" name="inputPseudoAcheteur" disabled <?php echo 'value="' . $inputPseudoDonneur . '"'; ?>>
            </div>
            <div class="form-group">
                <label for="inputPseudoVendeur">Pseudo Receveur</label>
                <input type="text" class="form-control" id="inputPseudoVendeur" name="inputPseudoVendeur" disabled <?php echo 'value="' . $inputPseudoReceveur . '"'; ?>>
            </div>
            <div class="form-group">
                <label for="inputNote">Note</label>
                <select name="inputNote" id="inputNote">
                    <option value="0" <?php if (isset($_GET['modifier']) && $inputNote == 0) echo 'selected'; ?>>0</option>
                    <option value="1" <?php if (isset($_GET['modifier']) && $inputNote == 1) echo 'selected'; ?>>1</option>
                    <option value="2" <?php if (isset($_GET['modifier']) && $inputNote == 2) echo 'selected'; ?>>2</option>
                    <option value="3" <?php if (isset($_GET['modifier']) && $inputNote == 3) echo 'selected'; ?>>3</option>
                    <option value="4" <?php if (isset($_GET['modifier']) && $inputNote == 4) echo 'selected'; ?>>4</option>
                    <option value="5" <?php if (isset($_GET['modifier']) && $inputNote == 5) echo 'selected'; ?>>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputAvis">Avis</label>
                <input type="text" class="form-control" id="inputAvis" name="inputAvis" <?php echo 'value="' . $inputAvis . '"'; ?>>
            </div>

            <button type="submit" class="btn btn-dark" name="validationModeration">Moderer l'avis</button>
        </form>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');
?>
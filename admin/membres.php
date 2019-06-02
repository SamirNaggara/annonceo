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

// Récupération des infos du membre pour afficher dans nos values
    $recupInfosMembre= $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");  
    $recupInfosMembre->bindParam(':id_membre', $_GET['changementMembre'], PDO::PARAM_STR);
    $recupInfosMembre->execute();
    $infoMembre = $recupInfosMembre->fetch(PDO::FETCH_ASSOC);

    $pseudo_membre = $infoMembre['pseudo'];
    $nom_membre = $infoMembre['nom']; 
    $prenom_membre = $infoMembre['prenom'];
    $telephone_membre = $infoMembre['telephone'];
    $email_membre = $infoMembre['email'];
    $civilite_membre = $infoMembre['civilite'];

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
if (isset($_GET['changementMembre'])){
    $changement_id_membre = $_GET['changementMembre']; 
    echo '<pre>'; print_r($changement_id_membre); echo '</pre>';
}
/* if (isset($_GET['modifierMembre'])){  */

    if(isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['validerMembre'])) {

        // on enlève les espace en début et fin de chaine avec trim()
        foreach($_POST AS $indice => $valeur) {
            $_POST[$indice] = trim($_POST[$indice]);
        } 
        
        // controle sur la taille du pseudo entre 4 et 14 caractères inclus
        if(iconv_strlen($pseudo_membre) < 4 || iconv_strlen($pseudo_membre) > 14) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, Le pseudo doit avoir entre 4 et 14 caractères inclus.<br>Veuillez recommencer</div>';
        }    
        
        // si ça existe, on place la saisie du formulaire dans ces variables.
        $pseudo_membre = strtolower($_POST['pseudo']);
        $nom_membre = strtolower($_POST['nom']); 
        $prenom_membre = strtolower($_POST['prenom']);
        $telephone_membre = $_POST['telephone'];
        $email_membre = $_POST['email'];
        $civilite_membre = $_POST['civilite'];       
        
        // vérification des caractères présent dans le pseudo
        if (!preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo_membre)) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre pseudo est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
        }
        
        // vérification des caractères présent dans le prenom
        if (!preg_match('#^[a-zA-Z0-9._-]+$#', $prenom_membre)) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
        }
        
        // vérification des caractères présent dans le nom
        if (!preg_match('#^[a-zA-Z0-9._-]+$#', $nom_membre)) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
        }
        
        // verification si le pseudo est disponible en BDD car unique
        $verif_pseudo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND id_membre != :id_membre_profil");
        $verif_pseudo->bindParam(':id_membre_profil', $changement_id_membre, PDO::PARAM_STR);
        $verif_pseudo->bindParam(':pseudo', $pseudo_membre, PDO::PARAM_STR);
        $verif_pseudo->execute();
    
        if($verif_pseudo->rowCount() > 0) {
            // s'il y a plus de 1 ligne alors le pseudo existe en plus de celui de l'identifiant en cours
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention ce pseudo est deja utilisé.<br>Veuillez en choisir un autre</div>';
        }   
        // vérification du format de l'email
        if(!isEmail($email_membre)) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
        }
        
        // vérification du format telephone
        if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $telephone_membre)) {
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du téléphone n\'est pas valide.<br>Veuillez recommencer</div>';
        }  
      //Recuperation du statut du membre concerné
        if($pseudo_membre != $_POST['pseudo'] || $civilite_membre != $_POST['civilite'] || $nom_membre != $_POST['nom'] || $telephone_membre != $_POST['telephone'] || $prenom_membre != $_POST['prenom'] || $email_membre != $_POST['email']) {

        
        

        $updateMembre = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_membre");
        $updateMembre->bindParam(':id_membre', $changement_id_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':pseudo', $pseudo_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':nom', $nom_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':prenom', $prenom_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':telephone', $telephone_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':email', $email_membre, PDO::PARAM_STR);
        $updateMembre->bindParam(':civilite', $civilite_membre, PDO::PARAM_STR);
        $updateMembre->execute();
/* 
        $_GET['pseudo'] =$pseudo_membre;
        $_GET['nom'] = $nom_membre; 
        $_GET['prenom'] = $prenom_membre;
        $_GET['telephone'] = $telephone_membre;
        $_GET['email'] = $email_membre;
        $_GET['civilite'] = $civilite_membre; */
        }
        header("location:" . URL . "admin/membres.php");
    /*}*/
}

$changementAdmin = "";
if (isset($_GET['changementAdmin'])){
  $changementAdmin = $_GET['changementAdmin']; 
}

elseif (isset($_GET['modifierAdmin'])){

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
            <div class="table-responsive tableMembre">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Id membre</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Civilité</th>
                            <th>Statut</th>
                            <th>Date d'updateMembre</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach($lesMembres as $leMembre){
                            
                            if ($leMembre['statut'] == 1){
                                $leMembreStatut = 'Membre';
                            }elseif ($leMembre['statut'] == 2){
                                $leMembreStatut = 'Admin';
                            }else{
                                $leMembreStatut = "Il y a un probleme avec le statut";
                            }
                            if ($leMembre['civilite'] =='f') { 
                                $leMembreCivilite = 'Femme';
                            } else { 
                                $leMembreCivilite = 'Homme';
                            }
                            
                            echo '<tr>';
                            echo '<td class="membre">' . $leMembre['id_membre'] . '</td>';
                            echo '<td class="pseudo">' . ucfirst($leMembre['pseudo']) . '</td>';
                            echo '<td class="nom">' . ucfirst($leMembre['nom']) . '</td>';
                            echo '<td class="prenom">' . ucfirst($leMembre['prenom']) . '</td>';
                            echo '<td class="telephone">' . $leMembre['telephone'] . '</td>';
                            echo '<td class="email">' . $leMembre['email'] . '</td>';
                            echo '<td class="civilite">' . $leMembreCivilite . '</td>';
                            echo '<td class="statut">' . $leMembreStatut . '</td>';
                            echo '<td class="date">' . formatStandardTotal($leMembre['date_enregistrement']) . '</td>';
                            ?>
                            <td class="btn-membre"> 
                                <a href="?changementAdmin=<?php echo $leMembre['id_membre'] ?>#modifierAdmin"><i class="fas fa-user"></i></a>
                                <a href="?changementMembre=<?php echo $leMembre['id_membre'] ?>#modifierMembre"><i class="fas fa-edit"></i></a>

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
        <?php
        if (isset($_GET['changementAdmin'])){
        ?>
        <div class="col-6 mx-auto">
            <form action="" method="get">
                <div class="form-group">
                    <label for="nouveauTitre">ID membre</label>
                    <input type="text" class="form-control" id="modifierAdmin" name="modifierAdmin" <?php echo 'value="' . $changementAdmin . '"'; ?>>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark d-block mx-auto">Changer le statut</button>
                </div>
            </form>
        </div>
        <?php } ?>
        <?php 
        if (isset($_GET['changementMembre'])){
        ?>
        <div class="col-sm-12 col-6 mx-auto">
            <form method="post" class="col-sm-12 col-8 proForm pl-2">
                <div class="row m-0">
                    <div class="form-group col-6">
                        <label for="id_membre">Identifiant</label>
                        <input type="text" disabled="disabled" class="form-control" id="id_membre" name="id_membre" value="<?php echo $infoMembre['id_membre']; ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="date_enregistrement">Date d'inscription</label>
                        <input type="text" disabled="disabled" class="form-control" id="date_enregistrement" name="date_enregistrement" value="<?php echo $infoMembre['date_enregistrement']; ?>">
                    </div>
                    <div class="form-group col-6 fg-pseudo">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" class="form-control" id="modifierMembre" name="pseudo" value="<?php echo ucfirst($pseudo_membre); ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="civilite">Sexe</label>
                        <select class="form-control col-12" id="civilite" name="civilite">
                            <option value="m">masculin</option>
                            <option value="f" <?php if($civilite_membre == 'f') echo 'selected'; ?>>féminin</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo ucfirst($nom_membre); ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="telephone">Telephone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone_membre; ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo ucfirst($prenom_membre); ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email_membre; ?>">
                    </div>
                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-dark col-12" name="validerMembre">Valider</button>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>

</div>

<?php
include_once('inc/footer.inc.php');
?>
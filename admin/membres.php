<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Recuperation des membres dans la base de données pour afficahge tableaux
$infosMembre = $pdo->prepare("SELECT * FROM membre ORDER BY date_enregistrement DESC");
$infosMembre->execute();
$lesMembres = $infosMembre->fetchAll(PDO::FETCH_ASSOC);

// déclaration de variable pour afficher les valeurs dans les values de nos champs // vides par défaut
$inputIdMembre = '';
$inputNouveauStatut = '';
$infoDuMembre = '';

if (isset($_GET['supprimer'])){

    //Supprimer un membre dans la base de donnée
    $supprimerLigne= $pdo->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
    $supprimerLigne->bindParam(':id_membre', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    
    header("location:" . URL . "admin/membres.php");
}

$changementAdmin = "";

if (isset($_GET['modifInfoMembre'])){
    $changementAdmin = $_GET['modifInfoMembre']; 
}

if (isset($_GET['modifInfoMembre'])){

    //Recuperation du statut du membre concerné
    $recuperationStatut= $pdo->prepare("SELECT statut FROM membre WHERE id_membre = :id_membre");
    $recuperationStatut->bindParam(':id_membre', $_GET['modifInfoMembre'], PDO::PARAM_STR);
    $recuperationStatut->execute();
    
    $statut = $recuperationStatut->fetch(PDO::FETCH_ASSOC);

//Si l'utilisateur est un membre, on update le statut a 2
if ($statut['statut'] == 1){
    $updateStatut= $pdo->prepare("UPDATE membre SET statut = 2 WHERE id_membre = :id_membre");
    $updateStatut->bindParam(':id_membre', $_GET['modifInfoMembre'], PDO::PARAM_STR);
    $updateStatut->execute();
} else{
    $updateStatut= $pdo->prepare("UPDATE membre SET statut = 1 WHERE id_membre = :id_membre");
    $updateStatut->bindParam(':id_membre', $_GET['modifInfoMembre'], PDO::PARAM_STR);
    $updateStatut->execute();
    }
    header("location:" . URL . "admin/membres.php");
    



$bo_pseudo_profil = "";
$bo_nom_profil = ""; 
$bo_prenom_profil = "";
$bo_telephone_profil = "";
$bo_email_profil = "";
$bo_civilite_profil = "";


    $id_bo_membre_profil = $_GET['modifInfoMembre'];
    $recupinfosMembre = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $recupinfosMembre->bindParam(':id_membre', $_GET['modifInfoMembre'], PDO::PARAM_STR);
    $recupinfosMembre->execute();

    $infoDuMembre = $recupinfosMembre->fetch(PDO::FETCH_ASSOC);
    
}

if(isset($_POST['bo_pseudo_profil']) && isset($_POST['bo_nom_profil']) && isset($_POST['bo_prenom_profil']) && isset($_POST['bo_telephone_profil']) && isset($_POST['bo_email_profil']) && isset($_POST['bo_civilite_profil'])) {

    // on enlève les espace en début et fin de chaine avec trim()
    foreach($_POST AS $indice => $valeur) {
        $_POST[$indice] = trim($_POST[$indice]);
    } 

    // si ça existe, on place la saisie du formulaire dans ces variables.
    $bo_pseudo_profil = strtolower($_POST['bo_pseudo_profil']);
    $bo_nom_profil = strtolower($_POST['bo_nom_profil']); 
    $bo_prenom_profil = strtolower($_POST['bo_prenom_profil']);
    $bo_telephone_profil = $_POST['bo_telephone_profil'];
    $bo_email_profil = $_POST['bo_email_profil'];
    $bo_civilite_profil = $_POST['bo_civilite_profil'];  

    // controle sur la taille du pseudo entre 4 et 14 caractères inclus
    if(iconv_strlen($bo_pseudo_profil) < 4 || iconv_strlen($bo_pseudo_profil) > 14) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, Le pseudo doit avoir entre 4 et 14 caractères inclus.<br>Veuillez recommencer</div>';
    }    

    echo '<pre>'; print_r($bo_pseudo_profil); echo '</pre>';
    // vérification des caractères présent dans le pseudo
    if (!preg_match('#^[a-zA-Z0-9._-]+$#', $bo_pseudo_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre pseudo est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
    }
    
    // vérification des caractères présent dans le prenom
    if (!preg_match('#^[a-zA-Z0-9._-]+$#', $bo_prenom_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
    }
    
    // vérification des caractères présent dans le nom
    if (!preg_match('#^[a-zA-Z0-9._-]+$#', $bo_nom_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
    }
    
    // verification si le pseudo est disponible en BDD car unique
    $verif_bo_pseudo_profil = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND id_membre = :id_membre");
    $verif_bo_pseudo_profil->bindParam(':id_membre', $id_bo_membre_profil, PDO::PARAM_STR);
    $verif_bo_pseudo_profil->bindParam(':pseudo', $bo_pseudo_profil, PDO::PARAM_STR);
    $verif_bo_pseudo_profil->execute();

    if($verif_bo_pseudo_profil->rowCount() > 0) {
        // s'il y a plus de 1 ligne alors le pseudo existe en plus de celui de l'identifiant en cours
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention ce pseudo est deja utilisé.<br>Veuillez en choisir un autre</div>';
    }   
    // vérification du format de l'email
    if(!isEmail($bo_email_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
    }
    
    // vérification du format telephone
    if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $bo_telephone_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du téléphone n\'est pas valide.<br>Veuillez recommencer</div>';
    }  
    // Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
    if (($bo_pseudo_profil != $infoDuMembre['pseudo'] || $bo_nom_profil != $infoDuMembre['nom'] || $bo_prenom_profil != $infoDuMembre['prenom'] || $bo_telephone_profil != $infoDuMembre['telephone'] || $bo_email_profil != $infoDuMembre['email'] || $bo_civilite_profil != $infoDuMembre['civilite']) && empty($msg)){
        echo 'test';
        $enregistrement = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_bo_membre_profil");
        $enregistrement->bindParam(':id_bo_membre_profil', $id_bo_membre_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':pseudo', $bo_pseudo_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':nom', $bo_nom_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':prenom', $bo_prenom_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':telephone', $bo_telephone_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':email', $bo_email_profil, PDO::PARAM_STR);
        $enregistrement->bindParam(':civilite', $bo_civilite_profil, PDO::PARAM_STR);
        $enregistrement->execute();

        $msg .= '<div class="alert alert-success mt-2" role="alert">Les informations du membres ont été modifiées</div>';
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
                            
                            if ($leMembre['statut'] == 1){
                                $leMembreStatut = 'Membre';
                            }elseif ($leMembre['statut'] == 2){
                                $leMembreStatut = 'Admin';
                            }else{
                                $leMembreStatut = "Il y a un probleme avec le statut";
                            }
                            
                            echo '<tr>';
                            echo '<td>' . $leMembre['id_membre'] . '</td>';
                            echo '<td>' . ucfirst($leMembre['pseudo']) . '</td>';
                            echo '<td>' . ucfirst($leMembre['nom']) . '</td>';
                            echo '<td>' . ucfirst($leMembre['prenom']) . '</td>';
                            echo '<td>' . $leMembre['telephone'] . '</td>';
                            echo '<td>' . $leMembre['email'] . '</td>';
                            echo '<td>' . $leMembre['civilite'] . '</td>';
                            echo '<td>' . $leMembreStatut . '</td>';
                            echo '<td>' . formatStandardTotal($leMembre['date_enregistrement']) . '</td>';
                            ?>
                            <td> 
                                <a href="?changementAdmin=<?php echo $leMembre['id_membre'] ?>#modifierAdmin"><i class="fas fa-user-tie"></i></a>
                                <a href="?modifInfoMembre=<?php echo $leMembre['id_membre'] ?>"><i class="fas fa-edit"></i></a>
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
        // Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
        if(isset($_GET['changementAdmin']) && $_GET['changementAdmin'] == $leMembre['id_membre']) {    
        ?>
        <div class="col-6 mx-auto">
            <form action="" method="get">
                <div class="form-group">
                    <label for="nouveauTitre">ID membre</label>
                    <input type="text" class="form-control" id="modifierAdmin" name="modifierAdmin" <?php echo 'value="' . $changementAdmin . '"'; ?>>
                </div>
                <button type="submit" class="btn btn-primary">Changer le statut</button>
            </form>
        </div>
        <?php } ?>
        
        <?php 
        // Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
        if(isset($_GET['modifInfoMembre']) && $_GET['modifInfoMembre'] == $infoDuMembre['id_membre']) {    
            /* echo '<pre>'; var_dump($_GET); echo '<pre>';
            echo '<pre>'; var_dump($lesMembres); echo '<pre>';  */
        ?>
        <form method="post" class="col-6 mx-auto">
            <div class="row m-0">
                <div class="form-group col-6">
                    <label for="id_membre_profil">Identifiant</label>
                    <input type="text" disabled="disabled" class="form-control" id="id_membre_profil" name="id_bo_membre_profil" value="<?php echo $infoDuMembre['id_membre'] ?>">
                </div>
                <div class="form-group col-6 fg-pseudo">
                    <label for="pseudo_profil">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo_profil" name="bo_pseudo_profil" value="<?php echo ucfirst($infoDuMembre['pseudo']); ?>">
                    <i class="fas fa-times"></i>
                    <i class="fas fa-check"></i>
                </div>
                <div class="form-group col-6">
                    <label for="civilite_profil">Sexe</label>
                    <select class="form-control col-12" id="civilite_profil" name="bo_civilite_profil">
                        <option value="m">masculin</option>
                        <option value="f" <?php if($infoDuMembre['civilite'] == 'f') echo 'selected'; ?>>féminin</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="nom_profil">Nom</label>
                    <input type="text" class="form-control" id="nom_profil" name="bo_nom_profil" value="<?php echo ucfirst($infoDuMembre['nom']); ?>">
                </div>
                <div class="form-group col-6">
                    <label for="telephone_profil">Telephone</label>
                    <input type="text" class="form-control" id="telephone_profil" name="bo_telephone_profil" value="<?php echo $infoDuMembre['telephone']; ?>">
                </div>
                <div class="form-group col-6">
                    <label for="prenom_profil">Prenom</label>
                    <input type="text" class="form-control" id="prenom_profil" name="bo_prenom_profil" value="<?php echo ucfirst($infoDuMembre['prenom']); ?>">
                </div>
                <div class="form-group col-6">
                    <label for="email_profil">Email</label>
                    <input type="text" class="form-control" id="email_profil" name="bo_email_profil" value="<?php echo $infoDuMembre['email']; ?>">
                </div>
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary col-12" name="validerMembre">Valider</button>
                </div>
            </div>
        </form>
        <div class="col-6 mx-auto">
            <form action="" method="get">
                <div class="form-group">
                    <label for="nouveauTitre">ID membre</label>
                    <input type="text" class="form-control" id="modifierAdmin" name="modifierAdmin" <?php echo 'value="' . $changementAdmin . '"'; ?>>
                </div>
                <button type="submit" class="btn btn-primary">Changer le statut</button>
            </form>
        </div>
        <?php
        // Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
        } ?>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');
?>
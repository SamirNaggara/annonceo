<?php
include_once('inc/init.inc.php');

if(!user_is_connected()) {
// si l'utilisateur n'est pas connecté
    header("location:" . URL);
    exit();
}
// déclaration de variable pour afficher les valeurs dans les values de nos champs egales aux sessions 

$id_membre_profil = $_SESSION['utilisateur']['id_membre'];
$pseudo_profil = $_SESSION['utilisateur']['pseudo'];
$nom_profil = $_SESSION['utilisateur']['nom'];
$prenom_profil = $_SESSION['utilisateur']['prenom'];
$telephone_profil = $_SESSION['utilisateur']['telephone'];
$email_profil = $_SESSION['utilisateur']['email'];
$civilite_profil = $_SESSION['utilisateur']['civilite'];
$statut_profil = $_SESSION['utilisateur']['statut'];
$date_enregistrement_profil = $_SESSION['utilisateur']['date_enregistrement'];  

if(isset($_POST['pseudo_profil']) && isset($_POST['nom_profil']) && isset($_POST['prenom_profil']) && isset($_POST['telephone_profil']) && isset($_POST['email_profil']) && isset($_POST['civilite_profil'])) {
    // on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	} 
    
    // controle sur la taille du pseudo entre 4 et 14 caractères inclus

	if(iconv_strlen($pseudo_profil) < 4 || iconv_strlen($pseudo_profil) > 14) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, Le pseudo doit avoir entre 4 et 14 caractères inclus.<br>Veuillez recommencer</div>';
	}    
    
    // si ça existe, on place la saisie du formulaire dans ces variables.
	$pseudo_profil = $_POST['pseudo_profil'];
	$nom_profil = $_POST['nom_profil']; 
	$prenom_profil = $_POST['prenom_profil'];
	$telephone_profil = $_POST['telephone_profil'];
	$email_profil = $_POST['email_profil'];
	$civilite_profil = $_POST['civilite_profil'];   
    
    // vérification des caractères présent dans le pseudo
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre pseudo est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le prenom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $prenom_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre prenom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // vérification des caractères présent dans le nom
	if (!preg_match('#^[a-zA-Z0-9._-]+$#', $nom_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention votre nom est incorrect, les caractères autorisés sont: a-z 0-9.<br>Veuillez recommencer</div>';
	}
    
    // verification si le pseudo est disponible en BDD car unique
	$verif_pseudo_profil = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND id_membre != :id_membre_profil");
	$verif_pseudo_profil->bindParam(':id_membre_profil', $id_membre_profil, PDO::PARAM_STR);
	$verif_pseudo_profil->bindParam(':pseudo', $pseudo_profil, PDO::PARAM_STR);
	$verif_pseudo_profil->execute();

	if($verif_pseudo_profil->rowCount() > 0) {
		// s'il y a plus de 1 ligne alors le pseudo existe en plus de celui de l'identifiant en cours
		$msg .= '<div class="alert alert-danger mt-2" role="alert">Attention ce pseudo est deja utilisé.<br>Veuillez en choisir un autre</div>';
	}   
    
    // vérification du format de l'email
	if(!filter_var($email_profil, FILTER_VALIDATE_EMAIL)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
	}
    
    // vérification du format telephone
    if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $telephone_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du téléphone n\'est pas valide.<br>Veuillez recommencer</div>';
    }  
    // Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
    if (($pseudo_profil != $_SESSION['utilisateur']['pseudo'] || $nom_profil != $_SESSION['utilisateur']['nom'] || $prenom_profil != $_SESSION['utilisateur']['prenom'] || $telephone_profil != $_SESSION['utilisateur']['telephone'] || $email_profil != $_SESSION['utilisateur']['email'] || $civilite_profil != $_SESSION['utilisateur']['civilite']) && empty($msg)){

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
}

//Recuperons les information de la table note, avec le note_id2 qui est egale a  membre_id de la table annonce
        
$infosNotes = $pdo->prepare("SELECT * FROM note WHERE membre_id1 = :id_membre OR membre_id2 = :id_membre");
$infosNotes->bindParam(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
$infosNotes->execute();

$lesNotes = $infosNotes->fetchAll(PDO::FETCH_ASSOC);
//On parcours toute les notes, on calcule la sommes de toutes les notes dans la variables $notes, on increment un compteur qui compte le nombre de notes, et le resultat est la division des deux

//        echo $lesNotes[0]["note"];
$compteur = 0;
$notes=0;
foreach($lesNotes as $uneNote){
    //On calcule la moyenne des notes que la personne connectée a reçut
    if ($uneNote["membre_id2"] == $_SESSION['utilisateur']['id_membre']){
        $notes += floatval($uneNote["note"]);

        $compteur += 1;
    }

}
$moyenneNote = round($notes/$compteur, 1);  
include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

<!--Titre et boutons de navigations-->

<div class="starter-template">
    <h1>Profil</h1>
    <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
    <a href="?action=informationsPersonnels" class="btn btn-warning text-white">Informations personnels</a>
    <a href="?action=mesCommentaires" class="btn btn-primary">Mes commentaires</a>
    <a href="?action=mesNotes" class="btn btn-primary">Mes notes</a>
    <hr>
</div>

<!--Formulaires des informations personnels-->

<?php

// Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
if ((isset($_GET['action']) && $_GET['action'] == "informationsPersonnels") || !isset($_GET['action'])){    
    
?>
<div class="container">
<div class="col-6 mx-auto">
    <form action="" method="post">
        <div class="form-group">
            <label for="id_membre_profil">Identifiant</label>
            <input type="text" disabled="disabled" class="form-control" id="id_membre_profil" name="id_membre_profil" value="<?php echo $id_membre_profil; ?>">
        </div>
        <div class="form-group">
            <label for="pseudo_profil">Pseudo</label>
            <input type="text" class="form-control" id="pseudo_profil" name="pseudo_profil" value="<?php echo $pseudo_profil; ?>">
        </div>
        <div class="form-group">
            <label for="nom_profil">Nom</label>
            <input type="text" class="form-control" id="nom_profil" name="nom_profil" value="<?php echo $nom_profil; ?>">
        </div>
        <div class="form-group">
            <label for="prenom_profil">Prenom</label>
            <input type="text" class="form-control" id="prenom_profil" name="prenom_profil" value="<?php echo $prenom_profil; ?>">
        </div>
        <div class="form-group">
            <label for="telephone_profil">Telephone</label>
            <input type="text" class="form-control" id="telephone_profil" name="telephone_profil" value="<?php echo $telephone_profil; ?>">
        </div>
        <div class="form-group">
            <label for="email_profil">Email</label>
            <input type="text" class="form-control" id="email_profil" name="email_profil" value="<?php echo $email_profil; ?>">
        </div>
        <div class="form-group">
            <label for="civilite_profil">Sexe</label>
            <select class="form-control" id="civilite_profil" name="civilite_profil">
                <option value="m">masculin</option>
                <option value="f" <?php if($civilite_profil == 'f') echo 'selected'; ?>>féminin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_enregistrement_profil">Date d'inscription</label>
            <input type="text" disabled="disabled" class="form-control" id="date_enregistrement_profil" name="date_enregistrement_profil" value="<?php echo $date_enregistrement_profil; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>
</div>
<?php
    //Fermeture du if de l'onglet informations personnels
}

// Ouverture de l'onglet sur les commentaires
if (isset($_GET['action']) && $_GET['action'] == "mesCommentaires"){    
    echo '<p>Je suis la page commentaire</p>';
}

// Ouverture de l'onglet sur les notes
if (isset($_GET['action']) && $_GET['action'] == "mesNotes"){    
    ?>
    <div class="starter-template">
        <h2>Mes avis</h2>
    </div>
    <div class="card card-body listingNote">
            <?php
        $premiereLigne = true;
        foreach($lesNotes as $uneNote){
               
        //On affiche uniquement les commentaire que la personne à reçut
    if ($uneNote["membre_id2"] == $_SESSION['utilisateur']['id_membre']){
            //Place un hr au dessus si ce n'est pas la premiere ligne, a la premiere il n'en met pas
                    
            if ($premiereLigne){
                $premiereLigne = false;
            }else{
                echo '<hr>';
            }
            ?>

            <p class="nomEtNote m-0"><i class="far fa-user"></i> <?php 
                    

                    
                    
            $infosMembreAvis = $pdo->prepare("SELECT pseudo FROM membre WHERE id_membre = :id_membre");
            $infosMembreAvis->bindParam(':id_membre', $uneNote['membre_id1'], PDO::PARAM_STR);
            $infosMembreAvis->execute();

            $leMembreAvis = $infosMembreAvis->fetch(PDO::FETCH_ASSOC);
                    
            echo ucfirst($leMembreAvis["pseudo"]) ?> : <span class="laNote"><?php echo $uneNote['note'] ?>/5</span></p>

            <span class="dateNote text-secondary"><?php echo date("d-m-Y", strtotime($uneNote['date_enregistrement']))  ?></span>
            <p class="avis p-3"><?php echo $uneNote['avis'] ?></p>

            <?php } ?>



            <?php
                //On ferme l'accolade du foreach des notes
            }
            ?>
    </div>

    <div class="starter-template">
        <h2>Les avis donnés</h2>
    </div>

    <div class="card card-body listingNote">
            <?php
        $premiereLigne = true;
        foreach($lesNotes as $uneNote){
               
        //On affiche uniquement les commentaire que la personne à reçut
    if ($uneNote["membre_id1"] == $_SESSION['utilisateur']['id_membre']){
            //Place un hr au dessus si ce n'est pas la premiere ligne, a la premiere il n'en met pas
                    
            if ($premiereLigne){
                $premiereLigne = false;
            }else{
                echo '<hr>';
            }
            ?>

            <p class="nomEtNote m-0"><i class="far fa-user"></i> <?php 
                    

                    
                    
            $infosMembreAvis = $pdo->prepare("SELECT pseudo FROM membre WHERE id_membre = :id_membre");
            $infosMembreAvis->bindParam(':id_membre', $uneNote['membre_id1'], PDO::PARAM_STR);
            $infosMembreAvis->execute();

            $leMembreAvis = $infosMembreAvis->fetch(PDO::FETCH_ASSOC);
                    
            echo ucfirst($leMembreAvis["pseudo"]) ?> : <span class="laNote"><?php echo $uneNote['note'] ?>/5</span></p>

            <span class="dateNote text-secondary"><?php echo date("d-m-Y", strtotime($uneNote['date_enregistrement']))  ?></span>
            <p class="avis p-3"><?php echo $uneNote['avis'] ?></p>

            <?php } ?>



            <?php
                //On ferme l'accolade du foreach des notes
            }
            ?>
    </div>
            <?php
    }
    ?>



<?php
include_once('inc/footer.inc.php');
?>

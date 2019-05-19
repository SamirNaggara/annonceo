<?php
include_once('inc/init.inc.php');

if(!user_is_connected()) {
// si l'utilisateur n'est pas connecté
    header("location:" . URL);
    exit();
}
// déclaration de variable pour afficher les valeurs dans les values de nos champs egales aux sessions 
$id_membre_profil = $_SESSION['utilisateur']['id_membre'];
$pseudo_profil = checkInput($_SESSION['utilisateur']['pseudo']);
$nom_profil = checkInput($_SESSION['utilisateur']['nom']);
$prenom_profil = checkInput($_SESSION['utilisateur']['prenom']);
$telephone_profil = $_SESSION['utilisateur']['telephone'];
$email_profil = $_SESSION['utilisateur']['email'];
$civilite_profil = checkInput($_SESSION['utilisateur']['civilite']);
$statut_profil = $_SESSION['utilisateur']['statut'];
$date_enregistrement_profil = checkInput($_SESSION['utilisateur']['date_enregistrement']);  

if(isset($_POST['pseudo_profil']) && isset($_POST['nom_profil']) && isset($_POST['prenom_profil']) && isset($_POST['telephone_profil']) && isset($_POST['email_profil']) && isset($_POST['civilite_profil']) && isset($_POST['validerMembre'])) {

    // on enlève les espace en début et fin de chaine avec trim()
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($_POST[$indice]);
	} 
    
    // controle sur la taille du pseudo entre 4 et 14 caractères inclus
	if(iconv_strlen($pseudo_profil) < 4 || iconv_strlen($pseudo_profil) > 14) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention, Le pseudo doit avoir entre 4 et 14 caractères inclus.<br>Veuillez recommencer</div>';
	}    
    
    // si ça existe, on place la saisie du formulaire dans ces variables.
	$pseudo_profil = strtolower($_POST['pseudo_profil']);
	$nom_profil = strtolower($_POST['nom_profil']); 
	$prenom_profil = strtolower($_POST['prenom_profil']);
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
	if(!isEmail($email_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du mail n\'est pas valide.<br>Veuillez recommencer</div>';
	}
    
    // vérification du format telephone
    if (!preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#", $telephone_profil)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Attention le format du téléphone n\'est pas valide.<br>Veuillez recommencer</div>';
    }  
    // Si il y a au moins 1 changement dans le form, et que msg est vide, on enregistre les informations
    if (($pseudo_profil != $_SESSION['utilisateur']['pseudo'] || $nom_profil != $_SESSION['utilisateur']['nom'] || $prenom_profil != $_SESSION['utilisateur']['prenom'] || $telephone_profil != $_SESSION['utilisateur']['telephone'] || $email_profil != $_SESSION['utilisateur']['email'] || $civilite_profil != $_SESSION['utilisateur']['civilite']) && isset($_POST['validerMembre']) && empty($msg)){

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
        
        //message pour dire que les informations ont été modifiées
        $msg .= '<div class="alert alert-success mt-2" role="alert">Une ou plusieurs de vos informations personnelles ont correctement été modifiée</div>';
    }
}

//Partie sur le changement de mot de passe

$actuelMdp = "";
$nouveauMdp= "";
// controle sur le password doit contenir au minimum 8 caractères 1 majuscule 1 chiffre

if(isset($_POST['inputActuelMdp']) && isset($_POST['inputNouveauMdp1']) && isset($_POST['inputNouveauMdp2']) && isset($_POST['enregistrementMdp'])){
    $actuelMdp = $_POST['inputActuelMdp'];
    $nouveauMdp= $_POST['inputNouveauMdp1'];
    if (!preg_match('#^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#', $nouveauMdp)) {
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Votre mot de passe doit contenir au minimum, 8 caratères, 1 majuscule et 1 chiffre<br> Veuillez recommencer</div>';
    }
    
    // L'enregistrement ne s'effectuera que si les deux mots de passe correspondent, sinon, l'on renvoie un message d'erreur que les deux ne correspondent pas
    if ($_POST['inputNouveauMdp1'] == $_POST['inputNouveauMdp2']){
        
        $nouveauMdp = checkInput($_POST['inputNouveauMdp1']);
        $actuelMdp = checkInput($_POST['inputActuelMdp']);

        //on verifie que le mot de passe actuel est le bon
        $infoMdp = $pdo-> prepare("SELECT mdp FROM membre WHERE id_membre = :id_membre");
        $infoMdp-> bindParam(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
        $infoMdp -> execute();
        
        $ligneMdpActuel = $infoMdp -> fetch(PDO::FETCH_ASSOC);
        
        //On verifie si le mdp est bon, s'il est bon on update dans la page de donnée et on envoie un message de succes, et si non, on envoie un message que le mdp n'est pas bon
        if(password_verify($actuelMdp, $ligneMdpActuel['mdp'])){
            //On hache le nouveau mdp
            $mdp = password_hash($nouveauMdp, PASSWORD_DEFAULT);
            
            //Puis on update le nouveau mdp
            $updateMdp = $pdo-> prepare("UPDATE membre SET mdp = :mdp WHERE id_membre = :id_membre");
            $updateMdp-> bindParam(':mdp', $mdp, PDO::PARAM_STR);
            $updateMdp-> bindParam(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
            $updateMdp -> execute();
            $msg .= '<div class="alert alert-success mt-2" role="alert">Votre mot de passe à été modifié.</div>';
        }else{
            $msg .= '<div class="alert alert-danger mt-2" role="alert">Le mot de passe actuel n\'est pas le bon.<br>Veuillez recommencer</div>';  
        }
    }else{
        $msg .= '<div class="alert alert-danger mt-2" role="alert">Les deux mots de passes ne correspondent pas.<br>Veuillez recommencer</div>';
    }
}

//Recuperons les information de la table note, avec le note_id2 qui est egale a  membre_id de la table annonce
        
$infosNotes = $pdo->prepare("SELECT * FROM note WHERE membre_id1 = :id_membre OR membre_id2 = :id_membre");
$infosNotes->bindParam(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
$infosNotes->execute();
$lesNotes = $infosNotes->fetchAll(PDO::FETCH_ASSOC);

//Requette qui recupere la moyenne des notes
$moyenneNote = $pdo->prepare("SELECT AVG(note) AS moyenneNote FROM note WHERE membre_id2 = :id_membre");
$moyenneNote->bindParam(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
$moyenneNote->execute();
$moyenneNote = $moyenneNote -> fetch(PDO::FETCH_ASSOC);  
$moyenneNote = round($moyenneNote['moyenneNote'],1);

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

<!--Titre et boutons de navigations-->

<div class="starter-template">
    <h1>Profil</h1>
    <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
</div>    
<div class="row m-0">
    <div class="profil col-4 p-0">
            <ul class="list-group col-12 p-0">
                <li class="list-group-item <?php if($_GET['action'] == 'informationsPersonnels') echo 'active'?>"> 
                    <a href="?action=informationsPersonnels" class="<?php if($_GET['action'] == 'informationsPersonnels') echo 'text-white'?> d-block w-100">Informations personnels</a>
                </li>
                <li class="list-group-item <?php if($_GET['action'] == 'mesAnnonces') echo 'active'?>">
                    <a href="?action=mesAnnonces" class="<?php if($_GET['action'] == 'mesAnnonces') echo 'text-white'?> d-block w-100">Mes annonces</a>
                </li>
                <li class="list-group-item <?php if($_GET['action'] == 'mesNotes') echo 'active'?>">
                    <a href="?action=mesNotes" class="<?php if($_GET['action'] == 'mesNotes') echo 'text-white'?> d-block w-100">Mes notes</a>
                </li>
                <li class="list-group-item <?php if($_GET['action'] == 'modifierProfil') echo 'active'?>">
                    <a href="?action=modifierProfil" class="<?php if($_GET['action'] == 'modifierProfil') echo 'text-white'?> d-block w-100">Modifier mon profil</a>
                </li>
                <li class="list-group-item <?php if($_GET['action'] == 'modifierPassword') echo 'active'?>">
                    <a href="?action=modifierPassword" class="<?php if($_GET['action'] == 'modifierPassword') echo 'text-white'?> d-block w-100">Modifier mot de passe</a>
                </li>
            </ul>
    </div>
    <!--Formulaires des informations personnels-->
    <?php
    if(!isset($_GET['action']) || $_GET['action'] == 'informationsPersonnels') {
    ?>
    <div class="formProfil col-8">  
            <div class="col-auto p-0">
                <ul class="list-group">
                    <li class="list-group-item bg-primary text-white">Vos informations</li>
                    <li class="list-group-item"><span class="infos_profil">Identifiant membre: </span><?php echo $_SESSION['utilisateur']['id_membre']; ?></li>
                    <li class="list-group-item"><span class="infos_profil">Pseudo: </span><?php echo ucfirst($_SESSION['utilisateur']['pseudo']); ?></li>
                    <li class="list-group-item"><span class="infos_profil">Nom: </span><?php echo ucfirst($_SESSION['utilisateur']['nom']); ?></li>
                    <li class="list-group-item"><span class="infos_profil">Prénom: </span><?php echo ucfirst($_SESSION['utilisateur']['prenom']); ?></li>
                    <li class="list-group-item"><span class="infos_profil">Email: </span><?php echo $_SESSION['utilisateur']['email']; ?></li>
                    <li class="list-group-item"><span class="infos_profil">Sexe: </span><?php if( $_SESSION['utilisateur']['civilite'] == 'm') echo 'Masculin'; else echo 'Féminin'; ?></li>
                    <li class="list-group-item"><span class="infos_profil">Téléphone: </span><?php echo $_SESSION['utilisateur']['telephone']; ?></li>
                    <li class="list-group-item"><span class="infos_profil">Statut: </span><?php if(user_is_admin()) { echo 'Administrateur'; } else { echo 'Membre'; } ?></li>
                </ul>
            </div>
    <?php }
    // Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
    elseif(isset($_GET['action']) && $_GET['action'] == "modifierProfil") {    
    ?>
    <form method="post" class="col-8 proForm pl-2">
        <div class="row m-0">
            <div class="form-group col-6">
                <label for="id_membre_profil">Identifiant</label>
                <input type="text" disabled="disabled" class="form-control" id="id_membre_profil" name="id_membre_profil" value="<?php echo $id_membre_profil; ?>">
            </div>
            <div class="form-group col-6">
                <label for="date_enregistrement_profil">Date d'inscription</label>
                <input type="text" disabled="disabled" class="form-control" id="date_enregistrement_profil" name="date_enregistrement_profil" value="<?php echo $date_enregistrement_profil; ?>">
            </div>
            <div class="form-group col-6 fg-pseudo">
                <label for="pseudo_profil">Pseudo</label>
                <input type="text" class="form-control" id="pseudo_profil" name="pseudo_profil" value="<?php echo ucfirst($pseudo_profil); ?>">
                <i class="fas fa-times"></i>
                <i class="fas fa-check"></i>
            </div>
            <div class="form-group col-6">
                <label for="civilite_profil">Sexe</label>
                <select class="form-control col-12" id="civilite_profil" name="civilite_profil">
                    <option value="m">masculin</option>
                    <option value="f" <?php if($civilite_profil == 'f') echo 'selected'; ?>>féminin</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label for="nom_profil">Nom</label>
                <input type="text" class="form-control" id="nom_profil" name="nom_profil" value="<?php echo ucfirst($nom_profil); ?>">
            </div>
            <div class="form-group col-6">
                <label for="telephone_profil">Telephone</label>
                <input type="text" class="form-control" id="telephone_profil" name="telephone_profil" value="<?php echo $telephone_profil; ?>">
            </div>
            <div class="form-group col-6">
                <label for="prenom_profil">Prenom</label>
                <input type="text" class="form-control" id="prenom_profil" name="prenom_profil" value="<?php echo ucfirst($prenom_profil); ?>">
            </div>
            <div class="form-group col-6">
                <label for="email_profil">Email</label>
                <input type="text" class="form-control" id="email_profil" name="email_profil" value="<?php echo $email_profil; ?>">
            </div>
            <div class="form-group col-12">
                <button type="submit" class="btn btn-primary col-12" name="validerMembre">Valider</button>
            </div>
        </div>
    </form>
    <?php
    // Le formulaire est apparent seuelement si action = informationsPersonnels OU BIEN si get action n'existe pas
    } 
    ?>
    <?php
    if(isset($_GET['action']) && $_GET['action'] == "modifierPassword") {    
    ?>
    <!--Form pour le mot de passe-->
    <form action="" method="post" class="col-8 pl-2">
        <div class="form-group">
            <label for="id_membre_profil">Mot de passe actuel</label>
            <input type="password" class="form-control" id="inputActuelMdp" name="inputActuelMdp">
        </div>
        <div class="form-group">
            <label for="pseudo_profil">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="inputNouveauMdp1" name="inputNouveauMdp1">
        </div>
        <div class="form-group">
            <label for="nom_profil">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="inputNouveauMdp2" name="inputNouveauMdp2">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary col-12" name="enregistrementMdp">Enregistrer</button>
        </div>
    </form>
    <?php } ?>
    <?php
    //Fermeture du if de l'onglet informations personnels
    // Ouverture de l'onglet sur les commentaires
    if (isset($_GET['action']) && $_GET['action'] == "mesAnnonces"){ ?>   
    <div class="col-8">
        <p>Mes futures annonces j'attends Samir pour les afficher</p>
    </div>
    <?php } ?>
    <?php
    // Ouverture de l'onglet sur les notes
    if (isset($_GET['action']) && $_GET['action'] == "mesNotes"){    
    ?>
    <div class="col-8 pl-2">
    <div class="starter-template">
        <h2>Mes avis</h2>
        <h3>Moyenne: <?php echo $moyenneNote; ?>/5</h3>
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
    </div>
    <?php
    }
    ?>
</div>
<?php
include_once('inc/footer.inc.php');
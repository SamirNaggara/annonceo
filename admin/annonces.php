<?php
include_once('../inc/init.inc.php');
include_once('../inc/function.inc.php');

if(!user_is_admin()) {
    header("location:" . URL . "profil.php");
    exit(); // permet de bloquer l'exécution de la suite du script
}
if(!user_is_connected()) {
    // si l'utilisateur n'est pas connecté on le redirige vers l'accueil
    header("location:" . URL);
}

/* $id_annonce = '';
$titre = '';
$pseudo = '';
$date = '';
$desCourte = '';
$desLongue = '';
$prix = '';
$pays = '';
$ville = '';
$adresse = '';
$cp = ''; */

//***************************
// DEBUT UPDATE D'ANNONCE
//***************************

if (isset($_POST['titre']) && isset($_POST['id_annonce']) && isset($_POST['photo_id']) && isset($_POST['pseudo']) && isset($_POST['date']) && isset($_POST['description_courte']) && isset($_POST['description_longue']) && isset($_POST['prix']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp'])) {


    // dans le cas d'un modif on conserve l'ancienne photo_principal avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle'])) {
        $photo_bdd = $_POST['photo_actuelle'];
    }

    if(empty($msg1) && !empty($_FILES['photo']['name'])) {
        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            //$nom_photo = $id_annonce . '-' . $_FILES['photo_base']['name'];
            $nom_photo = time() . '0-' . $_FILES['photo']['name'];
            $photo_bdd_base = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd; // l'emplacement où on va copier la photo
            copy($_FILES['photo']['tmp_name'], $photo_dossier);
        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo principale n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }
    // dans le cas d'un modif on conserve l'ancienne photo1 avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle1'])) {
        $photo_bdd1 = $_POST['photo_actuelle1'];
    }

    // vérification de la photo1 avant enregistrement
    if(!empty($_FILES['photo1']['name'])) {

        $photo_bdd1 = $_FILES['photo1']['name'];

        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo1']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            $nom_photo = time() . '1-' . $_FILES['photo1']['name'];
            $photo_bdd1 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd1; // l'emplacement où on va copier la photo
            copy($_FILES['photo1']['tmp_name'], $photo_dossier);
            echo 'je suis dans le else de verif extension';

        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°1 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }

    // dans le cas d'un modif on conserve l'ancienne photo2 avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle2'])) {
        $photo_bdd2 = $_POST['photo_actuelle2'];
    }
    // vérification de la photo2 avant enregistrement
    if(!empty($_FILES['photo2']['name'])) {

        $photo_bdd2 = $_FILES['photo2']['name'];

        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo2']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            $nom_photo = time() . '2-' . $_FILES['photo2']['name'];
            $photo_bdd2 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd2; // l'emplacement où on va copier la photo
            copy($_FILES['photo2']['tmp_name'], $photo_dossier);

        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°2 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }

    // dans le cas d'un modif on conserve l'ancienne photo3 avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle3'])) {
        $photo_bdd3 = $_POST['photo_actuelle3'];
    }

    // vérification de la photo3 avant enregistrement	
    if(!empty($_FILES['photo3']['name'])) {

        $photo_bdd3 = $_FILES['photo3']['name'];

        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo3']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            $nom_photo = time() . '3-' . $_FILES['photo3']['name'];
            $photo_bdd3 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd3; // l'emplacement où on va copier la photo
            copy($_FILES['photo3']['tmp_name'], $photo_dossier);

        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°3 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }


    // dans le cas d'un modif on conserve l'ancienne photo4 avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle4'])) {
        $photo_bdd4 = $_POST['photo_actuelle4'];
    }

    // vérification de la photo4 avant enregistrement	
    if(!empty($_FILES['photo4']['name'])) {

        $photo_bdd4 = $_FILES['photo4']['name'];

        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo4']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            $nom_photo = time() . '4-' . $_FILES['photo4']['name'];
            $photo_bdd4 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd4; // l'emplacement où on va copier la photo
            copy($_FILES['photo4']['tmp_name'], $photo_dossier);

        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°4 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }

    // dans le cas d'un modif on conserve l'ancienne photo5 avant de tester si une nouvelle photo à été chargé dans le formulaire
    if(!empty($_POST['photo_actuelle5'])) {
        
        $photo_bdd5 = $_POST['photo_actuelle5'];
    }
    // vérification de la photo5 avant enregistrement	
    if(!empty($_FILES['photo5']['name'])) {

        $photo_bdd5 = $_FILES['photo5']['name'];

        // on récupère l'extension du fichier avec le point
        $extension = strrchr($_FILES['photo5']['name'], '.');

        // on passe l'information en minuscule et on enlève le point
        $extension = strtolower(substr($extension, 1));

        // on défini toutes les valeurs acceptées dans un tableau array
        $extension_valide = array('jpg', 'jpeg', 'png', 'gif');

        $verif_extension = in_array($extension, $extension_valide);

        if($verif_extension) {
            // l'extension est valide, on copie la photo dans notre projet.
            $nom_photo = time() . '5-' . $_FILES['photo5']['name'];
            $photo_bdd5 = 'images/' . $nom_photo; // src que l'on va enregistrer dans la BDD
            $photo_dossier = RACINE_SERVEUR . $photo_bdd5; // l'emplacement où on va copier la photo
            copy($_FILES['photo5']['tmp_name'], $photo_dossier);

        } else {
            $msg2 .= '<div class="alert alert-danger mt-2" role="alert">Attention, l\'extension de la photo n°5 n\'est pas valide, extensions acceptées: png / jpg / jpeg / gif.<br>Veuillez recommencer</div>';
        }
    }
    if(empty($msg)) {

        if(!empty($_POST['id_annonce'])) {

        
    // modification annonce en bdd
        $enregistrement_photo = $pdo->prepare("UPDATE photo SET photo1 = :photo1, photo2 = :photo2, photo3 = :photo3, photo4 = :photo4, photo5 = :photo5 WHERE id_photo = :photo_id");
        $enregistrement_photo->bindParam(':photo1', $photo_bdd1, PDO::PARAM_STR);
        $enregistrement_photo->bindParam(':photo2', $photo_bdd2, PDO::PARAM_STR);
        $enregistrement_photo->bindParam(':photo3', $photo_bdd3, PDO::PARAM_STR);
        $enregistrement_photo->bindParam(':photo4', $photo_bdd4, PDO::PARAM_STR);
        $enregistrement_photo->bindParam(':photo5', $photo_bdd5, PDO::PARAM_STR);
        $enregistrement_photo->bindParam(':photo_id', $_POST['photo_id'], PDO::PARAM_STR);
        $enregistrement_photo ->execute();

        $photo_id = $pdo->lastInsertId();

        $enregistrement = $pdo->prepare("UPDATE annonce SET photo = :photo, titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp WHERE id_annonce = :id_annonce");

        $enregistrement->bindParam(':id_annonce', $_POST['id_annonce'], PDO::PARAM_STR);
        $enregistrement->bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
        $enregistrement->bindParam(':photo', $photo_bdd, PDO::PARAM_STR);
        $enregistrement->bindParam(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
        $enregistrement->bindParam(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
        $enregistrement->bindParam(':prix', $_POST['prix'], PDO::PARAM_STR);
        $enregistrement->bindParam(':pays', $_POST['pays'], PDO::PARAM_STR);
        $enregistrement->bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
        $enregistrement->bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
        $enregistrement->bindParam(':cp', $_POST['cp'], PDO::PARAM_STR);
        $enregistrement->execute();
    //message indiquant que les informations ont été modifiées
    $msg .= '<div class="alert alert-success mt-2" role="alert">Une ou plusieurs de vos informations personnelles ont correctement été modifiée</div>';
    //header('Refresh:2; url='. URL . 'admin/annonces.php');
        }
    }
}
//***************************
// FIN UPDATE D'ANNONCE
//***************************

//***************************
// SUPPRESSION D'ANNONCE
//***************************

if (isset($_GET['supprimer'])) {
    $supprimerLigne= $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");
    $supprimerLigne->bindParam(':id_annonce', $_GET['supprimer'], PDO::PARAM_STR);
    $supprimerLigne->execute();
    header("location:" . URL . "admin/annonces.php");
}
//***************************
// FIN SUPPRESSION D'ANNONCE
//***************************

// récupération des informations de l'annonce pour l'affichage en modification
if(isset($_GET['modifier'])) {

    $recupAnnonces = $pdo->prepare("SELECT * FROM annonce, photo, membre WHERE id_annonce = :id_annonce AND id_photo = photo_id AND id_membre = membre_id");
    $recupAnnonces->bindParam(':id_annonce', $_GET['modifier'], PDO::PARAM_STR);
    $recupAnnonces->execute();

    if($recupAnnonces->rowCount() > 0) {

        $laRecupAnnonces = $recupAnnonces->fetch(PDO::FETCH_ASSOC);
        $id_annonce = checkInput($laRecupAnnonces['id_annonce']);
        $id_photo = $laRecupAnnonces['photo_id'];
        $titre = checkInput($laRecupAnnonces['titre']);
        $pseudo = checkInput($laRecupAnnonces['pseudo']);
        $date = checkInput($laRecupAnnonces['date_enregistrement']);
        $desCourte = checkInput($laRecupAnnonces['description_courte']);
        $desLongue = checkInput($laRecupAnnonces['description_longue']);
        $prix = checkInput($laRecupAnnonces['prix']);
        $pays = checkInput($laRecupAnnonces['pays']);
        $ville = checkInput($laRecupAnnonces['ville']);
        $adresse = checkInput($laRecupAnnonces['adresse']);
        $cp = checkInput($laRecupAnnonces['cp']);
        $photo_actuelle =  $laRecupAnnonces['photo'];
        $photo_actuelle1 = $laRecupAnnonces['photo1'];
        $photo_actuelle2 = $laRecupAnnonces['photo2'];
        $photo_actuelle3 = $laRecupAnnonces['photo3'];
        $photo_actuelle4 = $laRecupAnnonces['photo4'];
        $photo_actuelle5 = $laRecupAnnonces['photo5'];
    }
}

// récuperation des categories
$recup_categorie = $pdo->query(
    "SELECT * FROM categorie ORDER BY titre"
);

// récupération des informations des annonces en fonction de leur categorie
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
} else {
    // recuperation des informations des annonces au complet
    $annonces = $pdo->prepare(
        "SELECT a.id_annonce, a.titre AS titre_annonce, a.description_courte, a.description_longue, a.prix, a.photo, a.pays, a.ville, a.adresse, a.cp, m.pseudo, c.titre, a.date_enregistrement  
    FROM annonce a, membre m, categorie c 
    WHERE m.id_membre = a.membre_id   
    AND a.categorie_id = c.id_categorie
    "
    );
    $annonces->execute();
}

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

<?php 
if(isset($_GET['modifier'])) {
?>
<!-- Début affichage formulaire de modification de l'annonce -->
<div class="container-fluid">
    <div class="starter-template pt-4">
        <h1>Modification annonces</h1>
        <p class="lead"><?php echo $msg;?></p>
    </div>
    <div class="col-12 mx-auto">
        <div class="row">
            <form method="post" action="" enctype="multipart/form-data" class="d-flex" >
                <div class="section1 col-4 offset-1">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_annonce" name="id_annonce" value="<?php echo $id_annonce; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="photo_id" name="photo_id" value="<?php echo $id_photo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce :</label>
                        <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pseudo">Auteur de l'annonce :</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Publié le :</label>
                        <input type="text" class="form-control" id="date" name="date" value="<?php echo formatStandardTotal($date); ?>">
                    </div>
                    <div class="form-group">
                        <label for="description_courte">Description courte :</label>
                        <textarea name="description_courte" id="description_courte" class="w-100" rows="5"><?php echo $desCourte; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description_longue">Description longue :</label>
                        <textarea name="description_longue" id="description_longue" class="w-100" rows="5"><?php echo $desLongue; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="text" class="form-control" id="prix" name="prix" value="<?php echo $prix; ?>">
                    </div>
                </div>
                <div class="section2 col-5 mx-auto flex-wrap">
                        <div class="container-fluid d-flex pt-2">
                            <?php if(!empty($photo_actuelle)) { ?>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Principale</label><br>
                                <img src="<?php echo URL.$photo_actuelle; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle" name="photo_actuelle" value="<?php echo $photo_actuelle; ?>">
                            </div>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Photo 1</label><br>
                                <img src="<?php echo URL.$photo_actuelle1; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle1" name="photo_actuelle1" value="<?php echo $photo_actuelle1; ?>">
                            </div>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Photo 2</label><br>
                                <img src="<?php echo URL.$photo_actuelle2; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle2" name="photo_actuelle2" value="<?php echo $photo_actuelle2; ?>">
                            </div>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Photo 3</label><br>
                                <img src="<?php echo URL.$photo_actuelle3; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle3" name="photo_actuelle3" value="<?php echo $photo_actuelle3; ?>">
                            </div>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Photo 4</label><br>
                                <img src="<?php echo URL.$photo_actuelle4; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle4" name="photo_actuelle4" value="<?php echo $photo_actuelle4; ?>">
                            </div>
                            <div class="text-center mr-2">
                                <label for="photo_actuelle">Photo 5</label><br>
                                <img src="<?php echo URL.$photo_actuelle5; ?>" alt="photo actuelle du produit <?php echo $titre; ?>" style="max-width:100%;">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="photo_actuelle5" name="photo_actuelle5" value="<?php echo $photo_actuelle5; ?>">
                            </div>
                    </div>
                    <?php } ?>
                    <div class="row pt-4">
                        <div class="form-group col-6">
                            <label for="photo">Photo principal :</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <div class="form-group col-6">
                            <label for="photo">Photo 1 :</label>
                            <input type="file" class="form-control" id="photo1" name="photo1">
                        </div>
                        <div class="form-group col-6">
                            <label for="photo">Photo 2 :</label>
                            <input type="file" class="form-control" id="photo2" name="photo2">
                        </div>
                        <div class="form-group col-6">
                            <label for="photo">Photo 3 :</label>
                            <input type="file" class="form-control" id="photo3" name="photo3">
                        </div>
                        <div class="form-group col-6">
                            <label for="photo">Photo 4 :</label>
                            <input type="file" class="form-control" id="photo4" name="photo4">
                        </div>
                        <div class="form-group col-6">
                            <label for="photo">Photo 5 :</label>
                            <input type="file" class="form-control" id="photo5" name="photo5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="adresse">Adresse :</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $adresse; ?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="cp">Code postal :</label>
                            <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="pays">Pays :</label>
                            <input type="text" class="form-control" id="pays" name="pays" value="<?php echo $pays; ?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="ville">Ville :</label>
                            <input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>">
                        </div>
                        <hr>
                        <input type="submit" class="form-control btn btn-warning col-11 mx-auto mt-2" id="enregistrement" name="enregistrement" value="Enregistrement">	
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin affichage formulaire de modification de l'annonce -->
<?php  } else { 
    // Début tableau contenant toutes les annonces
    echo '<div class="tableAnnonces">';
    echo '<div class="row">';
    echo '<a class="nav-link dropdown-toggle btn btn-default" href="" id="categorieAnnonces" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Trier par categories';
    echo '</a>';
    echo '<div class="dropdown-menu categoriesAnnonce" aria-labelledby="navbarDropdown">';
    echo '<a class="dropdown-item" href="'. URL. 'admin/annonces.php">Toutes les categories</a>';
    echo '<div class="dropdown-divider"></div>';
    // lien des catégories
    while($categorie = $recup_categorie->fetch(PDO::FETCH_ASSOC)) {
        $cat = checkInput($categorie['titre']);
        echo '<a class="dropdown-item" href="?categorie=' . $cat . '">'. $cat . '</a>';
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
    // Affichage des annonces dans le tableau
    while($mesAnnonces = $annonces->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        foreach($mesAnnonces AS $indice => $valeur ) {
            if($indice == 'photo') {
                echo '<td><img src="' . URL . $valeur . '" alt="image produit" style="width: 100px;" class="img-fluid"></td>';
            } elseif ($indice == 'description_courte') {
                echo '<td>' . substr($valeur, 0, 21). '<a class="dropdown-item" href">lire la suite</a></td>';
            } elseif ($indice == 'description_longue') {
                echo '<td>' . substr($valeur, 0, 21). '<a href="">...</a></td>';
            } else {
                echo '<td>' . $valeur . '</td>';
            }
        }  
        echo '<td>'; 
        echo '<a href="?categorie='.checkInput($mesAnnonces['id_annonce']).'"><i class="fas fa-search"></i></a>';
        echo '<a href="?modifier='.checkInput($mesAnnonces['id_annonce']).'"><i class="fas fa-edit"></i></a>';
        echo '<a href="?supprimer=' . checkInput($mesAnnonces['id_annonce']) . '" onclick="return(confirm(\'Etes vous sûr ?\'))"><i class="fas fa-trash"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
    echo '</div>';
    // Fin tableau contenant toutes les annonces
}
?>

<?php
include_once('inc/footer.inc.php');

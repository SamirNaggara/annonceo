<?php
include_once('inc/init.inc.php');
include_once('inc/function.inc.php');
if(!isset($_GET['id_annonce'])) {
	header('location:' . URL);
}
$id_annonce = $_GET['id_annonce'];
//Recuperons les informations de la table annonce de l'id_anonce en question

$infosAnnonce = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
$infosAnnonce->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
$infosAnnonce->execute();
    
//Si la base de données ne trouve pas de correspondance, on renvoie vers la page d'acceuil, sinon, on recupere les infos
if($infosAnnonce->rowCount() < 1) {
    header('location:' . URL);
}else{
    $cetteAnnonce = $infosAnnonce->fetch(PDO::FETCH_ASSOC);
    //Recuperons les information de la table membre, avec l'id qui est dans la table annonce
    $infosVendeur = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $infosVendeur->bindParam(':id_membre', $cetteAnnonce["membre_id"], PDO::PARAM_STR);
    $infosVendeur->execute();
    $ceVendeur = $infosVendeur->fetch(PDO::FETCH_ASSOC);

    //Recuperons les information de la table photo, avec le id_photo qui est dans la table annonce
    $infosPhotos = $pdo->prepare("SELECT * FROM photo WHERE id_photo = :id_photo");
    $infosPhotos->bindParam(':id_photo', $cetteAnnonce["photo_id"], PDO::PARAM_STR);
    $infosPhotos->execute();
    $lesPhotos = $infosPhotos->fetch(PDO::FETCH_ASSOC);

    //Recuperons les information de la table note, avec le note_id2 qui est egale a  membre_id de la table annonce
    $infosNotes = $pdo->prepare("SELECT * FROM note WHERE membre_id2 = :id_membre");
    $infosNotes->bindParam(':id_membre', $cetteAnnonce["membre_id"], PDO::PARAM_STR);
    $infosNotes->execute();
    $lesNotes = $infosNotes->fetchAll(PDO::FETCH_ASSOC);

    //Requette qui recupere la moyenne des notes
    $moyenneNote = $pdo->prepare("SELECT AVG(note) AS moyenneNote FROM note WHERE membre_id2 = :id_membre");
    $moyenneNote->bindParam(':id_membre', $cetteAnnonce["membre_id"], PDO::PARAM_STR);
    $moyenneNote->execute();
    $moyenneNote = $moyenneNote -> fetch(PDO::FETCH_ASSOC);  
    $moyenneNote = round($moyenneNote['moyenneNote'],1);
        
    //Recuperons les informations de la table commentaire, avec l'annonce id qui est egale a l'id de l'annonce
    $infosCommentaires = $pdo->prepare("SELECT
                                            c.commentaire,
                                            c.date_enregistrement,
                                            m.pseudo
                                            FROM commentaire c
                                            LEFT JOIN membre m ON m.id_membre = c.membre_id
                                            WHERE c.annonce_id = :id_annonce
                                            ORDER BY c.date_enregistrement DESC");
    $infosCommentaires->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $infosCommentaires->execute();
    $lesCommentaires = $infosCommentaires->fetchAll(PDO::FETCH_ASSOC);

    //Recuperation des 4 dernières annonces de la categories
    $infosAutresAnnonces = $pdo->prepare("SELECT * FROM annonce WHERE categorie_id = :categorie_id AND id_annonce != :id_annonce ORDER BY date_enregistrement limit 4");
    $infosAutresAnnonces->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $infosAutresAnnonces->bindParam(':categorie_id', $cetteAnnonce['categorie_id'], PDO::PARAM_STR);
    $infosAutresAnnonces->execute();
    $autresAnnonces = $infosAutresAnnonces->fetchAll(PDO::FETCH_ASSOC);   
        
    // Formulaire de l'avis
    $inputNote = "";
    $inputAvis = "";
    //Enregister l'avis dans la base de données
    if(isset($_POST['inputNote']) && is_numeric($_POST['inputNote']) && isset($_POST['inputAvis']) && isset($_POST['envoyerAvis'])){
        $inputNote = $_POST['inputNote'];
        $inputAvis = checkInput($_POST['inputAvis']);

        //Verifions si l'utilisateur à deja laissé un avis

        $recuperationAvis = $pdo->prepare("SELECT membre_id1 FROM note WHERE membre_id1 = :membre_id1 AND date_enregistrement > DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        $recuperationAvis->bindParam(':membre_id1', $_SESSION['utilisateur']['id_membre'] , PDO::PARAM_STR);
        $recuperationAvis->execute();

        //S'il y a une ligne, cela signifie qu'un resultat à été trouvé, donc il ne faut pas enregistrer le poste, mais envoyer un message d'erreur
            if ($recuperationAvis->rowCount() > 0){
                $msg .= '<div class="alert alert-danger mt-2" role="alert">Vous avez deja laissé un avis à cette personne dans la semaine.<br> Veuillez attendre 1 semaine avant de recommencer</div>';
            }else{
                if ($_SESSION['utilisateur']['id_membre'] == $cetteAnnonce['membre_id']){
                    $msg .= '<div class="alert alert-danger mt-2" role="alert">Vous ne pouvez pas vous mettre un avis a vous meme.<br>Merci</div>';
                }
                else{
                    $enregistrementAvis = $pdo->prepare("INSERT INTO note (membre_id1, membre_id2, note, avis,date_enregistrement) VALUES (:membre_id1, :membre_id2, :note, :avis, NOW())");
                    $enregistrementAvis->bindParam(':membre_id1', $_SESSION['utilisateur']['id_membre'] , PDO::PARAM_STR);
                    $enregistrementAvis->bindParam(':membre_id2', $ceVendeur['id_membre'], PDO::PARAM_STR);
                    $enregistrementAvis->bindParam(':note', $inputNote, PDO::PARAM_STR);
                    $enregistrementAvis->bindParam(':avis', $inputAvis, PDO::PARAM_STR);
                    $enregistrementAvis->execute();
                    //On enregistrer les avis, puis on actualise la page
                    header('Location: '.$_SERVER['REQUEST_URI']);
                }
            }           
        }

        // Envoyer le mail
        if(isset($_POST['monMessage']) && isset($_POST['envoyerMessage'])){
            $destinataire = $ceVendeur['email'];
            $expediteur = $_SESSION['utilisateur']['email'];
            $sujet = 'Vous avez reçut un message de ' . $_SESSION['utilisateur']['pseudo'];
            $message = $_POST['monMessage'];
            $expediteur = 'From: ' . $expediteur;
            mail($destinataire, $sujet, $message, $expediteur);
        }
        
        //Envoyer un nouveau commentaire
        if(isset($_POST['inputCommentaire']) && isset($_POST['envoyerCommentaire'])){
            $enregistrementCommentaire = $pdo->prepare("INSERT INTO commentaire (membre_id, annonce_id, commentaire, date_enregistrement) VALUES (:membre_id, :annonce_id, :commentaire, NOW())");
            $enregistrementCommentaire->bindParam(':membre_id', $_SESSION['utilisateur']['id_membre'] , PDO::PARAM_STR);
            $enregistrementCommentaire->bindParam(':annonce_id', $cetteAnnonce['id_annonce'], PDO::PARAM_STR);
            $enregistrementCommentaire->bindParam(':commentaire', checkInput($_POST['inputCommentaire']), PDO::PARAM_STR);
            $enregistrementCommentaire->execute();
            header('Location: '.$_SERVER['REQUEST_URI']);
        }      
    }

//****************
//DEBUT DE LA PAGE
//****************

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>
<div class="container">
    <div class="monAnnonce">
        <!-- Ecrit les messages d'erreurs -->
        <p class="lead">
            <?php echo $msg;?>
        </p>
        
        <header>
            <div class="titreAnnonce row justify-content-between">
                <div class="conteneurTitreNote col-lg-6 w-100 ml-auto mx-left mx-lg-0">
                    <h1 class="d-block text-lg-left mb-4">
                        <?php echo ucfirst($cetteAnnonce["titre"]); ?>
                        <span class="divider"></span>
                    </h1>
                    
                    <!-- Fin collapseVoirLesAvis -->
                </div>
                
                <!-- Fin conteneurTitreNote -->
            </div>
            <!-- Fin titreAnnonce -->
        </header>
        
        <!-- Fin container-fluid -->
        <!-- Carousel et texte de l'annonce -->
        <div class="conteneurCarouselTexte row ">
            <div class="carousel col-lg-6">
                <div id="carouselAnnonce" class="carousel slide w-90" data-ride="carousel">
                    <div class="carousel-inner w-100 rounded mb-2">
                        <div class="carousel-item active">
                            <?php 
                            echo '<div class="bg-carousel rounded">';
                                echo '<a href="' . $cetteAnnonce["photo"] . '" data-toggle="lightbox" data-title="'.ucfirst($cetteAnnonce["titre"]).'" data-footer="'.number_format($cetteAnnonce['prix'], 2, ',', ' ').' €" data-gallery="example-gallery">';
                                    echo '<img class="d-block img-fluid mx-auto" src="' . $cetteAnnonce["photo"] . '" alt="Premiere photo">';
                                echo '</a>';
                            echo '</div>';
                        ?>
                        </div>
                        <?php
                        $j=0;
                        $listePhoto = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                        foreach($lesPhotos as $ind => $laPhoto){
                            if (!empty($laPhoto) && $ind != 'id_photo'){
                                echo '<div class="carousel-item">';
                                    echo '<div class="bg-carousel rounded">';
                                        echo '<a href="' . $lesPhotos[$listePhoto[$j]] . '" data-toggle="lightbox" data-title="'.ucfirst($cetteAnnonce["titre"]).'" data-footer="'.number_format($cetteAnnonce['prix'], 2, ',', ' ').' €" data-gallery="example-gallery">';
                                            echo '<img class="d-block img-fluid mx-auto rounded" src="' . $lesPhotos[$listePhoto[$j]] . '" alt="'.$cetteAnnonce['titre'].'">';
                                        echo '</a>';
                                    echo '</div>';
                                echo '</div>';
                                $j++;
                            }
                        }
                    ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselAnnonce" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselAnnonce" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- Fin carousel -->
            <div class="description col-lg-6 mt-sm-2">
                <div class="card ">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php if($_GET['action'] == '') echo 'active'?>" href="<?php echo URL; ?>annonce.php?id_annonce=<?=$id_annonce?>">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($_GET['action'] == 'avis') echo 'active'?>" href="<?php echo URL; ?>annonce.php?id_annonce=<?=$id_annonce?>&action=avis">Le vendeur</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($_GET['action'] == 'contact') echo 'active'?>" href="<?php echo URL; ?>annonce.php?id_annonce=<?=$id_annonce?>&action=contact">Contact</a>
                            </li>
                            <li class="nav-item ml-auto">
                                <strong class="vendeur"><i class="fas fa-user"></i>
                                    <?php echo ucfirst($ceVendeur['pseudo']); ?></strong>
                                <span class="laMoyenne">
                                    <?php if($moyenneNote == '') {
                                                    echo 'Aucune note';?></li>
                                                <?php } else { ?>
                                                    <?php echo $moyenneNote ?>/5</span>
                                                    <?php } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                    <?php if(isset($_GET['action']) && $_GET['action'] == 'contact') { ?>
                        <h5 class="card-title text-center">Laisser un message à <?=ucfirst($ceVendeur["pseudo"])?></h5>
                        <?php if (!user_is_connected()) { 
                        echo '<div class="text-center">Veuillez vous <a href="#" data-toggle="modal" data-target="#connexionModal" data-backdrop="static">connectez</a> ou vous <a href="#" data-toggle="modal" data-target="#inscriptionModal" data-backdrop="static">inscrire</a> pour contacter '. ucfirst($ceVendeur["pseudo"]).'</div>';?>
                    </div>
                    <?php } else {?>
                </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 m-0 p-1 mx-auto">
                                <a class="contacter btn btn-outline-dark col-12 m-0 p-1" href="#" data-toggle="modal" data-target="#contacter" data-backdrop="static">Contacter</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } elseif(isset($_GET['action']) && $_GET['action'] == 'avis') {?>
                        <h5 class="card-title text-center">Informations sur <?=ucfirst($ceVendeur["pseudo"])?></h5>
                        <?php if (!user_is_connected()) { 
                        echo '<div class="text-center">Veuillez vous <a href="#" data-toggle="modal" data-target="#connexionModal" data-backdrop="static">connectez</a> ou vous <a href="#" data-toggle="modal" data-target="#inscriptionModal" data-backdrop="static">inscrire</a> pour contacter '. ucfirst($ceVendeur["pseudo"]).'</div>';?>
                    </div>
                    <?php } else {?>
                        <div  id="collapseVoirLesAvis">
                            <div class="listingNote">
                            <?php
                            $premiereLigne = true;
                            foreach($lesNotes as $uneNote){
                            
                            //Place un hr au dessus si ce n'est pas la premiere ligne, a la premiere il n'en met pas
                                if ($premiereLigne){
                                    $premiereLigne = false;
                                }else{
                                    echo '<hr>';
                                }
                            ?>
                                <p class="nomEtNote ml-3 mt-1 text-left">De <i class="far fa-user"></i> 
                            <?php 
                            
                            //On recupere les infos pour ecrire les notes et les avis du vendeur
                            $infosMembreAvis = $pdo->prepare("SELECT pseudo FROM membre WHERE id_membre = :id_membre");
                            $infosMembreAvis->bindParam(':id_membre', $uneNote['membre_id1'], PDO::PARAM_STR);
                            $infosMembreAvis->execute();
                            $leMembreAvis = $infosMembreAvis->fetch(PDO::FETCH_ASSOC);
                                echo ucfirst($leMembreAvis["pseudo"]) ?> ( <span class="laNote">
                                <?php 
                                if($uneNote['note'] == '') {
                                                echo 'Aucune note';?> )</span>
                                            <?php } else { ?>
                                                <?php echo $uneNote['note'] ?>/5 )</span>
                                                <?php } ?>
                                <span class="dateNote text-secondary">
                                <?php echo 'Le '.date("d-m-Y", strtotime($uneNote['date_enregistrement'])).' :'  ?></span></p>
                                <p class="avis p-3">
                                <?php echo $uneNote['avis'] ?>
                                </p>
                            <?php
                            //On ferme l'accolade du foreach des notes
                            }
                            ?>
                        <!-- Fin listingNote -->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <h5 class="card-title col-lg-6 addAvis">Laisser une note et un avis à <?=ucfirst($ceVendeur["pseudo"])?></h5>
                            <div class="col-lg-6">
                                <a class="laisserAvis btn btn-outline-dark col-12 m-0 p-1" href="#" data-toggle="modal" data-target="#laisserAvis" data-backdrop="static">Envoyer</a>
                            </div>
                            
                        </div>
                    </div>
                    <?php } ?>
                    <?php } else { ?>
                        
                        <div class="conteneurTexte overflow-scroll">
                            <p class="card-text p-0 m-0 text-justify" id="descriptionTexte">
                            <?php 
                            if (strlen($cetteAnnonce['description_longue']) > 960){
                                $textIncomplet = substr($cetteAnnonce['description_longue'],0, 960);
                                if (isset($_GET['texte']) && $_GET['texte'] == 'complet'){
                                    echo ucfirst(nl2br($cetteAnnonce['description_longue'])) . '<a href="?id_annonce=' . $cetteAnnonce['id_annonce'] . '#description" class="float-right mb-5 mt-3">Lire moins</a>';
                                }else{
                                    echo ucfirst(nl2br($textIncomplet)) . '<a href="?id_annonce=' . $cetteAnnonce['id_annonce'] . '&' . 'texte=complet#description" class="float-right">Lire la suite...</a>';
                                }
                            }else{
                                echo ucfirst(nl2br($cetteAnnonce['description_longue']));
                            }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-8 text-left py-auto"><i class="fas fa-map-marker-alt"></i>
                            <?php echo $cetteAnnonce['adresse'] . ',' . $cetteAnnonce['ville']?>
                            </div>
                            <div class="col-lg-4 text-right">
                                <?php echo number_format($cetteAnnonce['prix'], 2, ',', ' '); ?> <i class="fas fa-euro-sign"></i>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- Fin conteneurBoutons -->
            </div>
            <!-- Fin description -->
        </div>
        <!-- Fin conteneurCarouselTexte -->
        <!-- Partie ou l'on affiche les autres annonces-->
        <hr>
        <div class="gMap py-2 col-12">
        <?php
        $tabCar = array(" ", "\t", "\n", "\r", "\0", "\x0B", "\xA0");
        $cetteAnnonce['adresse'] = str_replace($tabCar, array(), $cetteAnnonce['adresse']);
        $cetteAnnonce['cp'] = str_replace($tabCar, array(), $cetteAnnonce['cp']);
        $cetteAnnonce['ville'] = str_replace($tabCar, array(), $cetteAnnonce['ville']);
        ?>
            <iframe src="https://maps.google.it/maps?q=<?php echo trim($cetteAnnonce['adresse']) . trim($cetteAnnonce['cp']) . trim($cetteAnnonce['ville']) ?>&output=embed" height="200" allowfullscreen></iframe>
        </div>
        <hr>
                <!-- Partie ou l'on affiche les commentaires -->
                <?php
        if (!user_is_connected()) { 
        } else {?>
        <div class="commentaires mt-4">
            <h4>Laisser un commentaire</h4>
            <form id="commentaire" method="post"  class="mt-3">
                <div class="form-group">
                    <textarea name="inputCommentaire" class="form-control" id="inputCommentaire" rows="4" placeholder="Mon commentaire..."></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-dark w-100" id="envoyerCommentaire" name="envoyerCommentaire" value="Envoyer">
                </div>
            </form>
            <div class="conteneurCommentaire mt-5">
                <?php
                    $premiereLigne2 = true;
                    foreach($lesCommentaires as $ceCommentaire){
                        if ($premiereLigne2){
                            $premiereLigne = false;
                        }else{
                            echo '<hr>';
                        }
                        ?>
                <span class="pseudo">
                    <?php echo ucfirst($ceCommentaire['pseudo']); ?></span>
                <span class="date text-secondary">
                    <?php echo formatStandardTotal($ceCommentaire['date_enregistrement']); ?></span>
                <p class="texteCommentaire">
                    <?php echo $ceCommentaire['commentaire']; ?>
                </p>
                <?php
                    }
                    ?>
            </div>
        </div>
        <?php } ?>
        <!-- Fin commentaires -->
        <div class="autresAnnonces mt-3 pb-5">
            <h4 class="bold col-12 text-lg-left p-0">Annonces similaires</h4>
            <div class="row">
            <?php 
            foreach($autresAnnonces as $cetteAutreAnnonce){
                ?>
                <figure class="col-12 col-md-3 mt-3 p-0 mr-md-2 mr-lg-0">
                    <a href="?id_annonce=<?php echo $cetteAutreAnnonce["id_annonce"] ?>">
                        <div class="picture mb-sm-3 m-lg-3 img-thumbnail mx-auto">
                    <?php echo '<img class="d-block" src="' . $cetteAutreAnnonce['photo'] . '" alt="Liens vers une autre annonce" title="' . $cetteAutreAnnonce['description_courte'] . '">'?>
                        </div>
                    </a>
                    <figcaption class="text-center text-dark mt-2 pb-sm-4"><?php echo ucfirst($cetteAutreAnnonce['titre']) ?></figcaption>
                </figure>
        <?php } ?>
            </div>
        </div>
        <!-- Fin autresAnnonces -->

        <!--Formulaire pour laisser un avis-->
        <div class="row laisserAvis">
            <form id="avis" method="post">
                <div class="modal fade col-sm-12 mx-auto" id="laisserAvis" tabindex="-1" role="dialog" aria-labelledby="laisserAvis" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAvis">Laisser un avis à
                                    <?php echo ucfirst($ceVendeur["pseudo"]); ?>
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputNote">Notes: </label>
                                        <select class="form-control" id="inputNote" name="inputNote">
                                            <option value="0">0/5</option>
                                            <option value="1">1/5</option>
                                            <option value="2">2/5</option>
                                            <option value="3">3/5</option>
                                            <option value="4">4/5</option>
                                            <option value="5" selected>5/5</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="inputAvis" id="inputAvis" cols="30" rows="10" placeholder="Mon avis"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-dark w-100" onclick="return inscription()" id="envoyerAvis" name="envoyerAvis" value="Envoyer">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Fin laisser un avis -->
        <div class="row modalContacter">
            <div class="modal fade col-sm-12 mx-auto" id="contacter" tabindex="-1" role="dialog" aria-labelledby="contacter" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalContact">Contacter
                                <?php echo ucfirst($ceVendeur["pseudo"]); ?>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="post">
                                <div class="form-group">
                                    <textarea class="form-control" name="monMessage" id="monMesage" cols="30" rows="10" placeholder="Mon message"></textarea>
                                </div>
                                <a class="voirLesAvis d-block d-lg-inline-block t-2 text-dark mb-3 colorLetter" data-toggle="collapse" href="#collapseNumeroDeTelephone" role="button" aria-expanded="false" aria-controls="collapseNumeroDeTelephone">
                                    Ou obtenir le numero de téléphone
                                </a>
                                <div class="collapse" id="collapseNumeroDeTelephone">
                                    <div class="card card-body listingNote">
                                        <p class="nomEtNote m-0"><i class="fas fa-phone"></i>
                                            <?php echo $ceVendeur['telephone'] ?>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-dark w-100" onclick="return inscription()" id="envoyerMessage" name="envoyerMessage" value="Envoyer">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Fin modalContacter -->
    </div>
    <!-- Fin section mon annonce -->
<?php
include_once('inc/footer.inc.php');
?>

                    



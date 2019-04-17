<?php
include_once('inc/init.inc.php');
include_once('inc/modal.inc.php');


if(!isset($_GET['id_annonce'])) {
	header('location:' . URL);
}
else{
    //Recuperons les informations de la table annoncede l'id_anoonce en question
    
    $infosAnnonce = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
	$infosAnnonce->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
	$infosAnnonce->execute();
    
    //Si la base de données ne trrouve pas de correspondance, on renvoie vers la page d'acceuil, sinon, on recupere les infos dans
    if($infosAnnonce->rowCount() < 1) {
		header('location:' . URL);
	}
    else{
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
        
        $lesNotes = $infosNotes->fetch(PDO::FETCH_ASSOC);
        
        //Recuperons les informations e la table commentaire, avec l'annonce id qui est egale a l'id de l'annonce
        
        $infosCommentaires = $pdo->prepare("SELECT * FROM commentaire WHERE annonce_id = :id_membre");
        $infosCommentaires->bindParam(':id_membre', $_GET['id_annonce'], PDO::PARAM_STR);
        $infosCommentaires->execute();
        
        $lesCommentaires = $infosCommentaires->fetch(PDO::FETCH_ASSOC);
        
        
        
        
    }
}

//Test pour voir si toutes les valeurs sont recuperer normalement dans la baess de données

echo '<pre>'; print_r($cetteAnnonce); echo '</pre>';
echo '<pre>'; print_r($ceVendeur); echo '</pre>';
echo '<pre>'; print_r($lesPhotos); echo '</pre>';
echo '<pre>'; print_r($lesNotes); echo '</pre>';
echo '<pre>'; print_r($lesCommentaires); echo '</pre>';

    


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>




<section class="monAnnonce">

    <header>
        <h1><?php echo $cetteAnnonce["titre"]; ?></h1>
        <span class="separation"> / </span>
        <strong class="vendeur"><i class="fas fa-user"></i><?php echo $ceVendeur['pseudo']; ?></strong>
        <span class="laMoyenne"><?php echo calculMoyenneNote($cetteAnnonce[membre_id]); ?>/5</span>
        span
        
        Ici le collapse 
        <a class="btn btn-primary" data-toggle="collapse" href="#collapseVoirLesAvis" role="button" aria-expanded="false" aria-controls="collapseVoirLesAvis">
            (voir les avis)
        </a>
        <div class="collapse" id="collapseVoirLesAvis">
            <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
            </div>
        </div>

    </header>




</section>



<?php
include_once('inc/footer.inc.php');

?>

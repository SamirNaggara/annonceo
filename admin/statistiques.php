<?php
include_once('../inc/init.inc.php');

if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}

//Requette pour les 5 membres les mieux notés

$membreMieuxNotes = $pdo->prepare("SELECT m.id_membre, m.pseudo, COUNT(n.id_note) as nbNote, AVG(n.note) as moyenneNote
                                        FROM note n 
                                        LEFT JOIN membre m ON m.id_membre = n.membre_id2
                                        GROUP BY id_membre 
                                        ORDER BY AVG(n.note) DESC
                                        LIMIT 5");
$membreMieuxNotes->execute();
$resultatMieuxNotes = $membreMieuxNotes ->fetchAll(PDO::FETCH_ASSOC);

//Requette pour les 5 membre les plus actifs

$membrePlusActif = $pdo->prepare("SELECT m.id_membre, m.pseudo, count(a.id_annonce) AS nbAnnonce
                                        from annonce a
                                        LEFT JOIN membre m ON m.id_membre = a.membre_id
                                        GROUP BY m.id_membre
                                        ORDER BY count(a.id_annonce) DESC
                                        LIMIT 5");
$membrePlusActif->execute();
$resultatMembreActif = $membrePlusActif ->fetchAll(PDO::FETCH_ASSOC);

//Requette pour les 5 annonces les plus anciennes

$annoncesPlusAnciennes = $pdo->prepare("SELECT
                                            m.pseudo, m.id_membre, a.date_enregistrement, a.id_annonce, a.titre
                                        FROM
                                            annonce a
                                        LEFT JOIN membre m ON m.id_membre = a.membre_id
                                        ORDER BY
                                            a.date_enregistrement
                                        LIMIT 5 ");
$annoncesPlusAnciennes->execute();
$resultatsAnnoncesAnciennes = $annoncesPlusAnciennes ->fetchAll(PDO::FETCH_ASSOC);

//Requette pour les 5 categories contenants le pluss d'annonces'
    
$topCategorie = $pdo->prepare("SELECT c.id_categorie, c.titre , COUNT(a.id_annonce) AS nbAnnonce
FROM annonce a
LEFT JOIN categorie c ON c.id_categorie = a.categorie_id
GROUP BY c.titre
ORDER BY COUNT(a.id_annonce) DESC
LIMIT 5");
$topCategorie->execute();
$resultatTopCategories = $topCategorie ->fetchAll(PDO::FETCH_ASSOC);

include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
    <div id="content-wrapper">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Statistique</a>
            </li>
            <li class="breadcrumb-item active">Gestion des statistiques</li>
        </ol>
        <div class="starter-template">
            <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
        </div>

        <div class="row m-0 col-lg-10 p-1 mx-auto pt-lg-5">
            <div class="statistique col-12 col-lg-4 p-0 pb-2 pr-lg-2">
                <ul class="list-group col-12 p-0">
                    <li class="list-group-item bg-light <?php if(isset($_GET['action']) && $_GET['action']=='lesMieuxNotes') {echo 'active bg-dark';} ?>">
                        <a href="?action=lesMieuxNotes#1" class="d-block w-100">Les mieux notés</a>
                    </li>
                    <li class="list-group-item bg-light <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusActifs'){echo 'active bg-dark';} ?>">
                        <a href="?action=lesPlusActifs#2" class="d-block w-100">Les plus actifs</a>
                    </li>
                    <li class="list-group-item bg-light <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusAnciens') {echo 'active bg-dark';} ?>">
                        <a href="?action=lesPlusAnciens#3" class="d-block w-100">Les plus anciennes annonces</a>
                    </li>
                    <li class="list-group-item bg-light <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusPopulaire') {echo 'active bg-dark';} ?>">
                        <a href="?action=lesPlusPopulaire#4" class="d-block w-100">Catégories les plus populaires</a>
                    </li>
                </ul>
            </div>
            <?php
            // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
            if ((isset($_GET['action']) && $_GET['action'] == "lesMieuxNotes") || !isset($_GET['action'])){ 
            ?>
            <div class="col-12 col-lg-7 p-0 card ml-auto">
                <h5 class="card-header">Participant les mieux notés</h5>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                    <?php 
                    $i=1;
                    foreach($resultatMieuxNotes as $leResultat){
                        ?>
                        <li class="list-group-item p-1 p-lg-3" title="<?php echo 'id=' . $leResultat['id_membre']; ?>"><?php echo $i . " - " . ucfirst($leResultat['pseudo']) ?>
                            <div class="conteneurResultat d-inline-block float-right">
                                <span class=""><strong><?php echo round($leResultat['moyenneNote'], 2); ?>/5</strong> basé sur <span class="colorLetter"><strong><?php echo $leResultat['nbNote']; ?></strong></span> avis</span>
                            </div>
                        </li>
                    <?php 
                    $i++;
                    }
                echo '</ul>';
            echo '</div>';
        echo '</div>';
            }?>
            <?php
            // Le formulaire est apparent seuelement si action = lesPlusActifs OU BIEN si get action n'existe pas
            if (isset($_GET['action']) && $_GET['action'] == "lesPlusActifs"){ 
            ?>
            <div class="col-12 col-lg-7 p-0 card ml-auto">
                <h5 class="card-header">Participant les plus actifs</h5>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                    <?php
                    $i=1; 
                    foreach($resultatMembreActif as $leResultat){
                        ?>
                        <li class="list-group-item p-1 p-lg-3" title="<?php echo $leResultat['id_membre']; ?>"><?php echo $i . " - " . ucfirst($leResultat['pseudo']) ?>
                            <div class="conteneurResultat d-inline-block float-right">
                                <span class="">Avec <span class="colorLetter"><strong><?php echo ucfirst($leResultat['nbAnnonce']) ?></strong></span> annonces</span>
                            </div>
                        </li>
                    <?php 
                    $i++;
                    }
                echo '</ul>';
            echo '</div>';
        echo '</div>';
            }?>
            <?php
            // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
            if ((isset($_GET['action']) && $_GET['action'] == "lesPlusAnciens")){ 
            ?>
            <div class="col-12 col-lg-8 p-0 card">
                <h5 class="card-header">Annonces les plus anciennes</h5>
                <div class="card-body p-0">
                    <?php 
                    $i=1;
                    foreach($resultatsAnnoncesAnciennes as $leResultat){
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-1 p-lg-3">
                                <div class="d-inline-block w-100 text-sm" title="<?php echo 'id=' . $leResultat['id_annonce']; ?>"><strong><a class="text-dark "href="<?php echo URL . 'annonce.php?id_annonce=' . $leResultat['id_annonce']; ?>"><?php echo $i . " - " . ucfirst($leResultat['titre']) . "</a></strong> / " . ucfirst($leResultat['pseudo'])?></div>
                                <div class="conteneurResultat d-inline-block float-lg-right">
                                    <span class=""><?php echo formatStandardTotal($leResultat['date_enregistrement']) ?></span>
                                </div>
                            </li>
                        </ul>
                    <?php 
                    $i++;
                    }
            echo '</div>';
        echo '</div>';
            }?>
            <?php
            // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
            if ((isset($_GET['action']) && $_GET['action'] == "lesPlusPopulaire")){ 
            ?>
            <div class="col-12 col-lg-7 p-0 card ml-auto">
                <h5 class="card-header">Annonces les plus anciennes</h5>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                    <?php 
                    $i=1;
                    foreach($resultatTopCategories as $leResultat){
                        ?>
                        <li class="list-group-item p-1 p-lg-3">
                            <div class="d-inline-block" title="<?php echo 'id=' . $leResultat['id_categorie']; ?>"><?php echo $i . " - " . ucfirst($leResultat['titre']) ?></div>
                            <div class="conteneurResultat d-inline-block float-right">
                                <span class="colorLetter"><strong><?php echo $leResultat['nbAnnonce'] ?></strong></span>
                            </div>
                        </li>
                    <?php 
                    $i++;
                    }
                echo '</ul>';
            echo '</div>';
        echo '</div>';
            }?>
        </div>
    </div>
<?php
include_once('inc/footer.inc.php');

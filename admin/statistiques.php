<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Requette pour les 5 membres les mieux notés
//

$membreMieuxNotes = $pdo->prepare("SELECT m.id_membre, m.pseudo, COUNT(n.id_note) as nbNote, AVG(n.note) as moyenneNote
                                        FROM note n 
                                        LEFT JOIN membre m ON m.id_membre = n.membre_id2
                                        GROUP BY id_membre 
                                        ORDER BY AVG(n.note) DESC
                                        LIMIT 5");
$membreMieuxNotes->execute();

$resultatMieuxNotes = $membreMieuxNotes ->fetchAll(PDO::FETCH_ASSOC);

//    
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

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Statistique</a>
            </li>
            <li class="breadcrumb-item active">Gestion des statistiques</li>
        </ol>
        <div class="starter-template container w-75">
            <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
            <div class="conteneurBouton d-flex flex-wrap justify-content-around">
                <a href="?action=lesMieuxNotes#1" class="btn m-3 <?php if((isset($_GET['action']) && $_GET['action']=='lesMieuxNotes') || !isset($_GET['action'])){echo 'btn-warning text-white';}else{echo 'btn-primary';} ?>">Les mieux notés</a>
                <a href="?action=lesPlusActifs#2" class="btn m-3 <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusActifs'){echo 'btn-warning text-white';}else{echo 'btn-primary';} ?>">Les plus actifs</a>
                <a href="?action=lesPlusAnciens#3" class="btn m-3 <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusAnciens'){echo 'btn-warning text-white';}else{echo 'btn-primary';} ?>">Les plus anciennes annonces</a>
                <a href="?action=lesPlusPopulaire#4" class="btn m-3 <?php if(isset($_GET['action']) && $_GET['action']=='lesPlusPopulaire'){echo 'btn-warning text-white';}else{echo 'btn-primary';} ?>">Catégories les plus populaires</a>
            </div>
            <hr>
        </div>

       <?php
        // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
        if ((isset($_GET['action']) && $_GET['action'] == "lesMieuxNotes") || !isset($_GET['action'])){ 
    
        ?>
        <ul class="list-group" id="1">
            <li class="list-group-item  w-50 active mx-auto">Participant les mieux notés</li>
            <?php 
            $i=1;
            foreach($resultatMieuxNotes as $leResultat){
                ?>
            <li class="list-group-item w-50 mx-auto">
                <div class="d-inline-block" title="<?php echo 'id=' . $leResultat['id_membre']; ?>"><?php echo $i . " - " . ucfirst($leResultat['pseudo']) ?></div>
                <div class="conteneurResultat d-inline-block float-right">
                    <span class=""><?php echo round($leResultat['moyenneNote'], 2); ?>/5</span>
                    <span class=""> basé sur <?php echo $leResultat['nbNote']; ?> avis</span>
                </div>
            </li>
        </ul>
            <?php 
            $i++;
            }
        }
            ?>
            
            
                   <?php
        // Le formulaire est apparent seuelement si action = lesPlusActifs OU BIEN si get action n'existe pas
        if (isset($_GET['action']) && $_GET['action'] == "lesPlusActifs"){ 
        $i=1;
        ?>
        <ul class="list-group" id="2">
            <li class="list-group-item  w-50 active mx-auto">Participant les plus actifs</li>
            <?php foreach($resultatMembreActif as $leResultat){
                ?>
            <li class="list-group-item w-50 mx-auto">
                <div class="d-inline-block" title="<?php echo $leResultat['id_membre']; ?>"><?php echo $i . " - " . ucfirst($leResultat['pseudo']) ?></div>
                <div class="conteneurResultat d-inline-block float-right">
                    <span class="">Avec <?php echo ucfirst($leResultat['nbAnnonce']) ?> annonces</span>
                </div>
            </li>
        </ul>
            <?php 
            $i++;
            }
        }
            ?>
        

       <?php
        // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
        if ((isset($_GET['action']) && $_GET['action'] == "lesPlusAnciens") || !isset($_GET['action'])){ 
    
        ?>
        <ul class="list-group" id="3">
            <li class="list-group-item  w-75 active mx-auto">Annonces les plus anciennes</li>
            <?php 
            $i=1;
            foreach($resultatsAnnoncesAnciennes as $leResultat){
                ?>
            <li class="list-group-item w-75 mx-auto">
                <div class="d-inline-block" title="<?php echo 'id=' . $leResultat['id_annonce']; ?>"><a class="text-dark "href="<?php echo URL . 'annonce.php?id_annonce=' . $leResultat['id_annonce']; ?>"><?php echo $i . " - " . ucfirst($leResultat['titre']) . "</a> / " . ucfirst($leResultat['pseudo'])?></div>
                <div class="conteneurResultat d-inline-block float-right">
                    <span class=""><?php echo formatStandardTotal($leResultat['date_enregistrement']) ?></span>
        
                </div>
            </li>
        </ul>
            <?php 
            $i++;
            }
        }
            ?>
            
            
                   <?php
        // Le formulaire est apparent seuelement si action = lesMieuxNotes OU BIEN si get action n'existe pas
        if ((isset($_GET['action']) && $_GET['action'] == "lesPlusPopulaire") || !isset($_GET['action'])){ 
    
        ?>
        <ul class="list-group" id="4">
            <li class="list-group-item  w-50 active mx-auto">Annonces les plus anciennes</li>
            <?php 
            $i=1;
            foreach($resultatTopCategories as $leResultat){
                ?>
            <li class="list-group-item w-50 mx-auto">
                <div class="d-inline-block" title="<?php echo 'id=' . $leResultat['id_categorie']; ?>"><?php echo $i . " - " . ucfirst($leResultat['titre']) ?></div>
                <div class="conteneurResultat d-inline-block float-right">
                    <span class=""><?php echo $leResultat['nbAnnonce'] ?></span>
        
                </div>
            </li>
        </ul>
            <?php 
            $i++;
            }
        }
            ?>









        <?php
include_once('inc/footer.inc.php');

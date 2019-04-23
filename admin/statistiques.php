<?php

include_once('../inc/init.inc.php');



if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


//Requette pour les 5 membres les mieux notés
//

$membreMieuxNotes = $pdo->prepare("SELECT m.id_membre, m.pseudo, COUNT(n.id_note), AVG(n.note)
                                        FROM note n 
                                        LEFT JOIN membre m ON m.id_membre = n.membre_id2
                                        GROUP BY id_membre 
                                        ORDER BY AVG(n.note) DESC
                                        LIMIT 5");
$membreMieuxNotes->execute();

$resultatMieuxNotes = $membreMieuxNotes ->fetchAll(PDO::FETCH_ASSOC)

//    
//Requette pour les 5 membre les plus actifs

$membrePlusActif = $pdo->prepare("SELECT m.id_membre, m.pseudo, count(a.id_annonce)
                                        from annonce a
                                        LEFT JOIN membre m ON m.id_membre = a.membre_id
                                        GROUP BY m.id_membre
                                        ORDER BY count(a.id_annonce) DESC
                                        LIMIT 5");
$membrePlusActif->execute();

$resultatMembreActif = $membrePlusActif ->fetchAll(PDO::FETCH_ASSOC)
    
    

//Requette pour les 5 annonces les plus anciennes
 
    
$annoncesPlusAnciennes = $pdo->prepare("SELECT * FROM annonce 
                                            ORDER BY date_enregistrement
                                            limit 5");
$annoncesPlusAnciennes->execute();

$resultatsAnnoncesAnciennes = $annoncesPlusAnciennes ->fetchAll(PDO::FETCH_ASSOC)


//Requette pour les 5 categories contenants le pluss d'annonces'

    
$topCategorie = $pdo->prepare("SELECT c.id_categorie, c.titre , COUNT(a.id_annonce)
FROM annonce a
LEFT JOIN categorie c ON c.id_categorie = a.categorie_id
GROUP BY c.titre
ORDER BY COUNT(a.id_annonce) DESC
LIMIT 5");
$topCategorie->execute();

$resultatTopCategories = $topCategorie ->fetchAll(PDO::FETCH_ASSOC)
    










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
        <div class="starter-template">
            <p class="lead"><?php echo $msg; // affichage de message pour l'utilisateur. Cette variable provient de init.inc.php ?></p>
            <a href="?action=informationsPersonnels" class="btn btn-warning text-white">Les mieux notés</a>
            <a href="?action=mesAnnonces" class="btn btn-primary">Les plus actifs</a>
            <a href="?action=mesNotes" class="btn btn-primary">Les plus anciens</a>
            <a href="?action=mesNotes" class="btn btn-primary">Catégories les plus populaires</a>
            <hr>
        </div>



        <?php
include_once('inc/footer.inc.php');

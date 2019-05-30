<?php
include_once('inc/init.inc.php');
include_once('inc/modal.inc.php');

    //Recuperation du nom des categories pour le select
    $infosCategorie = $pdo->prepare("SELECT titre, id_categorie FROM categorie");
    $infosCategorie->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $infosCategorie->execute();
    $infosCategorie = $infosCategorie->fetchAll(PDO::FETCH_ASSOC);

    //*****************************************************
    //Recupération et exploitation de la liste des communes
    //*****************************************************

    //Ouverture du fichier
    $myfile = fopen("communes1.csv", "r") or die("Unable to open file!");
    $maChaine = fread($myfile,filesize("communes1.csv"));

    //On crée une liste, en creant un nouvel element a chaque oint virgule
    $maListe = explode(";", $maChaine);
    array_shift($maListe);

    //On crée une liste qui contient toute les informations d'une ville'
    $lesVilles = [];
    $maPetiteListe = [];
    for ($i=0; $i<count($maListe);$i++){
        if ($i%7 == 0){
    //        Tout les 6 tours, j'ajoute le contenue de ma petite liste dans ma super liste
            array_push($lesVilles, $maPetiteListe);
            $maPetiteListe = [];
        }
    //    A chaque tour, j'ajoute l'element a ma petite liste
        array_push($maPetiteListe, $maListe[$i]);
    }

    //On recupere ici la liste de toutes les regions
    $listeRegions = [];
    for ($i=2; $i<count($lesVilles);$i++){
        if (!empty($lesVilles[$i][1])){
            if (!in_array($lesVilles[$i][1], $listeRegions)){
        array_push($listeRegions, $lesVilles[$i][1]);  
            }
        }      
    }

    $pourLaRegion = "(";
    foreach(cpEnFonctionDeRegion('Île-de-France', $lesVilles) as $leCp){
        $pourLaRegion .= $leCp . ',';
    }
    //Enleve le dernier élement de la chaine, et on ajoute la parenthese fermante
    $pourLaRegion = substr($pourLaRegion,0, strlen($pourLaRegion)-1);
    $pourLaRegion .= ')';

//***************************************************************************
// Faisons la requete des annonces presente au chargement de la page acceuil
//****************************************************************************

/* On calcule donc le numéro du premier enregistrement */


$perPage = 5;
$req = $pdo->query("SELECT COUNT(*) AS total FROM annonce");
$result = $req->fetch(PDO::FETCH_ASSOC);
$total = $result['total'];
$nbPage = ceil($total/$perPage);
if(isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']) == 1) {
    if($_GET['page'] > $nbPage) {
        $current = $nbPage;
    } else {
        $current = $_GET['page'];
    }
} else {
    $current = 1;
}
$firstOfPage = ($current-1)*$perPage;
$requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.photo, a.ville, m.pseudo, AVG(n.note) as moyenneNote
                                            FROM annonce a
                                            LEFT JOIN membre m ON m.id_membre = a.membre_id
                                            LEFT JOIN note n ON n.membre_id2 = m.id_membre
                                            GROUP BY a.id_annonce
                                            ORDER BY a.date_enregistrement DESC
                                            LIMIT $firstOfPage, $perPage");
$requeteAffichage->execute();
$requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);

//**************************************
//Demarrage de l'affichage de la page
//************************************
include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
    <div class="container-fluid">
        <div class="bgIndex d-flex align-item-center" style="background-image: url('images/indexbgc.jpg');">
            <form method="post" action="#" class="indexForm col-xs-12 col-lg-8 mx-auto d-flex flex-wrap justify-content-center align-content-center">
            <h1 class="text-center">Bienvenue sur <span class="colorLetter">A</span>nnonceo</h1>
                <div class="bgForm col-12">
                    <div class="row">
                        <div class="form-group col-6 col-sm-6 col-lg-3">
                            <select class="custom-select ajaxGlobale" id="categorie" name="categorie">
                                <option value="toutes">Par catégories</option>
                                <?php 
                                foreach($infosCategorie AS $laCategorie){
                                    echo '<option value="' . $laCategorie['id_categorie'] . '">' . $laCategorie['titre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-3 selectRegion">
                            <select class="ajaxGlobale custom-select" id="region" name="region">
                                <option value="toutes">Par regions</option>
                                <?php foreach($listeRegions as $laRegion){
                                echo '<option>' . $laRegion . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-3 selectDpt">
                            <select class="ajaxGlobale selectDepartement custom-select" id="departement" name="departement">
                                <option value="toutes">Par departements</option>
                                <?php foreach(departements('toutes', $lesVilles) as $leDepartement){
                                echo '<option>' . $leDepartement . '</option>';
                                }
                                ?>
                            </select>
                            <div class="ajaxGlobale form-group champVille">
                                <select class="custom-select ajaxIndex selectVille" id="ville" name="ville">
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group col-2">
                            <div class="ajaxGlobale form-group champVille">
                                <select class="custom-select ajaxIndex selectVille" id="ville" name="ville">
                                </select>
                            </div>
                        </div>  -->
                        <div class="form-group col-6 col-sm-6 col-lg-3">
                            <select class="ajaxGlobale custom-select" id="optionTrie" name="trie">
                                <option value="parDateDesc">Les plus récentes</option>
                                <option value="parDateAsc">Les plus anciennes</option>
                                <option value="parPrixDesc">Les moins chères</option>
                                <option value="parPrixAsc">Les plus chères</option>
                                <option value="parVendeur">Les meilleurs vendeurs</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>  
    <!-- ***************************************** -->
    <!-- Affichage des annonces en pages d'accueil -->
    <!-- ***************************************** --> 
    <div class="pageIndex">
        <div class="container">
            <div class="starter-template">
                <p class="lead">
                    <?php echo $msg;?>
                </p>
            </div>
            <div class="row">
            <!--
        ****************************
        DEBUT DU FORMULAIRE DE TRIE
        ****************************
        -->
            <nav class="col-lg-2 mt-3 filtrePrix">
                <div class="form-group">
                    <label for="prixMinimum">Filtrer par prix</label>
                    <input type="range" class="rangeMin ajaxGlobale" id="prixMinimum" name="prixMin" min="0" max="5000" step="10" value="0" />
                    <output class="" id="prixMin" name="resultMin"></output>
                </div>
                <div class="form-group">
                    <label for="prixMaximum"></label>
                    <input type="hidden" class="ajaxGlobale rangeMax" id="prixMaximum" name="prixMax" min="0" max="5000" step="10" value="5000" />
                    <output id="prixMax" class="" name="resultMax"></output>
                </div>
            </nav>
        
            <div class="annonce-index col-lg-10 mt-3">
            <ul class="pagination pagination-sm dark">
                <li class="<?php if($current == '1'){ echo "page-item disabled";} ?>"><a href="?page=<?php if($current != '1') { echo $current - 1; } else { $current; } ?>" class="page-link">&laquo;</a></li>

                <?php 
                for($i=1; $i<=$nbPage; $i++) {
                    if($i == $current) {
                        ?>
                        <li class="page-item active"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i?></a></li>
                        <?php
                    } else {
                        ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i?></a></li>
                        <?php
                    }
                }
                ?>                    

                <li class="<?php if($current == $nbPage){ echo "page-item disabled";} ?>"><a href="?page=<?php if($current != $nbPage) { echo $current + 1; } else { $current; } ?>" class="page-link">&raquo;</a></li>
            </ul>
            <div class="container">
                <div id="contenerReponseRequete" class="row">
                <!--Affichage de chargement de la page, qui s'affichera avant que le ajax ne rentre en jeu (sera effacer apres)-->
                    <?php 
                    foreach($requeteAffichage as $uneLigne){
                    ?>
                    <div class="blocRequete no-gutters bg-light col-sm-10 mx-auto col-12 mb-4 shadow">
                        <div class="row">
                            <div class="col-md-4 imgAnnonce">
                                <a href="<?php echo URL; ?>annonce.php?id_annonce=<?php echo $uneLigne['id_annonce']; ?>">
                                    <div class="picture">
                                        <img src="<?php echo $uneLigne['photo']; ?>" class="py-1 d-block" alt="photo annonceo">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-8 textAnnonce">
                                <div class="headerAnnonce mx-auto w-100 mb-2 d-flex ">
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo ucfirst($uneLigne['ville']);?></span>
                                    <span class="vendeurAnnonce"><i class="far fa-user"></i>
                                    <?php echo ucfirst($uneLigne['pseudo']); ?></span>
                                    <span class="note"> <?php if($uneLigne['moyenneNote'] == '') {
                                                echo 'Aucune note';?></span>
                                            <?php } else { ?>
                                            Notes : <?php echo round($uneLigne['moyenneNote'],1); ?>/5</span>
                                            <?php } ?>     
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 mt-2">
                                        <h5 class="colorLetter"><?php echo ucfirst($uneLigne['titre']); ?></h5>                            
                                        <p class="descAnnonces">
                                            <?php echo ucfirst($uneLigne['description_courte']); ?>
                                        </p>
                                    </div>
                                    <div class="col-lg-4 mt-2 d-flex flex-column">
                                        <p class="euroText text-right">
                                            <?php echo $uneLigne['prix']; ?> <i class="fas fa-euro-sign"></i>
                                        </p>
                                        <a href="<?php echo URL; ?>annonce.php?id_annonce=<?php echo $uneLigne['id_annonce']; ?>" class="btn btn-outline-dark">Voir l'annonce</a>           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <ul class="pagination pagination-sm">
                <li class="<?php if($current == '1'){ echo "page-item disabled";} ?>"><a href="?page=<?php if($current != '1') { echo $current - 1; } else { $current; } ?>" class="page-link">&laquo;</a></li>

                <?php 
                for($i=1; $i<=$nbPage; $i++) {
                    if($i == $current) {
                        ?>
                        <li class="page-item active"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i?></a></li>
                        <?php
                    } else {
                        ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i?></a></li>
                        <?php
                    }
                }
                ?>                    

                <li class="<?php if($current == $nbPage){ echo "page-item disabled";} ?>"><a href="?page=<?php if($current != $nbPage) { echo $current + 1; } else { $current; } ?>" class="page-link">&raquo;</a></li>
            </ul>
            </div>
        </div>
    </div>
</div>
<!-- Fin d'affichage des annonces en pages d'accueil -->
<?php
include_once('inc/footer.inc.php');


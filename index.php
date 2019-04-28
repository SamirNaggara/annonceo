<?php
include_once('inc/init.inc.php');
include_once('inc/modal.inc.php');

$infosCategorie = $pdo->prepare("SELECT titre, id_categorie FROM categorie");
        $infosCategorie->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
        $infosCategorie->execute();
        
        $infosCategorie = $infosCategorie->fetchAll(PDO::FETCH_ASSOC);





//Ouverture du fichier
$myfile = fopen("communes1.csv", "r") or die("Unable to open file!");
$maChaine = fread($myfile,filesize("communes1.csv"));

//On crée une liste, en creant un nouvel element a chaque oint virgule
$maListe = explode(";", $maChaine);
array_shift($maListe);
//echo $maChaine;
//echo count($maListe);
//echo '<pre>';
//print_r($maListe);
//echo '</pre>';
//fclose($myfile);

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
//array_shift($lesVilles);
//echo '<pre>';
//print_r($lesVilles);
//echo '</pre>';

//echo $lesVilles[2][1];

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
    
            echo $pourLaRegion;
//AND SUBSTRING(a.cp,1,2) IN :region


//echo '<pre>';
//print_r(cpEnFonctionDeVille('toutes', $lesVilles));
//echo '</pre>';

// Faisons la requete des annonces presente au chargement de la page acceuil
$requeteAffichage = $pdo->prepare("SELECT a.id_annonce, a.titre, a.description_courte, a.prix, a.photo, m.pseudo, AVG(n.note) as moyenneNote
                                            FROM annonce a
                                            LEFT JOIN membre m ON m.id_membre = a.membre_id
                                            LEFT JOIN note n ON n.membre_id2 = m.id_membre
                                            GROUP BY a.id_annonce
                                            ORDER BY a.date_enregistrement DESC
                                            LIMIT 30");
$requeteAffichage->execute();

$requeteAffichage = $requeteAffichage -> fetchAll(PDO::FETCH_ASSOC);


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

<div class="containerPage container-fluid row">
    <div class="contenerResultat d-none" id="contenerResultat"></div>
    <?php 
//    echo '<pre>';
//    print_r($_POST);
//    echo '<pre>';

    ?>
    <nav class="col-lg-4 mt-3">
        <div class="form-group">
            <label for="champsRechercher">Rechercher</label>
            <input type="email" class="form-control ajaxGlobale" id="champsRechercher" placeholder="Tapez votre recherche ici">
        </div>
        <form method="post" action="#">
            <div class="form-group">
                <label for="categorie">Categorie</label>
                <select class="custom-select ajaxGlobale" id="categorie" name="categorie">
                    <option value="toutes">Toutes les catégories</option>
                    <?php 

                    foreach($infosCategorie AS $laCategorie){
                        echo '<option value="' . $laCategorie['id_categorie'] . '">' . $laCategorie['titre'] . '</option>';
                    }
                    ?>

                </select>
            </div>
            <div class="form-group">
                <label for="region">Regions</label>
                <select class="ajaxGlobale custom-select" id="region" name="region">
                    <option value="toutes">Toutes les regions</option>
                    <?php foreach($listeRegions as $laRegion){
                    echo '<option>' . $laRegion . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departement">Departement</label>
                <select class="ajaxGlobale selectDepartement custom-select" id="departement" name="departement">
                    <option value="toutes">Tout les departements</option>
                    <?php foreach(departements('toutes', $lesVilles) as $leDepartement){
                    echo '<option>' . $leDepartement . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="ajaxGlobale form-group champVille">
                <label for="ville">Ville</label>
                <select class="custom-select ajaxIndex selectVille" id="ville" name="ville">

                </select>


            </div>
            <div class="form-group">
                <label for="prixMinimum">Prix minimum</label>
                <input type="range" class="rangeMin ajaxGlobale" id="prixMinimum" name="prixMin" min="0" max="5000" step="10" value="0" />
                <output class="" id="prixMin" name="resultMin"></output>
            </div>
            <div class="form-group">
                <label for="prixMaximum">Prix maximum</label>
                <input type="range" class="ajaxGlobale rangeMax" id="prixMaximum" name="prixMax" min="0" max="5000" step="10" value="5000" />
                <output id="prixMax" class="" name="resultMax"></output>
            </div>
            <!--           <button type="submit" name="enregistrement">Valider</button>-->
        </form>
        <h3>Options de trie</h3>
        <div class="form-check">
            <input class="form-check-input ajaxGlobale" type="radio" name="trie" id="parDateDesc" value="parDateDesc" checked>
            <label class="form-check-label" for="parDateDesc">
                Les plus récentes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input ajaxGlobale" type="radio" name="trie" id="parDateAsc" value="parDateAsc">
            <label class="form-check-label" for="parDateAsc">
                Les plus anciennes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input ajaxGlobale" type="radio" name="trie" id="parPrixDesc" value="parPrixDesc">
            <label class="form-check-label" for="parPrixDesc">
                Les moins chères
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input ajaxGlobale" type="radio" name="trie" id="parPrixAsc" value="parPrixAsc">
            <label class="form-check-label" for="parPrixAsc">
                Les plus chères
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input ajaxGlobale" type="radio" name="trie" id="parVendeur" value="parVendeur">
            <label class="form-check-label" for="parVendeur">
                Les meilleurs vendeurs
            </label>
        </div>
    </nav>
    <!-- Affichage des annonces en pages d'accueil -->
    <div class="container annonce-index col-lg-8 mt-3">
        <div class="starter-template">
            <h1><i class="fas fa-shopping-cart mes_icones"></i> Bienvenue sur Annonceo <i class="fas fa-shopping-cart mes_icones"></i></h1>
            <p class="lead">
                <?php echo $msg;?>
            </p>
        </div>

        <div id="contenerReponseRequete" class="mx-auto">
            <?php 
            foreach($requeteAffichage as $uneLigne){
               ?>
            <div class="blocRequete row no-gutters bg-light position-relative mx-auto">
                <div class="col-md-6 mb-md-0 p-md-4">
                    <a href="<?php echo URL; ?>annonce?id_annonce=<?php echo $uneLigne['id_annonce']; ?>">
                        <img src="<?php echo $uneLigne['photo']; ?>" class="w-100 img-fluid" alt="photo annonceo">
                    </a>
                </div>
                <div class="col-md-6 texte position-relative p-0 pl-md-0">
                    <h5 class="mt-0 p-0 pt-3 text-center text-md-left"><?php echo ucfirst($uneLigne['titre']); ?></h5>
                    <p class="p-0 text-center text-md-left w-100 mx-auto">
                        <?php echo ucfirst($uneLigne['description_courte']); ?>
                    </p>
                    <div class="footerAnnonce row mx-auto w-100 pb-4 mb-2 pr-3">
                        <span class="d-inline-block col-md-6 m-0 p-0 pb-1 text-center text-md-left">
                            <?php echo ucfirst($uneLigne['pseudo']); ?>: <?php echo round($uneLigne['moyenneNote'],1); ?>/5</span>
                        <span class="d-inline-block m-0 p-0 pb-1 col-md-6 text-center text-md-right">
                            <?php echo $uneLigne['prix']; ?> <i class="fas fa-euro-sign"></i>
                        </span>
                    </div>
                </div>
            </div>
            <?php
            }
            

            ?>

        </div>
    </div>


</div>
<!-- Fin d'affichage des annonces en pages d'accueil -->
<?php
include_once('inc/footer.inc.php');
?>

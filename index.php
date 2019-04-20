<?php
include_once('inc/init.inc.php');
include_once('inc/modal.inc.php');










include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
<!-- Affichage des annonces en pages d'accueil -->
<div class="container annonce-index">
    <div class="starter-template">
        <h1><i class="fas fa-shopping-cart mes_icones"></i> Bienvenue sur Annonceo <i class="fas fa-shopping-cart mes_icones"></i></h1>
        <p class="lead"><?php echo $msg;?></p>
    </div>
    <div class="row no-gutters bg-light position-relative">
        <div class="col-md-6 mb-md-0 p-md-4">
            <img src="images/img1.jpg" class="w-100 img-fluid"  alt="...">
        </div>
        <div class="col-md-6 position-static p-4 pl-md-0">
            <h5 class="mt-0">Columns with stretched link</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            <a href="<?php echo URL . "annonce.php?id_annonce=2"; ?>" class="stretched-link">Go somewhere</a>
        </div>
    </div>
    <br>
    <div class="row no-gutters bg-light position-relative">
        <div class="col-md-6 mb-md-0 p-md-4">
            <img src="images/img1.jpg" class="w-100 img-fluid"  alt="...">
        </div>
        <div class="col-md-6 position-static p-4 pl-md-0">
            <h5 class="mt-0">Columns with stretched link</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            <a href="#" class="stretched-link">Go somewhere</a>
        </div>
    </div>
        <br>
    <div class="row no-gutters bg-light position-relative">
        <div class="col-md-6 mb-md-0 p-md-4">
            <img src="images/img1.jpg" class="w-100 img-fluid"  alt="...">
        </div>
        <div class="col-md-6 position-static p-4 pl-md-0">
            <h5 class="mt-0">Columns with stretched link</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            <a href="#" class="stretched-link">Go somewhere</a>
        </div>
    </div>
    <br>
    <div class="row no-gutters bg-light position-relative">
        <div class="col-md-6 mb-md-0 p-md-4">
            <img src="images/img1.jpg" class="w-100 img-fluid"  alt="...">
        </div>
        <div class="col-md-6 position-static p-4 pl-md-0">
            <h5 class="mt-0">Columns with stretched link</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            <a href="#" class="stretched-link">Go somewhere</a>
        </div>
    </div>
    <br>
    <div class="row no-gutters bg-light position-relative">
        <div class="col-md-6 mb-md-0 p-md-4">
            <img src="images/img1.jpg" class="w-100 img-fluid"  alt="...">
        </div>
        <div class="col-md-6 position-static p-4 pl-md-0">
            <h5 class="mt-0">Columns with stretched link</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            <a href="#" class="stretched-link">Go somewhere</a>
        </div>
    </div>
</div>
<!-- Fin d'affichage des annonces en pages d'accueil -->
<?php
include_once('inc/footer.inc.php');
?>

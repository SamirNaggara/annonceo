<?php
include_once('inc/init.inc.php');


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
<div class="container">
    <div class="starter-template col-lg-10 mx-auto text-center">
        <h1>Contact</h1>
<!--        Attention!!! Important pour ecrire les messages d'erreurs-->
        <p class="lead"></p>
    </div>
    
<div class="row">
    <div class="col-lg-10 mx-auto">
        <form id="contactForm" method="post" action="">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="contactNom">Nom <span class="blue">*</span></label>
                    <input type="text" class="form-control" id="contactNom" name="contactNom" placeholder="Votre Nom" value="">
                    <p class="comment"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="contactPrenom">Prénom <span class="blue">*</span></label>
                    <input type="text" class="form-control" id="contactPrenom" name="contactPrenom" placeholder="Votre Prénom" value="">
                    <p class="comment"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="contactEmail">Email <span class="blue">*</span></label>
                    <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Votre Email" value="">
                    <p class="comment"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="contactObjet">Objet <span class="blue">*</span></label>
                    <input type="text" class="form-control" id="contactObjet" name="contactObjet" placeholder="Objet de votre mail" value="">
                    <p class="comment"></p>
                </div>
                <div class="form-group col-md-12">
                    <label for="contactMessage">Message <span class="blue">*</span></label>
                    <textarea id="contactMessage" class="form-control col-md-12" name="contactMessage" rows="4" placeholder="Votre message"></textarea>
                    <p class="comment"></p>
                </div>
                <div class="col-md-12">
                    <p class="blue"><strong>* Ces informations sont requises.</strong></p>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-warning col-md-12" name="contactEnvoyer">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');

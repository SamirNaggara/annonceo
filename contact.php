<?php
include_once('inc/init.inc.php');


include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>
<div class="container-fluid contact">
    <div class="starter-template col-lg-10 offset-lg-2 text-center">
        <h1>Contact</h1>
        <div class="divider"></div>
<!--        Attention!!! Important pour ecrire les messages d'erreurs-->
        <p class="lead"></p>
    </div>
    
    <div class="row">
        <div class="container">
            <div class="col-lg-8 offset-lg-4">
                <form id="contactForm" method="post">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contactNom">Nom <span class="colorLetter">*</span></label>
                            <input type="text" class="form-control" id="contactNom" name="contactNom" placeholder="Votre Nom" value="">
                            <p class="comment"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contactPrenom">Prénom <span class="colorLetter">*</span></label>
                            <input type="text" class="form-control" id="contactPrenom" name="contactPrenom" placeholder="Votre Prénom" value="">
                            <p class="comment"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contactEmail">Email <span class="colorLetter">*</span></label>
                            <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Votre Email" value="">
                            <p class="comment"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contactObjet">Objet <span class="colorLetter">*</span></label>
                            <input type="text" class="form-control" id="contactObjet" name="contactObjet" placeholder="Objet de votre mail" value="">
                            <p class="comment"></p>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="contactMessage">Message <span class="colorLetter">*</span></label>
                            <textarea id="contactMessage" class="form-control col-md-12" name="contactMessage" rows="4" placeholder="Votre message"></textarea>
                            <p class="comment"></p>
                        </div>
                        <div class="col-md-12">
                            <p class="colorLetter"><strong>* Ces informations sont requises.</strong></p>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-dark col-md-12" name="contactEnvoyer">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
include_once('inc/footer.inc.php');

<?php
include_once('inc/init.inc.php');


















include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');
?>

    <div class="starter-template">
        <h1>Contact</h1>
<!--        Attention!!! Important pour ecrire les messages d'erreurs-->
        <p class="lead"><?php echo $msg;?></p>
    </div>
    
<div class="row">
    <div class="col-6 mx-auto">
        <form id="contactForm" method="post" action="">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="contactName" aria-describedby="contactPseudoHelp" placeholder="Votre Nom">
            </div>
            <div class="form-group">
                <label for="firstName">Nom</label>
                <input type="text" class="form-control" id="contactFirstName" aria-describedby="contactFirstNameHelp" placeholder="Votre Prénom">
            </div>
            <div class="form-group">
                <label for="firstName">Email</label>
                <input type="text" class="form-control" id="contactEmail" aria-describedby="contactEmailHelp" placeholder="Votre Email">
            </div>
            <div class="form-group">
                <label for="firstName">Email</label>
                <textarea name="message" id="message" cols="74" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>

<?php
include_once('inc/footer.inc.php');

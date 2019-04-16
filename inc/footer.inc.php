<div class="row">
    <div class="modal fade" id="inscriptionModal" tabindex="-1" role="dialog" aria-labelledby="inscriptionModalLabel" aria-hidden="true" class="col-sm-4">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">S'inscrire</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPseudo" aria-describedby="pseudoHelp" placeholder="Votre pseudo">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPassword" aria-describedby="passwordHelp" placeholder="Votre mot de passe">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Votre nom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputFirstName" aria-describedby="firstNameHelp" placeholder="Votre prénom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Votre email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPhone" placeholder="Votre téléphone">
                        </div>
                        <select class="custom-select" id="inputSelect ">
                            <option selected>Homme</option>
                            <option value="">Femme</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Inscription</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="modal fade" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="connexionModalLabel" aria-hidden="true" class="col-sm-4">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connexionModalLabel">Connexion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="connection">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="connecxionInputPseudo" aria-describedby="pseudoHelp" placeholder="Votre pseudo">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="connexionInputPassword" aria-describedby="passwordHelp" placeholder="Votre mot de passe">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main><!-- /.container -->

<footer class="sticky-footer footerMembre">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright © Annonceo 2019 </span>
            <span><a href="<?php echo URL ?>mentions-legales.php">Mentions légales </a></span>
            <span><a href="<?php echo URL ?>conditions-generales-de-ventes.php">Conditions générales de ventes </a></span>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
    window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')

</script>
<script src="<?php echo URL ?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URL ?>js/sb-admin.min.js"></script>
<script src="<?php echo URL ?>js/monScript.js"></script>
</body>

</html>

<?php
include_once('inc/init.inc.php');
include_once('inc/modal.inc.php');
?>
<!-- Début Modal d'inscription -->
<div class="row">
    <div class="modal fade col-sm-12 mx-auto" id="inscriptionModal" tabindex="-1" role="dialog" aria-labelledby="inscriptionModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleInscription">S'inscrire</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register" method="post">
                        <div class="form-group">
                            <label for="inputPseudo">Pseudo</label>
                            <input type="text" class="form-control" id="inputPseudo" aria-describedby="inputPseudo" placeholder="Votre pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="registerinputPassword">Mot de passe</label>
                            <input type="password" class="form-control" id="registerinputPassword" aria-describedby="registerinputPassword" placeholder="Votre mot de passe" name="mdp" value="<?php echo $mdp; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Nom</label>
                            <input type="text" class="form-control" id="inputName" aria-describedby="inputName" placeholder="Votre nom" name="nom" value="<?php echo $nom; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputFirstName">Prénom</label>
                            <input type="text" class="form-control" id="inputFirstName" aria-describedby="inputFirstName" placeholder="Votre prénom" name="prenom" value="<?php echo $prenom; ?>">
                        </div>
                        <div class="form-group">
                            <label for="registerinputEmail">Email</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="text" class="form-control" id="registerinputEmail" aria-describedby="registerinputEmail" placeholder="Votre email" name="email" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="registerinputPhone">Téléphone</label>
                            <input type="tel" class="form-control" id="registerinputPhone" placeholder="Votre téléphone" name="telephone" value="<?php echo $telephone; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputSelect">Civilité</label>
                            <select class="custom-select" id="inputSelect" name="civilite">
                                <option value="m">Homme</option>
                                <option value="f" <?php if($civilite == 'f') echo 'selected';?>>Femme</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark w-100" onclick="return inscription()" id="inscription" name="inscription" value="Inscription">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal d'inscription -->

<!-- Modal de deconnection-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deconnexion">Prêt à partir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Êtes vous sûrs de vouloir vous deconnecter?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-dark" href="<?php echo URL . '?action=deconnexion'; ?>">Me deconnecter</a>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal de deconnexion -->

<!-- Début Modal de connexion -->
<div class="row">
    <div class="modal fade col-sm-12 mx-auto" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="connexionModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connexionModalLabel">Connexion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="connection">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formCon">
                        <div class="form-group">
                            <input type="text" class="form-control" id="connexionInputPseudo" aria-describedby="connexionInputPseudo" placeholder="Votre pseudo" name="pseudo_connexion">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="connexionInputPassword" aria-describedby="connexionInputPassword" placeholder="Votre mot de passe" name="mdp_connexion">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Connexion</button>
                        <!-- lien renvoyant vers le formulaire de renouvellement de mot de passe -->
                        <p><a href="reset-password.php" class="colorLetter text-decoration-none">Mot de passe oublié ?</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Fin Modal de connexion -->
</main>

<footer class="sticky-footer footerMembre">
    <div class="mx-auto my-auto">
        <div class="copyright text-center my-auto">
            <span class="mx-2">Copyright © Annonceo 2019 </span><span> |</span>
            <span class="mx-2"><a href="<?php echo URL?>mentions-legales.php">Mentions légales</a></span><span>|</span>
            <span class="mx-2"><a href="<?php echo URL ?>conditions-generales-de-ventes.php">Conditions générales de ventes </a></span>
        </div>
    </div>
</footer>

<script
        src="https://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
        crossorigin="anonymous">
</script>

<script>
    window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')

</script>
<script src="<?php echo URL ?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URL ?>js/sb-admin.min.js"></script>
<script src="<?php echo URL ?>js/jquery-ui.min.js"></script>
<script src="<?php echo URL ?>js/ekko-lightbox.js"></script>
<script src="<?php echo URL ?>js/anchorjs/anchor.js"></script>
<script src="<?php echo URL ?>js/monScript.js"></script>
<script src="<?php echo URL ?>js/carte.js"></script>
<script>
        $(document).ready(function ($) {
            // delegate calls to data-toggle="lightbox"
            $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"]):not([data-gallery="example-gallery-11"])', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    onShown: function() {
                        if (window.console) {
                            return console.log('');
                        }
                    },
                    onNavigate: function(direction, itemIndex) {
                        if (window.console) {
                            return console.log('');
                        }
                    }
                });
            });

            // disable wrapping
            $(document).on('click', '[data-toggle="lightbox"][data-gallery="example-gallery-11"]', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    wrapping: false
                });
            });

            //Programmatically call
            $('#open-image').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });
            $('#open-youtube').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });

            // navigateTo
            $(document).on('click', '[data-toggle="lightbox"][data-gallery="navigateTo"]', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    onShown: function() {
                        this.modal().on('click', '.modal-footer a', function(e) {
                            e.preventDefault();
                            this.navigateTo(2);
                        }.bind(this));
                    }
                });
            });

            anchors.options.placement = 'left';
            anchors.add('h3');
            $('code[data-code]').each(function() {
                var $code = $(this),
                    $pair = $('div[data-code="'+$code.data('code')+'"]');
                $code.hide();
                var text = $code.text($pair.html()).html().trim().split("\n");
                var indentLength = text[text.length - 1].match(/^\s+/)
                indentLength = indentLength ? indentLength[0].length : 24;
                var indent = '';
                for(var i = 0; i < indentLength; i++)
                    indent += ' ';
                if($code.data('trim') == 'all') {
                    for (var i = 0; i < text.length; i++)
                        text[i] = text[i].trim();
                } else  {
                    for (var i = 0; i < text.length; i++)
                        text[i] = text[i].replace(indent, '    ').replace('    ', '');
                }
                text = text.join("\n");
                $code.html(text).show();
            });
        });
    </script>
</body>

</html>

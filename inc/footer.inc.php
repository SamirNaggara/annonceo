</main><!-- /.container -->
<footer>

    <!-- Modal -->
    <div class="modal fade" id="modalInscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">S'inscrire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="pseudo" placeholder="Votre pseudo">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="mdp" placeholder="Votre mot de passe">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="nom" placeholder="Votre nom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="prenom" placeholder="Votre prénom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" placeholder="Votre email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="telephone" placeholder="Votre Téléphone">
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100" data-dismiss="modal">Inscription</button>
                        </div>
                    </form>
                </div>
            </div>                
        </div>
    </div>
    <div class="modal fade" id="modalConnexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document"></div>
                <div class="container">
                    <div class="card card-login mx-auto mt-5">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <div class="form-label-group">
                                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                                <label for="inputEmail">Email address</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                                <label for="inputPassword">Password</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me">
                                    Remember Password
                                </label>
                                </div>
                            </div>
                            <a class="btn btn-primary btn-block" href="index.html">Login</a>
                        </form>
                        <div class="text-center">
                        <a class="d-block small mt-3" href="register.html">Register an Account</a>
                        <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul>
        <li><a href="#">Mentions légales</a></li>
        <li><a href="#">Conditions générales de vente</a></li>
    </ul>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
    window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')

</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/sb-admin.min.js"></script>
<script src="../js/monScript.js"></script>
</body>

</html>

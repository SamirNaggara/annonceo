    <?php 
    include_once('inc/init.inc.php');
    include_once('inc/modal.inc.php');
    ?>
        <!-- Navbar -->
        <!-- Accueil -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="<?php echo URL;?>index.php">Annonceo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <!-- Dépot d'annonce -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="nouvelle-annonce.php">Déposer une annonce</a>
                    </li>
                    <!-- Adminstration si utilisateur est admin -->
                    <?php 
                    if(user_is_admin()) {
                    echo '<li class="nav-item dropdown">
                        <a class="nav-link" href="'.URL.'/admin/index.php" id="dropdown02" aria-haspopup="true" aria-expanded="false">Administration</a>
                    </li>';
                    }?>
                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <!-- Barre de recherche -->
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Espace membres -->
                <ul class="navbar-nav ml-auto ml-md-0">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?php echo URL ?>">Accueil site</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?action=deconnexion" data-toggle="modal" data-target="#logoutModal">Déconnexion</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#inscriptionModal" class="test" data-backdrop="static">Inscription</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#connexionModal" data-backdrop="static">Connexion</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo URL; ?>profil.php">Profil</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    <main role="main" class="container">

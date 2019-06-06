    <?php 
    include_once('inc/init.inc.php');
    include_once('inc/modal.inc.php');
    ?>
        <!-- Navbar -->
        <!-- Accueil -->
        <?php
        if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
            session_destroy();            
            header('Location:' . URL);
        } 
        ?>
        
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-md-flex justify-content-md-between text-center text-md-left" id="navbarsExampleDefault">
                <ul class="navbar-nav col-sm-12 col-md-6 col-lg-6 p-0">
                    <li class="title text-white">
                        <a class="navbar-brand hover" href="<?php echo URL;?>index.php"><span class="colorLetter">A</span>nnonceo</a>
                    </li>
                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link hover m-0" href="contact.php">Contact</a>
                    </li>
                    <!-- Dépot d'annonce -->
                    <!-- On affiche "Déposer une annonce" seulement siun utilateur est connecter-->
                    <?php if (user_is_connected()){ ?>
                    <li class="nav-item dropdown col-sm-12 col-md-7 col-lg-5 p-0 text-center">
                        <a class="nav-link hover depot" href="nouvelle-annonce.php"><i class="fas fa-plus-circle"></i> Déposer une annonce</a>
                    </li>
                    <?php } ?>
                </ul>
                <hr class="m-2">
                <div class="row">
                    <!-- Barre de recherche -->
                    <form class="col-lg-5 pl-md-5 p-lg-0" method="get">
                        <div class="input-group pl-md-4">
                            <input type="text" id="champsRechercher" class="form-control ajaxGlobale" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="champsRechercher">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-search" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Espace membres -->
                    <ul class="navbar-nav col-sm-12 col-lg-7 px-0 d-flex justify-content-sm-around">
                        <!-- Adminstration si utilisateur est admin -->
                        <?php 
                        if(user_is_admin()) {
                        echo '<li class="nav-item dropdown ml-md-auto">
                            <a class="nav-link" href="'.URL.'/admin/index.php" id="dropdown02" aria-haspopup="true" aria-expanded="false">Administration</a>
                        </li>';
                        }?>
                        <li class="nav-item dropdown no-arrow mr-2">
                            <a class="nav-link dropdown-toggle hover" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle fa-fw"></i>
                                <?php 
                                // Si l'utilisateur n'est pas connecter on ecrit "se connecter", sinon on n'ecris le pseudo du membre, et entre parenthese s'il est admin ou non
                                if (!user_is_connected()){
                                    echo 'Espace membre';
                                }
                                else{
                                    echo ucfirst($_SESSION['utilisateur']['pseudo']);
                                    
                                    if (user_is_admin()){
                                        echo ' (admin)';
                                    }
                                }
                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <?php 
                                // Inscription et connections ne n'apparaissent que si l'utilisateur n'est pas connecter
                                
                                if (!user_is_connected()){
                                    ?>
                                    
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#connexionModal" data-backdrop="static"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item test" href="#" data-toggle="modal" data-target="#inscriptionModal" data-backdrop="static"><i class="far fa-edit"></i> Inscription</a>
                                
                                
                                
                                <?php
                                }else{
                                    if (user_is_admin()){
                                        ?>
                                        <a class="dropdown-item" href="<?php echo URL . 'admin/index.php'; ?>" ><i class="fas fa-users-cog"></i> Administration</a>
                                <div class="dropdown-divider"></div>
                                <?php
                                    }
                                ?>
                                
                                <a class="dropdown-item" href="<?php echo URL; ?>profil.php"><i class="fas fa-user"></i> Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo URL . '?action=deconnexion' ?>" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
       
    <main style="padding-top: 55px;">

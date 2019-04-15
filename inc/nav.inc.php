    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Annonceo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Annonces</a>
                </li>
                <!-- espace membres -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Espace membres</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#inscriptionModal">Inscription</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#connexionModal">Connexion</a>
                        <a class="dropdown-item" href="#">Profil</a>
                    </div>
                </li>
                <!-- adminstration -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="<? echo 'URL'?> 'admin/templateAdmin.php'" id="dropdown02" aria-haspopup="true" aria-expanded="false">Administration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Rechercher" aria-label="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Rechercher une annonce</button>
            </form>
        </div>
    </nav>
    
    <main role="main" class="container">

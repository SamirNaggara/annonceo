  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="<?php echo URL; ?>">Administration</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
          <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                  <button class="btn btn-primary btn-search" type="button">
                      <i class="fas fa-search"></i>
                  </button>
              </div>
          </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">

          <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="<?php echo URL ?>">Accueil site</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo URL . '?action=deconnexion' ?>" data-toggle="modal" data-target="#logoutModal">Deconnexion</a>
              </div>
          </li>
      </ul>

  </nav>

  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="<?php echo URL ?>admin/statistiques.php">
                  <i class="fas fa-fw fa-chart-area"></i>
                  <span>Statistiques</span></a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-fw fa-folder"></i>
                  <span>Gestions</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                  <h6 class="dropdown-header">Gestion des:</h6>
                  <a class="dropdown-item" href="<?php echo URL ?>admin/annonces.php">Annonces</a>
                  <a class="dropdown-item" href="<?php echo URL ?>admin/categories.php">Catégories</a>
                  <a class="dropdown-item" href="<?php echo URL ?>admin/membres.php">Membres</a>
                  <a class="dropdown-item" href="<?php echo URL ?>admin/commentaires.php">Commentaires</a>
                  <a class="dropdown-item" href="<?php echo URL ?>admin/notes.php">Notes</a>
              </div>
          </li>


      </ul>
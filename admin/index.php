<?php

include_once('../inc/init.inc.php');


if(!user_is_admin()) {
	header("location:" . URL . "profil.php");
	exit(); // permet de bloquer l'exécution de la suite du script
}


















include_once('inc/header.inc.php');
include_once('inc/nav.inc.php');

?>



    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item active">Vue globale</li>
        </ol>

        
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->

    <!-- /.content-wrapper -->

 <?php
include_once('inc/footer.inc.php');
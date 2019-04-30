<?php

$tab = array();

$tab['resultat'] = '';
if (isset($_POST['idCategorie'])){
    $tab['resultat'] .= $_POST['idCategorie'];
}

if (isset($_POST['region'])){
    $tab['resultat'] .= $_POST['region'];
}

if (isset($_POST['departement'])){
    $tab['resultat'] .= $_POST['departement'];
}

if (isset($_POST['prixMin'])){
    $tab['resultat'] .= $_POST['prixMin'];
}

if (isset($_POST['prixMax'])){
    $tab['resultat'] .= $_POST['prixMax'];
}

echo json_encode($tab);




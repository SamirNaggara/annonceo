<?php

$host_db = 'mysql:host=localhost;dbname=annonceo';
$user = 'root';
$password = '';
$options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$pdo= new PDO($host_db, $user, $password, $options);

$msg = '';
$msg2 = '';

session_start();
include_once('function.inc.php');
//define('URL', 'http://localhost/teamRocket/trunk/');
define('URL', 'http://localhost/teamRocket/trunk/');

//Constante de l'adresse mail à laquelle la page contact renvoie un mail a annonceo
define('EMAILANNONCEO', 'samirm.nagg@gmail.com');

define('RACINE_SERVEUR', $_SERVER['DOCUMENT_ROOT'] . '/teamRocket/trunk//'); 

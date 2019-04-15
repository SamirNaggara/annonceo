<?php

$host_db = 'mysql:host=localhost;dbname=annonceo';
$user = 'root';
$password = '';
$options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$pdo = new PDO($host_db, $user, $password, $options);

$msg = '';

session_start();
include_once('function.inc.php');
define('URL', 'http://localhost/teamRocket/trunk/');

define('RACINE_SERVEUR', $_SERVER['DOCUMENT_ROOT'] . 'teamRocket.git/trunk/'); 

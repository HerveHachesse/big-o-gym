<?php
// Paramètres persos
$host = "xxxx"; // voir hébergeur
$user = "xxxx"; // vide ou "root" en local
$pass = "xxxx"; // vide en local
$bdd = "xxxx"; // nom de la BD

// connexion
try {
$DB = new PDO('mysql:host='.$host.';dbname='.$bdd,$user,$pass,array(
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOExeption $e) {
echo " connexion BDD impossible... ";
}
?>
<?php
// Paramètres persos
$host = ""; // voir hébergeur ou localhost en local
$user = ""; // vide ou "root" en local
$pass = ""; // vide en local
$bdd = ""; // nom de la BD

// connexion
try {
$DB = new PDO('mysql:host='.$host.';dbname='.$bdd,$user,$pass,array(
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOExeption $e) {
echo " connexion BDD impossible... ";
}
?>
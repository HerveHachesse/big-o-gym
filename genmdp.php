<?php 
$clair=$_GET['clair'];

$mdp=password_hash( $clair, PASSWORD_DEFAULT);
$chkpass = password_verify($clair, $mdp);

echo $clair;
echo ('<br>');
echo $mdp;
echo ('<br>');
echo $chkpass;
?>


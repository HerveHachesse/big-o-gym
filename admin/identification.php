<?php
// verif sessions
session_start();
include("config.php");
header('Content-type: application/json');

$msgok = 'Utilisateur ET mot de passe obligatoires';
// post log+pass presents ? 
if (!empty($_POST['login']) && !empty($_POST['mdp'])) {

	// prepare table tempo 
    $sql = "
	CREATE TEMPORARY TABLE membres
	SELECT 'client' AS type, client_id AS id, client_mail AS email, user_pwd AS passwd FROM bg_clients  
	UNION 
	SELECT 'salle' AS type, salle_id AS id, mail_gerant AS email, user_pwd AS passwd FROM bg_salles
	UNION
	SELECT 'admin' AS type, admin_id AS id, admin_mail AS email, user_pwd AS passwd FROM bg_admins
	";
	$req = $DB->prepare($sql);
    $req->execute();
	
	$login=$_POST['login'];
// verif si compte existe en BDD
    $sql = "SELECT * FROM membres WHERE email LIKE :login";
	$req = $DB->prepare($sql);
    $req->bindParam(':login', $login);
    $req->execute();
    $res = $req->fetchAll(PDO::FETCH_ASSOC);
	$champ = $res[0]["type"]."_id";	
	$table = $res[0]["type"]."s";
	$id = $res[0]["id"];
	$msgok = 'Utilisateur inconnu';	
	
    if (!empty($res)) { // si le user existe
		$mdpbdd = $res[0]["passwd"]; // on recup son pass en bdd 
		$chkpass = password_verify($_POST['mdp'], $mdpbdd); //et on compare avec le input
	
		if (!$chkpass) { // si mdp HS
			$msgok = 'Mauvais mot de passe !';
		}			
		
		if (($chkpass) && empty($_POST['newmdp'])) { // si mdp OK et pas de nouveau pass
			$_SESSION['_login'] = $_POST['login'];
			$_SESSION['_role'] = $res[0]["type"];
			$msgok = 'Bienvenue!';
			$action='refresh';
			$msgtit=$res[0]["type"];
		}	

		if (($chkpass) && !empty($_POST['newmdp'])) { // si mdp OK et demande nouveau pass
		$newmdp=password_hash($_POST['newmdp'], PASSWORD_DEFAULT);
			$sql = "UPDATE bg_$table set user_pwd = '$newmdp' WHERE $champ = $id";
			$req = $DB->prepare($sql);
			$req->execute();
			$msgok = 'Mot de passe modifié. Connectez-vous';
		}
	}
}// envoi des messages retour 
$feed = array('success'=>true, 'action'=>$action, 'message'=>$msgok, 'titre'=>$msgtit);		
echo json_encode($feed); 
?>
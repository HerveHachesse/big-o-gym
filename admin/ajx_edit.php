<?php
// verif sessions
session_start();
if(!isset($_SESSION['_login'])){
	header("location: form.php"); 
    die();
}
header('Content-type: application/json');
include("config.php");

// recup & traite posts
$src = $_POST['src'];
$sources = ['etat','read','perm1','perm2','perm3','perm4','perm5','perm6'];
$src =(in_array($src, $sources)) ? $src : NULL; // evitons l'injection sur cette var non bindParam-able en PDO
$id = (isset($_POST['idcli'])) ? $_POST['idcli'] : $_POST['idsal'];
$idperms = $_POST['idperms'];
$typ = (isset($_POST['idcli'])) ? "client" : "gérant";
$chk = (isset($_POST['chk']) AND ($_POST['chk']=='false') ) ? 'actif' : 'inactif';
$chkd = (isset($_POST['chk']) AND ($_POST['chk']=='false') ) ? '1' : '0';

// recup infos client / salle
$sql1 = (isset($_POST['idcli'])) ? "SELECT client_nom AS nom, client_mail AS mail FROM bg_clients WHERE client_id = :id" : "SELECT salle_nom AS nom, mail_gerant AS mail FROM bg_salles WHERE salle_id = :id";
$req = $DB->prepare($sql1);
$req->bindParam(':id', $id);
$req->execute();
$res = $req->fetch();
$nom = $res["nom"];
$mail = $res["mail"];

if($src=='etat'){// si modif etat	
	try { 
	$sql = (isset($_POST['idcli'])) ? "UPDATE bg_clients SET etat = ? WHERE client_id = ?" : "UPDATE bg_salles SET etat = ? WHERE salle_id = ?";
	$req = $DB->prepare($sql);
	$req->bindParam(1, $chk , PDO::PARAM_STR);		
	$req->bindParam(2, $id, PDO::PARAM_INT);		
	
		if ($req->execute()) { // OK ? -> envoi mail info
		
			$destinataire = $mail;
			$sujet = "API Big-O-Gym : compte désactivé" ;
			$entete = "From: info@bigogym.fr" ;
			$message = 'Bonjour,
			 
			Nous vous informons que le compte '.$nom.' a été désactivé par un administrateur BigOGym
			
			Ses permissions sur nos API sont donc suspendues.

			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.';
			//mail($destinataire, $sujet, $message, $entete) ;
			
			// alim retour ajax
			$msgtit = "Modification effectuée, ";
			$msgok = " mail envoyé au ".$typ;  
		} else { // KO
			$msgtit = "Un problème est survenu, ";
			$msgok = " erreur de requête ";  
		}		
	}
	catch(PDOException $exception){ // si erreur pdo log
		$error = $exception->getMessage();
		$msgtit = "ERREUR";
		$msgok = "Erreur BDD : ".$error; 
	} 
		
}else{ // si modif droits
		
	try{
	$sql = "UPDATE bg_droits SET $src = ? WHERE perms_id = ?";
	$req = $DB->prepare($sql);
	$req->bindParam(1, $chkd , PDO::PARAM_STR);		
	$req->bindParam(2, $idperms, PDO::PARAM_INT);
		if ($req->execute()) { // OK ? -> envoi mail info

			$destinataire = $mail;
			$sujet = "API Big-O-Gym : compte désactivé" ;
			$entete = "From: info@bigogym.fr" ;
			$message = 'Bonjour,
			 
			Nous vous informons que la permission '.$src.' de '.$nom.' a été désactivé par un administrateur BigOGym
			
			Les accès au module correspondant de notre API sont donc suspendus.

			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.';
			//mail($destinataire, $sujet, $message, $entete) ;
			
			// alim retour ajax
			$msgtit = "Modification effectuée, ";
			$msgok = " mail envoyé au ".$typ;  
		} else { // KO
			$msgtit = "Un problème est survenu, ";
			$msgok = " erreur de requête ";  
		}
	}
	catch(PDOException $exception){ 
		$error = $exception->getMessage();
		$msgtit = "ERREUR";
		$msgok = "Erreur BDD : ".$error; 
	}
}
$feed = array('success'=>true, 'action'=>'refresh', 'message'=>$msgok, 'titre'=>$msgtit);		
echo json_encode($feed);
?>
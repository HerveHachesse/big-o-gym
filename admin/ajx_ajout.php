<?php
date_default_timezone_set('Europe/Paris');
header('Content-type: application/json');

include("config.php");

// recup des posts
$salle=$_POST['salle'];
$idcli=$_POST['idcli'];
$gerant=$_POST['gerant'];
$adresse=$_POST['adresse'];
$urlogo=$_POST['url'];
$idperms=$_POST['idperms'];

$mailge=$_POST['mail'];
$mailcli=$_POST['mailcli'];

$msgok = "";
// Génération aléatoire d'une clé/mdp
$mdp=password_hash($mailge, PASSWORD_DEFAULT);

// TODO - VERIF EXIST LOGIN
//$sql = "SELECT * from bg_salles WHERE mail_gerant = $mailge";
//$req = $DB->prepare($sql);
//$req->execute();

if (!$req) {

// écriture en BDD	
	try{ 

		$tab = array(	
		':salle' => $salle,
		':idcli' => $idcli,
		':gerant' => $gerant,
		':mail' => $mailge,
		':mdp' => $mdp,
		':adresse' => $adresse,
		':url' => $urlogo,
		':etat' => 'inactif'
		);
			
		
			// nouvelle salle
			$sql = "INSERT INTO bg_salles (salle_nom, id_client, nom_gerant, mail_gerant, user_pwd, salle_adr, logo_url, etat) VALUES (:salle, :idcli, :gerant, :mail, :mdp, :adresse, :url, :etat)" ;
			$req = $DB->prepare($sql);
			$result = $req->execute($tab);
			$idsalle = $DB->lastInsertId();
			
			// clonage droits client
			$sql1 = "INSERT INTO bg_droits (perm1, perm2, perm3, perm4, perm5, perm6) SELECT perm1, perm2, perm3, perm4, perm5, perm6 FROM bg_droits WHERE perms_id LIKE :idperms" ;
			$req1 = $DB->prepare($sql1);
			$req1->bindParam(':idperms', $idperms);
			$result1 = $req1->execute();
			$newperms = $DB->lastInsertId();
			
			// ajout num salle
			$sql2 = "UPDATE bg_droits SET salle_id = :idsalle WHERE perms_id = :idperms" ;
			$req2 = $DB->prepare($sql2);
			$req2->bindParam(':idsalle', $idsalle);
			$req2->bindParam(':idperms', $newperms);
			$result2 = $req2->execute();
	
			$msgtit = "Nouvelle salle ajoutée. ";
			$msgok = " Mails envoyés au client et au gérant";
		} 
		catch(PDOException $exception){ 
		    $error = $exception->getMessage();
			$msgtit = "ERREUR";
			$msgok = $msgok."Erreur BDD : ".$error; 
		}
	 
		// mail activation gerant
		$destinataire = $mailge ;
		$sujet = "API Big-O-Gym : un nouveau compte a été ajouté." ;
		$entete = "From: info@unicod.fr" ;
		$message = 'Bonjour,
		 
		Votre structure a été ajoutée dans l\'API Big-O-Gym. Vous pourrez accèder à votre espace en vous connectant sur :
		http://www.unicod.fr/bigogym/
		
		
		Auparavant, veuillez cliquer sur le lien ci-dessous pour activer votre compte et définir votre nouveau mot de passe.
		Votre identifiant est l\'adresse mail que vous nous avez communiqué.
				 
		http://unicod.fr/bigogym/activation.php?log='.urlencode($mailge).'&mdp='.urlencode($mdp).'
		 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
		mail($destinataire, $sujet, $message, $entete) ; // envoi mail
		
		$copymail = "A : $destinataire <br> Sujet : $sujet <br><p>$message</p>";
		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/bigogym/admin/mailtemp/last_client_mail.txt","wb");
		fwrite($fp,$copymail);
		fclose($fp);
		
		// mail info client
		$destinataire = $mailcli ;
		$sujet = "API Big-O-Gym : un nouveau compte a été ajouté." ;
		$entete = "From: info@unicod.fr" ;
		$message = 'Bonjour,
		 
		Une nouvelle structure a été ajoutée dans votre espace Big-O-Gym :
		
		Nom : '.$salle.'
		Adresse: '.$adresse.'
		Gérant: '.$gerant.'
		Mail du gérant: '.$mailge.'
		
		Vos permissions par défaut ont été affectées à cette nouvelle entité.

		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
		mail($destinataire, $sujet, $message, $entete) ; // envoi mail

}else{
	$msgtit = " ERREUR ! -> ";	
	$msgok = "Cet identifiant existe déjà!";
}		
			$feed = array('success'=>true, 'action'=>'refresh', 'message'=>$msgok, 'titre'=>$msgtit);		
			echo json_encode($feed);
?>
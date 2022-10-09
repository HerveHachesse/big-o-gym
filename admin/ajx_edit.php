<?php
date_default_timezone_set('Europe/Paris');
header('Content-type: application/json');

include("config.php");

$src = ($_POST['src']);
$id = (isset($_POST['idcli'])) ? $_POST['idcli'] : $_POST['idsal'];
$typ = (isset($_POST['idcli'])) ? "client" : "gérant";
$chk = ( isset($_POST['chk']) AND ($_POST['chk']=='false') ) ? 'actif' : 'inactif';
$chkd = ( isset($_POST['chk']) AND ($_POST['chk']=='false') ) ? '1' : '0';

if($src=='etat'){
// modif etat	
		try{ 
		
		$sql = (isset($_POST['idcli'])) ? "UPDATE bg_clients SET etat = '$chk' WHERE client_id = $id" : "UPDATE bg_salles SET etat = '$chk' WHERE salle_id = $id";
		$req = $DB->prepare($sql);
		$req->execute();
		
		$msgtit = "Modification effectuée, ";
		$msgok = " mail envoyé au ".$typ; 
		//TODO envoi mail	
		}
		catch(PDOException $exception){ 
		    $error = $exception->getMessage();
			$msgtit = "ERREUR";
			$msgok = "Erreur BDD : ".$error; 
		} 

			$feed = array('success'=>true, 'action'=>'refresh', 'message'=>$msgok, 'titre'=>$msgtit);		
			echo json_encode($feed);	
		
}else{
// modif droits
		try{
		
		$sql = (isset($_POST['idcli'])) ? "UPDATE bg_droits SET $src = $chkd WHERE client_id = $id" : "UPDATE bg_droits SET $src = $chkd WHERE salle_id = $id";
		$req = $DB->prepare($sql);
		$req->execute();
		
		$msgtit = "Modification effectuée, ";
		$msgok = " mail envoyé au ".$typ; 
		//TODO envoi mail	
		}
		catch(PDOException $exception){ 
		    $error = $exception->getMessage();
			$msgtit = "ERREUR";
			$msgok = "Erreur BDD : ".$error; 
		}
		
			$feed = array('success'=>true, 'action'=>'refresh', 'message'=>$msgok, 'titre'=>$msgtit);		
			echo json_encode($feed);		

}

?>
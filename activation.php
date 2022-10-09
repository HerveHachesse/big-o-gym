<?php 
include("admin/config.php");

// récup login+mdp 
$login = $_GET['log'];
$mdp = $_GET['mdp'];
 

// récup mdp en BDD
$sql = $DB->prepare("SELECT user_pwd, etat FROM bg_salles WHERE mail_gerant like :login ");
if($sql->execute(array(':login' => $login)) && $row = $sql->fetch())
  {
    $mdpbdd = $row['user_pwd']; 
    $etat = $row['etat']; 
  }

// déjà actif ?
if($etat == 'actif')
  {
    $data = "?msg=Votre compte est déjà actif!&usr={$login}"; 

} else {
// sinon compare mdps
     if($mdp==$mdpbdd) //on compare les 2 chaines cryptees
       {
          // passe etat en actif
          $sql = $DB->prepare("UPDATE bg_salles SET etat = 'actif' WHERE mail_gerant like :login ");
          $sql->bindParam(':login', $login);
          $sql->execute();
          // si mdp + actif OK    
		 $data = "?msg=Votre compte a bien été activé! Vous devez créer un nouveau mot de passe&usr={$login}&mdpasse={$login}";
       }
     else // mdp KO
       {
         $data = "?msg=Erreur ! Votre compte ne peut être activé...";		 
       }
  }
		header("Location: admin/form.php{$data}");
		die();  
?>



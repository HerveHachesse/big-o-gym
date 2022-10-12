<?php 
// verif sessions
session_start();
if(isset($_SESSION['_login']))
{
	$lnk1='
	Vous êtes déjà connecté. <br> Revenez sur le site client: <br><br>
	<a href="../index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
	  Retour site client
	</a>';
}
if(($_SESSION['_role']=='admin')) {	
	$lnk2='
	<br>Ou sur le site admin : <br><br>
	<a href="admin.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
	  Retour site admin
	</a>';
}
// récup login+msg 
$msg = $_GET['msg'];
$user = $_GET['usr'];
$mdpasse = $_GET['mdpasse'];

?>
<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="BigOgym - Votre interface service Gym'O Matic">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BigOgym</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-pink.min.css" />
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
	<div class="mdl-layout mdl-js-layout mdl-color--grey-100">
		<main class="mdl-layout__content">
		
			<form id="form" name="form">
			
				<div class="mdl-card mdl-shadow--6dp" style="margin: 0 auto;margin-top: 10%;">
					<h6 class="msglogin"><?php echo $msg ?></h6>
					<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
						<h2 class="mdl-card__title-text">Identification</h2>
					</div>

					<div class="mdl-card__supporting-text">

						<div class="mdl-textfield mdl-js-textfield">
							<input class="mdl-textfield__input" type="text" id="login" name="login" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" value="<?php if(isset($_GET['usr'])) echo $user ?>" required />
							<label class="mdl-textfield__label" for="login">Utilisateur</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield">
							<input class="mdl-textfield__input" type="password" id="mdp" name="mdp" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" value="<?php if(isset($_GET['mdpasse'])) echo $mdpasse ?>" required/>
							<label class="mdl-textfield__label" for="mdp">Mot de passe</label>
						</div>
						
						<div id="chngpass" <?php if(!isset($_GET['mdpasse'])) echo "style='display:none'"?>>
							<div class="mdl-textfield mdl-js-textfield">
								<input class="mdl-textfield__input" type="newpassword" id="newmdp" name="newmdp" required />
								<label class="mdl-textfield__label" for="newmdp">Nouveau mot de passe</label>
							</div>
							
							<div class="mdl-textfield mdl-js-textfield">
								<input class="mdl-textfield__input" type="confpassword" id="confmdp" name="confmdp" required/>
								<label class="mdl-textfield__label" for="confmdp">Confirmer le nouveau mot de passe</label>
							</div>
						</div>
					</div>
				
					<div class="mdl-card__actions mdl-card--border">
						<button type="submit" id="recform" class="mdl-button mdl-button--colored mdl-js-button" disabled>Connexion</button>
						
					</div>
			
				</div>
			</form>			
			
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--3-col"></div>
				<div class="mdl-cell mdl-cell--3-col" style="text-align:center"><?php echo $lnk1 ?></div>
				<div class="mdl-cell mdl-cell--3-col" style="text-align:center"><?php echo $lnk2 ?></div>
				<div class="mdl-cell mdl-cell--3-col"></div>
			</div>
			
		</main>
	</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 	
<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script>
/********** listen changements form ***************/ 
$(function(){
	
		$(document).on('change','.mdl-textfield__input',function(){
			var $invalidFields = $('#form .is-invalid');
			var $emptyFields = $('#form input:required').filter(function() {		
				return $.trim(this.value) === "";
			});
				if ((!$emptyFields.length) && (!$invalidFields.length) === true) {
					$("#recform").prop('disabled', false);
					$("#recform").addClass("mdl-button--colored");					
					componentHandler.upgradeAllRegistered();
				}else{
					$("#recform").prop('disabled', true);
					$("#recform").removeClass("mdl-button--colored");
					componentHandler.upgradeAllRegistered();
				}
		});
});

function validatePassword() {
	var currentPassword, newPassword, confirmPassword, output = true;

	currentPassword = document.form.currentPassword;
	newPassword = document.form.newPassword;
	confirmPassword = document.form.confirmPassword;
	
	if (!newPassword.value) {
		newPassword.focus();
		document.getElementById("newmdp").innerHTML = "requis";
		output = false;
	}
	else if (!confirmPassword.value) {
		confirmPassword.focus();
		document.getElementById("confmdp").innerHTML = "requis";
		output = false;
	}
	if (newPassword.value != confirmPassword.value) {
		newPassword.value = "";
		confirmPassword.value = "";
		newPassword.focus();
		document.getElementById("confirmPassword").innerHTML = "Mot de passe et confirmation sont différents!";
		output = false;
	}
	return output;
}

// envoi formulaire
$(function(){
	$(document).on('click','#recform',function(e){
		e.preventDefault();
if(validatePassword){		
		var form = document.getElementById("form");
		var fd = new FormData(form);
		$.ajax({
			data: fd,
			url: "identification.php",
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json",
			type: 'POST',
			success: function(data) {
				history.pushState('', document.title, window.location.pathname);				
				var msg= data.message;
				var titr= data.titre;
					if(data.action=='refresh'){
						if(titr=='admin'){
						window.location.href='admin.php';	
						}else{
						window.location.href='../index.php';
						}	
					}
				$("#chngpass").hide();				
				$(".msglogin").html(msg);
				$("#mdp").val("");
			}
		});
		return false;
	}	
	});
});
</script>
	</body>
</html>	


<?php 
// verif sessions
session_start();
if(!isset($_SESSION['_login']))
{
	header("location: form.php");
    die();
}
if(($_SESSION['_role']!='admin')) {	
    die();
}
// includes
include("config.php");
// recup headers
$id=(isset($_GET['id'])) ? $_GET['id'] : '';
// requetes
$req1 = $DB->query('SELECT * FROM bg_clients WHERE client_id='.$id);
$req11 = $DB->query('SELECT * FROM bg_droits WHERE client_id='.$id);
?>
<!doctype html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BIGoGYM Administration</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css" />
	<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
        <header class="mdl-layout__header">


		  <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
		    <a href="admin.php" class="mdl-layout__tab">Clients</a>
		    <a href="" class="mdl-layout__tab">></a> 
		    <a href="" class="mdl-layout__tab is-active">Client</a>
		  </div>	  
			<button id="menu-top" class="mdl-button mdl-js-button mdl-button--icon">
			  <i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
				for="menu-top">
			  <li class="mdl-menu__item"><?php echo $_SESSION["_login"]?></li>
			  <li class="mdl-menu__item" onclick="window.location.href='logout.php';">Se déconnecter</li>
			</ul>

        </header>

        <main class="mdl-layout__content">
			<div class="mdl-grid">
		<?php
			while ($val = $req1->fetch(PDO::FETCH_ASSOC)) { 
					$etat=($val["etat"]=="actif") ? "checked" : "";
					$coul=($val["etat"]=="actif") ? "green" : "red";
					$nomcli=$val["client_nom"];
					$idcli=$val["client_id"];
					$mailcli=$val["client_mail"];
		 ?>
				<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--2dp">

					  <div class="mdl-card__menu refresh">
							<label id="tt1" data-src="client" data-val=<?php echo $val["client_id"]; ?> for="etat" class="mdl-switch mdl-js-switch mdl-js-ripple-effect toggle-icon-<?php echo $coul ?> modal">
							  <input type="checkbox" name="etat" id="etat" class="mdl-switch__input" <?php echo $etat ?>>
							  <span class="mdl-switch__label"></span>						  
							</label>

					  </div>	
				
					  <div class="mdl-card__title">
						<h2 class="mdl-card__title-text"><?php  echo $val["client_nom"];  ?> </h2>
						<div class="id_top">ID client: <?php  echo $val["client_id"];  ?></div>
					  </div>
					  <span class="mdl-card__subtitle-text">
					  <img src="<?php  echo $val["logo_url"];  ?>" width="100px" height="65px" style="float:left; margin:5px;">
					  <?php  echo $val["resume"]; ?>
					  </span>
					  

						  <div id="lemail" class="mdl-cell mdl-cell--8-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--4dp"></div>

					  
					  <span id="voirmail" class="mdl-chip mdl-chip--deletable">
						<span class="mdl-chip__text">Voir le mail envoyé</span>
						<button id="voir" type="button" class="mdl-chip__action"><i class="material-icons">mail</i></button>
					  </span>
						
						<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
						  <div class="mdl-tabs__tab-bar">
							  <a href="#perso" class="mdl-tabs__tab is-active">personnel</a>
							  <a href="#descrip" class="mdl-tabs__tab">détails</a>
							  <a href="#perms" class="mdl-tabs__tab">permissions</a>
						  </div>

						  <div class="mdl-tabs__panel is-active" id="perso">
							<ul>
							  <li>Directeur: <?php  echo $val["dpo"];  ?></li>
							  <li>Commercial: <?php  echo $val["comm"];  ?></li>
							  <li>Technicien: <?php  echo $val["tech"];  ?></li>
							</ul>
						  </div>
						  <div class="mdl-tabs__panel" id="descrip">
								<div class="mdl-card__supporting-text">
								<?php  echo $val["description"];  ?>
								</div>
						  </div>
						  
						<?php }
						while ($val = $req11->fetch(PDO::FETCH_ASSOC)) { 
							$idperms=$val["perms_id"];
						?>
						
						  <div class="mdl-tabs__panel" id="perms" data-val="<?php echo $val["perms_id"]; ?>">

						  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							  <tbody>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 1</td>
								  <td>
									<label id="per1" data-val=<?php echo $val["client_id"]; ?> for="perm1" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm1" class="mdl-switch__input" <?php if($val["perm1"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 2</td>
								  <td>
									<label id="per2" data-val=<?php echo $val["client_id"]; ?> for="perm2" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm2" class="mdl-switch__input" <?php if($val["perm2"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 3</td>
								  <td>
									<label id="per3" data-val=<?php echo $val["client_id"]; ?> for="perm3" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm3" class="mdl-switch__input" <?php if($val["perm3"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 4</td>
								  <td>
									<label id="per4" data-val=<?php echo $val["client_id"]; ?> for="perm4" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm4" class="mdl-switch__input" <?php if($val["perm4"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 5</td>
								  <td>
									<label id="per5" data-val=<?php echo $val["client_id"]; ?> for="perm5" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm5" class="mdl-switch__input" <?php if($val["perm5"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 6</td>
								  <td>
									<label id="per6" data-val=<?php echo $val["client_id"]; ?> for="perm6" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm6" class="mdl-switch__input" <?php if($val["perm6"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
							  </tbody>
							</table>

						  </div>
			<?php } ?>						  
						  
						</div>						

					  <div class="mdl-card__actions mdl-card--border">
						<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect shform">
						  ajouter une salle
						</a>
					  </div>

					
					<div id="formul">
						<form id="form">
						
						<button id="closeform" class="mdl-button mdl-js-button mdl-button--icon shform">
						  <i class="material-icons">close</i>
						</button>
					
						<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="salle" name="salle" value="" required />
							<label class="mdl-textfield__label" for="nom">Nom de la salle:</label>
						</div>

						<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="adresse" name="adresse" value="" required/>
							<label class="mdl-textfield__label" for="societe">Adresse de la salle:</label>
						</div>
						
						<div class="mdl-cell mdl-cell--12-col"></div>	
						<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="gerant" name="gerant" value="" required/>
							<label class="mdl-textfield__label" for="prenom">Nom & Prénom du gérant:</label>
						</div>						
						<div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield mdl-textfield--floating-label ">
							<input class="mdl-textfield__input" type="email" id="mail" name="mail" value="" required />
							<label class="mdl-textfield__label" for="mail">Adresse mail du gérant:</label>
						</div>
						
						<div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-textfield mdl-js-textfield mdl-textfield--floating-label ">
							<input class="mdl-textfield__input" type="url" id="url" name="url" value="" required />
							<label class="mdl-textfield__label" for="mail">URL du logo:</label>
						</div>

						<input type="hidden" id="idcli" name="idcli" value="<?php echo $idcli ?>"/>
						<input type="hidden" id="idperms" name="idperms" value="<?php echo $idperms ?>"/>
						<input type="hidden" id="mailcli" name="mailcli" value="<?php echo $mailcli ?>"/>
						
						<div class="mdl-card__actions mdl-card--border">
						  <button id="efface" class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect">effacer</button>
						  <button id="recform" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" disabled >enregistrer</button>				
						</div>	
						</form>
					</div>
					
				  
				
				</div>

				<div class="mdl-cell mdl-cell--12-col">			
				<button type="button" class="mdl-chip">
					<span class="mdl-chip__text">Toutes les salles <?php  echo $nomcli; ?> :</span>
				</button>
				</div>
			
			</div>	
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
						  <tbody>
			<?php
			$req2 = $DB->query('SELECT * FROM bg_salles WHERE id_client='.$id);
			while ($val = $req2->fetch(PDO::FETCH_ASSOC)) { 
					$etat=($val["etat"]=="actif") ? "on" : "off";
					$coul=($val["etat"]=="actif") ? "green" : "red";
			?>   
							<tr>
							  <td class="mdl-data-table__cell--non-numeric">
								<i id="ttp<?php echo $val["salle_id"]; ?>" class="material-icons nav" data-url="salle.php?id=<?php echo $val["salle_id"]; ?>">check_box_outline_blank</i>
								<div class="mdl-tooltip" data-mdl-for="ttp<?php echo $val["salle_id"]; ?>">voir la salle</div>
							  </td>
							  <td class="mdl-data-table__cell--non-numeric maxline"><?php  echo $val["salle_nom"];  ?></td>
							  <td><?php  echo $val["nom_gerant"];  ?></td>
							  <td><i class="material-icons toggle-icon-<?php echo $coul ?>">toggle_<?php echo $etat ?></i></td>
							</tr>
			<?php } ?>								
							
						  </tbody>
						</table>			
        </main>
<!--------------------- dialog ----------------------------->
		<dialog class="mdl-dialog">
			<h4 class="mdl-dialog__title">ATTENTION</h4>
			<div class="mdl-dialog__content">
			  <p id="message1">Vous allez <b><span class="sens"></span>activer</b> les droits <b><span id="m1-opt"></span></b> pour le client <b><?php echo $nomcli; ?></b>.<br> Confirmez-vous cette action ?</p>
			  <p id="message2">Vous allez <b><span class="sens"></span>activer</b> le client <b><?php echo $nomcli; ?></b>.<br>Confirmez-vous cette action ?</p>	  
			</div>

			<div class="mdl-dialog__actions">
			  <button type="button" id="" class="mdl-button confirm" >je confirme</button>
			  <button type="button" class="mdl-button close">annuler</button>
			</div>
		</dialog>
<!------------------ snack bar ---------------------------->
		<div class="mdl-js-snackbar mdl-snackbar">
		  <div class="mdl-snackbar__text au-centre snack-mess"></div>
		  <button class="mdl-snackbar__action" type="button"></button>
		</div>		
	</div>
	
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>	
	
	
<script>
/********** listen changements form ***************/ 
$(function(){
	
		$(document).on('change','.mdl-textfield__input',function(){
			var $invalidFields = $('#formul .is-invalid');
			var $emptyFields = $('#formul input:required').filter(function() {		
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

// modal config 
    var dialog = document.querySelector('dialog');
    var showDialogButton = document.getElementById("formvid");
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    dialog.querySelector('.close').addEventListener('click', function() {
		if(this.classList.contains("refresh")) {
			setTimeout(window.location.reload(),1000); 
		}
	     dialog.close();  
    });
	
// snackbar config 	
	var notification = document.querySelector('.mdl-js-snackbar');
	
// dialogue confirmation
$(function(){
	$(document).on('click','.modal',function(e){
		e.preventDefault();
		$('#message1').show();
		$('#message2').show();
		$('.sens').html('');
		var id=$(this).attr("data-val");
		var src=$(this).attr("for");
		var tglb = $(this).attr("id");
		$(".confirm").attr("id", id);	
		$(".confirm").attr("for", src);
		$(".confirm").attr("data-tglb", tglb);
		if ($('#'+src).is(':checked')){
			 $('.sens').html('dés');
			}
		if(src==='etat') {
			$('#message1').hide();
		}else{
			$('#message2').hide();
			$('#m1-opt').html(src);
		}
		dialog.showModal();	
	});
});

// change perms
$(function(){
	$(document).on('click','.confirm',function(e){
		e.preventDefault();
		var id =$(this).attr("id");
		var idperms=$("#perms").attr("data-val");
		var src =$(this).attr("for");
		var chk = $("#"+src).is(":checked");
		var tglb = $(this).attr("data-tglb");
		var fd = new FormData();
		fd.append("idperms", idperms);
		fd.append("idcli", id);
		fd.append("src", src);		
		fd.append("chk", chk);
		$.ajax({
			data: fd,
			url: "ajx_edit.php",
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json",
			type: 'POST',
			success: function(data) {
				dialog.close();
				if($('#'+tglb).is('.is-checked')) {
					$('#'+tglb)[0].MaterialSwitch.off();
				}
				else {
					$('#'+tglb)[0].MaterialSwitch.on();
				}
				componentHandler.upgradeAllRegistered();
				var msg1= data.message;
				var titr= data.titre;
				$('.mdl-snackbar__action').trigger('click');
				notification.MaterialSnackbar.showSnackbar(
				{ message: titr+msg1,	timeout: 5000 }
				);	
				
			}
			
		});
		return false;
	});
				
});

// affiche / masque form 
$(document).on('click','.shform', function(e){
	e.preventDefault();
	$('#formul').toggle('show');

});

// envoi formulaire ajout salle
$(function(){
	$(document).on('click','#recform',function(e){
		e.preventDefault();
		var form = document.getElementById("form");
		var fd = new FormData(form);
		$.ajax({
			data: fd,
			url: "ajx_ajout.php",
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json",
			type: 'POST',
			success: function(data) {
				$('#form').trigger("reset");
				$('#formul').toggle('show');
				$('#voirmail').show();
				componentHandler.upgradeAllRegistered();
				var msg= data.message;
				var titr= data.titre;
				$('.mdl-snackbar__action').trigger('click');
				notification.MaterialSnackbar.showSnackbar(
				{ message: titr+msg,timeout: 8000 }
				);	
				
			}
		});
		return false;
	});
});

// reset form
	$(document).on('click','#efface',function(){
		$('#form').trigger("reset");
		componentHandler.upgradeAllRegistered();		
	});
	
// nav js
$(document).on('click','.nav', function(e){
	e.preventDefault();
	var link = $(this).attr('data-url');
	window.location.href = link;
});

$(function(){
	var tgt=$('#voirmail').children().first();
	// voir mail
	$(document).on('click','#voirmail', function(e){
		e.preventDefault();
		$(this).addClass('cachemail');
		$('#lemail').load('mailtemp/last_client_mail.txt');
		$('#lemail').show();
		tgt.html('');
		tgt.html('Fermer le mail');
	});
	// fermer mail
	$(document).on('click','.cachemail', function(e){
		e.preventDefault();
		$(this).removeClass('cachemail');
		$('#lemail').html('');
		$('#lemail').hide();
		tgt.html('');
		tgt.html('Voir le mail envoyé');
	});
});
</script>

</body>
</html>


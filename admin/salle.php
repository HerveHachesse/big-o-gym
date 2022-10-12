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
// requetes
$id=(isset($_GET['id'])) ? $_GET['id'] : '0';
$req1 = $DB->query('SELECT * FROM bg_salles a, bg_droits b WHERE a.salle_id=b.salle_id AND a.salle_id='.$id);
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
		    <a href="admin.php" class="mdl-layout__tab">clients</a>
		    <a href="" class="mdl-layout__tab">></a>
		    <a href="javascript:history.back()" class="mdl-layout__tab">client</a>
		    <a href="" class="mdl-layout__tab">></a>
		    <a href="" class="mdl-layout__tab is-active">Salle</a>
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
					$nom_salle = $val["salle_nom"];
		 ?>
				<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--2dp">

					  <div class="mdl-card__title">
						<h2 class="mdl-card__title-text"><?php  echo $val["salle_nom"];  ?> </h2>
						<div class="id_top">ID salle: <?php  echo $val["salle_id"];  ?></div>
					  </div>
					  <span class="mdl-card__subtitle-text"><img src="<?php  echo $val["logo_url"];  ?>" width="100px" height="65px" style="float:left; margin:5px;"><?php  echo $val["resume"]; ?></span>

						
						<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
						  <div class="mdl-tabs__tab-bar">
							  <a href="#perso" class="mdl-tabs__tab is-active">personnel</a>
							  <a href="#perms" class="mdl-tabs__tab">permissions</a>
						  </div>

						  <div class="mdl-tabs__panel is-active" id="perso">
							<ul>
							  <li class="personnel"><i class="material-icons">person</i> <?php  echo $val["nom_gerant"];  ?></li>
							  <li class="personnel"><i class="material-icons">email</i>  <?php  echo $val["mail_gerant"];  ?></li>
							  <li class="personnel"><i class="material-icons">other_houses</i> <?php  echo $val["salle_adr"];  ?></li>
							</ul>
						  </div>

						  <div class="mdl-tabs__panel" id="perms" data-val="<?php echo $val["perms_id"]; ?>">
					
						  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							  <tbody>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 1</td>
								  <td>
									<label id="per1" data-val=<?php echo $val["salle_id"]; ?> for="perm1" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm1" class="mdl-switch__input" <?php if($val["perm1"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 2</td>
								  <td>
									<label id="per2" data-val=<?php echo $val["salle_id"]; ?> for="perm2" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm2" class="mdl-switch__input" <?php if($val["perm2"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 3</td>
								  <td>
									<label id="per3" data-val=<?php echo $val["salle_id"]; ?> for="perm3" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm3" class="mdl-switch__input" <?php if($val["perm3"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 4</td>
								  <td>
									<label id="per4" data-val=<?php echo $val["salle_id"]; ?> for="perm4" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm4" class="mdl-switch__input" <?php if($val["perm4"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 5</td>
								  <td>
									<label id="per5" data-val=<?php echo $val["salle_id"]; ?> for="perm5" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm5" class="mdl-switch__input" <?php if($val["perm5"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 6</td>
								  <td>
									<label id="per6" data-val=<?php echo $val["salle_id"]; ?> for="perm6" class="mdl-switch mdl-js-switch mdl-js-ripple-effect modal">
									  <input type="checkbox" id="perm6" class="mdl-switch__input" <?php if($val["perm6"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
							  </tbody>
							</table>

						  </div>
						</div>						
					  
					  <div class="mdl-card__actions mdl-card--border">
						<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" disabled>
						  supprimer cette salle
						</button>
					  </div>
					  <div class="mdl-card__menu">
							<label id="tt1" data-src="salle" data-val=<?php echo $val["salle_id"]; ?> for="etat" class="mdl-switch mdl-js-switch mdl-js-ripple-effect toggle-icon-<?php echo $coul ?> modal">
							  <input type="checkbox" name="etat" id="etat" class="mdl-switch__input" <?php echo $etat ?>>
							  <span class="mdl-switch__label"></span>						  
							</label>
					  </div>

				
				</div>
			<?php } ?>
	
        </main>

	</div>
	
	<dialog class="mdl-dialog">
		<h4 class="mdl-dialog__title">ATTENTION</h4>
		<div class="mdl-dialog__content">
		  <p id="message1">Vous allez <b><span class="sens"></span>activer</b> les droits <b><span id="m1-opt"></span></b> pour la salle <b><?php echo $nom_salle; ?></b>.<br> Confirmez-vous cette action ?</p>
		  <p id="message2">Vous allez <b><span class="sens"></span>activer</b> la salle <b><?php echo $nom_salle; ?></b>.<br> Confirmez-vous cette action ?</p>	  
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>	
	
<script>

// modal dialogue 
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
	var msg1, titr;
	
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

// change etat ou perms
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
		fd.append("idsal", id);
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
				console.log(tglb);
					if($('#'+tglb).is('.is-checked')) {
						$('#'+tglb)[0].MaterialSwitch.off();
					}
					else {
						$('#'+tglb)[0].MaterialSwitch.on();
					}
				componentHandler.upgradeAllRegistered();
				msg1= data.message;
				titr= data.titre;
				$('.mdl-snackbar__action').trigger('click');
				notification.MaterialSnackbar.showSnackbar(
				{ message: titr+msg1,	timeout: 3000 }
				);	
				
			}
			
		});
		return false;
	});
				
});

// navigation js
$(document).on('click','.nav', function(e){
	e.preventDefault();
	var link = $(this).attr('data-url');
	window.location.href = link;
});
</script>

</body>
</html>


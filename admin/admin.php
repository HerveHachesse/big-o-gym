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
$clause=(isset($_GET['tri']) AND ($_GET['tri']!='0')) ? 'WHERE etat="'.$_GET['tri'].'" ' : '';
$req1 = $DB->query('SELECT * FROM bg_clients '.$clause.' ORDER BY client_nom ASC');
?>
<!doctype html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Admin B-O-G">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BIGoGYM Administration</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css" />
	<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
	
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
        <header class="mdl-layout__header">


		  <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
		    <a href="admin.php" class="mdl-layout__tab is-active">Clients</a>
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
			<div class="mdl-cell mdl-cell--12-col">
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect nav" data-url="?" for="flash1">
			  <input <?php if (!isset($_GET['tri']) OR ($_GET['tri']=='0')) echo "checked" ?> class="mdl-radio__button" id="flash1" name="flash" type="radio" value="auto">
			  <span class="mdl-radio__label">Tous</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect nav" data-url="?tri=actif" for="flash2">
			  <input <?php if (isset($_GET['tri']) AND ($_GET['tri']=='actif')) echo "checked" ?> class="mdl-radio__button" id="flash2" name="flash" type="radio" value="auto">
			  <span class="mdl-radio__label">Actifs</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect nav" data-url="?tri=inactif" for="flash3">
			  <input <?php if (isset($_GET['tri']) AND ($_GET['tri']=='inactif')) echo "checked" ?> class="mdl-radio__button" id="flash3" name="flash" type="radio" value="auto">
			  <span class="mdl-radio__label">Inactifs</span>
			</label>
			</div>
		</div>	

		<table id="table1" class="display " style="width:100%; padding-right:10px; margin-top:10px;">
        <thead>
            <tr>
 				<th></th>               
				<th>Logo</th>

                <th>Client</th>
				<th>Salles</th>
                <th>Etat</th>
                <th>Voir+</th>
                <th>Technicien</th>			
                <th>Site</th>
                <th>Resumé</th>
            </tr>
        </thead>
		<tbody>
		<?php
			while ($val = $req1->fetch(PDO::FETCH_ASSOC)) { 
					$etat=($val["etat"]=="actif") ? "on" : "off";
					$coul=($val["etat"]=="actif") ? "green" : "red";
					$nbs = $DB->query('SELECT COUNT(*) FROM bg_salles WHERE id_client='.$val["client_id"])->fetchColumn();
					$nbsalles=($nbs!="") ? $nbs : "0";
		 ?>
			<tr>
			<td class="">
				<i id="tt<?php echo $val["client_id"]; ?>" class="material-icons nav" data-url="client.php?id=<?php echo $val["client_id"]; ?>">check_box_outline_blank</i>
				<div class="mdl-tooltip" data-mdl-for="tt<?php echo $val["client_id"]; ?>">voir ce client</div>
			</td>
			<td class="mdl-data-table__cell--non-numeric">
				<img class="logo-td" alt="logo-<?php  echo $val["client_nom"];  ?>" src="<?php  echo $val["logo_url"];  ?>">
			</td>
			<td class="mdl-data-table__cell--non-numeric" style="min-width: 50px;">
				<?php  echo $val["client_nom"];  ?><br>ID: <?php  echo $val["client_id"];  ?>
			</td>
			<td class="mdl-data-table__cell--non-numeric" style="padding:15px 10px 0 10px;">
			<span id="tts" class="mdl-badge" data-badge="<?php echo $nbsalles;?>"></span>
			</td>
			
			<td>
			<i class="material-icons toggle-icon-<?php echo $coul ?>">toggle_<?php echo $etat ?></i>
			</td>	
			<td data-cli="<?php  echo $val["client_id"];  ?>">
			</td>
			<td>
				<?php  echo $val["tech"];  ?>
			</td>
			<td>
				<?php  echo $val["site_url"];  ?>
			</td>
			<td>
				<?php  echo $val["resume"];  ?>
			</td>
			
			</tr>
				
	
<?php	 } ?>							
		</tbody>		
        <tfoot>
            <tr>
                <th></th>	
				<th></th>				
                <th></th>
                <th></th>
                <th></th>
                <th></th>			
                <th></th>
                <th></th>
				<th></th>
            </tr>
        </tfoot>
    </table>
		
		
		
		
		
		<div class="mdl-grid">
	
			<div class="mdl-cell mdl-cell--12-col">
			

			</div>
		</div>			
        </main>

	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>	
	
	
<script>
// init datatable
	$(document).ready( function () {
    table = $('#table1').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json',
        },
		columnDefs: 
			[{
				targets: [ 0, 1, 2, 3, 4],
				className: '',
				targets: [0, 1, 3, 5],
				orderable: false
			},
			{
				className: 'dtr-control',
				targets:   5
			} ],
        order: [[2, 'asc']],
		"lengthChange": false,
		info: false,
		responsive: {
            details: {
				type: 'column',
                target: 5,
                renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        return col.hidden ?
                            '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td>'+col.title+':'+'</td> '+
                                '<td>'+col.data+'</td>'+
                            '</tr>' :
                            '';
                    } ).join('');
 
                    return data ?
                        $('<table cellpadding="0" cellspacing="0" border="0" class="nowrap" />').append( data ) :
                        false;
                }
            }
        },

    });
});

// nav js
$(document).on('click','.nav', function(e){
	e.preventDefault();
	var link = $(this).attr('data-url');
	window.location.href = link;
});
</script>

</body>
</html>


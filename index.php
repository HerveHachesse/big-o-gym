<?php
session_start();
if(!isset($_SESSION['_login']))
{
?>
<div class="wrapper">
    <a href="admin/form.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored wrpbt" >session expirée <br> reconnectez-vous.</a>
</div>

<style>
.wrapper {
    text-align: center;
}
.wrpbt {
  position: absolute;
  margin: 0 auto;
  text-transform: uppercase;
  vertical-align:middle;
  top: 50%;
  font-size:25px;
  font-family:Arial;
  line-height: 120px;
  width:340px;
  height:250px;
  border-width:1px;
  color:#fff;
  border-color:#566963;
  font-weight:bold;
  border-top-left-radius:5px;
  border-top-right-radius:5px;
  border-bottom-left-radius:5px;
  border-bottom-right-radius:5px;
  box-shadow:inset 0px 1px 3px 0px #91b8b3;
  text-shadow:inset 0px -1px 0px #2b665e;
  background:linear-gradient(#768d87, #6c7c7c);
}

.wrpbt:hover {
  background: linear-gradient(#6c7c7c, #768d87);
}
</style>
	
<?php	
    die();
}

include("admin/config.php");
$page=(isset($_GET['page'])) ? $_GET['page'] : 'accueil';
	// prepare table tempo users
    $sql ="
	CREATE TEMPORARY TABLE membres
	SELECT 'client' AS type, a.client_id AS id, a.client_mail AS email, a.user_pwd AS passwd , b.perms_id FROM bg_clients a, bg_droits b WHERE a.client_id = b.client_id 
	UNION 
	SELECT 'salle' AS type, c.salle_id AS id, c.mail_gerant AS email, c.user_pwd AS passwd, d.perms_id FROM bg_salles c, bg_droits d WHERE c.salle_id = d.salle_id
	UNION
	SELECT 'admin' AS type, e.admin_id AS id, e.admin_mail AS email, e.user_pwd AS passwd, f.perms_id FROM bg_admins e, bg_droits f WHERE e.admin_id = f.admin_id";
	$req = $DB->prepare($sql);
    $req->execute();	
	
// recup infos en BDD
    $sql = "SELECT * FROM membres WHERE email LIKE :login";
	$req = $DB->prepare($sql);
    $req->bindParam(':login', $_SESSION['_login']);
    $req->execute();
    $res = $req->fetchAll(PDO::FETCH_ASSOC);
	$idperms = $res[0]["perms_id"];
	$iduser = $res[0]["id"];
// recup droits en BDD
    $sql = "SELECT * FROM bg_droits WHERE perms_id = :perms";
	$req1 = $DB->prepare($sql);
    $req1->bindParam(':perms', $idperms);
    $req1->execute();

if(($_SESSION['_role'])=='client')
{	
	$req2 = $DB->query('SELECT * FROM bg_clients a, bg_droits b WHERE a.client_id=b.client_id AND a.client_id='.$iduser);	
}
	
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>BIO-O-GYM</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="BIG-O-GYM">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="styles_demo.css">

  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">  
		  <img src="images/bigogym_logo.png" height="60px";/>
          <span class="mdl-layout-title"> VOTRE ESPACE</span>
          <div class="mdl-layout-spacer"></div>
		
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search">
              <label class="mdl-textfield__label" for="search">rechercher...</label>
            </div>
          </div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">A Propos</li>
            <li class="mdl-menu__item">Contact</li>
            <li class="mdl-menu__item">Informations légales</li>
          </ul>
        </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <img src="images/user.jpg" class="demo-avatar">
          <div class="demo-avatar-dropdown">
            <span><?php echo($_SESSION['_login']); ?></span>
            <div class="mdl-layout-spacer"></div>
            <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
              <i class="material-icons" role="presentation">arrow_drop_down</i>
              <span class="visuallyhidden">Comptes</span>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
              <li class="mdl-menu__item"><?php echo($_SESSION['_role']); ?></li>
              <li class="mdl-menu__item"><a href="admin/logout.php">se déconnecter</a></li>
            </ul>
          </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="?page=accueil"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Accueil</a>
          <a class="mdl-navigation__link" href="?page=infos"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">inbox</i>Infos</a>
          <a class="mdl-navigation__link" href="?page=salles"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">delete</i>Salles</a>
		  
			<?php
			while ($val = $req1->fetch(PDO::FETCH_ASSOC)) { 
			$idperms=$val["perms_id"];
			?>		  
		  <?php if($val["perm1"]==1){ ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">report</i>PERM1</a>
			<?php } if($val["perm2"]==1){ ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i>PERM2</a>
			<?php }if($val["perm3"]==1) { ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>PERM3</a>
			<?php }if($val["perm4"]==1) { ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_offer</i>PERM4</a>
			<?php } if($val["perm5"]==1){ ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">shopping_cart</i>PERM5</a>
			<?php } if($val["perm6"]==1) { ?>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>PERM6</a>
			<?php }
			} ?>
		  
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
        </nav>
      </div>
	  <?php include($page.".php");?>

    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>

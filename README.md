<img align="right" width="250" height="100" src="https://user-images.githubusercontent.com/105589603/195117884-51c482e7-115a-40ae-81a3-52a916e20ca3.png">

# Big-O-Gym
## Description
Big-O-Gym est une application PHP/ JQ / MySQL  permettant de gérer des droits d’accès aux modules d’une API  tierce. Ce programme est crée dans le cadre d’un test de formation Web  et destiné à un public d’administrateurs de site.
## Prérequis
PHP 5.5.9 ou supérieur, avec les extensions  JSON. PHP 7.2 recommandé

Base MySQL avec les droits d’administration
## Installation
Téléchargez et dézippez : https://github.com/HerveHachesse/big-o-gym/archive/refs/heads/main.zip

Si vous avez un accès à une console avec git installé, vous pouvez directement vous placer dans le dossier et taper :

git clone https://github.com/HerveHachesse/big-o-gym.git .

## Configuration
` `1- Création des tables :

Dans le .zip fourni, vous trouverez dans /admin le fichier : bg\_tables\_create.sql. Copiez ce fichier dans un emplacement local sur votre ordinateur, lancez le PHPMyAdmin de votre site et dans l’onglet IMPORTER, parcourez et choisissez votre fichier  bg\_tables\_create.sql puis cliquez sur EXECUTER. Si le script ne renvoie aucune erreur, vos tables sont prêtes à l’usage.

2- Fichier de configuration.

Vous trouverez sur votre serveur web dans le dossier /admin le fichier config.php. Editez-le avec un editeur FTP comme Filezilla pour entrer les données de connexion de votre serveur puis sauvegardez.

Vous devriez pouvoir à présent vous logger avec l’identifiant administrateur par défaut.

## Utilisation  Administrateur
**PAGE CLIENTS**

Une fois connecté Administrateur, vous accédez à la liste des clients. Elle affiche par défaut tous les clients, actifs ou non, dans un tableau paginé qui permet en outre une recherche dynamique et un tri des colonnes. Les colonnes « client » et « état » sont ordonnables via un clic sur les flèches en en-tête.

L’état du client (actif/Inactif) est représenté par un switch, vert ou grisé si inactif. Son nom, logo et nombre de salles associées sont aussi présents. Le bouton de sélection en début de colonne permet d’accéder à la fiche client. Une pagination du tableau est disponible en bas de page. Un clic sur le bouton de sélection en début de colonne permet d’accèder aux détails du client.


**PAGE CLIENT**

Elle permet d’accéder à tous les détails d’un client et d’effectuer les modifications d’état ou de permissions demandés. Les informations disponibles sont réparties dans 3 onglets : Personnel/ Détails / Permissions. Le menu est un fil d’Ariane navigable qui permet de revenir sur l’écran précédent.

On affiche ici ID, nom, résumé et logo ainsi que l’état client sous la forme d’un bouton switch. L’onglet personnel concerne les ressources humaines et contacts du client. Détails contient les informations les moins utilisées du compte : description détaillée et autres. L’onglet « permissions » va nous permettre de définir les permissions par défaut du client, permissions qui s’appliqueront a toute nouvelle structure crée sous sa responsabilité.

Le bouton « ajouter une salle » permet l’ouverture d’un court formulaire de rajout au clic. Une fois le formulaire validé, la base de donnée est mise à jour avec ces informations en conservant un état inactif. Un mail est envoyé au client pour l’informer du rajout de la structure et un autre au gérant pour validation de son compte. Ce mail contient le lien d’activation et permet au gérant de valider son inscription et de passer sa structure en état actif. Aprés la fermeture du formulaire, un bouton « voir le mail envoyé » sera disponible temporairement sur l’écran et présentera le mail envoyé.

La liste des salles associées à ce client et ses informations sont affichées en bas de page. Les états actif/inactif sont aussi repris pour chaque salle. On accède aux détails d’une salle via un clic sur le bouton sélection.

**PAGE SALLES**

Elle reprend les infos nom, id et logo et on décline le reste sur deux onglets : les informations salle et gérant, et les permissions de la salle.

Le clic sur l’état actif/inactif de la salle déclenche un modal de confirmation, une mise à jour de la base et génère l’envoi de mails informatifs. De la même manière que pour le client, les permissions sont modifiables au clic avec envois de mails et sujettes à un message informatif précis de confirmation,

Le bouton supprimer n’est pas actif.


## Vision Utilisateurs
**\* connectez-vous en tant que client ou gérant pour profiter de ces vues. \***

**PAGE ACCUEIL**

Une fois connecté Utilisateur, vous accédez à la page d’accueil  qui affiche par défaut des informations commerciales.

**PAGE INFOS**

On retrouve son état client (actif/Inactif) représenté par un switch ainsi que son nom, logo et nombre de salles associées. Les permissions courantes sont visibles mais non modifiables.

**PAGE SALLES**

On retrouve ses salles sous forme de cartes avec les les infos nom, id et logo et on décline le reste sur deux onglets : les informations salle et gérant, et les permissions de la salle.

## Terminé
Créez des clients, des salles et testez les capacités de l’appli sur différents supports… Merci pour votre lecture.

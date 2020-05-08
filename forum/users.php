<?php
//Cette page affiche la liste des utilisateurs inscrits
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Liste des utilisateurs</title>
    </head>
    <body>
	<header>
		<?php include("menus.php"); ?>
	</header>
    	<div id="titre_principal">
			<h2>FORUM DE PARTAGE DE CONNAISSANCES MEDICALES</h2>
		</div>
        <div class="content">
<?php
if(isset($_SESSION['username']))
{
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; Liste des utilisateurs
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Déconnexion</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
}
else
{
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; Liste des utilisateurs
    </div>
	<div class="box_right">
    	<a href="signup.php">Inscription</a> - <a href="login.php">Connexion</a>
    </div>
    <div class="clean"></div>
</div>
<?php
}
?>
Voici la liste des utilisateurs :
<table>
    <tr>
    	<th>Id</th>
    	<th>Nom d'utilisateur</th>
    	<th>Profession</th>
    	<th>Ville</th>
    	<th>Pays</th>
    	<th>E-mail</th>
    </tr>
<?php
//On recupere les identifiants, les pseudos et les emails des utilisateurs
$req = mysql_query('select id, username, profession, ville, pays, email from users');
while($dnn = mysql_fetch_array($req))
{
?>
	<tr>
    	<td class="center"><?php echo $dnn['id']; ?></td>
    	<td class="center"><a href="profile.php?id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td class="center"><?php echo htmlentities($dnn['profession'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td class="center"><?php echo htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td class="center"><?php echo htmlentities($dnn['pays'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td class="center"><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
<?php
}
?>
</table>
		</div>
		<?php include("copyright.php"); ?>
		<?php include("pied_de_page.php"); ?>
	</body>
</html>
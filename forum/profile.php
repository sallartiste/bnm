<?php
//Cette page permet d'afficher le profil d'un membre
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Profil d'un utilisateur</title>
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
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; <a href="users.php">Liste des utilisateurs</a> &gt; Profil d'un utilisateur
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vos messages (<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Déconnexion</a>)
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
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; <a href="users.php">Liste des utilisateurs</a> &gt; Profil d'un utilisateur
    </div>
	<div class="box_right">
    	<a href="signup.php">Inscription</a> - <a href="login.php">Connexion</a>
    </div>
    <div class="clean"></div>
</div>
<?php
}
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$dn = mysql_query('select username, profession, ville, pays, email, avatar, signup_date from users where id="'.$id.'"');
	if(mysql_num_rows($dn)>0)
	{
		$dnn = mysql_fetch_array($dn);
?>
Profil de <em>"<?php echo htmlentities($dnn['username']); ?>"</em> :
<?php
if($_SESSION['userid']==$id)
{
?>
<br /><div class="center"><a href="edit_profile.php" class="button">Modifier mon profil</a></div>
<?php
}
?>
<table style="width:500px;">
	<tr>
    	<td><?php
if($dnn['avatar']!='')
{
	echo '<img src="'.htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8').'" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
}
else
{
	echo 'Cet utilisateur n\'a pas d\'image perso.';
}
?></td>
    	<td class="left"><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
    	<strong>Profession</strong> : <?php echo htmlentities($dnn['profession'], ENT_QUOTES, 'UTF-8'); ?><br />
    	<strong>Ville</strong> : <?php echo htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8'); ?><br />
    	<strong>Pays</strong> : <?php echo htmlentities($dnn['pays'], ENT_QUOTES, 'UTF-8'); ?><br />
    	<strong>E-mail</strong> : <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
        <em>Date d'inscription : le <?php echo date('d/m/Y',$dnn['signup_date']); ?></em></td>
    </tr>
</table>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']!=$dnn['username'])
{
?>
<br /><a href="new_pm.php?recip=<?php echo urlencode($dnn['username']); ?>" class="big">Envoyer un MP à "<?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?>"</a>
<?php
}
	}
	else
	{
		echo 'Cet utilisateur n\'existe pas.';
	}
}
else
{
	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
}
?>
	</div>
		<?php include("copyright.php"); ?>
	</body>
</html>
<?php
//Cette page permet de modifer un message
include('config.php');
if(isset($_GET['id'], $_GET['id2']))
{
	$id = intval($_GET['id']);
	$id2 = intval($_GET['id2']);
if(isset($_SESSION['username']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.authorid, t2.title, t.message, t.parent, c.name from topics as t, topics as t2, categories as c where t.id="'.$id.'" and t.id2="'.$id2.'" and t2.id="'.$id.'" and t2.id2=1 and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)
{
if($_SESSION['userid']==$dn1['authorid'] or $_SESSION['username']==$admin)
{
include('bbcode_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Modifier une réponse - <?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> - Forum</title>
		<script type="text/javascript" src="functions.js"></script>
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
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Modifier une réponse
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vos messages (<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Déconnexion</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['message']) and $_POST['message']!='')
{
	if($id2==1)
	{
		if($_SESSION['username']==$admin and isset($_POST['title']) and $_POST['title']!='')
		{
			$title = $_POST['title'];
			if(get_magic_quotes_gpc())
			{
				$title = stripslashes($title);
			}
			$title = mysql_real_escape_string($dn1['title']);
		}
		else
		{
			$title = mysql_real_escape_string($dn1['title']);
		}
	}
	else
	{
		$title = '';
	}
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	$message = mysql_real_escape_string(bbcode_to_html($message));
	if(mysql_query('update topics set title="'.$title.'", message="'.$message.'" where id="'.$id.'" and id2="'.$id2.'"'))
	{
	?>
	<div class="message">Le message a bien &eacute;t&eacute; modifi&eacute;.<br />
	<a href="read_topic.php?id=<?php echo $id; ?>">Retourner au sujet</a></div>
	<?php
	}
	else
	{
		echo 'Une erreur s\'est produite lors de la modification du message.';
	}
}
else
{
?>
<form action="edit_message.php?id=<?php echo $id; ?>&id2=<?php echo $id2; ?>" method="post">
<?php
if($_SESSION['username']==$admin and $id2==1)
{
?>
	<label for="title">Titre</label><input type="text" name="title" id="title" value="<?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?>" />
<?php
}
?>
    <label for="message">Message</label><br />
    <div class="message_buttons">
        <input type="button" value="Gras" onclick="javascript:insert('[b]', '[/b]', 'message');" /><!--
        --><input type="button" value="Italique" onclick="javascript:insert('[i]', '[/i]', 'message');" /><!--
        --><input type="button" value="Souligne" onclick="javascript:insert('[u]', '[/u]', 'message');" /><!--
        --><input type="button" value="Image" onclick="javascript:insert('[img]', '[/img]', 'message');" /><!--
        --><input type="button" value="Lien" onclick="javascript:insert('[url]', '[/url]', 'message');" /><!--
        --><input type="button" value="Gauche" onclick="javascript:insert('[left]', '[/left]', 'message');" /><!--
        --><input type="button" value="Centre" onclick="javascript:insert('[center]', '[/center]', 'message');" /><!--
        --><input type="button" value="Droite" onclick="javascript:insert('[right]', '[/right]', 'message');" />
    </div>
    <textarea name="message" id="message" cols="70" rows="6"><?php echo html_to_bbcode($dn1['message']); ?></textarea><br />
    <input type="submit" value="Envoyer" />
</form>
<?php
}
?>
		<?php include("copyright.php"); ?>
	</body>
</html>
<?php
}
else
{
	echo '<h2>Vous n\'avez pas le droit de modifier ce message.</h2>';
}
}
else
{
	echo '<h2>Le message que vous désirez modifier n\'existe pas.</h2>';
}
}
else
{
?>
<h2>Vous devez être connecté pour accéder à cette page:</h2>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Nom d'utilisateur</label><input type="text" name="username" id="username" /><br />
		<label for="password">Mot de passe</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Se souvenir</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="S'inscrire" />
        </div>
    </form>
</div>
<?php
}
}
else
{
	echo '<h2>Un identifiant du message que vous désirez modifier n\'est pas défini.</h2>';
}
?>
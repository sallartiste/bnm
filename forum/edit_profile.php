<?php
//Cette page permet aux utilisateurs de modifier leur profil
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Modifier ses informations personnelles</title>
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
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; Modifier ses informations personnelles
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vos messages (<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Déconnexion</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
	if(isset($_POST['username'], $_POST['profession'], $_POST['ville'], $_POST['pays'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']))
	{
		if(get_magic_quotes_gpc())
		{
			$_POST['username'] = stripslashes($_POST['username']);
			$_POST['profession'] = stripslashes($_POST['profession']);
			$_POST['ville'] = stripslashes($_POST['ville']);
			$_POST['pays'] = stripslashes($_POST['pays']);
			$_POST['password'] = stripslashes($_POST['password']);
			$_POST['passverif'] = stripslashes($_POST['passverif']);
			$_POST['email'] = stripslashes($_POST['email']);
			$_POST['avatar'] = stripslashes($_POST['avatar']);
		}
		if($_POST['password']==$_POST['passverif'])
		{
			if(strlen($_POST['password'])>=6)
			{
				if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
				{
					$username = mysql_real_escape_string($_POST['username']);
					$profession = mysql_real_escape_string($_POST['profession']);
					$ville = mysql_real_escape_string($_POST['ville']);
					$pays = mysql_real_escape_string($_POST['pays']);
					$password = mysql_real_escape_string($_POST['password']);
					$email = mysql_real_escape_string($_POST['email']);
					$avatar = mysql_real_escape_string($_POST['avatar']);
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from users where username="'.$username.'"'));
					if($dn['nb']==0 or $_POST['username']==$_SESSION['username'])
					{
						if(mysql_query('update users set username="'.$username.'", profession="'.$profession.'", ville="'.$ville.'", pays="'.$pays.'", password="'.$password.'", email="'.$email.'", avatar="'.$avatar.'" where id="'.mysql_real_escape_string($_SESSION['userid']).'"'))
						{
							$form = false;
							unset($_SESSION['username'], $_SESSION['userid']);
?>
<div class="message">Vos informations ont bien &eacute;t&eacute; modifif&eacute;e. Vous devez vous reconnecter.<br />
<a href="login.php">Se connecter</a></div>
<?php
						}
						else
						{
							$form = true;
							$message = 'Une erreur est survenue lors des modifications.';
						}
					}
					else
					{
						$form = true;
						$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
					}
				}
				else
				{
					$form = true;
					$message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
				}
			}
			else
			{
				$form = true;
				$message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
			}
		}
		else
		{
			$form = true;
			$message = 'Les mot de passe que vous avez entr&eacute; ne sont pas identiques.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		if(isset($message))
		{
			echo '<strong>'.$message.'</strong>';
		}
		if(isset($_POST['username'],$_POST['profession'],$_POST['ville'],$_POST['pays'],$_POST['password'],$_POST['email']))
		{
			$username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			if($_POST['password']==$_POST['passverif'])
			{
				$password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
			}
			else
			{
				$password = '';
			}
			$profession = htmlentities($_POST['profession'], ENT_QUOTES, 'UTF-8');
			$ville = htmlentities($_POST['ville'], ENT_QUOTES, 'UTF-8');
			$ville = htmlentities($_POST['pays'], ENT_QUOTES, 'UTF-8');
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
			$avatar = htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			$dnn = mysql_fetch_array(mysql_query('select username,profession,ville,pays,password,email,avatar from users where username="'.$_SESSION['username'].'"'));
			$username = htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8');
			$profession = htmlentities($dnn['profession'], ENT_QUOTES, 'UTF-8');
			$ville = htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8');
			$pays = htmlentities($dnn['pays'], ENT_QUOTES, 'UTF-8');
			$password = htmlentities($dnn['password'], ENT_QUOTES, 'UTF-8');
			$email = htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8');
			$avatar = htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8');
		}
?>
    <form action="edit_profile.php" method="post">
        <p><em>Vous pouvez modifier vos informations :</em></p><br />
        <div class="center">
            <p><label for="username">Nom d'utilisateur</label><input type="text" name="username" id="username" value="<?php echo $username; ?>" /></p><br />
			<p><label for="profession">Profession</label><input type="text" name="profession" id="profession" value="<?php echo $profession; ?>" /></p><br />
			<p><label for="ville">Ville</label><input type="text" name="ville" id="ville" value="<?php echo $ville; ?>" /></p><br />
			<p><label for="pays">Pays</label><input type="text" name="pays" id="pays" value="<?php echo $pays; ?>" /></p><br />
            <p><label for="password">Mot de passe<span class="small"> (6 caract&egrave;res min.)</span></label><input type="password" name="password" id="password" value="<?php echo $password; ?>" /></p><br />
            <p><label for="passverif">Mot de passe<span class="small"> (v&eacute;rification)</span></label><input type="password" name="passverif" id="passverif" value="<?php echo $password; ?>" /></p><br />
            <p><label for="email">Email</label><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></p><br />
			<p><label for="avatar">Image perso<span class="small"> (facultatif)</span></label><input type="file" name="avatar" id="avatar" value="<?php echo $avatar; ?>" /></p><br />
            <input type="submit" value="Envoyer" />
        </div>
    </form>

<?php
	}
}
else
{
?>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.</div>
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
?>
</div>
	<?php include("copyright.php"); ?>
	<?php include("pied_de_page.php"); ?>
	</body>
</html>
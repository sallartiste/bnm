<?php
//Cette page permet aux utilisateurs de s'inscrire
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Inscription</title>
    </head>
    <body>
	<header>
		<?php include("menus.php"); ?>
	</header>
    	<div id="titre_principal">
			<h2>FORUM DE PARTAGE DE CONNAISSANCES MEDICALES</h2>
		</div>
<?php
if(isset($_POST['username'], $_POST['profession'], $_POST['ville'], $_POST['pays'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']) and $_POST['username']!='')
{
	//On enleve lechappement si get_magic_quotes_gpc est active
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
				$dn = mysql_num_rows(mysql_query('select id from users where username="'.$username.'"'));
				if($dn==0)
				{
					$dn2 = mysql_num_rows(mysql_query('select id from users'));
					$id = $dn2+1;
					//On enregistre les informations dans la base de donnee
					if(mysql_query('insert into users(id, username, profession, ville, pays, password, email, avatar, signup_date) values ('.$id.', "'.$username.'", "'.$profession.'", "'.$ville.'", "'.$pays.'", "'.$password.'", "'.$email.'", "'.$avatar.'", "'.time().'")'))
					{
						$form = false;
?>
<div class="message">Vous avez bien &eacute;t&eacute; inscrit. Vous pouvez dor&eacute;navant vous connecter.<br />
<a href="login.php">Se connecter</a></div>
<?php
					}
					else
					{
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
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
			$message = 'Le mot de passe que vous avez entr&eacute; contient moins de 6 caract&egrave;res.';
		}
	}
	else
	{
		$form = true;
		$message = 'Les mots de passe que vous avez entr&eacute; ne sont pas identiques.';
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
		echo '<div class="message">'.$message.'</div>';
	}
	//On affiche le formulaire
?>
<div class="content">
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Accueil du Forum</a> &gt; Inscription
    </div>
	<div class="box_right">
    	<a href="signup.php">Inscription</a> - <a href="login.php">Connexion</a>
    </div>
    <div class="clean"></div>
</div>
    <form action="signup.php" method="post">
        <p><em>Veuillez remplir ce formulaire pour vous inscrire :</em></p><br />
        <div class="center">
            <p><label for="username">Nom d'utilisateur</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
			<p><label for="profession">Profession</label><input type="text" name="profession" value="<?php if(isset($_POST['profession'])){echo htmlentities($_POST['profession'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
			<p><label for="ville">Ville</label><input type="text" name="ville" value="<?php if(isset($_POST['ville'])){echo htmlentities($_POST['ville'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
			<p><label for="pays">Pays</label><input type="text" name="pays" value="<?php if(isset($_POST['pays'])){echo htmlentities($_POST['pays'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
            <p><label for="password">Mot de passe<span class="small"> (6 caract&egrave;res min.)</span></label><input type="password" name="password" /></p><br />
            <p><label for="passverif">Mot de passe<span class="small"> (v&eacute;rification)</span></label><input type="password" name="passverif" /></p><br />
            <p><label for="email">E-mail</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
			<p><label for="avatar">Image perso<span class="small"> (facultatif)</span></label><input type="file" name="avatar" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /></p><br />
            <input type="submit" value="Envoyer" />
		</div>
    </form>
</div>
<?php
}
?>
</div>
		<?php include("copyright.php"); ?>
	</body>
</html>
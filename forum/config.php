<?php
/******************************************************
----------------Configuration Obligatoire--------------
Veuillez modifier les variables ci-dessous pour que le
forum puisse fonctionner correctement.
******************************************************/

//On se connecte a la base de donnee
mysql_connect('localhost', 'root', '');
mysql_select_db('bibnumed');

//Nom dutilisateur de ladministrateur
$admin='YoussefLutangu';

/******************************************************
----------------Configuration Optionelle---------------
******************************************************/

//Nom du fichier de laccueil
$url_home = 'forum.php';

//Nom du design
$design = 'default';


/******************************************************
----------------------Initialisation-------------------
******************************************************/
include('init.php');
?>
<?php
/******************************************************
----------------Configuration Obligatoire--------------
Veuillez modifier les variables ci-dessous pour que le
forum puisse fonctionner correctement.
******************************************************/

//On se connecte a la base de donnee
mysql_connect('sql24', 'vvx87971', 'OYvWb71h9V8J');
mysql_select_db('vvx87971');

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

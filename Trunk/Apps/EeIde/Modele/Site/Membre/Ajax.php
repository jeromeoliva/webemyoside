<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();


/*
 * Page et Classe Ajax
 * Page appelé par les appel Ajax
 ***/
include("../JHom/Core.php");
//include("../Core/Eemmys.php");
//Ajout de l'application
include("../Core/Config.php");
//include("../Core/PlugIn.php");
include("../Core/Application.php");
include("../Apps/CooltureInstitute/CooltureInstitute.php");

$core = new Core(true);

// Initialisation de la classe avec le core
$Class = JVar::GetPost("Class");
$Methode = JVar::GetPost("Methode");

    
$app = new CooltureInstitute($core);

//Execute la methode
$app->$Methode();


?>

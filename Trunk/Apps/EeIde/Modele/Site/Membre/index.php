<?php
/**
 * Page d'accueil du site
 */
include("../JHom/Runner.php");

//Ajout de l'application
include("../Core/Config.php");
include("../Core/PlugIn.php");
include("../Core/Application.php");
include("../Apps/CooltureInstitute/CooltureInstitute.php");


/**
 * Selection de la page
 */
if(isset($_GET["Page"]) && file_exists($_GET["Page"].".php"))
{
	include($_GET["Page"].".php");
	Runner::RunInstance($_GET["Page"]);
}
else
{
	include("home.php");
	Runner::RunInstance("home");
}
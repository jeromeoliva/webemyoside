<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Page d'accueil du site
 */
include("JHom/Runner.php");

//Ajout de l'application
include("Core/Config.php");
include("Core/PlugIn.php");
include("Core/Application.php");
include("Core/Eemmys.php");

/**
 *Deconection suppression du cookie
 * */
if(isset($_GET["action"]) && $_GET["action"]=="disconnect")
{
  setcookie(md5("WebEmyosUser"));
  $core = new Core(true);
  //redirection pour enregistrement du cookie
  $core->Redirect("index.php");
}

/**
 * Connection automatique
 * grace au cookies
 * */
if(isset($_COOKIE[md5("WebEmyosUser")]) && $_COOKIE[md5("WebEmyosUser")] != "")
{
  $core = new Core(true);
  $user = new User($core);

  $user->GetById($_COOKIE[md5("WebEmyosUser")]);

  //Connecte l'utilisateur
  JVar::Connect($user, $user->GroupeId , $core);
  //Redirige dans la bonne section
  $user->Groupe->Value->Section->Value->Directory->Value;

  $core->Redirect($user->Groupe->Value->Section->Value->Directory->Value);
}

$core = new Core(false);

//Installation du site
if($core->ConfigDb->GetKey("DATABASESERVER") == "" )
{
    include("install.php");
    Runner::RunInstance("install");
}
else if(isset($_GET["Page"]) && file_exists($_GET["Page"].".php"))
{
	include($_GET["Page"].".php");
	Runner::RunInstance($_GET["Page"]);

	//Ajoute un stat
	$core = new Core(false);
	Stat::Add($core, $_GET["Page"]);
}
else
{
    include("home.php");
    Runner::RunInstance("home");
}

?>

<?php
/**
 * Page d'accueil du site
 */
include("JHom/Runner.php");

//Ajout de l'application
include("Core/Config.php");
include("Core/PlugIn.php");
include("Core/Application.php");
include("Core/Eemmys.php");

/*
 * Apps Incluses 
 * XXXX-APPS-XXX
 */


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

?>

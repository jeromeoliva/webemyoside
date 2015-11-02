<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
 * Page et Classe Ajax
 * Page appelé par les appel Ajax
 ***/
include("JHom/Core.php");
include("Core/Eemmys.php");

//Initialisation du coeur de framework
$Core= new Core(true);
if(JVar::GetPost("Widget"))
{
	$widgetName = JVar::GetPost("Widget");
	//Inclusion des classe nescessaire
	include("Core/Config.php");
	include("Core/PlugIn.php");
	include("Core/Widget.php");
	include("Widgets/$widgetName/$widgetName.php");

	$Class = $widgetName;
}
else if(JVar::GetPost("App"))
{
	//Inclusion des classe nescessaire
	include("Core/Config.php");
	include("Core/PlugIn.php");
	include("Core/Application.php");
	include("Core/EeGame.php");

	if(JVar::GetPost("Class"))
	{
		$appName = JVar::GetPost("Class");

		if(JVar::GetPost("Folder"))
			$folder = "/".JVar::GetPost("Folder");
		else
			$folder = "";
		
		if(file_exists("Apps/".JVar::GetPost("App").$folder."/$appName.php"))
		{
			include("Apps/".JVar::GetPost("App").$folder."/$appName.php");
		}
		else
		{
			//TODO parametrer le lien dans EeDevelopper
			include($Core->GetUserDirectory()."/Files/Files/Projets/".JVar::GetPost("App")."/$appName.php");
		}
	}
	else
	{
		$appName = JVar::GetPost("App");

		if(file_exists("Apps/$appName/$appName.php"))
		{
			include("Apps/$appName/$appName.php");
		}
		else
		{
			//TODO parametrer le lien dans EeDevelopper
			include($Core->GetUserDirectory()."/Files/Files/Projets/$appName/$appName.php");
		}
	}


	$Class = $appName;
}

else
{
	$Class=JVar::GetPost("Class");
}

$Methode =JVar::GetPost("Methode");

// Initialisation de la classe avec le core
$class=new $Class($Core);

//Execute la methode
$class->$Methode();

//Affichage
//echo $class->Show();

?>

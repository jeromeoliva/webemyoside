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
include("../JHom/Core.php");
include("../Core/Eemmys.php");
include("../Core/Profil/Profil.php");
include("../Core/Profil/Developper.php");
include("../Core/Profil/Contractor.php");
include("../Core/Profil/Tester.php");
include("../Core/Profil/Worker.php");
include("../Core/Profil/All.php");

//Initialisation du coeur de framework
$Core= new Core(true);
if(JVar::GetPost("Widget"))
{
	$widgetName = JVar::GetPost("Widget");
	//Inclusion des classe nescessaire
	include("../Core/Config.php");
	include("../Core/PlugIn.php");
	include("../Core/Widget.php");
	include("../Widgets/$widgetName/$widgetName.php");

	$Class = $widgetName;
}
else if(JVar::GetPost("App"))
{
	//Inclusion des classe nescessaire
	include("../Core/Config.php");
	include("../Core/PlugIn.php");
	include("../Core/Application.php");
	include("../Core/EeGame.php");

        $appName = JVar::GetPost("App");
        
	if(JVar::GetPost("Class") && JVar::GetPost("Class") != $appName)
	{
             //Demarrage de l'appli pour les include
             if(!class_exists($appName))
                 $app = Eemmys::GetApp($appName, $Core);

               $appName = JVar::GetPost("Class");

		if(JVar::GetPost("Folder"))
			$folder = "/".JVar::GetPost("Folder");
		else
			$folder = "";

		if(file_exists("../Apps/".JVar::GetPost("App").$folder."/$appName.php"))
		{
			include("../Apps/".JVar::GetPost("App").$folder."/$appName.php");
		}
		else
		{
                    //Application dasn EeIde
                    include("../Data/Apps/EeIde/".JVar::GetPost("App")."/".$appName.".php");
                    //TODO parametrer le lien dans EeDevelopper
			//include($Core->GetUserDirectory()."/Files/Files/Projets/".JVar::GetPost("App")."/$appName.php");
		}
	}
	else
	{
		$appName = JVar::GetPost("App");

                
                if(file_exists("../Apps/$appName/$appName.php"))
		{
			include("../Apps/$appName/$appName.php");
		}
		else
		{
			include("../Data/Apps/EeIde/$appName/$appName.php");
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
$class= new $Class($Core);

//Execute la methode
$class->$Methode();

//Affichage
//echo $class->Show();

?>

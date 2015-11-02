<?php
session_start();

/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

include("../JHom/Core.php");
include("../Core/Eemmys.php");
include("../Core/Config.php");
include("../Core/PlugIn.php");
include("../Core/Application.php");
include("../Core/Profil/Profil.php");
include("../Core/Profil/Developper.php");
include("../Core/Profil/Contractor.php");
include("../Core/Profil/Tester.php");
include("../Core/Profil/Worker.php");
include("../Core/Profil/All.php");

//Demarage du coeur de framework
$Core = new Core(true);

//Demarrage de l'application$
$Eemmys = new Eemmys($Core);
$Eemmys->Start();

?>

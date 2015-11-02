<?php //header("Content-Type: text/xml;charset=utf-8");
$content = "<?xml version='1.0' encoding='utf-8'?>";
$urlBase ="http://webemyos.com";
$content .= "<urlset xmlns='http://www.google.com/schemas/sitemap/0.84'>";
$content .= "<url><loc>$urlBase/Accueil.html</loc></url>";
$content .= "<url><loc>$urlBase/Applications.html</loc></url>";
$content .= "<url><loc>$urlBase/Widgets.html</loc></url>";
$content .= "<url><loc>$urlBase/Comunitys.html</loc></url>";
$content .= "<url><loc>$urlBase/Games.html</loc></url>";
$content .= "<url><loc>$urlBase/Articles.html</loc></url>";
//Applications

include("JHom/Core.php");

$Core = new Core(false);

include("JHom/Utility/Format/Format.php");
include("JHom/Control/JHomControl/JHomControl.php");

include("JHom/Control/TextBox/TextBox.php");
include("JHom/Control/TextArea/TextArea.php");
include("JHom/Control/CheckBox/CheckBox.php");
include("JHom/Control/NumericBox/NumericBox.php");
include("JHom/Control/DateBox/DateBox.php");
include("JHom/Control/DateTimeBox/DateTimeBox.php");

include("JHom/Entity/JHomEntity/JHomEntity.php");
include("JHom/Entity/Langs/Langs.php");
include("JHom/Entity/Apps/Apps.php");
include("JHom/Entity/Widgets/Widgets.php");
include("JHom/Entity/Comunity/Comunity.php");
include("JHom/Entity/News/News.php");

$App = new Apps($Core);
$apps = $App->GetAll();
foreach($apps as $app)
{	
$content .= "<url><loc>$urlBase/Applications-".$app->Code->Value.".html</loc></url>";
}


//Gadgets
$Widget = new Widgets($Core);$widgets = $Widget->GetAll();
foreach($widgets as $widget){	
$content .= "<url><loc>$urlBase/Widgets-".$widget->Code->Value.".html</loc></url>";
}
//Communautées
$Community = new Comunity($Core);
$Communitys =  $Community->GetAll();
foreach($Communitys as $community)
{	
$content .= "<url><loc>$urlBase/Comunitys-".$community->Name->Value."-".$community->IdEntite.".html</loc></url>";}

//Jeux
$Apps = new Apps($Core);$Apps->AddArgument(new Argument("Apps","CategoryId",EQUAL, 3 ));

$Games = $Apps->GetByArg();foreach($Games as $games){	$content .= "<url><loc>$urlBase/Games-".$games->Code->Value."-".$games->IdEntite.".html</loc></url>";}

//Articles

$news = new News($Core);$news->AddArgument(new Argument("News","TypeId", EQUAL, "1"));
$News = $news->GetByArg();foreach($News as $new)
{$content .= "<url><loc>$urlBase/Articles-".$new->Code->Value."-".$new->IdEntite.".html</loc></url>";};



$content .= '</urlset>';

echo str_replace("\r\n", "", $content);
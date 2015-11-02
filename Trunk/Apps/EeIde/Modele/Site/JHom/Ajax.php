<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();
/**
 * Page et Classe Ajax
 * Page appel� par les appele Ajax
 ***/
include("../JHom/Core.php");

$Core=new Core(true);

$Class=JVar::GetPost("Class");
$Methode =JVar::GetPost("Methode");

//Instancie la classe
if(JVar::GetPost("Type"))
	$class=new $Class($Core);
else
	$class=new $Class("");

//Execute la methode
$class->$Methode();

?>

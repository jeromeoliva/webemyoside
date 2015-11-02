<?php
header("Content-type : text/javascript");
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

include('JHom/Core.php');
$Core=new Core(false);

$Include=new JHomInclude($Core->GetJDirectory().'Include.xml','.js',$Core->GetJDirectory());

?>

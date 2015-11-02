<?php
header("Content-type : text/javascript");
/*
 * 28/04/2009
 * Inclusion des fichiers javascript � utiliser
 * */

include('JHom/Core.php');
$Core=new Core(false);

$Include=new JHomInclude($Core->GetJDirectory().'Include.xml','.js',$Core->GetJDirectory());

?>

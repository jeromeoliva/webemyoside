<?php

/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

$bSuccess=true;

foreach ($_FILES as $file => $fileArray)
{
	echo("File key: $file\n");
	foreach ($fileArray as $item=>$val)
	{
		echo("  Data received: $item=>$val\n");
	}

	echo "<br/> fichier temp : ".$fileArray['tmp_name'] ." Envoi vers : " . $_GET["Directory"]."/".$fileArray['name']. "  :";


	move_uploaded_file($fileArray['tmp_name'], $_GET["Directory"]."/".$fileArray['name']);

	//Let's manipulate the received file: in this demo, we just want to remove it!
	//unlink($fileArray['tmp_name']);
	//echo("  Temp file ${fileArray['tmp_name']} removed !\n");
}
echo("\n");
//Let's say to the applet that it's a success or a failure:
if ($bSuccess)
{
	echo "SUCCESS\n";
}
 else
{
	$msgError = "Unknown error";
	echo "ERROR: $msgError\n";
}
echo "End of upload_dummy.php script\n";

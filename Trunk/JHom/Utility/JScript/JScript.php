<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class JScript
{
	function JScript()
	{
		$this->Version = "2.0.0.0";
	}

 	/**
 	 * Retourne un balise javascript
 	 * */
 	public static function GetJsBalise()
 	{
 		return "<script type='text/javascript'>!_0_!</script>";
 	}

 	/**
 	 * Insert un fichier js
 	 * */
 	public static function InsertFile($file)
 	{
		return "<script type='text/javascript' src='".$file."' ></script>";
 	}
 }

?>
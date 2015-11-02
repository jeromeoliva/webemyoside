<?php
/**09/05/2009
 * classe pour gerer les script javascript
 * 
 * 15/04/2014
 * Renomage pour suivre les nouvels conventions de codage
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
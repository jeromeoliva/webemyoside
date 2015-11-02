<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class TextBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function TextBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="text";

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
	}
}
?>
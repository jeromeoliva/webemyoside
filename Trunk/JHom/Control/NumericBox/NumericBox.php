<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class NumericBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function NumericBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="Text";
		$this->RegExp="'^[0-9]*$'";
		$this->MessageErreur="Nombre invalide";
		$this->AddAttribute("OnBlur","NumericBox.Verify(this,\"".JFormat::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")");

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
	}
}
?>
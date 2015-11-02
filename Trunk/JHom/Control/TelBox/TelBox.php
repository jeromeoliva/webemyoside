<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class TelBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function TelBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->RegExp="'\+?[ 0-9\\-]_*'";

		//$this->RegExp="'^[0-9]{8}$|^00[0-9]{11,13}$'";
		$this->MessageErreur="Telephone invalide";
		$this->AddAttribute("OnBlur","TelBox.Verify(this,\"".Format::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")");

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
	}
}
?>
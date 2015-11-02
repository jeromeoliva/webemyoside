<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class DateTimeBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function DateTimeBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->RegExp="'([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4})'";
		$this->MessageErreur="Date invalide elle doit être au format jj/mm/aaaa";
		$this->Type="text";
		$this->AddAttribute("OnBlur","DateTimeBox.Verify(this,\"".JFormat::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")");

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
	}
}
?>
<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class EmailBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function EmailBox($name)
	{
		//Version
		$this->Version ="2.0.1.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="email";
		$this->RegExp="'^([a-zA-Z0-9].+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,4})$'";
		//$this->RegExp="'^[a-z0-9-+_](\.?[a-z0-9-+_])*@[a-z0-9-+_](\.?[a-z0-9-+_])*\.[a-z]{2,4}$'i";
		$this->MessageErreur="Email invalide";
		$this->AddAttribute("onblur","EmailBox.Verify(this,\"".JFormat::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")");

		$this->AutoCapitalize = false;
    	        $this->AutoCorrect = false;
    	        $this->AutoComplete = false;
	}
}
?>
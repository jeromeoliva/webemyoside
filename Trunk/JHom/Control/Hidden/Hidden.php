<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Hidden extends JHomControl implements IJHomControl
{
	//Constructeur
	function Hidden($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="hidden";

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
	}
}
?>
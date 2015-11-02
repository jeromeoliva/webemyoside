<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Button extends JHomControl implements IJHomControl
{
	//Constructeur
	function Button($type)
	{
		//Version
		$this->Version ="2.0.0.1";
		$this->AutoCapitalize = 'None';
		$this->AutoCorrect = 'None';
		$this->CssClass = 'btn btn-primary';

		switch($type)
		{
			case "submit":
				$this->Type="submit";
			break;
			default :
				$this->Type="button";
			break;
		}
	}
}

?>
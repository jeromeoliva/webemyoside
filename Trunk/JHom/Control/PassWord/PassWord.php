<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class PassWord extends JHomControl implements IJHomControl
{
	//Constructeur
	function PassWord($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Type="password";
		$this->Name=$name;
	}
}
?>
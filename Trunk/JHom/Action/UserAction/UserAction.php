<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class UserAction extends JHomAction
{
	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		//Version
		$this->Version = "2.0.0.0";

		return "JUserAction.DoAction('".$this->Action."','".$this->Arg."',this);";
	}
}
?>
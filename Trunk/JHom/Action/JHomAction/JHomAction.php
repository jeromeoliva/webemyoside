<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class JHomAction
{
	//Propri�te
	protected $Action;
	protected $Arg;

	//Constructeur
	function JHomAction($fonction,$arg="")
	{
		//Version
		$this->Version = "2.0.0.0";

		$this->Action=$fonction;
		$this->Arg=$arg;
	}

	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		return "this.form.Action.value = '$this->Action' ; this.form.submit()";
	}
}
?>
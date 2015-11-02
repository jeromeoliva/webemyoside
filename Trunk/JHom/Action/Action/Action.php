<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Action extends JHomAction
{
	private $Classe;
	private $Methode;
	private $argument;

	//Constructeur
	function Action($class="", $methode="", $argument="")
	{
		//Version
		$this->Version = "2.0.0.1";

		$this->Classe=$class;
		$this->Methode=$methode;
		$this->Argument=$argument;
	}

	//Enregistrement de l'action � effectuer
	function DoAction()
	{
	   return $this->Classe->DoAction();
	}

	//Asseceur
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}

?>

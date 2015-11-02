<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
 * Classe de base pour les modules de page
 */

 //Classe de base pour toutes les entity
class JHomTemplate
{
	public $Version;
	protected $Core;
	protected $Form;
	protected $Entity;
	protected $Libelle;

	//Constructeur
	function JHomTemplate($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		$this->Core =$core;
	}

	//Assecceurs
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

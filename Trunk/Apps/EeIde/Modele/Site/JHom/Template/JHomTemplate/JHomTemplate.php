<?php
/*
 * 17/02/2010
 * Classe de base pour les modéles de page
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

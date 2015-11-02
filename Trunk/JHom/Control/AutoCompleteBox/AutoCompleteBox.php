<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class AutoCompleteBox extends JHomControl implements IJHomControl
{
	private $Entity;
	private $StartAt;
	private $SourceControl;
	public $Parameter;

	//Constructeur
	function AutoCompleteBox($name,$core)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->StartAt = 3;
	}

	//Affichage
	function Show()
	{
		$TextControl = "<span id='sp".$this->Id."' >";

		//Ajout de la textBox
		$TextControl .="<input type='text' id='".$this->Id."' onkeyup='AutoCompleteBox.Search(this, \"".$this->Entity."\", \"".$this->Methode."\", \"".$this->StartAt."\" , \"".$this->SourceControl."\", \"".$this->Parameter."\");' ".$this->getProperties()." />";

		$TextControl .="</span>";

		return  $TextControl;
	}

	//asseceurs
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

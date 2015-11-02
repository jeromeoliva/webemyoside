<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class ToolTip extends jhomControl
{

	private $IdEntity;
	private $Class;
	private $Methode;
	private $Url;

	//Constructeur
	function ToolTip($class="", $methode="", $idEntity="",$url="")
	{
		//Version
		$this->Version = "2.0.1.1";
		$this->Class=$class;
		$this->Methode = $methode;
		$this->IdEntity = $idEntity;
		$this->Url=$url;
	}

	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		return "var toolTip=new ToolTip(this);toolTip.url ='".$this->Url."';toolTip.data='Type=core&Class=".$this->Class."&Methode=".$this->Methode."&idEntity=".$this->IdEntity."';toolTip.Open();";
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

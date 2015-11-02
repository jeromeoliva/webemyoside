<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Image extends JHomControl implements IJHomControl
{
	//Proprietes
	private $Directory;
	private $Src;
	private $Title;
	private $Description;
	private $Alt;

	//Constructeur
	function Image($source,$description="")
	{
		//Version
		$this->Version ="2.0.0.1";

		$this->Src=$source;
		$this->Description = $description;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<img src='";

		//Definition du repertoire
		if($this->Directory != "")
			$TextControl .= $this->Directory."/"  ;

		$TextControl .= $this->Src."' " ;
		$TextControl .= $this->getProperties();
		$TextControl .=" title='".$this->Title."'";
		$TextControl .=" alt ='".$this->Alt."'";

		$TextControl .="  />";

		if($this->Description != "")
			$TextControl .= "<br/><p class='Description'>".$this->Description."</p>";

		return $TextControl ;
	}

	//Asseceurs
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
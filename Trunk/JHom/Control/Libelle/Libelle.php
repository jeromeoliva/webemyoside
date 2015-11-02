<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Libelle extends JHomControl implements IJHomControl
{
	//Constructeur
	function Libelle($text,$name="")
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Text=$text;
		$this->Name = $name;
		$this->Id= $name;
	}

	//Affichage
	function Show()
	{
		if($this->Name)
			$TextControl ="<p id=".$this->Name.">".$this->Text."<p>";
		else
			$TextControl = $this->Text;

		return $TextControl ;
	}
}
?>

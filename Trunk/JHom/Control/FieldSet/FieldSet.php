<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class FieldSet extends JHomControl implements IJHomControl
{
	//Constructeur
	function FieldSet($name , $text ="")
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Text=$text;
		$this->Name = $name;
		$this->Id = $name;
	}

	//Affichage
	function Show()
	{
		$TextControl ="<fieldSet id='".$this->Name."'>".$this->Text."</fieldSet>";

		return $TextControl ;
	}
}

?>
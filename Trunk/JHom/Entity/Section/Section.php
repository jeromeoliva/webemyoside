<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Section extends JHomEntity
{
	function Section($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_section";
		$this->Alias = "st" ;

	    //proprietes
		$this->Name = new Property("Name","Name",TEXTBOX,false,$this->Alias);
		$this->Directory = new Property("Directory","Directory",TEXTBOX,false,$this->Alias);
		//Creation de l'entit�
		$this->Create();
	}
}
?>
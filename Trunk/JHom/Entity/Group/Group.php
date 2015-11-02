<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Group extends JHomEntity
{
	protected $Section;

	//Constructeur
	function Group($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_group";
		$this->Alias = "gr";

		//proprietes
		$this->Name = new Property("Name","Name",TEXTBOX,false,$this->Alias);
		$this->SectionId = new Property("Section","SectionId",TEXTBOX,false,$this->Alias);
		$this->Section = new EntityProperty("Section","SectionId");

		//Creation de l'entit�
		$this->Create();
	}
}
?>
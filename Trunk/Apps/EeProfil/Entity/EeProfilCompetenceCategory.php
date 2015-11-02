<?php 
/* 
*Description de l'entite
*/
class EeProfilCompetenceCategory extends JHomEntity  
{
	//Constructeur
	function EeProfilCompetenceCategory($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeProfilCompetenceCategory"; 
		$this->Alias = "EeProfilCompetenceCategory"; 

		$this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>
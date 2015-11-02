<?php 
/* 
*Description de l'entite
*/
class EeProfilCompetence extends JHomEntity  
{
	//Constructeur
	function EeProfilCompetence($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeProfilCompetence"; 
		$this->Alias = "EeProfilCompetence"; 

		$this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
		$this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>
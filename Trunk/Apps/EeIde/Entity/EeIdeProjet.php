<?php 
/* 
* Projet
*/
class EeIdeProjet extends JHomEntity  
{
	//Constructeur
	function EeIdeProjet($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="eeideprojet"; 
		$this->Alias = "eeideprojet"; 

		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 

                //Ajoute les propriétés de partage entre application
                $this->AddSharedProperty();
                
		//Creation de l entité 
		$this->Create(); 
	}
}
?>
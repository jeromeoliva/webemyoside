<?php 
/* 
*Description de l'entite
*/
class EeAppCategory extends JHomEntity  
{
	//Constructeur
	function EeAppCategory($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeAppCategory"; 
		$this->Alias = "EeAppCategory"; 

		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>
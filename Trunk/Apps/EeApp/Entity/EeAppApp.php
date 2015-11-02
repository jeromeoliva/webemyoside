<?php 
/* 
*Description de l'entite
*/
class EeAppApp extends JHomEntity  
{
        protected $Category;
        
	//Constructeur
	function EeAppApp($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeAppApp"; 
		$this->Alias = "EeAppApp"; 

		$this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
		$this->Category = new EntityProperty("EeAppCategory", "CategoryId");
                        
                $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

                $this->Actif = new Property("Actif", "Actif", TEXTBOX,  true, $this->Alias); 
		
		//Partage entre application 
		$this->AddSharedProperty();

		//Creation de l entité 
		$this->Create(); 
	}
}
?>
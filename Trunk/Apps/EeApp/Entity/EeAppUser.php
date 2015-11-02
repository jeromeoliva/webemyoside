<?php 
/* 
*Description de l'entite
*/
class EeAppUser extends JHomEntity  
{
        protected $App;
        
	//Constructeur
	function EeAppUser($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeAppUser"; 
		$this->Alias = "EeAppUser"; 

		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
		$this->AppId = new Property("AppId", "AppId", NUMERICBOX,  true, $this->Alias); 
                $this->App = new EntityProperty("EeAppApp", "AppId");    
                
		//Creation de l entité 
		$this->Create(); 
	}
}
?>
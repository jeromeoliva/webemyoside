<?php 
/* 
*Description de l'entite
*/
class EeProfilCompetenceEntity extends JHomEntity  
{
        //Entity Property
        protected $User;
        protected $Competence;
        
	//Constructeur
	function EeProfilCompetenceEntity($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeProfilCompetenceEntity"; 
		$this->Alias = "EeProfilCompetenceEntity"; 

		$this->CompetenceId = new Property("CompetenceId", "CompetenceId", NUMERICBOX,  true, $this->Alias); 
                $this->Competence = new EntityProperty("EeProfilCompetence", "CompetenceId"); 
              
                $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
                $this->User = new EntityProperty("User", "UserId"); 
                
		//Partage entre application 
		$this->AddSharedProperty();

		//Creation de l entité 
		$this->Create(); 
	}
}
?>
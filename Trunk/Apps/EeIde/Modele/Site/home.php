 <?php
/**
 * Page d'accueil de webemyos
 *
 * */
 class home
 {
	function home()
	{
		//Version
 		$this->Version = "2.1.0.0";

		//Initialisation du coeur
		$this->Core=new Core(true);
                
                //Initialisation de la masterPage
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");

                // Ajout du titre
		$this->Core->Page->Title = $this->Core->GetCode("home");

		//Ajout de la description
		$this->Core->Page->Masterpage->AddBlockTemplate("!Description", "Premiére plateforme de mise en relation d'experts comptable");

		// Ajout du template
		$this->Core->Page->Template = "Template/home.tpl";
		
                //Instantaion de l'application
                /*
                XXXX-APPS-XXX
                 * */
       }
	
	function CreatePage()
	{
	}
 }

?>

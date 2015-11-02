 <?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
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

		//Données pour le référencement de la page
                $this->Core->Page->Masterpage->AddBlockTemplate("!Title",  "Webemyos Developper");
                $this->Core->Page->Masterpage->AddBlockTemplate("!Description", "Plateforme de développement application Webemyos");
                $this->Core->Page->Masterpage->AddBlockTemplate("!KeyWord", "");
                  
                // Ajout du template
		$this->Core->Page->Template = "Template/home.tpl";
       
                //Traduit les textes mulitlangue
                $this->SetDataText();
               
	}
	
        /**
         * Traduit les DataTexte
         */
        function SetDataText()
        {
        
        }
        
        
	function CreatePage()
	{
	}
 }

?>

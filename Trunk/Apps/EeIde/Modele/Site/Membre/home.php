<?php
/**
 * Page d'accueil
 *
 * */
 class home
 {
	function home()
	{
		//Initialisation du coeur
		$this->Core=new Core(true);

	    //Initialisation de la masterPAge
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");

		// Ajout du titre
		$this->Core->Page->Title = $this->Core->GetCode("home");

		// Ajout du template
		$this->Core->Page->Template = "../JHom/Template/Pages/homeMember.tpl";

                //Instantaion de l'application
                $app = new CooltureInstitute($this->Core);
                
		// Texte d'accueil
		$this->Core->Page->AddBlockTemplate("!desktop",$app->LoadFirstDesktop());
	}

	function CreatePage()
	{
	}
 }

?>

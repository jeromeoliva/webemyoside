<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class app
 {
	function app()
	{
		//Version
 		$this->Version = "2.1.0.0";

		//Initialisation du coeur
		$this->Core=new Core(true);

	    //Initialisation de la masterPage
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");
		
		// Ajout du template
		$this->Core->Page->Template = "Template/apps.tpl";
		
		$appName = JVar::Get('app');
		$idEntite = JVar::Get('Id');
		
		if(file_exists("Apps/" .$appName ."/".$appName.".php"))
		{
		  // Ajout du titre
			$this->Core->Page->Title = $this->Core->GetCode("App")." " .$appName ;
		
			//Recuperation de l'application
			$app = new $appName($this->Core);
			$app->IdEntity = JVar::Get("Id");	
		
			$this->Core->Page->Masterpage->AddBlockTemplate("!spTitle", $appName);
			$TextControl = $app->Display();
			
      $this->Core->Page->Masterpage->AddBlockTemplate("!dvDetail", $TextControl);
	
      $this->Core->Page->Masterpage->AddBlockTemplate("!Title", "Webemyos");
	
  	}
		else
		{
			$this->Core->Page->Masterpage->AddBlockTemplate("!dvDetail", "Cette application n'existe pas");
		}
	}
	
	function CreatePage()
	{
	}
 }

?>

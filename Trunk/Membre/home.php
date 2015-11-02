<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

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
		$this->Core->Page->Template = "../JHom/Template/Pages/homeMembre.tpl";

		// Texte d'accueil
		$this->Core->Page->AddBlockTemplate("!txtWelcome",$this->Core->GetCode("Welcome"));

		$DataText = new DataText($this->Core);
		$DataText->GetByCode("PageAccueil");
		$this->Core->Page->AddBlockTemplate("!txtPageHome",$DataText->Text->Value);

		//Video de présentation
		$vid = new Image("Images/Accueil.png");
		$vid->AddStyle("width","350px");
		$this->Core->Page->AddBlockTemplate("!vidPageHome","");

		//Publication
		$this->Core->Page->AddBlockTemplate("!txtMyNews",$this->Core->GetCode("MyNews"));

		$PublicationBlock = new PublicationBlock($this->Core);
		$PublicationBlock->RefreshControlId = "newsStatut";

		$this->Core->Page->AddBlockTemplate("!publicationBlock", $PublicationBlock->Show() );

		//Filtre
		$this->Core->Page->AddBlockTemplate("!txtFiltreNews",$this->Core->GetCode("FilterBy"));

		//Bouton tous
		$btnFilterAll =  new Button(BUTTON);
		$btnFilterAll->Value = $this->Core->GetCode("All");
		$btnFilterAll->CssClass = "button";
		$action = new AjaxAction("NewsBlock","LoadAll");
		$action->ChangedControl = "newsStatut";
		$btnFilterAll->OnClick = $action->DoAction();
		$this->Core->Page->AddBlockTemplate("!btnFilterAll",$btnFilterAll->Show());

			//Bouton mon profils
		$btnFilterProfil =  new Button(BUTTON);
		$btnFilterProfil->Value = $this->Core->GetCode("Profil");
		$btnFilterProfil->CssClass = "button";
		$action = new AjaxAction("NewsBlock","LoadProfil");
		$action->ChangedControl = "newsStatut";
		$btnFilterProfil->OnClick = $action->DoAction();
		$this->Core->Page->AddBlockTemplate("!btnFilterProfil",$btnFilterProfil->Show());

		//Bouton Amis
		$btnFriend =  new Button(BUTTON);
		$btnFriend->Value = $this->Core->GetCode("Friends");
		$action = new AjaxAction("NewsBlock","LoadFriend");
		$btnFriend->CssClass = "button";
		$action->ChangedControl = "newsStatut";
		$btnFriend->OnClick = $action->DoAction();
		$this->Core->Page->AddBlockTemplate("!btnFilterFriend",$btnFriend->Show());

		//Bouton de contact
		$btnContact =  new Button(BUTTON);
		$btnContact->Value = $this->Core->GetCode("Contact");
		$btnContact->CssClass = "button";
		$action = new AjaxAction("NewsBlock","LoadContact");
		$action->ChangedControl = "newsStatut";
		$btnContact->OnClick = $action->DoAction();
		$this->Core->Page->AddBlockTemplate("!btnFilterContact",$btnContact->Show());

		//Bouton de geomixer
		$btnGeomixer =  new Button(BUTTON);
		$btnGeomixer->Value = $this->Core->GetCode("Geomixer");
		$btnGeomixer->CssClass = "button";
		$action = new AjaxAction("NewsBlock","LoadGeomixer");
		$action->ChangedControl = "newsStatut";
		$btnGeomixer->OnClick = $action->DoAction();
		$this->Core->Page->AddBlockTemplate("!btnFilterGeomixer",$btnGeomixer->Show());

		//Bouton de question
		$btnQuestion =  new Button(BUTTON);
		$btnQuestion->Value = $this->Core->GetCode("Question");
		$btnQuestion->CssClass = "button";
		$action = new AjaxAction("NewsBlock","LoadGeomixer");
		$action->ChangedControl = "newsStatut";
		$btnQuestion->OnClick = $action->DoAction();
		//TODO
		//$this->Core->Page->AddBlockTemplate("!btnFilterQuestion",$btnQuestion->Show());
		$this->Core->Page->AddBlockTemplate("!btnFilterQuestion","");

		//Bouton de requetes
		$btnRequest =  new Button(BUTTON);
		$btnRequest->Value = $this->Core->GetCode("Request");
		$btnRequest->CssClass = "button";
		$btnRequest->AddStyle("border-right","none");
		$action = new AjaxAction("NewsBlock","LoadGeomixer");
		$action->ChangedControl = "newsStatut";
		$btnRequest->OnClick = $action->DoAction();
		//TODO
		//$this->Core->Page->AddBlockTemplate("!btnFilterRequest",$btnRequest->Show());
		$this->Core->Page->AddBlockTemplate("!btnFilterRequest","");


		//Module des news
		$NewsBlock = new NewsBlock($this->Core, "newsStatut");
		$NewsBlock->Load($this->Core->User->IdEntite , ALL);

		$this->Core->Page->AddBlockTemplate("!newsBlock",$NewsBlock->Show());

	}

	function CreatePage()
	{
	}
 }

?>

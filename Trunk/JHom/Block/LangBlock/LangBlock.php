<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class LangBlock extends JHomBlock implements IJHomBlock
 {
 	//Propriete


	//Constructeur
	function LangBlock($core="")
	{
		//Version
 		$this->Version = "2.0.0.0";

		$this->Core=$core;
	    //Fomulaire de saisie
	    $this->Form = new FormBlock("Lang","",POST,PAGE);
		$this->Form->Frame=false;

		//Francais
		$this->imgFr=new Image("Images/Flags/fr.png");
		$this->imgFr->Title="Francais";
		$this->imgFr->OnClick = new UserAction("ChangeLangFR");

		//Anglais
		$this->imgGb=new Image("Images/Flags/Gb.png");
		$this->imgGb->Title="Anglais";
		$this->imgGb->OnClick = new UserAction("ChangeLangEn");

	}

	//Initialisation
	function Init()
	{
		$this->Frame=false;
	}

	//Change la langue
	function ChangeLangFr()
	{
		$this->Core->SetLang("Fr");
	}

	function ChangeLangEn()
	{
		$this->Core->SetLang("En");
	}

	function ChangeLangIt()
	{
		$this->Core->SetLang("It");
	}
	//Insertion des controls
	function Create()
	{
		$this->Form->Add($this->imgFr);
		$this->Form->Add($this->imgGb);
		$this->Body =$this->Form->Show();
	}

	//Affichage
	function Show()
	{
		$this->LoadControl();
		$this->CallMethod();
		$this->Init();
		$this->Create();
		return parent::Show();
	}
 }
?>

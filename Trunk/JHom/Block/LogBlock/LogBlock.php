<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class LogBlock extends JHomBlock implements IJHomBlock
{
	//Propriete


	//Constructeur
	function LogBlock()
	{
		//Version
 		$this->Version = "2.0.0.0";

		//Fomulaire de saisie
	    $this->Form = new FormBlock("Pass","",POST,PAGE);
		$this->Form->Frame=false;

		//Initialisation de la popup
		$LogView  = new PopUp("LogViewer","Show","");
		$LogView->Name="LogCore";
		$LogView->Title="Log des informations du Core";
		$LogView->Width="300px";
		$LogView->Height="400px";
		$LogView->Left="10px";

		//Ajout des arguments
		$LogView->AddArgument("Type","Core");

		//Image
		$this->imgCore=new Image("Images/Core.gif");
		$this->imgCore->Title="Core";
		$this->imgCore->OnClick = $LogView->DoAction();

		$LogView->Name="LogDb";
		$LogView->Title="Log des informations de la base de donn�e";
      	$LogView->AddArgument("Type","Db");
		$this->imgDb=new Image("Images/Db.gif");
		$this->imgDb->Title="Base de donn�e";
		$this->imgDb->OnClick = $LogView->DoAction();

		$LogView->Name="LogEn";
		$LogView->Title="Log des informations des entit�s";
      	$LogView->AddArgument("Type","En");
		$this->imgEn=new Image("Images/En.gif");
		$this->imgEn->Title="Entity";
		$this->imgEn->OnClick = $LogView->DoAction();

		$this->imgDelete=new Image("Images/delete.png");
		$this->imgDelete->Title="Suppression des fichiers";
		$this->imgDelete->OnClick = new UserAction("Delete");
	}

	//Initialisation
	function Init()
	{
		$this->Frame=false;
	}

	//Insertion des controls
	function Create()
	{
		$this->Form->Add($this->imgCore);
		$this->Form->Add($this->imgDb);
		$this->Form->Add($this->imgEn);
		$this->Form->Add($this->imgDelete);

		$this->Body =$this->Form->Show();
	}

	//Supression des fichiers
	function Delete()
	{
		JHomLog::Delete();
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

	//Asseceur
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}

//Classe d'affichage des messages de log
class LogViewer
{
	//Constructeur
	function LogViewer()
	{

	}

	function Show()
	{
		$type=JVar::GetPost("Type");
		echo $type;
		echo JHomLog::GetLog($type);
	}
}

?>
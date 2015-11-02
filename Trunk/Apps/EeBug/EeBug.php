<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
 * Application de gestion de bug
 **/
class EeBug extends Application
{
	/**
	 * Constructeur
	 * */
	 function EeBug($core)
	 {
	 	parent::__construct($core, "EeComunity");
	 	$this->Core = $core;

	 	//if(!class_exists("ComunityCategoryBlock"))
		//	include("ComunityCategoryBlock.php");
	 }

	/*
	 * Affiche une popup de report de bug
	 * */
	function ReportBug()
	{
		$jbBug = new JBlock($this->Core, "jbBug");
		$jbBug->Table = true;
		$jbBug->Frame = false;

		$tbTitre = new TextBox("tbTitre");
		$tbTitre->Value = JVar::GetPost('AppWidget');
		$tbTitre->AddStyle("width","300px");
		$tbTitre->Libelle =  $this->Core->GetCode("BugOn");
		$tbTitre->Enabled = false;
		$jbBug->AddNew($tbTitre);

		$tbCommentaire = new TextArea("tbCommentaire");
		$tbCommentaire->AddStyle("width", "350px");
		$tbCommentaire->AddStyle("height", "200px");

		$jbBug->AddNew($tbCommentaire,2);

		//Action
		$action = New AjaxAction("EeBug", "SaveBug");
		$action->AddArgument("App", "EeBug");
		$action->ChangedControl  = "jbBug";
		$action->AddControl($tbTitre->Id);
		$action->AddControl($tbCommentaire->Id);

		//Bouton
		$btnSave = new Button(BUTTON);
		$btnSave->Value = $this->Core->GetCode("Save");
		$btnSave->CssClass = "btn btn-success";
		$btnSave->OnClick = $action;
		$jbBug->AddNew($btnSave, 2, ALIGNRIGHT);
		echo $jbBug->Show();
	}

	/**
	 * Enregistre le bug
	 * */
	function SaveBug()
	{
		//Enregistrement
		$bug = new Bug($this->Core);
		$bug->AppWidget->Value = JVar::GetPost("tbTitre");
		$bug->Commentaire->Value = JVar::GetPost("tbCommentaire");

		$bug->State->Value = 'new';
		//Recuperation du navigateur
		$browser = $_SERVER['HTTP_USER_AGENT'];

		$bug->Navigateur->Value = $browser;
		$bug->Save();

		echo "<span class='FormUserValid'>".$this->Core->GetCode("SaveBugOk")."</span>";
	}
        
        /**
         * Charge les catégorie du budget selon le type 
         * Recettes ou dépenses
         */
        function LoadCategoryChild()
        {
            
        }
}
?>
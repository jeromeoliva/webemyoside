<?php

/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Page de contact
 *
 * */
 class actions
 {
	function actions()
	{
		//Version
 		$this->Version = "2.1.0.0";

		//Initialisation du coeur
		$this->Core=new Core(true);

	    //Initialisation de la masterPAge
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");

		//Ajout du titre
		$this->Core->Page->Title = $this->Core->GetCode("Actions");

		//Ajout de la description
		$this->Core->Page->Masterpage->AddBlockTemplate("!spTitle", "Reinitialisation du mot de passe");

		// Ajout du template
		$this->Core->Page->Template = "JHom/Template/Pages/standard.tpl";

		//Module de contact
		//$TextControl = "<input type='hidden' value='base64_decode(JVar::Get("u"))."</input>";
		$TextControl = "<div class='block'>";
		$TextControl .= "<h2>".$this->Core->GetCode("NewPassword")."</h2>";

		$TextControl .= "<table>";

		$tbNewPassWord = new PassWord('tbNewPassWord');
		$TextControl .= "<tr><td>".$this->Core->GetCode("Password")."</td><td>".$tbNewPassWord->Show()."</td></tr>";

		$tbConfirmPassWord = new PassWord('tbConfirmPassWord');
		$TextControl .= "<tr><td>".$this->Core->GetCode("ConfirmPassWord")."</td><td>".$tbConfirmPassWord->Show()."</td></tr>";

		//boutton de sauvegarde
		$btnSave = new button(BUTTON);
		$btnSave->CssClass = "art-button";
		$btnSave->Value = $this->Core->GetCode("Save");
		$btnSave->OnClick = "PassBlock.SaveNewPassWord('".JVar::Get('u')."');";

		$TextControl .= "<tr><td colspan='2' style='text-align:right'>".$btnSave->Show()."</td></tr>";
		$TextControl .= "</table></div>";

		$this->Core->Page->AddBlockTemplate("!BlockLeft",'');
		$this->Core->Page->AddBlockTemplate("!content",$TextControl);

		$this->Core->Page->AddBlockTemplate("!dvRight",'');
		$this->Core->Page->AddBlockTemplate("!dvLeft",'');
	}

	function CreatePage()
	{
	}
 }
?>

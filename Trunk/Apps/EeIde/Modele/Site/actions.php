<?php
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

		
		// Ajout du template
		$this->Core->Page->Template = "JHom/Template/Pages/standard.tpl";

               switch(JVar::Get("a"))
                {
                    //Validation de l'user
                    case "valide" : 
                    
                    //Recuperation de l'id
                    $id = JVar::Get("i");
                    $id = str_replace("xa", "", $id);    
                    $id = str_replace("ty", "", $id);    
                    $id = $id / 99;   
                    
                    //Recuperation de l'utilisateur
                    $user = new User($this->Core);
                    $user->GetById($id);
                    $user->Valide->Value = 1;
                    $user->Save();
                    
                    //Ajout de la description
                    $this->Core->Page->Masterpage->AddBlockTemplate("!spTitle", "Validation de votre compte");
    
                    $TextControl = "<h2>Votre compte est validé vous pouvez dès à présent vous connecter</h2>";
                    $this->Core->Page->AddBlockTemplate("!dvDetail",$TextControl);
                        
                        break;
                    
                    case "reset": 
                    
                        $this->Core->Page->Masterpage->AddBlockTemplate("!spTitle", "Saisis un nouveau mot de passe");
    
                        $TextControl = "<div  id='dvNewMdp' >";
    
                        $tbNewPassWord = new PassWord('tbNewPassWord');
                        $tbNewPassWord->PlaceHolder = "Nouveau mot de passe";
                        $tbNewPassWord->CssClass = "small";
                        $TextControl .= $tbNewPassWord->Show();

                        $tbConfirmPassWord = new PassWord('tbConfirmPassWord');
                        $tbConfirmPassWord->PlaceHolder = "Confirmation";
                        $TextControl .= "<br/>". $tbConfirmPassWord->Show();
                        
                        //boutton de sauvegarde
                        $btnSave = new button(BUTTON);
                        $btnSave->CssClass = "button small";
                        $btnSave->Value = "Enregistrer";
                        $btnSave->OnClick = "PassBlock.SaveNewPassWord('".JVar::Get('i')."');";

                        $TextControl .= "<br/>".$btnSave->Show();
                        $TextControl .= "</div>";

                        $this->Core->Page->AddBlockTemplate("!dvDetail",$TextControl);
                        break;
                    
                    
                
		//Module de contact
		//$TextControl = "<input type='hidden' value='base64_decode(JVar::Get("u"))."</input>";
	/*	

		$this->Core->Page->AddBlockTemplate("!dvRight",'');
		$this->Core->Page->AddBlockTemplate("!dvLeft",'');*/
                }
	}

	function CreatePage()
	{
	}
 }
?>

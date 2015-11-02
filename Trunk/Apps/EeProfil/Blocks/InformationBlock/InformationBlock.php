<?php
/**
 * Module de gestion des informations
 * */
 class InformationBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function InformationBlock($core="")
	  {
		$this->Core = $core;
	  }

	  /**
	   * Creation
	   */
	  function Create()
	  {
	  }

	  /**
	   * Initialisation
	   */
	  function Init()
	  {
	  }

	  /**
	   * Affichage du module
	   */
	  function Show($all=true)
	  {
	  }
 
         /*
         * Charge les informations du profil
         */
         function Load($showTemplate)
         {
             if($showTemplate)
             {
                $this->SetTemplate(EeProfil::$Directory . "/Blocks/InformationBlock/Load.tpl");

                $this->AddParameters(array('!detail' => $this->GetInformation() ));

                return $this->Render();
             }
             else
             {
                 return $this->GetInformation();
             }
         }
         
         /**
          * Affiche les champs des informations
          */
         function GetInformation()
         {
             //Module d'info
             $jbInfo = new JBlock($this->Core, "jbInfo");
             $jbInfo->Frame =false;
             $jbInfo->Table  = true;
             
             //info de l'utilisateur
             $jbInfo->AddNew($this->Core->User->FirstName);
             $jbInfo->AddNew($this->Core->User->Name);
             
             //Ville
	     $tbCity = new AutoCompleteBox("tbCity",$this->Core);
	     $tbCity->Libelle = $this->Core->GetCode("City");
	     $tbCity->Entity = "City";
	     $tbCity->Methode = "SearchCity";
	     $tbCity->Value = $this->Core->User->City->Value->Name->Value;
	     $tbCity->AutoComplete = false;
	     $tbCity->AddStyle("width","180px");
             $jbInfo->AddNew($tbCity);
             
             //Sauvegarde
             $action = new AjaxAction("EeProfil", "SaveInformation");
             $action->AddArgument("App", "EeProfil");
             $action->ChangedControl = "jbInfo";
             $action->AddControl($this->Core->User->FirstName->Control->Id);
             $action->AddControl($this->Core->User->Name->Control->Id);
             $action->AddControl("tbCity");
	     
             //Bouton de sauvegarde
             $btnSave = new Button(BUTTON); 
             $btnSave->CssClass = "btn btn-primary";
             $btnSave->Value = $this->Core->GetCode("Save");
             $btnSave->OnClick = $action;
                     
             $jbInfo->AddNew($btnSave, 2, ALIGNRIGHT); 
         
             //Separation
             $jbInfo->AddNew(new Libelle("<div class='separation'></div>" ), 2);
         
             //Image du profil
             $jbInfo->AddNew($this->GetImage($this->Core->User->IdEntite, true));
             
             //Ajout de la photo de profil
             $uploadAjax = new UploadAjaxFile("EeProfil", $this->Core->User->IdEntite, "EeProfilAction.LoadInformation()", "SaveImageProfil");
             $jbInfo->AddNew($uploadAjax, 2);
                
             return $jbInfo->Show();
         }
         
         /**
          * Récupere l'image d'un profil
          * @param type $userId
          * @param type $mini
          */
         function GetImage($userId, $mini)
         {
                //Repertoire des données
                if(EeProfil::InFront())
                {
                   $directory = "Data/Apps/EeProfil/";
                }
                else
                {
                   $directory = "../Data/Apps/EeProfil/";
                }
             
                if(file_exists($directory."/".$userId.".jpg"))
                {
                    if($mini)
                    {
                       $file = $directory."/".$userId."_96.jpg?rand=".rand(1, 1000);
                    }
                    else
                    {
                       $file = $directory."/".$userId.".jpg?rand=".rand(1, 1000);
                    }
                }
                else
                {
                  $file =   "Images/noprofil.png";
                }
                $img = new Image($file);
        //        $img->Title = $this->Core->User->GetPseudo();
                
                return $img;
         }
}?>
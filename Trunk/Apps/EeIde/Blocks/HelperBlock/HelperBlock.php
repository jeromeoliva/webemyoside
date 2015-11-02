<?php
/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */
class HelperBlock extends JHomBlock implements IJhomBlock
{
	function HelperBlock($core)
	{
            $this->Core = $core;
	}
	
	/*
	* Crée le module
	*/	
	function Create()
	{
	}

	/*
	* Initialise
	*/
	function Init()
	{
	}
	
	/*
	* Affiche le module
	*/
	function Show()
        {}
        
        /**
         * Permet d'ajouter un helper
         */
        function ShowAddHelper()
        {
            $jbHelper = new JBlock($this->Core, "jbHelper") ;
           
           //Nom
           $tbName = new TextBox("tbNameHelper");
           $tbName->PlaceHolder = $this->Core->GetCode("Name");
           $jbHelper->AddNew($tbName);
           
           //Action
           $action = new AjaxAction("EeIde","AddHelper");
           $action->AddArgument("App", "EeIde");
           $action->AddArgument("Projet", JVar::GetPost("Projet"));
           $action->ChangedControl = "jbHelper";
           $action->AddControl($tbName->Id);
           
           //Bouton de sauvegarde
           $btnCreate = new Button(BUTTON);
           $btnCreate->CssClass = "btn btn-primary";
           $btnCreate->Value = $this->Core->GetCode("Save");
           $btnCreate->OnClick = $action;
           $jbHelper->AddNew($btnCreate);
           
           return $jbHelper->Show();
        }
        
        /**
         * Crée le nouvel helper
         */
        function AddHelper()
        {
            //Recuperation du nom
            $name = JVar::GetPost("tbNameHelper");
            $projet = JVar::GetPost("Projet");;
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddHelper();
            }
            else
            {
                //Creation du projet
                if(HelperHelper::CreateHelper($this->Core, $projet, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='error'>".$this->Core->GetCode("HelperExist")."</span>". self::ShowAddHelper();
                }
            }
        }
}
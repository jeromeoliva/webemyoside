<?php
/* 
 *  Webemyos.
 *  Jérôme Oliva
* module de creation de module
*/
class ModuleBlock extends JHomBlock implements IJhomBlock
{
	function ModuleBlock($core)
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
         * Permet d'ajouter un module
         */
        function ShowAddModule()
        {
           $jbModule = new JBlock($this->Core, "jbModule") ;
           
           //Nom
           $tbName = new TextBox("tbNameModule");
           $tbName->PlaceHolder = $this->Core->GetCode("Name");
           $jbModule->AddNew($tbName);
           
           //Action
           $action = new AjaxAction("EeIde","AddModule");
           $action->AddArgument("App", "EeIde");
           $action->AddArgument("Projet", JVar::GetPost("Projet"));
           $action->ChangedControl = "jbModule";
           $action->AddControl($tbName->Id);
           
           //Bouton de sauvegarde
           $btnCreate = new Button(BUTTON);
           $btnCreate->CssClass = "btjn btn-primary";
           $btnCreate->Value = $this->Core->GetCode("Save");
           $btnCreate->OnClick = $action;
           $jbModule->AddNew($btnCreate);
           
           return $jbModule->Show();
       }
       
       /**
        * Ajoute le module
        */
       function AddModule()
       {
            //Recuperation du nom
            $name = JVar::GetPost("tbNameModule");
            $projet = JVar::GetPost("Projet");;
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddModule();
            }
            else
            {
                //Creation du projet
                if(ModuleHelper::CreateModule($this->Core, $projet, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='success'>".$this->Core->GetCode("ModuleExist")."</span>". self::ShowAddModule();
                }
            }
        }
        
        
        /**
         * Permet d'ajouter une action à un module
         */
        function ShowAddActionModule()
        {
            //Recuperation des variables
            $projet = JVar::GetPost("Projet");
            $block = JVar::GetPost("Block");
            
            //Creation du bloc
            $jbAction = new JBlock($this->Core, "jbAction");
            
            //Nom de l'action
            $tbNameAction = new TextBox("tbNameAction");
            $tbNameAction->PlaceHolder = $this->Core->GetCode("Name");
            $jbAction->AddNew($tbNameAction);
            
            //Ajout d'un template
            $cbTemplate = new CheckBox("cbTemplate");
            $cbTemplate->Libelle = $this->Core->GetCode("EeIde.AddTemplate");
            $jbAction->AddNew($cbTemplate);
            
            //Action   
            $action = new AjaxAction("EeIde","AddActionModule");
            $action->AddArgument("App", "EeIde");
            $action->AddArgument("Projet", $projet);
            $action->AddArgument("Block", $block);
            
            $action->ChangedControl = "jbAction";
            $action->AddControl($tbNameAction->Id);
            $action->AddControl($cbTemplate->Id);
            
            //Bouton de sauvegarde
            $btnCreate = new Button(BUTTON);
            $btnCreate->CssClass = "button orange";
            $btnCreate->Value = $this->Core->GetCode("Save");
            $btnCreate->OnClick = $action;
            $jbAction->AddNew($btnCreate);
            
            return $jbAction->Show();
        }
        
        /**
         * Ajoute une action à un module
         */
        function AddActionModule()
        {
            //Recuperation des données
            $projet = JVar::GetPost("Projet");
            $block = JVar::GetPost("Block");
            $nameAction = JVar::GetPost("tbNameAction");
            $addTemplate = (JVar::GetPost("cbTemplate") == 1);
            
            if($nameAction == "")
            {
                return "<span class='FormUserError'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddModule();
            }
            else
            {
                ModuleHelper::AddActionModule($projet, $block, $nameAction, $addTemplate);
                return "<span class='FormUserValid'>".$this->Core->GetCode("SaveOk")."</span>"; 
            }
        }
        
}
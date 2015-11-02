<?php
/*
 * Module de gestion des projets
 */
class ProjetBlock extends JHomBlock implements IJhomBlock
{
	function ProjetBlock($core)
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
        
        /**
         * Creation d'un nouveau projet
         */
        function ShowCreateNewProjet()
        { 
           //Block
           $jbNewProjet = new JBlock($this->Core, "jbNewProjet");
           $jbNewProjet->Table = true;
            
           //Nom
           $tbNameProjet = new TextBox("tbNameProjet");
           $tbNameProjet->PlaceHolder = "EeIde.ProjetName";
           $jbNewProjet->AddNew($tbNameProjet);
           
           //Action
           $action = new AjaxAction("EeIde", "CreateProjet");
           $action->AddArgument("App", "EeIde");
           $action->ChangedControl = "jbNewProjet";
           $action->AddControl($tbNameProjet->Id);
           
           //Sauvegarde
           $btnCreate = new Button(Button);
           $btnCreate->CssClass = "btn btn-success";
           $btnCreate->Value = $this->Core->GetCode("Create");
           $btnCreate->OnClick = $action;
           
           $jbNewProjet->AddNew($btnCreate, '', ALIGNRIGHT);
           
           return $jbNewProjet->Show();
        }
        
        /**
         * Création du projet
         */
        function CreateProjet()
        {
            //Recuperation du nom
            $name = JVar::GetPost("tbNameProjet");
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowCreateNewProjet();
            }
            else
            {
                //Creation du projet
                if(ProjetHelper::CreateProjet($this->Core, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='error'>".$this->Core->GetCode("ProjetExist")."</span>". self::ShowCreateNewProjet();
                }
            }
        }
        
        /**
         * Charge les outils et le projets
         */
        function LoadProjet()
        {
            $this->SetTemplate(EeIde::$Directory . "/Blocks/ProjetBlock/ProjetBlock.tpl");

            //Recuperation du projet
            $projet = JVar::GetPost("Projet");
            
            //TabStrip de l'editeur
            $tsEditor = new TabStrip("tsEditor","EeIde");
            $tsEditor->AddTab("information", new Libelle("Votre projet"));
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!lstTools' => ToolHelper::GetTool($this->Core, $projet),
                                 '!lstElement' => ElementHelper::GetAll($this->Core, $projet),
                                 '!lstEditor' => $tsEditor->Show(),
                                ));
            
            return $this->Render();
        }
}

?>

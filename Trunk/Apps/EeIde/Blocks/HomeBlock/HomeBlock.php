<?php
/*
* module d'accueil
*/
class HomeBlock extends JHomBlock implements IJhomBlock
{
	function HomeBlock($core)
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
	{	
            $this->SetTemplate(EeIde::$Directory . "/Blocks/HomeBlock/HomeBlock.tpl");
    
           
            //Passage des parametres à la vue
            $this->AddParameters(array('!TitleHome' => $this->Core->GetCode("EeIde.TitleHome"),
                                 '!SubtitleHome' => $this->Core->GetCode("Ide.SubTitleHome"),
                                 '!lstRecentProjet' => $this->GetProjets(),
                               '!tools' => $this->GetTool(),
                    ))
                    ;
                
            return $this->Render();
	}
        
       function GetTool()
       {
           $html = "";
           
           //Creation de projet
           $btnNewProjet = new Button(BUTTON);
           $btnNewProjet->CssClass = "btn btn-primary";
           $btnNewProjet->Value = $this->Core->GetCode("EeIde.StartProjet");
           $btnNewProjet->OnClick = "EeIdeAction.NewProjet()";
           
           $html .= $btnNewProjet->Show();
           
           return $html;
       }

       /**
        * Obtient les projets de'lutilisateur
        */
       function GetProjets()
       {
            //Projet recent de l'utilisateur
           $html = "<div id='lstProjet' >";
           $lstRecentProjet = ProjetHelper::GetRecentProjet($this->Core);
            
            if(count($lstRecentProjet) > 0)
            {
                 //Entete
                $html .= "<div class='headFolder'  >";
                $html .= "<b class='blueTree'>&nbsp;</b>" ;
                $html .= "<span class='blueTree name' ><b>".$this->Core->GetCode("Name")."</b></span>" ;
                $html .= "</span>";  
                $html .= "</div>" ;
                
                foreach($lstRecentProjet as $projet)
                {
                    $html .= "<div class='projet'  >";
          
                    $link = new Link($projet->Name->Value, "#");
                    $link->Title = $projet->Name->Value;
                    $link->OnClick = "EeIdeAction.LoadProjet('".$projet->Name->Value."')";
          
                    $html .= "<span>".$link->Show()."</span>";
                    
                    $html .= "</div>";
                }
            }
            
            $html .= "</div>";
            
            return $html;
       }
}     
?>
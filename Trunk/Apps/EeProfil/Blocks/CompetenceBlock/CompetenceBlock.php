<?php
/**
 * Module de gestion des compétences
 * */
 class CompetenceBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function CompetenceBlock($core="")
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
        * Charges les compétences de l'utilisateur
        */
         function Load()
        {
                $this->SetTemplate(EeProfil::$Directory . "/Blocks/CompetenceBlock/Load.tpl");
                $this->AddParameters(array('!dvCompetenceUser' => $this->GetUserCompetence(),
                                         ));

                return $this->Render();
        }

        /**
         * Compétence de l'utilisateur
         */
        function GetUserCompetence()
        {
            //Recuperation des catégorie
            $categories = CompetenceHelper::GetCategorie($this->Core);
            
            $html = "";
            
            foreach($categories as $categorie)
            {
                $html .= "<div class='categorie col-md-4 '>";
                $html .= "<div class='titleBlue'>".$categorie->Name->Value."</div>";
                
                //Recuperation des compétences
                $competences = CompetenceHelper::GetByCategoryByUser($this->Core, $categorie->IdEntite, $this->Core->User->IdEntite);

                $html .= "<ul>";
                
                foreach($competences as $competence)
                {
                  $cbCompetence = new CheckBox($competence["Id"]); 
                  $cbCompetence->Checked = $competence["Selected"];
                  
                  $html .= "<li>".$cbCompetence->Show()."&nbsp;".$competence["Code"]."</li>";
                }
                
                $html .= "</ul>";
                $html .= "</div>";
            }
            
            //Enregistrement
            $btnSave = new Button(BUTTON);
            $btnSave->Value = $this->Core->GetCode("Save");
            $btnSave->CssClass = "btn btn-primary";
            $btnSave->OnClick = "EeProfilAction.SaveCompetence()";
            
            $html .= "<div class='col-md-12 alignCenter '>".$btnSave->Show()."</div>";
            
            return $html;
        }
}?>
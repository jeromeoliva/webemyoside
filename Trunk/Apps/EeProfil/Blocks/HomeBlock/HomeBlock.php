<?php
/**
 * Module de la page d'accueil
 * */
 class HomeBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function HomeBlock($core="")
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
                //Passage des parametres à la vue
                $this->AddParameters(array('!titleHome' => $this->Core->GetCode("EeProfil.TitleHome"),
                                            '!messageHome' => $this->Core->GetCode("EeProfil.MessageHome"),
                                           '!tools' => $this->GetTools(),
                                        ));

                $this->SetTemplate(EeProfil::$Directory . "/Blocks/HomeBlock/HomeBlock.tpl");

                return $this->Render();
	  }
          
          /**
           * Obtient le menu
           */
          function GetTools()
          {
              $btnInformation = new Button(BUTTON);
              $btnInformation->CssClass = "btn btn-success";
              $btnInformation->Value = $this->Core->GetCode("EeProfil.MyInformation");
              $btnInformation->OnClick = "EeProfilAction.LoadInformation()";
              
              $html = $btnInformation->Show();
                      
              $btnCompetence = new Button(BUTTON);
              $btnCompetence->CssClass = "btn btn-info";
              $btnCompetence->Value = $this->Core->GetCode("EeProfil.MyCompetence");
              $btnCompetence->OnClick = "EeProfilAction.LoadCompetence()";
              
              $html .= $btnCompetence->Show();
              
              return $html;
          }
 }?>
<?php
/**
 * Module d'accueil
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
           //Bouton pour créer un message
                $btnMyApp = new Button(BUTTON);
                $btnMyApp->Value = "EeApp.MyApp";
                $btnMyApp->CssClass = "btn btn-info";
                $btnMyApp->OnClick = "EeAppAction.LoadMyApp();";
                
                //Fichier Partage
                $btnShowApp= new Button(BUTTON);
                $btnShowApp->Value = "EeApp.Apps";
                $btnShowApp->CssClass = "btn btn-success";
                $btnShowApp->OnClick = "EeAppAction.LoadApps();";
                
                
	        //Passage des parametres à la vue
                $this->AddParameters(array('!titleHome' => $this->Core->GetCode("EeApp.TitleHome"),
                                            '!messageHome' => $this->Core->GetCode("EeApp.MessageHome"),
                                           
                                            '!btnMyApp' =>  $btnMyApp->Show(),                     
                                            '!btnShowApp' => $btnShowApp->Show(),
                                        ));

                $this->SetTemplate(EeApp::$Directory . "/Blocks/HomeBlock/HomeBlock.tpl");

                return $this->Render();
	  }
 }?>
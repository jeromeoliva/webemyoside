<?php
/**
 * Module des gestion des applications
 * */
 class AppBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function AppBlock($core="")
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
          
          /**
           * Charges les applications de l'utilisateur
           */
          function LoadMyApp()
          {
              $html ="";
              
              //Recuperation
              $apps = AppHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
              
              if(count($apps) > 0)
              {
                    //Entete
                    $html .= "<div class='headApp titleBlue'  >";
                    $html .= "<b class='blueTree'>&nbsp;</b>" ;
                    $html .= "<span class='blueTree name' ><b>".$this->Core->GetCode("Categorie")."</b></span>" ;
                    $html .= "<span class='blueTree'><b>".$this->Core->GetCode("App")."</b></span>" ;
                    $html .= "<span class='blueTree'><b>".$this->Core->GetCode("Description")."</b></span>" ;
                    $html .= "</span>";  
                    $html .= "</div>" ;
                    
                    foreach($apps as $app)
                    {
                        $img = new Image("../Apps/".$app->App->Value->Name->Value."/images/logo.png");
                  
                        $html .= "<div class='App'  >";
                        $html .= "<span class='blueOne name' >".$app->App->Value->Category->Value->Name->Value."</span>" ;
                        $html .= "<i class='blueOne'>".$img->Show()."</i>" ;
                        $html .= "<span class='blueOne name' id='".$app->IdEntite."' >".$app->App->Value->Name->Value."</span>" ;
                        $html .= "<span class='blueOne' >".$app->App->Value->Description->Value."</span>" ;

                        //Bouton d'ajout
                        $btnRemove = new Button(BUTTON);
                        $btnRemove->Value = $this->Core->GetCode("EeApp.Remove");
                        $btnRemove->OnClick = "EeAppAction.Remove(".$app->IdEntite.", this)";

                        $html .= "<span class='blueOne ' >".$btnRemove->Show()."</span>" ;

                        $html .= "</div>";
                    }
              }
              else
              {
                  $html= $this->Core->GetCode("EeApp.NoApp");
              }
              
              return $html;
          }
          
          /**
           * Charge les applications disponibles
           */
          function LoadApps()
          {
              $html = "";
              
              //Recuperation 
              $apps = AppHelper::GetByParameters($this->Core);
              
                              //Entete
            $html .= "<div class='headApp titleBlue'  >";
            $html .= "<b class='blueTree'>&nbsp;</b>" ;
            $html .= "<span class='blueTree name' ><b>".$this->Core->GetCode("Categorie")."</b></span>" ;
            $html .= "<span class='blueTree'><b>".$this->Core->GetCode("App")."</b></span>" ;
            $html .= "<span class='blueTree'><b>".$this->Core->GetCode("Description")."</b></span>" ;
            $html .= "</span>";  
            $html .= "</div>" ;
                
              foreach($apps as $app)
              {
                  $img = new Image("../Apps/".$app->Name->Value."/images/logo.png");
                  
                  $html .= "<div class='App'  >";
                  $html .= "<span class='blueOne name' >".$app->Category->Value->Name->Value."</span>" ;
                 
                  $html .= "<i class='blueOne'>".$img->Show()."</i>" ;
                  $html .= "<span class='blueOne ' id='".$app->IdEntite."' >".$app->Name->Value."</span>" ;
                  $html .= "<span class='blueOne ' >".$app->Description->Value."</span>" ;
           
                  //Verification si l'utyilisateur a déjà l'app
                  if(!AppHelper::UserHave($this->Core, $app->IdEntite))
                  {
                        //Bouton d'ajout
                    $btnAdd = new Button(BUTTON);
                    $btnAdd->Value = $this->Core->GetCode("EeApp.Add");
                    $btnAdd->OnClick = "EeAppAction.Add(".$app->IdEntite.", this)";

                    $html .= "<span class='blueOne ' >".$btnAdd->Show()."</span>" ;
                  }
                  
                  $html .= "</div>";
              }
              
              return $html;
          }
 }?>
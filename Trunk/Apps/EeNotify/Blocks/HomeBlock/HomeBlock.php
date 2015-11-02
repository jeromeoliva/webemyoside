<?php
/**
 * Module accueil
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
            $this->AddParameters(array('!lstNotify' => $this->GetNotify()));
            
            $this->SetTemplate(EeNotify::$Directory . "/Blocks/HomeBlock/HomeBlock.tpl");

            return $this->Render();
	  }
          
          /**
           * Obtient les notifications de l'utilisateur
           */
          function GetNotify()
          {
              //Template de détail
              $this->SetTemplate(EeNotify::$Directory . "/Blocks/HomeBlock/Detail.tpl");

              //Recuperation des notification
              $notifys = NotifyHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
              
              if(count($notifys) > 0 )
              {
                $html ="";

                //Ligne D'entete
                $html .= "<div class='notify'  >";
                $html .= "<div class='blueTree name' ><b>".$this->Core->GetCode("App")."</b></div>" ;
                $html .= "<div class='blueTree'><b>".$this->Core->GetCode("User")."</b></div>" ;
                $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Date")."</b></div>" ;
                $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Message")."</b></div>" ;
                $html .= "</span>";  
                $html .= "</div>" ;
                
                $Eprofil = Eemmys::GetApp("EeProfil", $this->Core);
                  
                foreach($notifys as $notify)
                {
                   $logo = new Image("../Apps/".$notify->AppName->Value."/Images/logo.png");
                           
                  //Passage des parametres à la vue
                  $this->AddParameters(array(
                                             '!user' => $Eprofil->GetProfil($notify->User->Value),
                                            '!app' => $logo->Show(),
                                            '!date' => $notify->DateCreate->Value,
                                             '!description' => $this->Core->GetCode($notify->Description->Value),
                                             '!code' => $this->Core->GetCode($notify->Code->Value),
                         ));

                  $html .= $this->Render();
                }
                
                return $html;
              }
              else
              {
                  return "<h3>".$this->Core->GetCode("EeNotify.NoNotify")."</h3>";
              }
              
          }
 }?>
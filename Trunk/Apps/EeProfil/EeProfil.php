<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Application de gestion du profil utilisateur
 * */
class EeProfil extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeProfil";

	/**
	 * Constructeur
	 * */
	 function EeProfil($core)
	 {
	 	parent::__construct($core, "EeProfil");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeProfil::IncludeBlock();
                
                //Inclue les entité
		EeProfil::IncludeEntity();
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeProfil", "EeProfil");
	 	echo $textControl;
	 }
         
          /**
          * Inclut les module nescessaires
          */
         public static function IncludeBlock()
         {
               $blocks = array("HomeBlock", "InformationBlock", "CompetenceBlock");
             
               foreach($blocks as $block)
               { 
                    if(!class_exists($block))
                    {
                        include("Blocks/".$block."/".$block.".php");
                    }
              }
                   
                //Inclu les helper
                if(!class_exists("UserHelper"))
                {
                    include("Helper/UserHelper.php");
                    include("Helper/CompetenceHelper.php");
                }
         }
         
         /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		$entites = array("EeProfilCompetenceCategory", "EeProfilCompetence", "EeProfilCompetenceEntity");
		
		foreach($entites as $entite)
		{
                    include("Entity/".$entite.".php");
		}
	}
        
        /**
         * Charge les information de base du profil
         */
        public function LoadInformation($showAll = true)
        {
            $informationBlock = new InformationBlock($this->Core);
            echo $informationBlock->Load($showAll);
        }
        
        /**
         * Enregistre les informations du profil
         */
        public function SaveInformation()
        {
            //Enregistrement
            echo UserHelper::Save($this->Core,
                                  JVar::GetPost("FirstName"),
                                  JVar::GetPost("Name"),
                                  JVar::GetPost("tbCity")
                   );
                    
            $this->LoadInformation(false);
        }
        
        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "../Data/Apps/EeProfil/";
           
           switch($action)
           {
               case "SaveImageProfil":
                               //Sauvegarde
                move_uploaded_file($tmpFileName, $directory."/".$idElement.".jpg");

                //Crée un miniature
                $image = new JImage();
                $image->load($directory."/".$idElement.".jpg");
                $image->fctredimimage(48, 0,$directory."/".$idElement."_96.jpg");

                $this->Core->User->Image->Value = $directory."/".$idElement.".jpg";
                $this->Core->User->Save();
                   break;
           }
        }
        
        /**
         * Charge les compétences du profil
         */
        public function LoadCompetence()
        {
            $competenceBlock = new CompetenceBlock($this->Core);
            echo $competenceBlock->Load();
        }
        
        //Enregistre les competences
        public function SaveCompetence()
        {
            echo UserHelper::SaveCompetence($this->Core, $this->Core->User->IdEntite, JVar::GetPost("competenceId"));
                    
            echo $this->LoadCompetence();
        }
        
        /**
         * Récupere l'image du profil
         */
        public function GetProfil($user = false, $cssClass = "", $addInvitation = false)
        {
            $html = "<div class='$cssClass'>";
            
            $informationBlock = new InformationBlock($this->Core);
            
            if($user != false)
            {
                $html .= $informationBlock->GetImage($user->IdEntite, true)->Show();
            }
            else
            {
                $html .= $informationBlock->GetImage($this->Core->User->IdEntite, true)->Show();
                $user = $this->Core->User;
            }
            
            $html .= "<div class='member'>".$user->GetPseudo()."</div>";
            $html .= "</div>";
            
            return $html ;
        }
}
?>
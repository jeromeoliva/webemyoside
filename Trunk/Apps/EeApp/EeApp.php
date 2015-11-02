<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Application de gestion des applications
 * */
class EeApp extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeApp";

	/**
	 * Constructeur
	 * */
	 function EeApp($core)
	 {
	 	parent::__construct($core, "EeApp");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeApp::IncludeBlock();
                
                //Inclue les entité
		EeApp::IncludeEntity();
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeApp", "EeApp");
	 	echo $textControl;
	 }
         
          /**
          * Inclut les module nescessaires
          */
         public static function IncludeBlock()
         {
              	if(!class_exists("HomeBlock"))
		{
                    include("Blocks/HomeBlock/HomeBlock.php");
                    include("Blocks/AppBlock/AppBlock.php");
                }
                
                //Inclu les helper
                if(!class_exists("AppHelper"))
                {
                   include("Helper/AppHelper.php");
                }
         }
         
         /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		$entites = array("EeAppCategory", "EeAppApp", "EeAppUser");
		
		foreach($entites as $entite)
		{
                    include("Entity/".$entite.".php");
		}
	}
        
        /**
         * Charge les applications de l'utilisateur
         */
        public function LoadMyApp()
        {
            $appBlock = new AppBlock($this->Core);
            echo $appBlock->LoadMyApp();
        }
        
        /**
         * Charge les applications disponibles
         */
        public function LoadApps()
        {
            $appBlock = new AppBlock($this->Core);
            echo $appBlock->LoadApps();
        }
        
        /**
         * Ajoute une app à l'utilisateur
         */
        public function Add()
        {
            $appId = JVar::GetPost("appId");
            $appName= JVar::GetPost("appName");
            $result = AppHelper::Add($this->Core, $appId, $appName );
            
            if($result === true)
            {
                echo $this->Core->GetCode("EeApp.AppAdded");
            }
            else if($result === false)
            {
                echo $this->Core->GetCode("EeApp.ErrorAdded");
            }
            else
            {
               echo $result; 
            }
        }
        
        /**
         * Supprime une app au bureau
         */
        public function Remove()
        {
            $appId = JVar::GetPost("appId");
            
            AppHelper::Remove($this->Core, $appId);
        }
        
        /**
         * Obtient toutes les applications Actives
         */
        public function GetActif()
        {
            return AppHelper::GetActif($this->Core);
        }
       
        /*
         * Obtient les applications par catégories
         */
        public function GetByCategory($categoryId)
        {
            return AppHelper::GetByCategory($this->Core, $categoryId);
        }
        
        /**
         * Retourne une application depuis son Id
         * @param type $appId
         */
        public function GetAppById($appId)
        {
            return AppHelper::GetById($this->Core, $appId);
        }
        
        /**
         * Retourne une application par son nom
         * @param type $name
         */
        public function GetAppByName($name)
        {
            return AppHelper::GetByName($this->Core, $name);
        }
        
        /**
         * Obtient les categories des applications
         */
        public function GetCategory()
        {
            return AppHelper::GetCategory($this->Core);
        }
       
}
?>
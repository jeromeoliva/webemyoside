<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Application de gestion des XXX
 * */
class EeXXX extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeXXX";

	/**
	 * Constructeur
	 * */
	 function EeXXX($core)
	 {
	 	parent::__construct($core, "EeXXX");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeXXX::IncludeBlock();
                
                //Inclue les entité
		EeXXX::IncludeEntity();
                
                //Inclue les helpers
                EeXXX::IncludeHelper();
                
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeXXX", "EeXXX");
	 	echo $textControl;
	 }
         
          /**
          * Inclut les module nescessaires
          */
         public static function IncludeBlock()
         {
               //Inclue les modules;
               /*block*/
         }
         
         /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		//Inclue les entite
               /*entity*/
	}
        
        /*
         * Inclue les helpers
         */
        public static function IncludeHelper()
        {
            //Inclue les helper
               /*helper*/
        }
}
?>
<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Application de gestion des notification
 * */
class EeNotify extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeNotify";

	/**
	 * Constructeur
	 * */
	 function EeNotify($core)
	 {
	 	parent::__construct($core, "EeNotify");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeNotify::IncludeBlock();
                
                //Inclue les entité
		EeNotify::IncludeEntity();
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeNotify", "EeNotify");
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
                }
                
                //Inclu les helper
                if(!class_exists("NotifyHelper"))
                {
                    include("Helper/NotifyHelper.php");
                }
         }
         
        /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		$entites = array("EeNotifyNotify");
		
		foreach($entites as $entite)
		{
                    include(self::$Directory."/Entity/".$entite.".php");
		}
	}
        
        /**
         * Ajoute une notification
         * 
         * @param type $userId
         * @param type $DestinataireId
         * @param type $AppName
         * @param type $EntityId
         * @param type $Code
         */
        public function AddNotify($userId, $code, $destinataireId= "", $AppName = "", $EntityId = "",  $emailSubjet ="" , $emailMessage="")
        {
            NotifyHelper::AddNotify($this->Core, $userId, $code, $destinataireId, $AppName, $EntityId, $emailSubjet, $emailMessage);
        }
        
        /**
         * Obtient les notifications des applications
         * 
         * @param type $appName
         * @param type $EntityId
         */
        public function GetNotifyApp($appName, $EntityId)
        {
             return NotifyHelper::GetNotify($this->Core, $appName, $EntityId);
        }
        
        /**
         * Affiche les dernières notifications
         * 
         * @return string
         */
        public function GetInfo()
        {
            $html ="";
            
            //Obtient les dernière notifications
            $notifications = NotifyHelper::GetLastByUser($this->Core, $this->Core->User->IdEntite);
            
            if(count($notifications )> 0 )
            {
            
                foreach($notifications as $notification)
                {
                       $html .= "<div class='notification'><a href='#' onclick='Eemmys.StartApp(\"\",\"EeNotify\")'>";

                       $html .= "<span class='date'>".$notification->DateCreate->Value."</span>";
                       $html .= "<span class='text'>".$this->Core->GetCode($notification->Code->Value)."</span></a>";

                      $html .= "</div>";
                }

                return $html;
            }
            else
            {
                return $this->Core->GetCode("EeNotify.Noti");
            }
        }
        
        /**
         * Retourne le nombre de notification
         */
        function GetCount()
        {
            $notify = NotifyHelper::GetByUser($this->Core, $this->Core->User->IdEntite );
            
            return count($notify);
        }
}
?>
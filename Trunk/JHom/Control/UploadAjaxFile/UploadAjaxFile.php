<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 class UploadAjaxFile extends JHomControl implements IJHomControl
 {
 	//Propriete
 	private $app;
 	private $idElement;
        private $callBack;
        private $action;
        private $idUpload;

    //Constructeur
 	function UploadAjaxFile($app, $id, $callBack, $action = false, $idUpload ="fileToUpload")
 	{
            $this->app = $app;
            $this->idElement = $id;
            $this->callBack = $callBack;
            $this->action = $action;
            $this->idUpload = $idUpload; 
        }
        
        /**
         * Affiche le control
         * 
         * @return string
         */
        function Show()
        {
             $TextControl = "<span class='upLoadAjax'>";
             $TextControl .= "<span id='spLoading$this->idUpload' style='display:none' ><img src='Images/loading/loading30.gif'></span>";
             $TextControl .= "<span id='spUploadAjaxControl$this->idUpload'><b class='FormUserValid' style='display:none' id='spUploadAjaxValide'>Enregistrement Réussie</b><b class='FormUserError' id='spUploadAjaxError' style='display:none'>Erreur</b><br/>" ;
             $TextControl .= "<input type='hidden' id='hdApp$this->idUpload' value='".$this->app."' />";
             $TextControl .= "<input type='hidden' id='hdIdElement$this->idUpload' value='".$this->idElement."' />";
             $TextControl .= "<input type='hidden' id='hdAction$this->idUpload' value='".$this->action."' />";
            
             $TextControl .= "<input id='".$this->idUpload."' type='file' size='45' name='fileToUpload' class='input'>";
                          
             $TextControl .= "<button class='btn btn-success' id='buttonUpload' onclick='UploadAjaxFile.Upload(\"".$this->callBack."\", \"".$this->idUpload."\");'>Envoyer</button></span>";
             
             $TextControl .= "</span>"; 
             
             return $TextControl;
        }
 }

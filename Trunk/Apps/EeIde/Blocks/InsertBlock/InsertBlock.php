<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Module d'insertion de fonction js
 */
class InsertBlock extends JHomBlock implements IJhomBlock
{
	function InsertBlock($core)
	{
            $this->Core = $core;
	}
	
	/*
	* Crée le module
	*/	
	function Create()
	{
	}

	/*
	* Initialise
	*/
	function Init()
	{
	}
	
	/*
	* Affiche le module
	*/
	function ShowInsertJs()
	{	
            $this->SetTemplate(EeIde::$Directory . "/Blocks/InsertBlock/InsertBlock.tpl");
    
            //Recuperation des foncion Js disponible
            $lstFonction = new ListBox("lstFonction");
            $lstFonction->Add($this->Core->GetCode("ChoseFunction"), "");
            
            foreach($this->GetJsFonction() as $fonction)
            {
                $lstFonction->Add($fonction, $fonction);
            }
            $lstFonction->OnChange = "IdeInsert.fonctionJsSelected(this)";
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!Title' => $this->Core->GetCode("EeIde.AddJsFonction"),
                                       '!lstFonction' => $lstFonction->Show()));                   
                
            return $this->Render();
	}
        
        /**
         * Récuprer toutes les fonction Js
         */
        function GetJsFonction()
        {
            $fonctions = array();
            $directory = EeIde::$Directory."/Insert/Js";
       
            if ($dh = opendir($directory))
            {
                 while (($file = readdir($dh)) !== false)
                 {
                   if($file != "." && $file != ".." )
                   {
                       if(is_dir($file) || strpos($file, ".") === false)
                       {
                           //  $html .="<li class='icon-folder-close green' style='display:block'>".$file."</li>";
                       }
                       else
                       {
                        $fonctions[] = str_replace(".php", "", $file);
                       }
                   }
                 }
              }
         return $fonctions;
        }
        
        /**
         * Récuprer toutes les fonction Js
         */
        function GetPhpFonction()
        {
            $fonctions = array();
            $directory = EeIde::$Directory."/Insert/Php";
       
            if ($dh = opendir($directory))
            {
                 while (($file = readdir($dh)) !== false)
                 {
                   if($file != "." && $file != ".." )
                   {
                       if(is_dir($file) || strpos($file, ".") === false)
                       {
                           //  $html .="<li class='icon-folder-close green' style='display:block'>".$file."</li>";
                       }
                       else
                       {
                        $fonctions[] = str_replace(".php", "", $file);
                       }
                   }
                 }
              }
         return $fonctions;
        }
        
        /**
         * Récupère les parametres a initialiser d'une fonction js
         */
        function GetParameterJsFonction()
        {
            $fonction = JVar::GetPost("Fonction");
            
            //Inclusion de la classe
            include(EeIde::$Directory."/Insert/Insert.php" );
            include(EeIde::$Directory."/Insert/Js/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $TextControl = $fonctionInsert->GetParameter();
     
            //Sauvegarde
            $btnSave = new Button(BUTTON);
            $btnSave->CssClass = "btn btn-success";
            $btnSave->Value = $this->Core->GetCode("Create");
            $btnSave->OnClick = "IdeInsert.GetCodeTemplate('Js')";
            
            $TextControl .= "<br/>".$btnSave->Show();
            
            return $TextControl;
        }
        
        /**
         * Récupere le code du template
         */
        function GetCodeTemplate()
        {
            $fonction = JVar::GetPost("Fonction");
            $parameters = explode("_-", JVar::GetPost("Parameter"));
            $type = JVar::GetPost("Type");
                    
            //Inclusion de la classe
            include(EeIde::$Directory."/Insert/Insert.php" );
            include(EeIde::$Directory."/Insert/".$type."/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $Content = $fonctionInsert->ShowInsert($parameters);
            
            $tbContent = new TextArea("tb");
            $tbContent->Value = $Content;
            
            return $tbContent->Show();
        }
        
        /*
	* Affiche le module
	*/
	function ShowInsertPhp()
	{	
            $this->SetTemplate(EeIde::$Directory . "/Blocks/InsertBlock/InsertBlock.tpl");
    
            //Recuperation des foncion Js disponible
            $lstFonction = new ListBox("lstFonction");
            $lstFonction->Add($this->Core->GetCode("ChoseFunction"), "");
            
            foreach($this->GetPhpFonction() as $fonction)
            {
                $lstFonction->Add($fonction, $fonction);
            }
            $lstFonction->OnChange = "IdeInsert.fonctionPhpSelected(this)";
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!Title' => $this->Core->GetCode("EeIde.AddPhpFonction"),
                                       '!lstFonction' => $lstFonction->Show()));                   
                
            return $this->Render();
	}
        
         /**
         * Récupère les parametres a initialiser d'une fonction php
         */
        function GetParameterPhpFonction()
        {
            $fonction = JVar::GetPost("Fonction");
            
            //Inclusion de la classe
            include(EeIde::$Directory."/Insert/Insert.php" );
            include(EeIde::$Directory."/Insert/Php/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $TextControl = $fonctionInsert->GetParameter();
     
            //Sauvegarde
            $btnSave = new Button(BUTTON);
            $btnSave->CssClass = "btn btn-success";
            $btnSave->Value = $this->Core->GetCode("Create");
            $btnSave->OnClick = "IdeInsert.GetCodeTemplate('Php')";
            
            $TextControl .= "<br/>".$btnSave->Show();
            
            return $TextControl;
        }
}

?>

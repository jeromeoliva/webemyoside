<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Editeur de template
 */
class TemplateBlock extends JHomBlock implements IJhomBlock
{
	function TemplateBlock($core)
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
	function Show()
	{	
            $this->SetTemplate(EeIde::$Directory . "/Blocks/TemplateBlock/TemplateBlock.tpl");
    
            //Recuperation des variable
            $projet = JVar::GetPost("Projet");
            $module = JVar::GetPost("Module");
            
            $directory = "../Apps/".$projet."/Blocks/".$module;
      
            //Lecture du dossier
            if ($dh = opendir($directory))
            {
                $lstTemplate = "<ul class='alignLeft'>";
            
                while (($file = readdir($dh)) !== false)
                {
                  if($file != "." && $file != ".." )
                  {
                      if(is_dir($file) || strpos($file, ".") === false || strpos($file, ".php") > 0)
                      {
                      }
                      else
                      {
                       $lstTemplate .="<li class='blue' onclick='IdeElement.LoadCodeTemplate(\"".$projet."\", \"".$module."\", \"".$file."\", true)'>".$file."</li>";
                      }
                  }
                }
                
                 $lstTemplate .= "</ul>";
            }
            else
            {
                echo "Errure";
            }
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!lstTemplate' => $lstTemplate,
                                       '!Tools'=> ToolHelper::GetTemplateEditorTool($this->Core),
                                       '!cssFile' => ElementHelper::LoadCssFile($projet),
                                       '!idDivApp' => "appRun" .$projet
                ) 
                                    );
                
            return $this->Render();
	}
        
        /**
         * Charge le templace
         */
        function LoadCodeTemplate()
        {
            $projet = JVar::GetPost("Projet");
            
            if(JVar::GetPost("ShowStyle"))
            {
                 //Ajout du style css
                 $filecss = "../Apps/".$projet."/".$projet.".css";
                 $contentCss = JFile::GetFileContent($filecss); 
            
                 //Les css sont préxifer par le nom de l'application
                 $contentCss = str_replace("#appRun".$projet , "", $contentCss );
            
                $html = "<style type='text/css' >".$contentCss."</style>";
            }
            
            $file = "../Apps/".$projet."/Blocks/".JVar::GetPost("Module")."/".JVar::GetPost("File");
            $html .= JFile::GetFileContent($file);    
            
            return $html;
        }
       
        /**
         * Sauivegarde le template
         */
        function SaveTemplate()
        {
            //Enregistrement du template
            $file = "../Apps/".JVar::GetPost("Projet")."/Blocks/".JVar::GetPost("Module")."/".JVar::GetPost("File");
            JFile::SetFileContent($file, JVar::GetPost("Content"));
            
            //Enregistrement du fichier css
            $file = "../Apps/".JVar::GetPost("Projet")."/".JVar::GetPost("Projet").".css";
            return JFile::SetFileContent($file, JVar::GetPost("CssContent"));
        }
}

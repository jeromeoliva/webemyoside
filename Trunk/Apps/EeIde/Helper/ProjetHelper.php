<?php
/*
 * Webemyos
 * Jerome Oliva 07/02/2014
 * Helper pour la gestion des projets
 * */

class ProjetHelper
{
    
    /**
     * Récupere l'application EeIde
     */
    public static function GetApp($core)
    {
        return Eemmys::GetApp("EeIde", $core);
    }
    
    /**
     * Obtient les projets
     * @param type $core
     */
    public static function GetProjet($core)
    {
        //recuperation des  projet dans config
        $projets = new EeIdeProjet($core);
        //TODO Reactiver 
        // Gerer le partage des projets
        //$projets->AddArgument(new Argument("EeIdeProjet", "UserId", EQUAL, $core->User->IdEntite));
        //$projets->GetByArg()
        
        return  $projets->GetAll();   
    }
    
    /**
     * Récupere les projets récents de l'utilisateur
     */
    public static function GetRecentProjet($core)
    {
        $elements = self::GetProjet($core);
        
        return $elements;
        /*if(count($elements) > 0)
        {
            $html = "<ul class='alignLeft'>";
            
            foreach($elements as $element)
            {
                $link = new Link($element->Name->Value, "#");
                $link->Title = $element->Name->Value;
                $link->OnClick = "EeIdeAction.LoadProjet('".$element->Name->Value."')";
          
                $html .= "<li>".$link->Show()."</li>";
            }
            
            $html .= "</ul>";
            
            return "<div id='lstProjet'>".$html."</div>";
        }
        else
        {
            return "<div id='lstProjet'>".$core->GetCode("EeIde.NoProjet")."</div>";
        }*/
    }
    
    /**
     * Définie si un projet existe en base de donnée
     * 
     * @param type $core
     * @param type $name
     */
    public static function Exist($core, $name)
    {
       $projet = new EeIdeProjet($core);
       $projet->AddArgument(new Argument("EeIdeProjet", "Name", EQUAL, $name));
       
       $projets = $projet->GetByArg();
       
       return  ( count($projets) > 0);
    }
    
    /**
     * Création d'un nouveau projet
     */
    public static function CreateProjet($core, $name)
    {
        //Creation du repertoire du projet
	$destination = EeIde::$Destination."/".$name; //;"../Data/Apps/EeIde/".$name;
        
       //Le projet n'existe pas en base
        if(!ProjetHelper::Exist($core, $name))
        {
            echo "<span class='succes' >Enregistrement en base</span>";
            
            //Enregistrement en base 
            $projet = new EeIdeProjet($core);
            $projet->UserId->Value = $core->User->IdEntite;
            $projet->Name->Value = $name;
            $projet->Save();
        }
        
        if(!file_exists($destination))
        {
            //Creation du repertoire
            JFile::CreateDirectory($destination);
        
            //Copy des fichier
            copy(EeIde::$Directory. '/Modele/App/EeXXX.xml', $destination."/".$name.".xml");
	    copy(EeIde::$Directory. '/Modele/App/EeXXX.php', $destination."/".$name.".php");
            copy(EeIde::$Directory. '/Modele/App/EeXXX.js', $destination."/".$name.".js");
            copy(EeIde::$Directory. '/Modele/App/EeXXX.css', $destination."/".$name.".css");
            
            //Creation des dossiers indispensables
            JFile::CreateDirectory($destination. "/Blocks");
            JFile::CreateDirectory($destination. "/Entity");
            JFile::CreateDirectory($destination. "/Helper");
            JFile::CreateDirectory($destination. "/Db");
            JFile::CreateDirectory($destination. "/Images");
            
            //Copie du logo
            copy(EeIde::$Directory. '/Modele/App/Images/logo.png', $destination."/Images/logo.png");
            
             //Renommage des noms
             self::ReplaceNameApp($destination."/".$name.".xml", $name);
             self::ReplaceNameApp($destination."/".$name.".php", $name);
             self::ReplaceNameApp($destination."/".$name.".js", $name);
            
            return true; 
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Remplace touts les noms des applications
    * */
    public static function ReplaceNameApp($file, $name)
    {
           $content = JFile::GetFileContent($file);
           $content = str_replace("EeXXX", $name, $content);

           //Enregistrement
           JFile::SetFileContent($file, $content);
    }
    
    /**
     * Obtient les app d'un projet
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $ideProjet = new EeIdeProjet($core);
                
        $ideProjet->AddArgument(new Argument("EeIdeProjet", "AppName" ,EQUAL, $appName));
        $ideProjet->AddArgument(new Argument("EeIdeProjet", "EntityName" ,EQUAL, $entityName));
        $ideProjet->AddArgument(new Argument("EeIdeProjet", "EntityId" ,EQUAL, $entityId));
        
        return $ideProjet->GetByArg();
        
    }
}

?>

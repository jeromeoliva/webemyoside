<?php

/* 
 * Classe de gestion des dépot
 */
class DepotHelper
{
    
       /*
     * Obtient les dépot disponibles
     */
    public static function GetDepots()
    {
      //Obtient les dépots qui sont dans le dossier Depots
         $folderName = dir("../Depots/");
        $folders = array();
        
       while($file = $folderName->read())
	  {
	  
	     $folders[] = $file;
	  }
          
	  $folderName->close();
          
          return $folders;
    }
    
    /*
     * Ajoute un dépot
     */
    public static function Upload($core, $depot)
    {
            //Copie du fichier Zip et decompression
            copy ("../Depots/" .$depot,  "../Apps/".$depot);
            JFile::UnCompresse("../Apps/", $depot);
            JFile::Delete($depot, "../Apps/");
        
        echo "<br/><span class='success'>Téléchargement ok</span>";
        
        $app = str_replace(".zip", "", $depot);
        
        //Installation de la base de donées
        echo "<br/><span class='success'>Creation de table en base de donnée</span>";
        EntityHelper::CreateTable($core, $app);
        
        //Copi les fichiers Front
        DepotHelper::CopyFileFront($app);
        
        //Ajoute un projet
        DepotHelper::AddProjet($core, $app);
     }
    
    /**
     * Copie les fichiers pour le front
     */
    public static function CopyFileFront($app)
    {
        
        //Copie des fichier front
        if(file_exists("../Apps/".$app."/Front/".$app."Front.php"))
        {
            echo "<br/><span class='success'>Ajout de fichier front . ".$app."Front.php </span>";
            copy("../Apps/".$app."/Front/".$app."Front.php", "../".$app."Front.php");
        }
        
        if(file_exists("../Apps/".$app."/Front/".$app.".tpl"))
        {
            echo "<br/><span class='success'>Ajout de fichier template . ".$app.".tpl </span>";
            copy("../Apps/".$app."/Front/".$app.".tpl", "../Template/".$app.".tpl");
        }
        
        if(file_exists("../Apps/".$app."/Front/.htaccess"))
        {
            echo "<br/><span class='success'>Ajout de directive htaccess</span>";
            $directive = JFile::GetFileContent("../Apps/".$app."/Front/.htaccess");
            
            JFile::Append("../.htaccess", $directive);
            
            DepotHelper::AddRewriteAll();
        }
    }

    //Replace la rececriture Global
    function AddRewriteAll()
    {
        $directive = JFile::GetFileContent("../.htaccess");
        $all = "RewriteRule ^([A-Za-z]+)\.html$ index.php?Page=$1 [L]";
        
        JFile::SetFileContent(str_replace($all, "", $directive));
        
        //Ajout à la fin
        JFile::Append("../.htaccess", $all);
    }
    
    /**
     * Ajoute le projet
     * @param type $core
     * @param type $app
     */
    function AddProjet($core, $app)
    {
        $projet = new  EeIdeProjet($core);
        $projet->Name->Value = $app;
        $projet->UserId->Value = $core->User->IdEntity;
        $projet->Save();
    }
    
    /*
     * Supprime un projet
     */
    function DeleteProjet($core, $app)
    {
        $projet = new EeIdeProjet($core);
        $projet->GetByName();
        $projet->Delete();
    }
    
    /**
     * Obtient les dépots de l'utilisateurs
     */
    public static function GetMyDepots()
    { 
        $folderName = dir("../Apps/");
        $folders = array();
        
       while($file = $folderName->read())
	  {
	   if(   ($file != ".") && ($file != "..") && ($file != "EeIde") && ($file != "EeInfo") 
              && ($file != "EeNotify")  && ($file != "EeBug") && ($file != "EeProfil") )
	   {
	     $folders[] = $file;
	   }
	  }
          
	  $folderName->close();
          
          return $folders;
    }
    
    /**
     * Supprime une dépot
     */
    public static function Delete($core, $depot)
    {
        $path = "../Apps/".$depot;
        
        //Suppression des lignes dans le htaccess
        $directive = JFile::GetFileContent("../.htaccess");
        $deleteDirective = JFile::GetFileContent("../Apps/".$depot."/Front/.htaccess");
        
        JFile::SetFileContent("../.htaccess", str_replace($deleteDirective,"" , $directive) );
        
         //TODO Il faudrait aussi supprimer les tables en base de donnée
        JFile::Delete( $depot."Front.php", "../");
        JFile::Delete( $depot.".tpl", "../Template/");
        
        //Supprime les tables de la base de donnée
        EntityHelper::DeleteTable($core, $depot);
        
        //TODO A corriger
        JFile::RemoveAllDir($path);
        
        if(!file_exists("../Apps/".$depot))
        {
            echo "<span class='success' >Le dépot ".$depot." à bien été supprimé</span>";
        }
 
        
        //Si le dépot est un projet on supprime aussi le projet
        $projet = new EeIdeProjet($core);
        $projet->AddArgument(new Argument("EeIdeProjet", "Name", EQUAL, $depot));
        $projets = $projet->GetByArg();
        
        if(count($projets) > 0)
        {
            $projets[0]->Delete();
        }
    }
    
    /*
     * Dépots des projets utilisateurs
     */
    public static function GetMyProjectDepots($core)
    {
        $projets = new EeIdeProjet($core);
        $projets->AddArgument(new Argument("EeIdeProjet", "UserId", EQUAL, $core->User->IdEntite));
        
        return $projets->GetByArg();
    }
}
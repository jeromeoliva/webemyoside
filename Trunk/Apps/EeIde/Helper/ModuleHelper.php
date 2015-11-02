<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 * Module d'aide pour les module 
 */
class ModuleHelper
{
   /**
    * Ajoute un module au projet
    * 
    * @param type $core
    * @param type $projet
    * @param type $name
    */
   public static function CreateModule($core, $projet, $name)
   {
         //Creation du repertoire du projet
	//$destination = "../Data/Apps/EeIde/".$projet."/Blocks/".$name."Block";
        $destination = EeIde::$Destination."/".$projet."/Blocks/".$name;
                
        if(!file_exists($destination))
        {
            //Creation du repertoire
             JFile::CreateDirectory($destination);
            
            //Copie des fichiers
            copy(EeIde::$Directory. '/Modele/Blocks/XXXBlock.php', $destination."/".$name.".php");
            
            //Remplace les noms
            self::ReplaceNameBlock($destination."/".$name.".php", $name);
            
            //Enregistre le module dans l'application
            self::RegisterBlock($core, $name, $projet);
            
            return true;
        }
        else
        {
            return false;
        }
   } 
   
   /**
    * Ajoute l'entité dans l'app
    * @param type $core
    * @param type $name
    * @param type $projet
    */
   public static function RegisterBlock($core, $name, $projet)
   {
       $content = JFile::GetFileContent("../Apps/".$projet."/".$projet.".php", false);
       $content = str_replace("/*block*/", "\r\t\tinclude_once(\"Blocks/".$name."/".$name.".php\");"."\r\n\t/*block*/", $content);

       JFile::SetFileContent("../Apps/".$projet."/".$projet.".php", $content);
   }
       
   /**
    * Remplace touts les noms des applications
    * */
    public static function ReplaceNameBlock($file, $name)
    {
           $content = JFile::GetFileContent($file);
           $content = str_replace("XXX", $name."", $content);

           //Enregistrement
           JFile::SetFileContent($file, $content);
    }
    
    /**
     * Ajoute une action à un module
     * @param type $projet
     * @param type $block
     * @param type $nameAction
     * @param type $addTemplate
     */
    public static function AddActionModule($projet, $block, $nameAction, $addTemplate)
    {
        //nom du fichier
        //$fileName = "../Data/Apps/EeIde/".$projet."/Blocks/".$block."/".$block.".php";
        $fileName = EeIde::$Destination."/".$projet."/Blocks/".$block."/".$block.".php";
        
        //Recuperation du contenu
        $content = JFile::GetFileContent($fileName);
        
        //Fin du fichier
        $EndFile = "/*action*/";
        
        $tab = "\t";
        $newLigne = "\r\n".$tab;
        
        $newContent .="$newLigne/*$newLigne*Expliquer la fonction de cette action$newLigne*/";
        $newContent .="$newLigne function ".$nameAction. "()";
        $newContent .="$newLigne{";
            
        if($addTemplate)
        {
           $newContent .= "$newLigne$tab %this->SetTemplate($projet::%Directory . \"/Blocks/$block/$nameAction.tpl\");";
           $newContent .= "$newLigne$tab %this->AddParameters(array('!monParametre' => '' ));";
           $newContent .= "$newLigne$tab return %this->Render();";
           
           //Repertoire de destination
           $destination = EeIde::$Destination."/".$projet."/Blocks/".$block."/";
           
           //On crée le nouveau fichier de template
           copy(EeIde::$Directory. '/Modele/Blocks/XXX.tpl', $destination."/".$nameAction.".tpl");
        }
               
        $newContent .="$newLigne}$newLigne";
        
        //Ajout de la fonction à la fin du fichier
        $newContent = str_replace($EndFile, $newContent.$EndFile, $content);
        $newContent = str_replace(chr(37), chr(36), $newContent);
        
        //Enregistrement de l'action 
        //On enregistre la nouvelle action à la fin du fichier
        JFile::SetFileContent($fileName, $newContent );
    }
}

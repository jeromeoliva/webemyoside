<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
class All 
{
    
    public static function GetMenu()
    {
        $html = "";
        
        return $html;
    }
    
    public static function GetDashBoard($core)
    {
        $html = "";
        
        $tabStrip = new TabStrip("tbWall");
        
        
         //Affichage des applications sous fomre de widget
        $apps = array("EeProjet", "EeNotify", "EeMessage", "EeAgenda");
        
        foreach($apps as $app)
        {
            
           $EeApp = Eemmys::GetApp($app, $core);
           
           $tabStrip->AddTab($app, new Libelle("je suis ".$EeApp->GetInfo()));           
           
           $html .= "</div>";
            
        }
        
        
        
        /*$tabStrip->AddTab("Wall", new Libelle("Le mur "));
        $tabStrip->AddTab("Les projets", new Libelle("Le mur "));
        $tabStrip->AddTab("Mes applications", new Libelle("Le mur "));
        */
        $html .=  $tabStrip->Show();
             
        return $html;
    }
    
}

<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
class Tester 
{
    /**
     * Obtien le menu d'un développeur
     */
    public static function GetMenu($core)
    {
        $html = "<ul class='alignLeft'>";
        $html .= "<li id='btnStart' ><img src='../Images/Icone/home.png' >&nbsp;".$core->GetCode("Home")."</li>";
        $html .= "<li id='btnNotify' ><img src='../Apps/EeNotify/Images/logo.png' >&nbsp;".$core->GetCode("Notify")."</li>";
        $html .= "<li id='btnProfil' ><img src='../Apps/EeProfil/Images/logo.png' >&nbsp;".$core->GetCode("MyProfil")."</li>";
        //$html .= "<li id='btnAnnoncer' ><img src='../Apps/EeAnnoncer/Images/logo.png' >&nbsp;".$core->GetCode("Annonces")."</li>";
        //$html .= "<li id='btnForm' ><img src='../Apps/EeForm/Images/logo.png' >&nbsp;".$core->GetCode("Enquete")."</li>";
    
        //  $html .= "<li id='btnProjet' ><img src='../Apps/EeProjet/Images/logo.png' >&nbsp;".$core->GetCode("MyProjet")."</li>";
      //  $html .= "<li id='btnContact' ><img src='../Apps/EeContact/Images/logo.png' >&nbsp;".$core->GetCode("MyContact")."</li>";
      //  $html .= "<li id='btnMessage' ><img src='../Apps/EeMessage/Images/logo.png' >&nbsp;".$core->GetCode("MyMessage")."</li>";
      //  $html .= "<li id='btnAgenda' ><img src='../Apps/EeAgenda/Images/logo.png' >&nbsp;".$core->GetCode("MyCalendar")."</li>";
        $html .= "<li id='btnApp' ><img src='../Apps/EeApp/Images/logo.png' >&nbsp;".$core->GetCode("Apps")."</li>";
    
    	$html .= "<li  ><a href='disconnect.php' class='icon-off blueOne' title='disconnect'></a></li>";
    
        $html .= "</ul>";
        return $html;
    }
    
    /*
     * Obtient le tableu de bord utilisateur
     */
    public static function GetDashBoard($core)
    {
        $html = "<div class='span12' id='dashBoard'><h2 class='icon-dashboard blueTwo'>&nbsp".$core->GetCode("MyDashBoard")."</h2><div>";
        
        $html .= "<div class='span12'> ";
        
        //Affichage des applications sous fomre de widget
        $apps = array("EeNotify", "EeMessage", "EeAnnoncer", "EeForm");
        
        foreach($apps as $app)
        {
            $html .= "<div class='widget span4'>";
            $html .= "<div class='title'>".$app;
            $html .= "<i class='icon-desktop launcher' onclick='Eemmys.StartApp(\"\", \"".$app."\")'></i>";         
            $html .= "</div>";
            
           $EeApp = Eemmys::GetApp($app, $core);
           $html .= $EeApp->GetInfo();
           
           $html .= "</div>";
            
        }
        
        $html .= "</div>";
        
        
        //Affichage des application de l'utilisateur
        $html .= "<div class='span12' ><h2 class='icon-desktop blueTree'>&nbsp".$core->GetCode("MyApp")."</h2></div>";
        $html .=  "<div class='span12' id='dvMyApp'>";
        
        //recuperation des app utilisateurs
        $eap = Eemmys::GetApp("EeApp", $core);
        $apps = AppHelper::GetByUser($core, $core->User->IdEntite);
       
        if(count($apps)> 0 )
        {
        
            foreach($apps as $app)
            {
                $img = new Image("../Apps/".$app->App->Value->Name->Value."/Images/logo.png");
                $img->Title = $img->Alt = $app->App->Value->Name->Value;
                $img->OnClick = "Eemmys.StartApp('', '".$app->App->Value->Name->Value."', '')";

                $icRemove = new Libelle("<b class='icon-remove' onclick='Eemmys.RemoveAppUser(\"".$app->IdEntite."\", this)'>&nbsp;</b>");
                $html .= "<div class='span1 app' >".$img->Show().$icRemove->Show()."</div>";
            }
        }
        else
        {
            $html .= $core->GetCode("EeApp.NoApp");
        }
        
        $html .= "</div> ";
        
        return $html;
    }
    
    /**
     * Obtient l'aide
     */
    public static function GetHelp($core)
    {
        $html ="";
        
        return $html;
    }
}

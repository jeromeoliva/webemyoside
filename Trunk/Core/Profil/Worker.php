<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
class Worker 
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
        $html .= "<li id='btnAnnoncer' ><img src='../Apps/EeAnnoncer/Images/logo.png' >&nbsp;".$core->GetCode("Annonces")."</li>";
        //$html .= "<li id='btnForm' ><img src='../Apps/EeForm/Images/logo.png' >&nbsp;".$core->GetCode("Enquete")."</li>";
    
          $html .= "<li id='btnProjet' ><img src='../Apps/EeProjet/Images/logo.png' >&nbsp;".$core->GetCode("Projet")."</li>";
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
        $html = "<div class='row' id='dashBoard'><h2 class='icon-dashboard blueTwo'>&nbsp".$core->GetCode("MyDashBoard")."</h2><div>";
        
        $html .= "<div class='row'> ";
        
        //Affichage des applications sous fomre de widget
        $apps = array("EeProjet", "EeAnnoncer", "EeForm");
        
        foreach($apps as $app)
        {
            $html .= "<div class='widget col-md-4'>";
            $html .= "<i class='icon-desktop launcher' onclick='Eemmys.StartApp(\"\", \"".$app."\")'></i>";         
           
            $html .= "<div class='title'>".$app;
            $html .= "</div>";
            
           $EeApp = Eemmys::GetApp($app, $core);
           $html .= $EeApp->GetInfo();
           
           $html .= "</div>";
            
        }
        
        $html .= "</div>";
        
        
        //Affichage des application de l'utilisateur
        $html .= "<div class='row' ><h2 class='icon-desktop blueTree'>&nbsp".$core->GetCode("MyApp")."</h2></div>";
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
                $html .= "<div class='col-md-2 app' >".$img->Show().$icRemove->Show()."</div>";
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
                if(!isset($_GET["new"]))
        {
            return "";
        }
        else
            {
                         $html ="
                       <ol id='joyRideTipContent'>

                          <li data-id='top' data-button='Suivant' data-options='tipLocation:top'>
                            <h2>Bienvenue</h2>
                            <p>Bonjour et merci d'avoir créé votre compte sur Webemyos. Faisons un petit tour des fonctionnalitées
                               afin que vous puissiez prendre en main cet outil.</p>
                          </li>
                          <li data-id='btnStart' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Le bureau</h2>
                            <p>Ce bouton vous permet de revenir sur votre bureau principal.</p>
                          </li>
                              <li data-id='btnNotify' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Les notifications</h2>
                            <p>Ce bouton vous permet de voir ce qui c'est passé pendant votre absence et les interactions avce les autres membres.</p>
                          </li>
                          <li data-id='btnProfil' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Mon profil</h2>
                            <p>Ce bouton permet de configurer votre profil. Un profil renseigné avec un photo est toujours plus agréable non ?</p>
                          </li>
                           <li data-id='btnProfil' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Mon profil</h2>
                            <p>Ce bouton permet de configurer votre profil. Un profil renseigné avec un photo est toujours plus agréable non ?</p>
                          <li data-id='btnApp' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Les applications</h2>
                            <p>Ce bouton permet d'accèder au catalogue d'application. Il est réguliérement mit à jour.</p>
                          </li>
                           <li data-id='dvMyApp' data-button='Suivant' data-options='tipLocation:right'>
                            <h2>Mes applicatiions</h2>
                            <p>Ici se trouve vos applications favorites, vous pouvez en ajouter en cliquant sur l'icone <b class='icon-pushpin'>&nbsp;</b> de chaque application.</p>
                          </li>


                          <li data-button='Suivant'>
                            <h2>Voila c'est fini</h2>
                            <p>La présentation est finie profitez pleinement de Webemyos!</p>
                          </li>
                        </ol>

                        <script type='text/javascript'>
                          $(window).load(function() {


                           $('#joyRideTipContent').joyride(
                            {postStepCallback : function (index, tip)
                                    {
                                if (index == 2)
                                     {
                                    $(this).joyride('set_li', false, 1);
                                     }
                                    }
                            });

                          }
                          );
                        </script>

                    ";

                    return $html ;
        }
    }
}

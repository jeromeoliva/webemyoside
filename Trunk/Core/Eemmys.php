<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/***
 * Moteur principale de la partie membre
 */
class Eemmys
{
  private $Core;

  /**
   * Constructeur
   */
  public function Eemmys($core)
  {
    $this->Core = $core;
  }

  /**
   * Démarrage de l'application
   */
  public function Start()
  {
   //Affichage du template de base
    $html = Eemmys::GetTemplate();
  
    //Initialisation des variables
    $html = Eemmys::InitTemplate($html, 
                                 array( '!pseudo' => $this->Core->User->GetPseudo(),
                                        '!script' => Eemmys::Load(),
                                        '!infoUser' => Eemmys::LoadInfoUser($this->Core),
                                        '!adminItem' => Eemmys::GetAdminItem($this->Core),
                                        '!joyride' => Profil::GetHelp($this->Core),
                                    )
             );      
            
    //Traduit les textes multilabngue   
    $html = Eemmys::SetLanguage($this->Core, $html,
                                array("!membre.dashboard",
                                      "!membre.myDashboard",
                                    "!membre.myProfil",
                                    "!membre.myProjets",
                                    "!membre.myAnnonces",
                                    "!membre.myForms",
                                    "!membre.myContacts",
                                    "!membre.myAgenda",
                                    "!membre.myCommunity",
                                    "!membre.myApplications",
                                    "!membre.myFile",
                                    "!membre.myDisconnect",
                                    )
            );
  
    echo $html;
  }

  /*
   * Récupere le template de la page;
   */
  public function GetTemplate()
  {
    return JFile::GetFileContent("../JHom/Template/Pages/member.tpl");
  }

  /**
   * Initialise le template avec les bon paramètres
   * 
   * @param type $parameter
   */
  public function InitTemplate($html, $parameters)
  {
      foreach($parameters as $key => $value)
      {
          $html = str_replace($key, $value, $html);
      }
      
      return $html;
  }
  
  /*
   * Obtient les onglet pour les administrateur
   */
  public static function GetAdminItem($core)
  {
      if($core->User->Email->Value == "jerome.oliva@gmail.com")
      {
          $html = "<li id='btnIde'>EeIde</li>";
          $html .= "<li id='btnAdmin'>EeAdmin</li>";
      
           return $html;
      }
  }
  
  
  /**
   * Traduit les textes multilangue
   * @param type $core
   * @param type $elements
   */
  public static function SetLanguage($core,$html, $elements)
  {
      foreach($elements as $element)
      {
           $html = str_replace($element, 
                               $core->GetCode(str_replace("!", "", $element)),
                               $html);
      }
      
      return $html;
  }
  
  /**
   * Obtient le nombre de notification 
   * @param type $core
   */
  public static function  GetInfoNotify($core)
  {
      $notify = self::GetApp("EeNotify" , $core);
      return $core->GetCode("Notifiy") . "(".$notify->GetCount().")";
  }
  
   /**
   * Obtient le nombre de notification 
   * @param type $core
   */
  public static function  GetInfoMessage($core)
  {
      $emessage = self::GetApp("EeMessage" , $core);
      return $core->GetCode("Message") . "(".$emessage->GetCount().")";
  }
  
  
  //Retourne l'image de fond
  public static function GetBackground()
  {
    include("../../../JHom/Core.php");

    return Core::GetUserBackGround();
  }

  /**
   * Récupére les outils des fenetres
   * */
  public function GetWindowTool($appName)
  {
    $textControl = "<i class='icon-pushpin' title='".$this->Core->GetCode("AddToMyDesktop")."' onclick='Eemmys.AddAppUser(\"".$appName."\")' id='btnAddDesktop'>&nbsp;</i>";
    $textControl .= "<i class='icon-desktop' title='".$this->Core->GetCode("Minimize")."' id='btnMinimize'>&nbsp;</i>";
    $textControl .= "<i class='icon-remove' title='".$this->Core->GetCode("Close")."' id='btnClose'>&nbsp;</i>";
    return $textControl;
  }

  /**
   * Retourne un élement multilingue dans la langue courante
   * */
  public function GetCode()
  {
    $code = JVar::GetPost("Code");
    echo $this->Core->GetCode($code);
  }

  /**
   * Récupere l'image de démarrage
   */
  public static function GetImageLoading()
  {
    $image = new Image("../Images/loading.gif");
    echo $image->Show();
  }

  /**
   * Charge le bureau avec les paramètres de l'utilisateur
   */
  public static function Load()
  {
    $textControl = JScript::GetJsBalise();
    $textControl = JFormat::Text($textControl, "Eemmys.Load();");
    return $textControl;
  }
  
  /**
   * Récupère les info utilisateur
   */
  public static function LoadInfoUser($core)
  {
      $Eprofil = Eemmys::GetApp("EeProfil", $core);
      return $Eprofil->GetProfil($core->User, "EemmysProfil");
  }       
  
  /**
   * Chargement de la barre d'outil
   */
  public function LoadTool()
  {
    //Div du menu
    $textControl = "<div id='dvMenu'>";
    $textControl .="<table style='height:200px:text-align:left;'>";

    //Ajout des onglets
    $textControl .= $this->AddItem("../Images/icones/parameter.png",$this->Core->GetCode("Parameter"),"EeParameter");
    $textControl .= $this->AddItem("../Images/icones/stockage.png",$this->Core->GetCode("Files"),"EeExplorer");
    $textControl .= $this->AddItem("../Images/icones/widget.png",$this->Core->GetCode("Widget"),"EeWidget");
    $textControl .= $this->AddItem("../Images/icones/application.png",$this->Core->GetCode("Application"),"EeApp");
    $textControl .= $this->AddItem("../Images/icones/profil.png",$this->Core->GetCode("MyProfil"),"EeProfil");
    $textControl .= $this->AddItem("../Images/icones/comunnity.png",$this->Core->GetCode("Comunity"),"EeComunity");

    //TODO
    $textControl .= $this->AddItem("../Images/icones/message.png",$this->Core->GetCode("MyMessage"),"EeMessage");
    $textControl .= $this->AddItem("../Images/icones/browser.png",$this->Core->GetCode("Browser"),"EeBrowser");

    $textControl .="</table>";
    //Deconnection
    $imgDeconnect = new Image("../Images/icones/deconnect.png");
    $imgDeconnect->Title = $this->Core->GetCode("Close");
    $textControl .= "<div class='RowClose' id='btnDeconnect''>".$imgDeconnect->Show()."</div>";

    $textControl .="</div>";
    //Info
     $textControl .="<div id='dvInfo'></div>";
    //Tchat
    $textControl .="<div id='dvTchat'></div>";

    //Div de la barre d'outil
    $textControl .= "<div id='toolBarr'>";
    $textControl .="<table style='width:100%'><tr>";

    //Logo pour demarrage
      $textControl .="<td id='tdTool'  style='width:25px'><img id='btnStart' src='../Images/logoMin.png' style='width:35px' title='demarrer'  ></td>";

  //Mes informations Profil, invitation, messages !!
  //Acces directes au programmes
  $textControl .="<td id='tdInfo' style='width:25px'><span class='icon-exclamation' id='btnInfo' title='Mes informations' > </td>";

  //Tchat
  //$imgTchat = new Image("Images/icones/tchat.png");
  //  $imgTchat->Id = "btnTchat";
   // $imgTchat->Title = $imgInfo->Alt = $this->Core->GetCode("Tchat");
  //$textControl .="<td id='tdTchat' style='width:25px'>".$imgTchat->Show()."</td>";

  //Ajout de widgets
  $textControl .="<td id='tdTchat' style='width:25px'><span class='icon-plus' id='btnAddWidget' title='Ajouter des gadgets' /></td>";

  //Ajout d'application
  $textControl .="<td id='tdTchat' style='width:25px'><span class='icon-plus-sign' id='btnAddApp' title='Ajouter des applications' /></td>";

  //Pour le compte de demo on eut se créer son propore compte
  if($this->Core->User->IdEntite == 37)
  {
    $Libelle = "<span style='color:white;'>WebEmyos me plait je crée mon compte : </span>";
    $btnCreateCompte = new Link("Je crée mon compte", "#");
    //$btnCreateCompte->CssClass = "btn btn-success";
    $btnCreateCompte->AddStyle("color","white");
    $btnCreateCompte->Value = 'Créer mon compte';
    $btnCreateCompte->OnClick = "Eemmys.CreateCompte();";

  	$textControl .="<td id='tdCreatCompte' >".$Libelle.$btnCreateCompte->Show()."</td>";
  }
  $textControl .="<td  id='tdApp' style='text-align:left'></td>";
  $textControl .= "<td  text-align:right'><span class='icon-cloud' style='padding-right:15px'><i>&nbsp;&nbsp;Webemyos - Créons le web de demain!</i></span></td>";
   $textControl .="</tr></table>";

   $textControl .= "</div>";
   echo $textControl;
  }

  /**
   * Ajoute un item au menu
   */
  private function AddItem($image, $title, $app)
  {
    $textControl = "<tr id='".$app."'>";
    //Chargement de l'image
    $image = new Image($image);
    $image->Title = $title;
    $textControl .= "<td>".$image->Show()."</td>";
    $textControl .= "<td style='text-align:left;''>".$title."</td>";

    $textControl .="</tr>";

    return  $textControl;
  }

  /**
   * Charge les applications
   * */
  public function LoadApp()
  {
    //Recuperation des app utilisateurs
    $EeApp = Eemmys::GetApp("EeApp", $this->Core);
    $Apps = $EeApp->GetUserApp();

    $numberApp = 0;
    $numberBlockApp = 0;
  $idBlockApp = 0;

    $TextControl = "";

    foreach($Apps as $app)
    {
      if($numberBlockApp == 0)
      {
        //Premier did appli par defaut
        if($idBlockApp == 0)
        {
          $class = "class='blockAppSelected'";
          $style= "";
        }
        else
        {
          $class = '';
          $style= "style='display:none;'";
        }

        $TextControl .= "<div id='blockApp_$idBlockApp' $class $style><table>";
      }

      if($numberApp == 0)
      {
        $TextControl .= "<tr>";
      }

      //Recuperation du logo
      $img = new Image("../Apps/".$app."/images/logo.png");
      $img->Id = $app;
      $img->Title = $app;

      $TextControl .= "<td id='".$app."'>".$img->Show();
      $TextControl .= "<br/><span>".$app."</span>";
      $TextControl .= "</td>";
      $numberApp++;

      if($numberApp == 2)
      {
        $TextControl .= "</tr>";
        $numberApp = 0;
      }

      $numberBlockApp++;

      if($numberBlockApp == 16)
      {
        $TextControl .= "</table></div>";
        $numberBlockApp = 0;
        $idBlockApp++;
      }
    }

    if($numberBlockApp < 16)
  {
      $TextControl .= "</table>";
  }

  $dvAction = "<table id='control'><tr>";
    $imgAfter = new Image("../Images/icones/after.png");
    $imgAfter->Title = $this->Core->GetCode("AppAfter");
    $imgAfter->OnClick = 'Eemmys.LoadAppAfter();';
  $dvAction .= "<td>".$imgAfter->Show()."</td>";

   $imgBefore = new Image("../Images/icones/before.png");
   $imgBefore->Title = $this->Core->GetCode("AppBefore");
   $imgBefore->OnClick = 'Eemmys.LoadAppBefore();';
   $dvAction .= "<td>".$imgBefore->Show()."</td>";

   $dvAction .= "</tr></table>";

    echo $dvAction.$TextControl;
  }

  /**
   * Charge les applications
   * */
  public function LoadWidget()
  {
    //Recuperation des widget utilisateurs
    $EeWidget = Eemmys::GetApp("EeWidget", $this->Core);
    $Widgets = $EeWidget->GetUserWidget();

    $numberWidget = 0;
    $numberBlockWidget = 0;
  $idBlockWidget = 0;

  $TextControl = '';

    foreach($Widgets as $widget)
    {
        if($numberBlockWidget == 0)
        {
          //Premier did appli par defaut
          if($idBlockWidget == 0)
          {
            $class = "class='blockWidgetSelected'";
            $style= "";
          }
          else
          {
            $class = '';
            $style= "style='display:none;'";
          }

          $TextControl .= "<div id='blockWidget_$idBlockWidget' $class $style><table><tr>";
      }

      //Recuperation du logo
      $img = new Image("../Widgets/".$widget."/images/logo.png");
      $img->Id = $widget;
      $img->Title = $widget;

      $TextControl .= "<td id='".$widget."'>".$img->Show();
      $TextControl .=  "<br/><span>".$widget."<span>";
      $TextControl .=	"</td>";

      $numberWidget++;
      $numberBlockWidget++;

      if($numberWidget == 6)
      {
        $TextControl .= "</tr></table></div>";
        $numberBlockWidget = 0;
        $numberWidget = 0;
        $idBlockWidget++;
      }
  }

    if($numberBlockWidget < 6)
  {
      $TextControl .= "</table></div>";
  }

     $dvAction = "<span id='control'><div class='widgetAfter'>";
    $imgAfter = new Image("../Images/icones/after.png");
    $imgAfter->Title = $this->Core->GetCode("WidgetAfter");
    $imgAfter->OnClick = 'Eemmys.LoadWidgetAfter();';
  $dvAction .= $imgAfter->Show()."</div>";

   $imgBefore = new Image("../Images/icones/before.png");
   $imgBefore->Title = $this->Core->GetCode("WidgetBefore");
   $imgBefore->OnClick = 'Eemmys.LoadWidgetBefore();';
   $dvAction .= "<div class='widgetBefore'>".$imgBefore->Show()."</div>";


    echo  $TextControl.$dvAction;
  }

  /**
   * Charge les élements multiluange
   */
  public function LoadLanguage()
  {
    echo $this->Core->GetAllCode();
  }

  /**
   * Charge les applications
   * */
  public function LoadNew()
  {
    echo Profil::GetDashBoard($this->Core);
  }
  
  /**
   * Démarre l'application
   * */
  public function StartApp()
  {
    $parametre = explode(":", JVar::GetPost("Parameter"));
    $appName = $parametre[1];
    $url = JVar::GetPost("Url");

    //Ajout d'une statistique
    Stat::Add($this->Core, '', $appName);

    //Ajouter un point pour le concours
    //	UserAvantage::AddPoint($this->Core, UserAvantage::TEST_PROTO, 3, $appName);

    //Inclusion des classe nescessaire
    include("../Core/Config.php");
    include("../Core/PlugIn.php");
    include("../Core/Application.php");
    include("../Core/EeGame.php");

    if($url)
    {
      include("$url/$appName.php");
    }
    else
    {
      include("../Apps/$appName/$appName.php");
    }

    $app = new $appName($this->Core);
    $app->Url = $url;

    $app->Run();
  }

  /**
   * Instancie et retourne l'application
   */
  public function GetApp($appName, $core)
  {
      if(!class_exists("Config"))
      include("../Core/Config.php");

    if(!class_exists("PlugIn"))
      include("../Core/PlugIn.php");

    if(!class_exists("Application"))
        include("../Core/Application.php");

    if(!class_exists($appName))
    {
     if(file_exists("../Apps/$appName/$appName.php"))
     {
        include_once("../Apps/$appName/$appName.php");
     }
     //C'est dans une ide
     else
     {
        include_once("../Data/Apps/EeIde/$appName/$appName.php");  
     }
    }

    $app = new  $appName($core);

    return $app;
  }
/**
   * Instancie et retourne l'application
   */
  public function GetAppFront($appName, $core)
  {
    if(!class_exists("Config"))
      include("Core/Config.php");

    if(!class_exists("PlugIn"))
      include("Core/PlugIn.php");

    if(!class_exists("Application"))
        include("Core/Application.php");

    if(!class_exists($appName))
    {
        include("Apps/$appName/$appName.php");
    }
    
    $app = new  $appName($core);

    return $app;
  }
  
  public function StartWidget()
  {
    $parametre = explode(":", JVar::GetPost("Parameter"));
    $widget = $parametre[1];

  //Ajout d'une statistique
  Stat::Add($this->Core, '', '', $widget);

    //Inclusion des classe nescessaire
    include("../Core/Config.php");
    include("../Core/PlugIn.php");

    include("../Core/Widget.php");

    include("../Widgets/$widget/$widget.php");

    $wid = new  $widget($this->Core);
    $wid->Run();
  }

  /**
   * Retourne differents type d'info
   * */
  public function GetInfo()
  {
     $source = JVar::GetPost('Source');
	 $type = rand(0, 5);
    //Todo a suuprimer
    //$type = 5;

    //TEST
    if($type == 3)
    {
      $type = 1;
    }

  if(($type < 4 ) && $source == 'front')
  {
    $type = 4;
    $front = true;
  }
  else
  {
    $front = false;
  }

    $TextControl = "";

    switch($type)
    {
      //News
      case 0:
        //$TextControl .= "<h4>".$this->Core->GetCode("News")."</h4>";
        //Recuperation des news
        $News = new News($this->Core);
        $News->AddOrder("DateCreate");
        $news = $News->GetAll();

        //Affichage de la news prinipale en grand
        $TextControl .= "<div class='news'>";
        $TextControl .="<h3>".$this->Core->GetCode("NewsDay")."</h3>" ;
        $TextControl .="<table>";
        $TextControl .= "<tr class='ligneentete'><td><h5>".$news[0]->DateCreate->Value."</h5></td><td><b>".$news[0]->Title->Value."<b></td></tr>";
        $TextControl .= "<tr><td colspan='2'>".$news[0]->Libelle->Value."</td></tr>";
        $TextControl .="</table>";
        $TextControl .= "<div>";

      break;
      // Contact
      // A Afffiner avec les amis des amis
      // ou Des membre de même affinité
      case 1:
        $TextControl.= "<h4>".$this->Core->GetCode("Contact")."</h4>";

        //recuperation idMin et max
        $request = "select min(id) as min from ee_user";
        $min = $this->Core->Db->GetLine($request);
        $request = "select max(id) as max from ee_user";
        $max = $this->Core->Db->GetLine($request);

        $userId = rand($min["min"], $max["max"]);

        if($this->Core->User->IdEntite == $userId)
        {
            $userId = 36 ;
        }

        $profilBlok = new ProfilBlock($this->Core, $userId,  false, CONTACTS, TRUE);
        $TextControl.= $profilBlok->Show();
      break;
      //Comunauté
      case 2:
        $TextControl.= "<h4>".$this->Core->GetCode("Comunity")."</h4>";

        $Comunity = new Comunity($this->Core);
        $comunityId = rand(1, $Comunity->GetNumber());

        $Comunity->GetById($comunityId);

        if($source == 'front')
    {
      $imgUrl = '/Membres/'.$Comunity->GetImageMini();
    }
    else
    {
      $imgUrl = $Comunity->GetImageMini();
    }

    $img = new Image($imgUrl );

        $img->AddStyle("width","50px");

        $TextControl.= "<table><tr><td>".$img->Show()."</td><td>".$Comunity->Name->Value."</td></tr></table>";

      break;
      //Publicité
      case 3:
        $TextControl.= "<h4>".$this->Core->GetCode("Pub")."</h4>";
      break;
      //Application
      case 4:
        $Application = new Apps($this->Core);
        $ApplicationId = rand(1, $Application->GetNumber());
        $Application->GetById($ApplicationId);

        $TextControl.= "<h4>".$this->Core->GetCode("Application")." : " .$Application->Code->Value."</h4>";

        if($source == 'front')
    {
      $img = new Image("Apps/".$Application->Code->Value."/images/logo.png");

      $linkApp =  new Link($this->Core->GetCode("ReadFiche"),"Applications-".$Application->Code->Value.".html");
      $linkApp->CssClass = "art-button";
      $btnApp = "<tr><td colspan='2' style='text-align:right'>".$linkApp->Show()."</td></tr>";
    }
    else
    {
      $img = new Image("../Apps/".$Application->Code->Value."/images/logo.png");
      $btnApp ='';
    }

        $TextControl.= "<table><tr class='ligneentete'><td>".$img->Show()."</td><td>".$Application->Libelle->Value."</td></tr>".$btnApp."</table>";



      break;
      //Gadget
      case 5:
        $Widget = new Widgets($this->Core);
        $WidgetId = rand(1, $Widget->GetNumber());
        $Widget->GetById($WidgetId);

        $TextControl.= "<h4>".$this->Core->GetCode("Widget")." : " .$Widget->Code->Value. "</h4>";

     if($source == 'front')
    {
      $img = new Image("Widgets/".$Widget->Code->Value."/images/logo.png");

      $linkWidget =  new Link($this->Core->GetCode("ReadFiche"),"Widgets-".$Widget->Code->Value.".html");
      $linkWidget->CssClass = "art-button";
      $btnWidget = "<tr><td colspan='2' style='text-align:right'>".$linkWidget->Show()."</td></tr>";
    }
    else
    {
        $img = new Image("../Widgets/".$Widget->Code->Value."/images/logo.png");
    	$btnWidget = "";
    }
        $TextControl.= "<table><tr class='ligneentete'><td>".$img->Show()."</td><td>".$Widget->Libelle->Value."</td></tr>".$btnWidget."</table>";
      break;


    }
    echo $TextControl;
  }

  /**
   * Retounre l'utilisateur
   */
  function GetUser()
  {
    $user = $this->Core->User;

    $userText = "!".$user->Name->Value;
    $userText .= ','.$user->FirstName->Value;
    $userText .=','.$user->Email->Value."!";

    echo $userText;
  }

  /**
   * Connection avec un compte de demo
   */
  function ConnectDemo()
  {
     $user = new User($this->Core);
    $user->GetById(37);
    JVar::Connect($user, $user->GroupeId , $this->Core);
  }

  /**
   * Pop in de creation de compte
   */
  function AskCreateCompte()
  {
	//JVar::Disconnect($this->Core);
	$registrationBlock = new RegistrationBlock($this->Core,'', '../index.php', false);
	echo $registrationBlock->Show();
  }

  function DoAction()
  {
  	return 'hh';
  }

  
  
  /*
  * Popin de connection facebook
  */
  function GetPopInFacebook()
  {
  	//Recuperation de l'url
  	$url = base64_decode(JVar::GetPost('url'));
	//$url = "auth.php?code=toto";
  	
  	//Ajout de l'iframe
  	$TextControl = "<iframe src='$url' style='width:100%;height:400px'></iframe>";
  	
  	//Ajout du boutton
  	$btnClose = new Button(BUTTON);
  	$btnClose->CssClass='art-button';
  	$btnClose->Value = "Fermer";
  	$btnClose->OnClick = "Eemmys.LoadDesktop()";
  	
  	$TextControl .= "<br/>". $btnClose->Show();
  	
  	echo $TextControl;
  }
  
  /*
  * Affiche un module de création de projet
  */
  function ShowCreateProject()
  {
  	$registrationBlock = new RegistrationBlock($this->Core,"","",false, true);
	
	echo $registrationBlock->Show();
  }
}

?>
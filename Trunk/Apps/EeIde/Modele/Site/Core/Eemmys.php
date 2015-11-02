<?php
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

    // Pour ajouter des codes du mulilingue
    //$this->Core->GetCode("ConfirmSendInvitation");
  }

  /**
   * Démarrage de l'application
   */
  public function Start()
  {
    //Affichage du template de base
    $textControl = Eemmys::GetTemplate();
    $textControl = str_replace("!script", Eemmys::Load(),$textControl);

    if($this->Core->User->IdEntite == 37 || isset($_GET['new']))
    {
      $textControl = str_replace("!dvDemo", Eemmys::LoadDemo(),$textControl);
    }
    // Réponse à un questionnaire
    else if(JVar::Get("form") != "")
    {
       $EeForm = Eemmys::GetApp("EeForm",$this->Core);
       
    	//TODO verifier que l'utilisateur n'a pas deja répondu au questionnaire
    	if($EeForm->HaveReponse(JVar::Get("form")))
    	{
    		   $textControl = str_replace("!dvDemo", Eemmys::LoadDemo(),$textControl);
    	}
    	else
    	{
   		      $textControl = str_replace("!dvDemo", "<script type='text/javascript' >Eemmys.ShowForm(".JVar::Get("form").")</script>",$textControl);
    	}
    }
    //Inscription afin de créer un projet
    else if(isset($_GET['projet']))
    {
    	//recuperation  du premier projet de l'utilisateur afin de le charger
    	 $EeProjet = Eemmys::GetApp("EeProjet",$this->Core);
      	 $projets = $EeProjet->GetProjets();
      
         $textControl = str_replace("!dvDemo", Eemmys::LoadDemoProjet($projets[0]->IdEntite),$textControl);
    }
    else
    {
      $textControl = str_replace("!dvDemo", '',$textControl);
    }

    //Ajout du style
    $parameter = new EeParameter($this->Core);
    $skin = $parameter->GetUserParameter(1);

    $Parameter = new ParameterElement($this->Core);
    $Parameter->GetById($skin);
    $textControl = str_replace("!style", $Parameter->Libelle->Value,$textControl);

    echo $textControl;
  }

  /*
  * Charge les élements de démo
  */
  public function LoadDemo()
  {
 $TextControl ="
   <ol id='joyRideTipContent'>
      <li data-id='bntProfil' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 1</h2>
        <p>Pour configurer votre profil c'est ici.</p>
      </li>
      <li data-id='btnProfil' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 1</h2>
        <p>Pour configurer votre profil c'est ici.</p>
      </li>
      <li data-id='btnProfil' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 2</h2>
        <p>D'ici vous pourrez gérer vos documents et fichiers importants.</p>
      </li>
       <li data-id='btnWidget' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 3</h2>
        <p>Accédez rapidement à vos gadgets</p>
      </li>
      <li data-id='btnExplorer' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 3</h2>
        <p>Accèdez rapidement à vos gadgets.</p>
      </li>
      <li data-id='btnWidget' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 4</h2>
        <p>Accédez rapidement à vos applications.</p>
      </li>
      </li>
      <li data-id='btnApp' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 5</h2>
        <p>D'ici vous pourrez parametrer votre bureau.</p>
      </li>
         <li data-id='btnParameter' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 6</h2>
        <p>D'ici vous pouvez accédez à vos communautés.</p>
      </li>
      </li>
      <li data-id='btnComunity' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Etape 7</h2>
        <p>Consultez vos messages de toutes vos boites de réception.</p>
      </li>
      <li data-id='btnStart' data-button='Suivant' data-options='tipLocation:top'>
        <h2>Etapes 8</h2>
        <p>Accédez rapidement à vos informations</p>
      </li>
     <li data-id='btnInfo' data-button='Suivant' data-options='tipLocation:top'>
        <h2>Etapes 9</h2>
        <p>Ajoutez des gadgets.</p>
      </li>
      <li data-id='btnAddWidget' data-button='Suivant' data-options='tipLocation:top'>
        <h2>Etape 10</h2>
        <p>Ajoutez des applications.</p>
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

	return $TextControl;

  }
  
  /*
  * Charge la demonstration d'un EeProjet
  */
  public function LoadDemoProjet($idProjet)
  {
  	 $TextControl =" <ol id='joyRideTipContent'>
      <li data-id='btnStart' data-class='so-awesome' data-text='Suivant' class='custom'>
        <h2>Merci d'avoir déposer votre projet sur Webemyos</h2>
        <p>Prenons les temps de découvrir cet outil et ces fonctionnalitées.</p>
      </li>
      <li data-id='lstProject' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Vos projets</h2>
        <p>Ici se trouve vos projets, un clique dessus et il se charge dans la partie centrale.</p>
      </li>
      <li data-id='vindex_1' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Les projets partagés</h2>
        <p>Ici se trouve les projets que les membres ont partagés avec vous.</p>
      </li>
      <li data-id='index_0' data-button='Suivant' data-options='tipLocation:bottom'>
        <h2>Les onglets</h2>
        <p>Ici se trouvent les différents onglets qui vous permettent de naviguer entre tout les outils.</p>
      </li>
      <li data-id='IdeeProjetprojetAstuce' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Les astuces</h2>
        <p>Retrouvez ici toutes les astuces et des conseils dans chaques étapes de réalisation de votre projet</p>
      </li>
      <li data-id='IdeeProjetprojetPartenaire' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Les partenaires</h2>
        <p>Besoins de parternaires vous les retrouverez ici.</p>
      </li>
      <li data-id='IdeeProjetprojetPrestataire' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Les prestataires</h2>
        <p>Ici se trouvent les prestataires regroupés par thématiques.</p>
      </li>
      <li data-id='IdeeProjetprojetInformation' data-button='Suivant' data-options='tipLocation:right'>
        <h2>Les outils</h2>
        <p>Ici se trouvent les outils.</p>
      </li>
      <li data-button='Suivant'>
        <h2>Voila c'est fini</h2>
        <p>La présentation est finie profitez pleinement de Webemyos!</p>
      </li>
    </ol>
    <script type='text/javascript'>
    window.setTimeout('Eemmys.StartApp(\"\",\"EeProjet\")', 500);
    window.setTimeout('EeProjetAction.LoadProjet(".$idProjet.")', 1000);
    
    
      $(window).load(function() {
   
   
        $('#joyRideTipContent').joyride({postStepCallback : function (index, tip) {

          if (index == 2) {
//            $(this).joyride('set_li', false, 1);
          }
        }});
      });
    </script>

";

return $TextControl;
  	
  
  }
  

  /*
   * Récupere le template de la page;
   */
  public function GetTemplate()
  {
    return JFile::GetFileContent("../JHom/Template/Pages/member.tpl");
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
  public function GetWindowTool()
  {
    $textControl = "<img src='../Images/icones/minimize.png' alt='minimize' title='".$this->Core->GetCode("Minimize")."' id='btnMinimize'>";
    //$textControl .= "<img src='../Images/icones/maximize.png' alt='maximize' title='".$this->Core->GetCode("Maximize")."' id='btnMaximize'>";
    $textControl .= "<img src='../Images/icones/close.png' alt='close' title='".$this->Core->GetCode("Close")."' id='btnClose'>";
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
    $textControl = Script::GetJsBalise();
    $textControl = Format::Text($textControl, "Eemmys.Load();");
    return $textControl;
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
    $textControl .="<table><tr>";

    //Logo pour demarrage
       $textControl .="<td id='tdTool'><span id='btnStart' class='icon-home' tilte='demarer'></span></td>";

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
	$Libelle = "<span style='color:blue;'>WebEmyos me plait je crée mon compte : </span>";
    $btnCreateCompte = new Button(BUTTON);
    $btnCreateCompte->Value = 'Créer mon compte';
    $btnCreateCompte->OnClick = "Eemmys.CreateCompte();";

  	$textControl .="<td id='tdCreatCompte' >".$Libelle.$btnCreateCompte->Show()."</td>";
  }

  $textControl .="<td  id='tdApp'></td>";
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
    //Recuperation des news
    $News = new News($this->Core);
    $News->AddOrder("DateCreate");
	$News->AddArgument(new Argument("News","TypeId", NOTEQUAL,  "1" ));

    $news = $News->GetByArg();

    //Affichage du tableau de bord utilisateur
    $TextControl = "<table><tr style='vertical-align:top;'><td>";
    $TextControl .= "<div class='info'>";
    $TextControl .= "<h3>".$this->Core->GetCode('MyInfo')."<i class='icon-exclamation iconeTitle' ></i></h3>";

    $EeInfo = Eemmys::GetApp("EeInfo",$this->Core);
    $TextControl .= "<div style='text-align:left'>".$EeInfo->GetInfoUser()."</div>";
    $TextControl .= "</div></td>";

   //News Partie utilisateur
   $TextControl .= "<td><div class='info'>";
   $TextControl .="<h3>".$this->Core->GetCode("NewsDay")."<i class='icon-star iconeTitle' ></i></h3>" ;
   $TextControl .="<table>";
  
   $popUp = new Popup("News", "Show");
   $popUp->AddArgument("idEntite", $news[0]->IdEntite);
   $popUp->Title = $this->Core->GetCode("Detail");
   
   $TextControl .= "<td ><h5 class='icon-star'>".$news[0]->DateCreate->Value."</h5></td><td><b>".$news[0]->Title->Value."<b></td>";
   
   $lkNew= new Link(substr($news[0]->Libelle->Value,0,10)." ...", "#");
   $lkNew->CssClass = 'blue';
   $lkNew->OnClick = $popUp;
   
   $TextControl .= "<td>".$lkNew->Show()."</td></tr>";


     $TextControl .="</table>";
   $TextControl .="</div></td>";

   //Commuanuté des projets
	$EeProjet = Eemmys::GetApp("EeProjet",$this->Core);
   	$idProjet = $EeProjet->GetIdProjetRand($this->Core);

	$projet = new EeProject($this->Core);
	$projet->GetById($idProjet);

	$TextControl .= "<td rowspan='2'><div class='infoProject'>";
    $TextControl .= "<h3>".$this->Core->GetCode('NewsOfProject')."<i class='icon-comment iconeTitle' ></i></h3>";
    $TextControl .= "<h4>".$this->Core->GetCode('ProjetName')." : " .$projet->Title->Value. "</h4>";

	//
    $EeInfo = Eemmys::GetApp("EeComunity",$this->Core);
	//todo recupere le nom du projet
	//$TextControl
    $TextControl .= $EeInfo->GetByProjet($idProjet);
    $TextControl .= "</div></td></tr>";

    //Nouveau projet à découvrir
    $TextControl .= "<tr style='vertical-align:top'><td><div class='info'>";
    $TextControl .= "<h3>".$this->Core->GetCode('NewProject')."<i class='icon-qrcode iconeTitle' ></i></h3>";

    $EeProjet = Eemmys::GetApp("EeProjet",$this->Core);
    $TextControl .= $EeProjet->GetProject();

    $TextControl .= "</div></td>";

	//Nouveau formulaire à répondre
	$TextControl .= "<td><div class='info'>";
    $TextControl .= "<h3>".$this->Core->GetCode('NewForm')."<i class='icon-edit-sign iconeTitle' ></i></h3>";
    $EeInfo = Eemmys::GetApp("EeForm",$this->Core);
    $TextControl .= $EeInfo->GetForm();
    $TextControl .= "</div></td>";

	$TextControl .= "</tr></table>";

    echo $TextControl;
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
	UserAvantage::AddPoint($this->Core, UserAvantage::TEST_PROTO, 3, $appName);

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
      include("../Apps/$appName/$appName.php");

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

  //Inclue les entité pour les projets
  function IncludeClassProject()
  {
		include('../Apps/EeProjet/Entity/eeProject.php');
		include('../Apps/EeProjet/Entity/eeProjectCategory.php');
		include('../Apps/EeProjet/Entity/eeProjectAstuce.php');
		include('../Apps/EeProjet/Entity/eeProjectPartenaire.php');
		include('../Apps/EeProjet/Entity/eeProjectBesoin.php');
		include('../Apps/EeProjet/Entity/eeProjectValeur.php');
		include('../Apps/EeProjet/Entity/eeProjectChiffre.php');
		include('../Apps/EeProjet/Entity/eeProjectConcurrent.php');
		include('../Apps/EeProjet/Entity/eeProjectProduitService.php');
		include('../Apps/EeProjet/Entity/eeProjectFinanceur.php');
		include('../Apps/EeProjet/Entity/eeProjectUserPartenaire.php');
		include('../Apps/EeProjet/Entity/eeProjectStrategie.php');
		include('../Apps/EeProjet/Entity/eeProjectPrototype.php');
  }

  /*
  * Affiche les detail d'un projet
  */
  function ShowProject($show= true, $jsObject = "Home")
  {
  	//self::IncludeClassProject();
	include('Core/Application.php');
	include_once('Core/Config.php');
	include_once('Core/PlugIn.php');
	include_once('Core/Widget.php');

	include('Apps/EeProjet/EeProjet.php');
	include('Apps/EeProjet/Entity/eeProject.php');
	include('Apps/EeProjet/Entity/eeProjectBesoin.php');
	include('Apps/EeProjet/Entity/eeProjectValeur.php');
	include('Apps/EeProjet/Entity/eeProjectPrototype.php');
		
	$Projets = new eeProject($this->Core);
	$Projets->addArgument(new Argument("eeProject","Actif", EQUAL , "1"));
	$projets = $Projets->GetByArg();

	$eProjet = new EeProjet($this->Core);
	
	$TextControls =  "<div style='width:800px;height:600px;overflow:auto'>" ;
	$TextControls = "<span style='float:left;width:10%' title = ".$this->Core->GetCode('PreviousProjet')." onclick='".$jsObject.".PreviousProjet();'  id='previousProjet' class='label green'> < </span>";
	$i =0;
	
	foreach($projets as $projet)
	{
		if($i==0)
		{
			$style="";
		}
		else
		{
			$style="display:none";
		}
		$TextControls .= "<span style='".$style.";float:left;width:80%' id='Projet_".$i ."' >".$eProjet->ShowProjet($projet->IdEntite, false, false)."</span>";
		
		$i++;
	 
	}

	$TextControls .= "<span style='float:right;width:10%;' title = ".$this->Core->GetCode('NextProjet')." onclick='".$jsObject.".NextProjet();' id='nextProjet' class='label green'> > </span>";
	

	$TextControls.= "</div>";
	
	if($show)
	{
		echo $TextControls;
	}
	else
	{
		return $TextControls;
	}
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
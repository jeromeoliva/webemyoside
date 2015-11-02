<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
 * Application de gestion des informations
 **/
class EeInfo extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';

	/**
	 * Constructeur
	 * */
	 function EeInfo($core)
	 {
	 	parent::__construct($core, "EeInfo");
	 	$this->Core = $core;

	 	//if(!class_exists("ComunityCategoryBlock"))
		//	include("ComunityCategoryBlock.php");
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		$textControl = parent::Run($this->Core, "EeInfo", "EeInfo");

		//Recuperation des parametres
		$params = Serialization::Decode(JVar::GetPost("params"));

		if(isset($params['Type']) && $params['Type'] == 'All')
		{
			//$textControl .= $this->GetInfoUser();
			$textControl = str_replace("!infoTextAccueil", $this->GetInfoUser(), $textControl);

			echo $textControl;
		}
		else
		{
			//Recuperation du Data Text
			$DataText = new DataText($this->Core);
			$DataText->GetByCode("MessagePresentation");

			//Creation du text d'accueil avec la possibilité d'ouvrir les première application
			$TextAccueil = "<h2 class='VTabStripEnabled active' style='width:100%'>".$DataText->Title->Value."</h2>";

			//Initialisation du text
			$TextAccueil .= $DataText->Text->Value;

			//Ajout des boutons
			$apps = array("EeParameter", "EeProfil", "EeExplorer", "EeWidget", "EeApp", "EeMessage", "EeWidget", "EeBrowser", "EeComunity", "EeProjet");

			foreach($apps as $app)
			{
				$btnApp = new Button(BUTTON);
				$btnApp->Value = $this->Core->GetCode("Lanch"). " ".$app;
				$btnApp->CssClass = "btn btn-success";
				$btnApp->OnClick = "EeInfo.StartApp('".$app."')";

				$TextAccueil = str_replace("{btn".$app."}", $btnApp->Show(), $TextAccueil);
			}
			
		 	//EeProjet
		 	$projet = Eemmys::GetApp('EeProjet', $this->Core);
			
			//Utilisateur qui a un projet
			if($projet->UserHave())
			{
				$TextAccueil .= "<br/><br/><h2 class='VTabStripEnabled active' style='width:100%'>Votre projet</h2><br/><br></br>";
				
				//Image
				$img = new Image("../Images/porteurProjet.png");
				$img->Title = $this->Core->getCode("YourProjet");
				
				$TextAccueil .="<div style='float:left'>".$img->Show()."</div>";
				$TextAccueil .= $this->Core->GetCode("AccueilProjet");
			
				//Bouton EeProjet	
				$btnEeProjet = new Button("BUTTON");
				$btnEeProjet->CssClass = "btn btn-success";
				$btnEeProjet->Value =  "Lancer EeProjet";
				$btnEeProjet->AddStyle("width","200px" );
				$btnEeProjet->AddStyle("height","50px" );
				
				$btnEeProjet->OnClick = "Eemmys.StartApp('EeProjet','EeProjet')";
		
			//	$TextAccueil .= "<br/>".$btnEeProjet->Show(); 
			}
			else
			{
				$TextAccueil .= "<h2 class='VTabStripEnabled active' style='width:100%' >Devenez les acteurs du web de demain .....</h2><br/><br/><br/>"; 
				
				//Image
				$img = new Image("../Images/porteurProjet.png");
				$img->Title = $this->Core->getCode("YourProjet");
				
				$TextAccueil .="<div style='float:left'>".$img->Show()."</div>";
				$TextAccueil .= $this->Core->GetCode("AccueilProjetUser");
			}
		
			$textControl = str_replace("!infoTextAccueil", $TextAccueil, $textControl);
		 	
		 	echo $textControl;
		}
	 }

	/**
	 * Recupere les informations d'une application ou d'un widget
	 */
	function About()
	{
		//Recuperation du nom
		$name = JVar::GetPost("AppWidget");

		//Application
		if(file_exists("../Apps/$name/$name.php"))
		{
			include("../Apps/$name/$name.php");

			$TextControl = $this->Core->GetCode("Author")." : ";
			$app = new $name($this->Core);
			$TextControl .= $app->Author;

			$TextControl .= "<br/>".$this->Core->GetCode("Version")." : ";
			$TextControl .= $app->Version;
		}
		else if(file_exists("../Widgets/$name/$name.php"))
		{
			include("../Core/Widget.php");
			include("../Widgets/$name/$name.php");

			$TextControl = $this->Core->GetCode("Author")." : ";
			$widget = new $name($this->Core);
			$TextControl .= $widget->Author;

			$TextControl .= "<br/>".$this->Core->GetCode("Version")." : ";
			$TextControl .= $widget->Version;

		}
		else
		{
			$TextControl = " Non accessible en developpement";
		}
		echo $TextControl;
	}

	/**
	 * Retourne les informations sur l'utilisateur
	 * */
	function GetInfoUser($all = true)
	{
		if($all)
		{
			$TextControl = "<table>";
		}
		else
		{
			$TextControl = "";
		}

		$Apps = array(/*"EeProfil",*/ "EeMessage", "EeComunity" /*, "EeContact"*/);

		//Si l'utilisateur à un projet on ajoutes EeProjet
		$projet = Eemmys::GetApp('EeProjet', $this->Core);
		
		if($projet->UserHave())
		{
			//$Apps[] = "EeProjet";
			$app = Eemmys::GetApp("EeProjet", $this->Core);
		
			$TextControl .= "<tr><td colspan='2' >".$app->GetInfoUser()."</td>";
		}
		
                //Bouton d'invitation
                $TextControl .= "<tr><td colspan='2' class='separation'><h3 class='icon-group' style='display:block;color:green'> Gagnez des points en parrainant</h3>Invitez vos amis et cumulez des points <br/>(1 invitation confirmé = 1 point)";
                
                //Action
                $PopUp = new Popup("InvitationBlock", "ShowSendMessage");
                $PopUp->AddArgument("App","EeMessage");
                
                $btnInvit = new Link("J'invite des amis", "#");
                $btnInvit->CssClass = "icon-group buttonMini";
                $btnInvit->OnClick = $PopUp;
                $TextControl .= "<br/>".$btnInvit->Show()."</td></tr>";
                
                $TextControl .= "<tr><td colspan='2' class='separation'><h3 class='icon-info'>&nbsp; Notifications</h3></td></tr>";
                
		foreach($Apps as $appName)
		{
			$app = Eemmys::GetApp($appName, $this->Core);
			if($all)
			{
				$TextControl .= "<tr><td>".$app->GetInfoUser()."</td>";
				//Bouton pour demarrer l'appli
				$btnRun = new Link( "&nbsp;".$this->Core->GetCode("Run") . " " . $appName, "#");
				$btnRun->Value = $this->Core->GetCode("Run") . " " . $appName;
				$btnRun->CssClass = "icon-desktop buttonMini";
				$btnRun->OnClick = "Eemmys.StartApp('', '".$appName."')";
				$TextControl .= "<td>".$btnRun->Show()."</td></tr>";
			
			}
			else
			{
				$TextControl .= $app->GetInfoUser().'-_';
			}
		}

		if($all)
		{
			//Nombre de point cumulés
			$TextControl .= "<tr><td colspan='2'>".$this->Core->GetCode('TotalPoint').' <b class="green">'. UserAvantage::GetTotal($this->Core)."<b></td></tr>";
			$TextControl .= "<tr><td colspan='2'>".$this->Core->GetCode('YourPosition'). " : <b class='green'>".$this->Core->User->Position->Value ."</b></td></tr>";
		
			$TextControl .= "</table>";
		}
		else
		{
			$TextControl .= $this->Core->GetCode('TotalPoint').' '. UserAvantage::GetTotal($this->Core);
		}
		return $TextControl;
	}
}
?>
<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

//Inclusion of the class of core
include "JHomDomDocument.php";
include "JHomConfig.php";
include "JHomDB.php";
include "JHomDBXml.php";
include "JHomInclude.php";
include "Constante.php";
include "JHomVar.php";
include "JHomLog.php";
include "JHomLanguage.php";
include "JHomAjax.php";
include "JHomApps.php";


abstract class JHomCore
{
	//Property
	protected $Config;
    public $Db;
  	protected $Include;
	protected $Page;
	protected $Entity;
	protected $JDirectory;
	protected $User;
	protected $UserGroupe;
	protected $Lang;
	protected $Version;
	protected $DataBaseEnabled;

	//Constructeur
	function JHomCore($include,$typeDb="",$file="",$directory="",$configFile = "")
	{
	  //Version du coeur
	  $this->Version ="2.2.0.0";

	  try
		{
			 //Configuration
			if($configFile != "")
			{
				$this->Config = new JHomConfig($configFile);
			}
			else
			{
				$this->Config = new JHomConfig("Config.xml");
			}

			//Repertoire du coeur
			 $this->JDirectory = $this->Config->GetKey("JDIRECTORY");

			 //Verification de l'utilisateur
			 if(!$this->NeedConnection($this->Config->GetKey("GROUP")) && $include)
			 {
          $this->Redirect("../index.php");
			 }

			//Repertoire du framework
			$this->JDirectory=$this->Config->GetKey("JDIRECTORY");

			switch($typeDb)
			 {
				case XML:

					$this->Db=new JHomDBXml($file,$directory);
					$this->Lang = new JHomConfig($this->JDirectory."Data/Lang.xml");
				break;
				default:

			//Choix du fonctionnement avec sans base de donnée
			if($configFile != "")
			{
				$this->ConfigDb = new JHomConfig($configFile);
			}
			else
			{
				 $this->ConfigDb = new JHomConfig($this->JDirectory."Config.xml");
			}

			 if($this->ConfigDb->GetKey("DATABASESERVER") != "")
			 {
			 $this->DataBaseEnabled = true;
			 //Data Base
	         $this->Db=new JHomDB(
									 $this->ConfigDb->GetKey("DATABASESERVER"),
									 $this->ConfigDb->GetKey("DATABASENAME"),
									 $this->ConfigDb->GetKey("DATABASELOGIN"),
									 $this->ConfigDb->GetKey("DATABASEPASS")
								 );

			//Gestion des langues
			$this->Lang=new JHomLanguage($this);

			//Langue par defaut
			if(JVar::GetSession("Lang") == "")
				  JVar::SetSession("Lang",$this->Config->GetKey("LANG"));
			 }
			 else
			 {
			 	$this->DataBaseEnabled=false;
			 }
			 break;
			 }

			//Inclusion des fichiers
			if($include)
			{
				$this->Include=new JHomInclude($this->JDirectory.$this->Config->GetKey("INCLUDE"),".php",$this->JDirectory);

				//Creation de la  page
				$this->Page= new Page($this);

			    //On charge l'utilisateur quand on inclue les fichiers car les script non pas besoin des Utilisateur connect�
		    	if(JHomVar::IsConnected($this) && $this->DataBaseEnabled && class_exists("User"))
		    	{
		    		$this->User=new User($this);
					$this->User->GetById(JHomVar::GetUser($this));
		    	}
			}

            //Gestion Ajax
            $this->Ajax = new JHomAjax();

			JHomLog::Title(CORE,"Ouveture",INFO);
		}
		catch (Exception  $e)
		{
                    
                    echo "ERREUR" . $e->GetMessage();
			JHomLog::Title(CORE,"Erreur",ERR);
			JHomLog::Write(CORE,$e->GetMessage(),ERR);
			throw new Exception($e->GetMessage());
		}
	}

	 //Verifie les droits utilisateurs
	 private function NeedConnection($Group)
	 {
   	if(!empty($Group))
		{
			if($Group==JHomVar::GetUserGroup($this))
				return true;
			else
				return false;
		}
		else
		{
			return true;
		}
		JHomLog::Write(CORE,"Connection",INFO);
	 }

	 //Retourne le repertoire du coeur
	 function GetJDirectory()
	 {
		return $this->JDirectory;
	 }

	function GetVersion()
	{
		return $this->Version;
	}
	 //Recupere le libelle d'un code dans la langue selectionn�e
	 function GetCode($code)
	 {
	 	if($this->DataBaseEnabled)
	 		return $this->Lang->GetCode($code,$this->GetLang());
	 	else
	 		return $code;
	 }

	/**
	 * Retourne tous les élements multilingue
	 */
	function GetAllCode()
	{
		return $this->Lang->GetAllCode($this->GetLang());
	}


	 //Recupere la langue selectionn�
	 function GetLang($code="")
	 {
	 	//Retourne le code de la langue choisi
	 	if($code =="")
	 	{
	 		return JVar::GetSession("Lang");
	 	}
	 	//Retourne l'identifiant
	 	else
	 	{
	 		$Lang= new Langs($this);
	 		$Lang->AddArgument(new Argument("Langs","Code",EQUAL,JVar::GetSession("Lang")));
 			$Langs= $Lang->GetByArg();

			if(sizeof($Langs)>0)
 				return $Langs[0]->IdEntite;
	 	}
	 }

	 //Selectionne la langue du site
	 function SetLang($lang)
	 {
	 	Jvar::SetSession("Lang",$lang);
	 }

	 //Retourne le skin a utiliser
	 function GetSkin()
	 {
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN")."/style.css";
	 }

	//Retourne le repertoire du skin a utiliser
	function GetDirectorySkin()
	{
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN");
	}

	 //Retourne le skin des popup
	 function GetPopUpSkin()
	 {
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN")."/Popup.php";
	 }

	 //Retourne le repertoire des scripts
	 function GetJsScript()
	 {
		return $this->GetJDirectory()."Jscripts/";
	 }

	 //Retourne le nom du site
	 function GetSiteName()
	 {
		return $this->Config->GetKey("SITENAME");
	 }

	//Retourne les actions
	function GetAction()
	{
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Action/Action.xml");

		//Recuperation des elements
		$Action = $Document->GetElementsByTagName("ELEMENT");
		$Actions = array();

		//Ajout
		foreach($Action as $action)
 		{
 			$Actions[] = $action->nodeValue;
 	    }
		return $Actions;
	}

	 //Retourne les control enregistr�
	 function GetControl($DynamicAdd=false)
	 {
	 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Control/Control.xml");

		//Recuperation des elements
		$Control = $Document->GetElementsByTagName("ELEMENT");

		$Controls = array();
		//Ajout
		foreach($Control as $control)
 		{
 			if(is_object($control) and $control->nodeValue != "JHomControl")
			{
				if( ($DynamicAdd &&  $control->getAttribute("DynamicAdd")== "True") || !$DynamicAdd)
          		{
              		$Controls[] = $control->nodeValue;
          		}
          	}

 		}
		return $Controls;
	 }

	 //Retourne les modules enregistr�s
	 function GetModule($DynamicAdd=false)
	 {
			 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Block/Block.xml");

		//Recuperation des elements
		$Module = $Document->GetElementsByTagName("ELEMENT");

		$Modules = array();
		//Ajout
		foreach($Module as $module)
 		{

 			if(is_object($module) and $module->nodeValue != "JHomBlock")
			{
				if( ($DynamicAdd &&  $module->getAttribute("DynamicAdd")== "True") || !$DynamicAdd)
	          		{
	              	  $Modules[] = $module->nodeValue;
              		}
		  	}

 		}
		return $Modules;
	 }

	 //Retourne les outils partie utilisateur
	 function GetTools($DynamicAdd=false)
	 {
			 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Block/Block.xml");

		//Recuperation des elements
		$Module = $Document->GetElementsByTagName("ELEMENT");

		$Modules = array();
		//Ajout
		foreach($Module as $module)
 		{
 			if(is_object($module) and $module->nodeValue != "JHomBlock")
			{
				if( ($module->getAttribute("Tool")== "True" && $module->getAttribute("Actif")== "True") )
	          		{
	              	  $Modules[] = $module->nodeValue;
              		}
		  	}
 		}
		return $Modules;
	 }

	 //Retourne les enitit�es enregistr�s
	 function GetEntite()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Entity/Entity.xml");

		//Recuperation des elements
		$Entity = $Document->GetElementsByTagName("ELEMENT");
		$Entitys = array();

		//Ajout
		foreach($Entity as $entity)
 		{
 			if($entity->getAttribute("className") != "")
 			{
 			   $Entitys[] = $entity->getAttribute("className");
 			}
 			else
 			{
    	      $Entitys[] = $entity->nodeValue;
 			}
        }
		return $Entitys;
	 }

	 //Retourne les pages enregistr�s
	 function GetPage()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Page/Page.xml");

		//Recuperation des elements
		$Page = $Document->GetElementsByTagName("ELEMENT");
		$Pages = array();

		//Ajout
		foreach($Page as $page)
 		{
 		      $Pages[] = $page->nodeValue;
        }
		return $Pages;
	 }

	 //Retourne les utilitaires enregistr�s
	 function GetUtility()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Utility/Utility.xml");

		//Recuperation des elements
		$Utility = $Document->GetElementsByTagName("ELEMENT");
		$Utilitys = array();

		//Ajout
		foreach($Utility as $utlity)
 		{
 		      $Utilitys[] = $utlity->nodeValue;
        }
		return $Utilitys;
	 }

     //Retourne les template enregistr�s
     function GetTemplate()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Template/Template.xml");

		//Recuperation des elements
		$Template = $Document->GetElementsByTagName("ELEMENT");
		$Templates = array();

		//Ajout
		foreach($Template as $template)
 		{
 		      $Templates[] = $template->nodeValue;
        }
		return $Templates;
	 }
	  //Retourne les utilisateurs admin
	 function GetAdminUser()
	 {
	 	//Recuperation groupeAdmin
	 	$Group = new Group($this);
		$Group->GetByName("Admin");

		$User = new User($this);
	 	$User->AddArgument(new Argument("User","GroupeId",EQUAL,$Group->IdEntite));
	 	$Users = $User->GetByArg();

	 	return $Users;
	 }

	 //Redirection
	 function Redirect($Url)
	 {
	 	if(!headers_sent())
	 		header("Location:$Url");
	 	else
	 		echo "<script type='text/javascript'>window.location.replace('$Url');</script>";
	 }

	/**
	 * Récupere le repertoire utilisateur
	 */
	public function GetUserDirectory($idUser ="")
	{
		if($idUser == "")
		{
			$userId = $_SESSION[md5("Webemyos_User")];
		}
		else
		{
			$userId = $idUser;
		}

		$user = new User($this);
		$user->GetById($userId);

		return "../".$user->Serveur->Value."/User/".md5($userId)."";
	}



	 /*
	  * Recupere l'url de fnd écran utilisateur
	  */
	 public static function GetUserBackGround()
	 {
	 	//Recuperation de l'utilisateur dans la session
		$user = $_SESSION[md5("WebEmyos_User")];
	 	//ouverture du fichier de parametrage
	 	$fileName = "../../../Membre/User/".md5($user)."/Apps/EeParameter.xml";

		//Ouverture du fichier de configuration
		$dom = new DomDocument();
		$dom->Load($fileName);

		$Config = $dom->getElementsByTagName("config");

		if($Config->item(0) != null)
		{
			//Recherche de la cle 2
			if($Config->item(0)->childNodes != null)
			{
				foreach($Config->item(0)->childNodes as $node)
				{
					if($node->getAttribute("key") == 2)
					{
						$value = $node->getAttribute("value");
					}
					if($node->getAttribute("key") == 3)
					{
						if($node->getAttribute("value") == "1")
							$showImage = true;
						else
							$showImage = false;

					}
				}
			}
		}

		if($showImage)
	 		return $value;
	 	else
	 		return '';

	 }

	 /**
	  * Recupere un message de validation OK
	  * */
	 function GetMessageValid($id='')
	 {
	 	if($id != '')
	 	{
	 		$id= "id='".$id."'";
	 	}
	 	return "<span class='FormUserValid' $id>".$this->GetCode("SaveOk")."</span>";
	 }

	 /**
	  * Recupere un message d'erreur'
	  * */
	 function GetMessageError($id='')
	 {
	 	if($id != '')
	 	{
	 		$id= "id='".$id."'";
	 	}
	 	return "<span class='FormUserError'>".$this->GetCode("Error")."</span>";
	 }
}
?>

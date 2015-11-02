<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class RegistrationBlock extends JHomBlock implements IJhomBlock
{
	private $AddButtonFacebook; 
	private $AddForm; 
	public $IdEntity;
	
	//Constructeur
	function RegistrationBlock($core="", $idSite = '', $page = '', $addBtnFacebook= true, $addProjet = false, $addForm = false)
	{
		$this->Core = $core;

		//Formulaire d'inscription
		$this->FormRegistration = new FormBlock("formRegistration",($page != '' ? $page : ""),POST,"Page",$this->Core);
		$this->FormRegistration->CssClass = "signupform";
		$this->FormRegistration->Frame = false;
		$this->FormRegistration->Table = false;
		$this->Table = false;
		$this->Frame = false;

		$this->AddButtonFacebook =  $addBtnFacebook;
		$this->AddProjet =  $addProjet;

		//Utilisateur
		$this->User = new User($this->Core);

		$this->lstSexe = new ListBox("lstSexe");
		$this->tbVerifEmail = new EmailBox("tbVerifEmail");
		$this->tbVerifPass = new PassWord("tbVerifPass");
	
		$this->AddForm = $addForm;
	}

	function Init()
	{
		//Name
		$this->User->Name->Libelle = "";
		$this->User->Name->Control->PlaceHolder = $this->Core->GetCode("Name");
		$this->FormRegistration->AddNew($this->User->Name);

		//First Name
		$this->User->FirstName->Libelle ="";
		$this->User->FirstName->Control->PlaceHolder = $this->Core->GetCode("FirstName");
		$this->FormRegistration->AddNew($this->User->FirstName);

		//Verification
		$Action = new VerifyAction("User", "Verify");
		$Action->AddArgument("Type","Verify");

		//Verification
		$this->User->Email->Control->Id = "tbEmail";

		$Action->SourceControl = $this->User->Email->Control->Id;
		$Action->ErrorMessage = $this->Core->GetCode("LoginExist");

		$this->User->Email->Control->OnChange = $Action;

		$this->User->Email->Libelle ="";
		$this->User->Email->Control->PlaceHolder = $this->Core->GetCode("Email");
		$this->FormRegistration->AddNew($this->User->Email);

		$this->User->PassWord->Libelle = "";
		$this->User->PassWord->Control->PlaceHolder = '"'.$this->Core->GetCode("PassWord").'"';
		$this->FormRegistration->AddNew($this->User->PassWord);

		//Verifiaction du mot de passe
		$this->tbVerifPass->Libelle = '';
		$this->tbVerifPass->PlaceHolder = $this->Core->GetCode("Verify");
		$this->FormRegistration->AddNew($this->tbVerifPass);
		
		//Conditions générales d'utilisation
		$cbCondition = new CheckBox("cbCondition");
		$cbCondition->Libelle = $this->Core->GetCode("AcceptReglement");
		$cbCondition->Checked= true;
		$this->FormRegistration->AddNew($cbCondition);
	
		
		//Bouton d'enregistrement
		$this->BtnSave = new Button(BUTTON);
		$this->BtnSave->CssClass ="btn btn-primary";
		$this->BtnSave->AddStyle("width", "250px");
		$this->BtnSave->AddStyle("height", "30px");
		$this->BtnSave->Value = $this->Core->GetCode("LetsGo");
		
		//Creation d'un projet 
		if($this->AddProjet)
		{
			$this->FormRegistration->AddNew(new Libelle("<h3>".$this->Core->GetCode("MyProjet")."</h3>"));
			$tbProjet = new TextBox('tbTitleProjet');
			$tbProjet->PlaceHolder = $this->Core->GetCode("ProjetTitle");
			$this->FormRegistration->Add($tbProjet);
			
			$tbDescription = new TextArea('tbDescriptionProjet');
			$tbDescription->PlaceHolder = $this->Core->GetCode("ProjetDescription");
			
			$this->FormRegistration->AddNew($tbDescription);
			$this->FormRegistration->AddNew(new Libelle("<input type='hidden' name='addProjet' value='1'><br/>"));
		}
		
		$this->BtnSave->OnClick = new UserAction("SaveUser");
		$this->FormRegistration->AddNew($this->BtnSave,"4", ALIGNRIGHT);
		
		if($this->AddButtonFacebook)
		{
			$this->FormRegistration->AddNew($this->CreateFacebookButton(), "4", ALIGNRIGHT );
		}

		if($this->AddForm)
		{
			$this->FormRegistration->AddNew(new Libelle("<input type='hidden' name='hdForm' value='".$this->IdEntity."'  />"));
		}
	}

	/*
	* Ajout d'un bouton de connection facebook
	*/
	function CreateFacebookButton()
	{
	    //Inclusion des classes eden
	    include('Library/eden/eden.php');
	    include('Library/eden/eden/facebook.php');

		$auth = eden('facebook')->auth('499714926769823', 
									   'df55e9585edfa2bc4b7e303a5885bb39', 
									   'http://webemyos.com/auth.php');
		//Url de connection
		$login = $auth->getLoginUrl();

	 	//Boutton de connection
		$btnFacebook = new button(BUTTON);
		$btnFacebook->Value = 'Facebook';

		//Popup
		$popUp = new Popup("Eemmys","GetPopInFacebook");
		$popUp->AddArgument('url', base64_encode($login));
		$popUp->Title = "Connection Facebook";
		$btnFacebook->CssClass = "btnFacebook";
		
		$btnFacebook->Value = 'Connection avec Facebook';
		$btnFacebook->OnClick = $popUp;
		
		return $btnFacebook;
	}

	//Enregistrement
	function SaveUser()
	{
		//Recuperation du groupe code
		$Groupe = new  Group($this->Core);
		$Groupe->GetByName("Membre");
		$this->User->GroupeId->Value = $Groupe->IdEntite;

		//Sexe
		$this->User->Sexe->Value = $this->lstSexe->Value;

		if(!JVar::GetPost("cbCondition"))
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("MustAcceptReglement"));
			return false;
		}

		if(JVar::GetPost("Password") != JVar::GetPost("tbVerifPass"))
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("PassNotEqual"));
			return false;
		}
		
		if(JVar::GetPost("Email") && $this->User->Exist())
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("LoginExist"));
			return false;
		}

		if(JVar::GetPost('addProjet') &&  JVar::GetPost('tbTitleProjet') == '')
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("ErrorTitleProjet"));
			return false;
		}

		if($this->User->IsValid() && $this->User->PassWord->Value == $this->tbVerifPass->Value)
		{
			$this->User->DateCreate->Value = JDate::Now();

			$this->User->Serveur->Value = URLDATAMEMBRE;

			$this->User->Save();

			//Envoi du mail
			$Email  = new JEmail();
			$Email->Template = "MessageTemplate";
			$Email->Sender = EMAIL_CONTACT;
			$Email->Title = $this->Core->GetCode("ValidInscription");

			// text parametrable
			$text = new DataText($this->Core);
			$text->GetByCode("txtInscription");

			$Email->Body = $text->Text->Value;
     		$Email->Body  .= "<br/>" .$this->Core->GetCode("Email")." : " . $this->User->Email->Value."<br/>";
     		$Email->Body .= " <br/>" . $this->Core->GetCode("PassWord") .":".$this->User->PassWord->Value."<br/>";
			$Email->Body .="<br/>" . $this->Core->GetCode("ThankYou");

			$Email->SendUserAndAdmin($this->User->Email->Value);

			//Chargement de l'utilisateur
			$User = new User($this->Core);
			$User->GetById($this->Core->Db->GetInsertedId());

			//Connecte l'utilisateur
			JVar::Connect($User,$User->GroupeId, $this->Core);

			//Creation du dossier
			//echo "File to create".$this->Core->GetUserDirectory();
			$userId = $_SESSION[md5("WebEmyos_User")];
			$directory = md5($userId);

			//Enregistrement du site pour l'utilisateur
			if(JVar::Get("idSite"))
			{
				$site = new Site($this->Core);
				$site->GetById(JVar::Get("idSite"));
				$site->UserId->Value = 	$userId;
				$site->Valid->Value = 0;

				$site->Save();
			}
		
			//Création des repertoire et de fichiers de base
			$this->CreateDirectoryUser($this->User->Serveur->Value);
		
			//repertoitre de base des images
			$User->Groupe->Value->Section->Value->Directory->Value;
		
			// Creation du projet
			if(JVar::GetPost('tbTitleProjet'))
			{
			 	include('Apps/EeProjet/Entity/eeProject.php');
			 	
			 	$projet = new eeProject($this->Core);
			 	$projet->Title->Value = JVar::GetPost('tbTitleProjet');
			 	$projet->Commentaire->Value =  JVar::GetPost("tbDescriptionProjet");
			 	$projet->UserId->Value = $userId;
			 	$projet->Actif->Value = 0;
			 	$projet->Save();
	
				//Redirige dans la bonne section
				$this->Core->Redirect($User->Groupe->Value->Section->Value->Directory->Value.'index.php?projet');
			}
			else if(JVar::GetPost("hdForm"))
			{
				//Redirige dans la bonne section
				$this->Core->Redirect($User->Groupe->Value->Section->Value->Directory->Value.'index.php?form='.JVar::GetPost("hdForm"));
			}
			else
			{
				//Redirige dans la bonne section
				$this->Core->Redirect($User->Groupe->Value->Section->Value->Directory->Value.'index.php?new');
			}
		}
		else
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("MessageFieldEmpty"));
		}
	}

	/*
	*Enregistrement d'un utilisateur pour facebook
	*/
	function SaveForFacebook($user)
	{	
		//Recuperation du groupe code
		$Groupe = new  Group($this->Core);
		$Groupe->GetByName("Membre");

		$user->GroupeId->Value = $Groupe->IdEntite;
		$user->DateCreate->Value = JDate::Now();
		$user->Serveur->Value = URLSITE.URLDATAMEMBRE;
		$user->Save();

		//Chargement de l'utilisateur
		$User = new User($this->Core);
		$User->GetById($this->Core->Db->GetInsertedId());

		//Connecte l'utilisateur
		JVar::Connect($User, $User->GroupeId, $this->Core);
		
		//Création des repertoire et de fichiers de base
		$this->CreateDirectoryUser($user->Serveur->Value);
	}

	/*
	* Créer les repertoire et dossier pour les utilisateurs
	*/
	function CreateDirectoryUser($serveur)
	{
		//Creation du dossier
		//echo "File to create".$this->Core->GetUserDirectory();
		$userId = $_SESSION[md5("WebEmyos_User")];
		$directory = md5($userId);

		JFile::CreateDirectory("Membre/User/".$directory);

		//Creation des repertoire de base
		JFile::CreateDirectory("Membre/User/".$directory."/Apps");
		JFile::CreateDirectory("Membre/User/".$directory."/Widgets");

		//Copy des fichiers de base
		if(JVar::Get("idSite"))
		{
			copy("Membre/User/base/Apps/EeAppSite.xml", "Membre/User/".$directory."/Apps/EeApp.xml");
		}
		else
		{
			copy("Membre/User/base/Apps/EeApp.xml", "Membre/User/".$directory."/Apps/EeApp.xml");
		}

		copy("Membre/User/base/Apps/EeParameter.xml", "Membre/User/".$directory."/Apps/EeParameter.xml");
		copy("Membre/User/base/Apps/EeWidget.xml", "Membre/User/".$directory."/Apps/EeWidget.xml");
	
		//Repertoire des données utilisateur
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory());
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Files");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Images");

		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Images/Profil");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Images/Wall");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Images/Wallpaper");

		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Partage");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Sound");
		JFile::CreateDirectory($serveur."/".$this->Core->GetUserDirectory()."/Files/Video");
}

	//Insertion des controls
	function Create()
	{
		$this->Body = "<h3 class='icon-signout'> Je crée mon compte </h3>";

		//$this->Body .= $this->GetFacebookLogin();
		$this->Body .= $this->FormRegistration->Show();
	}

	/**
	 * Créer un bouton De login facebook
	 * */
	function GetFacebookLogin()
	{
		require 'src/facebook.php';

		$facebook = new Facebook(array(
								  'appId'  => '200120140123518',
								  'secret' => '43c841164d9c01d76bc2fedb4a792ab7',
									));

		// See if there is a user from a cookie
		$user = $facebook->getUser();

		if ($user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $user_profile = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
		    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
		    $user = null;
		  }
		}

		 if ($user)
	 	{
		     $TextControl = " Your user profile is
		      <pre>
		        ".print htmlspecialchars(print_r($user_profile, true))."
		      </pre> ";
			}
	 	else
	 	{
	 		 $TextControl = "<fb:login-button></fb:login-button>";
        }
    $TextControl .="<div id='fb-root'></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '".$facebook->getAppID()."',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>";


		return $TextControl;
	}

	//Affichage
	function Show()
	{
		$this->LoadControl();
		$this->Init();
		$this->CallMethod();
		$this->Create();
		return parent::Show();
	}

	//Asseceur
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}
?>

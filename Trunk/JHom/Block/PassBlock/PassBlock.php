<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class PassBlock extends JHomBlock implements IJhomBlock
{
	//Propriete
	private $Page;
	private $ReturnPage;
	private $Login;
	private $Pass;
	private $BtConnect;
	private $Verif;
	private $RootDirectory;
	private $AdminDirectory;
	private $CallBackUrl;
	private $Redirect;
	private $ShowAcces;

	//Constructeur
	function PassBlock($core="")
	{
		//Version
 		$this->Version = "2.0.0.0";

		$this->Core=$core;
		//Repertoire root
		$this->RootDirectory="Root/";
		//Repertoire administration
		$this->AdminDirectory="Admin/";

		//Fomulaire de saisie
		$this->Verif = new FormBlock("Pass","",POST,PAGE);
		$this->Verif->Id = "dvLogin";
                $this->Verif->CssClass = "loginform";
		$this->Verif->Title=$this->Core->GetCode('Authentification');

		//Identifiant
		$this->Email= new EmailBox("Email");
		$this->Email->AddStyle("Width","250px");
		$this->Email->PlaceHolder = $this->Core->GetCode("Email");
		
		//Mot de passe
		$this->Pass=new PassWord("Pass");
		$this->Pass->AddStyle("Width","250px");
		$this->Pass->PlaceHolder = "'".$this->Core->GetCode('Password')."'";

		//Bouton de connection
		$this->BtConnect = new Button(SUBMIT);
		$this->BtConnect->Value=$this->Core->GetCode('OK');
		$this->BtConnect->CssClass = "btn btn-success";
		$this->BtConnect->OnClick=new UserAction("Connect");

		//Checkbox 'Se souvenir de moi'
		$this->cbRemember = new CheckBox("cbRemember", $this->Core->GetCode("RememberMe"));

		//Libelle mot de passe oublie
		$this->LinkPassOublie = new Link($this->Core->GetCode("ForgetPass"),"#");
		$this->LinkPassOublie->OnClick = 'PassBlock.AsskNewPassword();';
	}

	//Connecte l'utilisateur
	function Connect()
	{
		//Test des champs saisie
		if($this->Email->Value != "" &&  $this->Pass->Value != "")
		{
			$Core=new Core(false);
			//Recuperation de l'utilisateur
			$User=new User($Core);
			$UserLogin = new Argument("User",$User->Email->TableName,EQUAL,$this->Email->Value);
			$User->AddArgument($UserLogin);
			$Users=$User->GetByArg();

			//Verification du pass
			if(sizeof($Users)>0 &&  $Users[0]->PassWord->Value == md5($this->Pass->Value))
			{
				//Enregistrement du cookie
    		  	if(isset($_POST["cbRemember"]))
    	   	  	{
         	 		setcookie(md5("WebEmyosUser"), $Users[0]->IdEntite,time()+3600*24*31*12);
         	  	}

				//Connecte l'utilisateur
				JVar::Connect($Users[0], $Users[0]->GroupeId->Value , $this->Core);
				//Redirige dans la bonne section

				$this->Redirect($Users[0]->Groupe->Value->Section->Value->Directory->Value);
			}
			else
			{
				$this->Core->Page->Message->Show($this->Core->GetCode("PassInvalid"));
			}
		}
		else
		{
			$this->Core->Page->Message->Show($this->Core->GetCode("EmailInvalid"));
		}
	}

	//Deconnecte l'utilisateur
	function Disconnect()
	{
		JVar::Disconnect($this->Core);
		if($this->CallBackUrl)
			$this->Core->Redirect($this->CallBackUrl);
	}

	function Redirect($section)
	{
		if($this->Redirect)
			$this->Core->Redirect($this->Redirect);
		else
			$this->Core->Redirect($section);
	}

	//Definition des etats des control en fonction de la connection
	function Init()
	{
		//Utilisateur connect�
		if(JVar::IsConnected($this->Core))
		{
			$this->BtConnect->Enabled=false;
			//Affichage du nom de l'utilisateur'
			$Core=new Core(false);
			$User=new User($Core);
			$User->GetById(JVar::GetUser($this->Core));

			$this->Email->Value = $User->Email->Value;
			//$this->Pass->Value = "password";
		}
		/*else
		{
			$this->Email->Value = $this->Core->getCode("Email");
			$this->Pass->Value = "password";
		}*/
	}

	//Insertion des controls
	function Create()
	{
		//Creation du bloc de contr�les
		$TextControl  = $this->Email->Show();
        $TextControl .= $this->Pass->Show();
        $TextControl .= $this->BtConnect->Show();
        $TextControl .= "<br/>".$this->cbRemember->Show().$this->Core->GetCode("RememberMe");

       // $TextControl .= '<div class="linker"><span class="remember">'.$this->cbRemember->Show().'<label for="remember">'.$this->Core->GetCode("RememberMe").'</label></span>';

		//PopUp du mot de pass oubli�
		$PopUp =  new PopUp("PassBlock","ShowForget");
		$PopUp->Height = "200";

		$this->LinkPassOublie->OnClick = $PopUp;

		$TextControl .= '<br/><span class="forget">'.$this->LinkPassOublie->Show().'</span>';

        //Ajout des contr�les au formulaire
        $this->Verif->Add(new Libelle($TextControl));

		$this->Body = $this->Verif->Show();
	}

	//Affiche un message de demande de ressaisir le mot de passe
	function ShowForget()
	{
		$TextControl = "<span><span id='lbResult'>".$this->Core->GetCode("ForgetPass")."</span></span>";

		$tbEmail = new EmailBox("tbNewEmail");
		$tbEmail->Libelle = $this->Core->GetCode("YourEmail");

		$TextControl .= "<br/>".$this->Core->GetCode("YourEmail")." ".$tbEmail->Show();

		//Action
		$action = new AjaxAction("PassBlock", "SendEmail");
		$action->ChangedControl = "lbResult";
		$action->AddControl("tbNewEmail");

		//bouton d'envoi
		$btnSend = new Button(BUTTON);
		$btnSend->Value = $this->Core->GetCode("Send");
		$btnSend->CssClass = "button orange";
		$btnSend->OnClick = $action;

		$TextControl .= "<br/>".$btnSend->Show();

		echo $TextControl;
	}

	/**
	 * Envoi d'un email a l'adresse afin de reinitialiser le mot de passe
	 * */
	function SendEmail()
	{
		$Email = JVar::GetPost('tbNewEmail');

		//Recuperation de l'utilisateur
		$user = new User($this->Core);
		$user->AddArgument(new Argument("User","Email",EQUAL, $Email));
		$User = $user->GetByArg();

		if(count($User) == 0 )
		{
			echo "<span class='error' id='lbResult'>".$this->Core->GetCode("UserNotExist")."</span>";
		}
		else
		{
			//Creation de email
			//Creation du mail d'invitation
			$Email  = new JEmail();
			$Email->Template = "MessageTemplate";
			$Email->Sender = EMAIL_CONTACT;
			$Email->Title = $this->Core->GetCode("TitlePasswordReseted");

			$Email->Body = $this->Core->GetCode("TextPasswordReseted");;
			//Ajout du lien
			$link = new Link($this->Core->GetCode("ChangePassword"), URLSITE."index.php?Page=actions&a=rpw&u=" . base64_encode($User[0]->Email->Value));
			$Email->Body .= "<br/>".$link->Show();

			//Envoi du mail
			$Email->SendUserAndAdmin($User[0]->Email->Value);


			echo "<span class='success' id='lbResult'>".$this->Core->GetCode("EmailResetPasswordSend")."</span>";
		}
	}

	/**
	 * Change le mot de passe de l'utilisateur
	 * */
	public function NewPassWord()
	{
		$email = base64_decode(JVar::GetPost("u"));

		//Recuperation de l'utilisateur
		$user = new User($this->Core);
		$user->AddArgument(new Argument("User","Email",EQUAL, $email));
		$User = $user->GetByArg();

		if(count($User) == 0 )
		{
			echo "<span class='error' id='lbResult'>".$this->Core->GetCode("UserNotExist")."</span>";
		}
		else
		{
			$User[0]->ChangePassword(JVar::GetPost('p'));
			echo "Ok";
		}
	}

	//Affichage
	function Show()
	{
		$this->LoadControl();
		$this->CallMethod();
		$this->Init();
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

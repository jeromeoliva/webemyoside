<?php
class MyPassBlock extends JHomBlock implements IJhomBlock
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
        
        //Utilise pour sauvegarder une mission
        public $MissionId;

	//Constructeur
	function MyPassBlock($core="")
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
		$this->LinkPassOublie->OnClick = 'NeedExpertPassBlock.AsskNewPassword();';
                
                //Lien pour créer son compte
                $this->LinkCreate = new Link("Créer mon compte", "account.html");
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
				JVar::Connect($Users[0], $Users[0]->GroupeId , $this->Core);
				
                                //Enregistrement de la mission
                                if(JVar::GetPost('hdMission'))
                                {
                                    if(!class_exists("MissionHelper"))
                                    {
                                       $app = new NeedExpert($this->Core);
                                    }
                                    
                                    MissionHelper::ValideUser($this->Core, $Users[0]->IdEntite, JVar::GetPost('hdMission'));
                                }

                                //Redirige dans la bonne section
				$this->Redirect("home.html");
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
		$PopUp =  new PopUp("NeedExpertPassBlock","ShowForget");
		$PopUp->Height = "200";

		$this->LinkPassOublie->OnClick = $PopUp;

		$TextControl .= '<br/><span class="forget">'.$this->LinkPassOublie->Show().'</span>';
                $TextControl .=   '<br/><span class="account">'.$this->LinkCreate->Show().'</span>';

        //Enregistrement d'une mission
        if($this->MissionId != "")
        {
            $TextControl .= "<input type='hidden' name='hdMission' id='hdMission' value='".$this->MissionId."'> ";
        }
        // On le reposte si l'utilisateur c'est trompé
        else if(JVar::GetPost('hdMission'))
        {
            $TextControl .= "<input type='hidden' name='hdMission' id='hdMission' value='".JVar::GetPost('hdMission')."'> ";
        }
                
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
		$action = new AjaxAction("NeedExpertPassBlock", "SendEmail");
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

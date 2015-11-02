<?php

/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class AuthentificationBlock extends JHomBlock
{
        /**
         *  Constructeur
	*/
	function AuthentificationBlock($core="")
	{
            $this->Core = $core;
	}

	/**
	 * Creation
	 */
	function Create()
	{
	}

	/**
	 * Initialisation
	 */
	function Init()
	{
	}

	/**
	 * Affichage du module
	 */
	function Show($all=true)
	{}
        
        /**
         * Module de connection ou de création de compte
         */
        function GetAuthentification()
        {
             $html = "<div class='row' id='dvAuthentification' >";
             
             $html .= "<span class='col-md-4 left'>".$this->GetPass()."</span>";
             $html .= "<span class='col-md-4 right'>".$this->GetAddCompte()."</span>";
                 
             $html .= "</div>";
             
             return $html;
        }
        
        /**
         * module de connection
         */
        function GetPass()
        {
            $html = "<h4>".$this->Core->GetCode("Connexion")."</h4>";
            
            //Login
            $tbEmail = new BsEmailBox("tbAuthEmail");
            $tbEmail->Title = $this->Core->GetCode("Login");
            
            $html .= $tbEmail->Show();
            
            //Pass
            $tbPass = new BsPassword("tbAuthPass");
            $tbPass->Title = $this->Core->GetCode("PassWord");
            $html .= "<br/>".$tbPass->Show();
           
            //Bouton
            $btnConnect = new Button(BUTTON);
            $btnConnect->Value = $this->Core->GetCode("Connect");
            $btnConnect->CssClass = "btn btn-primary";
            $btnConnect->OnClick = "AuthentificationBlock.Connect()";
            $html .= "<br/>".$btnConnect->Show();
            
            return $html;
        }
        
        /**
         * Module de création de compte
         */
        function GetAddCompte()
        {
             $html = "<h4>".$this->Core->GetCode("Join")."</h4>";
            
            //Login
            $tbEmail = new BsEmailBox("tbCreateEmail");
            $tbEmail->Title = $this->Core->GetCode("Login");
            
            $html .= $tbEmail->Show();
            
            //Pass
            $tbPass = new BsPassword("tbCreatePass");
            $tbPass->Title = $this->Core->GetCode("PassWord");
            $html .= "<br/>".$tbPass->Show();
            
            //Pass
            $tbVerifPass = new BsPassword("tbCreateVerifPass");
            $tbVerifPass->Title = $this->Core->GetCode("Verification");
            $html .= "<br/>".$tbVerifPass->Show();
           
            //Bouton
            $btnConnect = new Button(BUTTON);
            $btnConnect->Value = $this->Core->GetCode("Inscription");
            $btnConnect->OnClick = "AuthentificationBlock.CreateCompte()";
            $html .= "<br/>".$btnConnect->Show();
            
            return $html;
        }
        
        /**
         * Connect L'utilisateur
         */
        function Connect()
        {
            $email = JVar::GetPost("Email");
            $pass = JVar::GetPost("Pass");
            
            //Test des champs saisie
		if($email != "" &&  $pass != "")
		{
                        //Recuperation de l'utilisateur
			$User=new User($this->Core);
			$UserLogin = new Argument("User", "Email", EQUAL, $email);
			$User->AddArgument($UserLogin);
			$Users=$User->GetByArg();

			//Verification du pass
			if(sizeof($Users)>0 &&  $Users[0]->PassWord->Value == md5($pass))
			{
				//Connecte l'utilisateur
				JVar::Connect($Users[0], $Users[0]->GroupeId->Value , $this->Core);
                
                       		echo "<span class='succes'>".$this->Core->GetCode("ConnectionOk")."</span>";
                        }
			else
			{
				echo "<span class='error'>".$this->Core->GetCode("PassInvalid")."</span>";
                                
                                echo $this->GetAuthentification();
			}
		}
		else
		{
			echo $this->Core->GetCode("EmailInvalid");
                        
                        echo $this->GetAuthentification();
		}
        }
        
        /**
         * Crée un comte et connect l'utilisateur
         */
        function CreateCompte()
        {
            	//Initalisation de l'utilisateur
                $user = new User($this->Core);
                $user->Email->Value = JVar::GetPost("Email");
                $user->PassWord->Value = JVar::GetPost("Pass");

                //Recuperation du groupe code
		$Groupe = new  Group($this->Core);
		$Groupe->GetByName("Membre");
		$user->GroupeId->Value = $Groupe->IdEntite;

		if(JVar::GetPost("Pass") != JVar::GetPost("Verif"))
		{
			echo $this->Core->GetCode("PassNotEqual");
                        echo $this->GetAuthentification();
			return false;
		}
		
		if(JVar::GetPost("Email") && $user->Exist())
		{
			echo $this->Core->GetCode("LoginExist");
                        echo $this->GetAuthentification();
			return false;
		}
		
		if($user->IsValid() && $user->PassWord->Value ==  JVar::GetPost("Verif"))
		{
			$user->DateCreate->Value = JDate::Now();

			$user->Serveur->Value = URLDATAMEMBRE;

			$user->TypeId->Value = 1;
			$user->Save();

                        //Chargement de l'utilisateur
			$User = new User($this->Core);
                        $User->AddArgument(new Argument("User", "Email", EQUAL, JVar::GetPost("Email")));
                        $users = $User->GetByArg();
                        
                        $userId = $users[0]->IdEntite;
                        
                        $User->GetById($userId);

			//Connecte l'utilisateur
			JVar::Connect($User, $Groupe->IdEntite, $this->Core, $userId);
                        
			//Envoi du mail
			$Email  = new JEmail();
			$Email->Template = "MessageTemplate";
			$Email->Sender = EMAIL_CONTACT;
			$Email->Title = $this->Core->GetCode("ValidInscription");

			// text parametrable
			$text = new DataText($this->Core);
			$text->GetByCode("txtInscription");

			$Email->Body = $text->Text->Value;
                        $Email->Body  .= "<br/>" .$this->Core->GetCode("Email")." : " . $user->Email->Value."<br/>";
                        $Email->Body .= " <br/>" . $this->Core->GetCode("PassWord") .":".$user->PassWord->Value."<br/>";
			$Email->Body .="<br/>" . $this->Core->GetCode("ThankYou");

			$Email->SendUserAndAdmin($user->Email->Value);

                        echo "<span class='succes'>".$this->Core->GetCode("CreationCompteValide")."</span>";
                   	
		}
		else
		{
			echo $this->Core->GetCode("MessageFieldEmpty");
                        
                         echo $this->GetAuthentification();
		}
        }
        
        /**
         * Rafrachit le module de connection
         */
        function RefreshPassBlock()
        {
            //Logo
		if(JVar::IsConnected($this->Core))
		{
		        //Accès au bureau
                        $profilLightBlock = new ProfilLightBlock($this->Core);
             
                        echo $profilLightBlock->Show();
                }
		else
		{
		 
                       //Block de connection
                       $passBlock = new PassBlock($this->Core);
                       $passBlock->Table = false;
                       $passBlock->Frame = false;
                       
                       echo $passBlock->Show();
               }
        }
        
}
?>

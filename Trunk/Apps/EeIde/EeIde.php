<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */


/*
 * Application de devellopement des applications
 * */

class EeIde extends Application
{
	/**
	 * Auteur et version
         * Repertoire des fichiers
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeIde";
        public static $Destination = "../Apps";

	/**
	 * Constructeur
	 * */
	 function EeIde($core)
	 {
	 	parent::__construct($core, "EeIde");
	 	$this->Core = $core;
                
                //Inclusione des module et des entitées
                $this->IncludeBlock();
                $this->IncludeEntite();
         }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeIde", "EeIde");
	 	echo $textControl;
	 }
         
         /**
          * Inclut les module nescessaires
          */
         function IncludeBlock()
         {
              	if(!class_exists("HomeBlock"))
		{
                     include_once("Blocks/HomeBlock/HomeBlock.php");
                     include("Blocks/ProjetBlock/ProjetBlock.php");
                     include("Blocks/ModuleBlock/ModuleBlock.php");
                     include("Blocks/EntityBlock/EntityBlock.php");
                     include("Blocks/TemplateBlock/TemplateBlock.php");
                     include("Blocks/InsertBlock/InsertBlock.php");
                     include("Blocks/HelperBlock/HelperBlock.php");
                     include("Blocks/DepotBlock/DepotBlock.php");
               }
                
                //Inclue les helper
                if(!class_exists("ProjetHelper"))
                {
                    include("Helper/ProjetHelper.php");
                    include("Helper/ToolHelper.php");
                    include("Helper/ElementHelper.php");
                    include("Helper/ModuleHelper.php");
                    include("Helper/EntityHelper.php");
                    include("Helper/HelperHelper.php");
                    include("Helper/DeployHelper.php");
                    include("Helper/LandingPageHelper.php");
                    include("Helper/InstallHelper.php");
                    include("Helper/DepotHelper.php");
                    include("Helper/FtpHelper.php");
                    
                    /*Helper*/
                }
         }
         
         /**
          * Ajoute les entité
          */
         function IncludeEntite()
         {
            if(!class_exists("EeIdeProjet"))
            {
                include("Entity/EeIdeProjet.php");
            }
         }
         
         /**
          * Charge la page d'accueil
          */
         function LoadHome()
         {
             $homeBlock = new HomeBlock($this->Core);
             echo $homeBlock->Show();
         }
         
         /**
          * Charges les projets utilisateurs
          */
         function LoadUserProjet()
         {
             $homeBlock = new HomeBlock($this->Core);
             echo $homeBlock->GetProjets();
         }
         
         /*
          * Pop in de création de projet
          */
         function ShowCreateNewProjet()
         {
             $projetBlock = new ProjetBlock($this->Core);
             echo $projetBlock->ShowCreateNewProjet();
         }
         
         /**
          * Creation d'un projet
          */       
         function CreateProjet()
         {
             $projetBlock = new ProjetBlock($this->Core);
             echo $projetBlock->CreateProjet(); 
         }
         
         /**
          * Charge le projet avec tout les outils
          * 
          */
         function LoadProjet()
         {
             $projetBlock = new ProjetBlock($this->Core);
             echo $projetBlock->LoadProjet(); 
         }
         
         /**
          * Charge le fichier
          */
         function LoadFile()
         {
             echo ElementHelper::LoadFile($this->Core, JVar::GetPost("Projet"), JVar::GetPost("Name"), JVar::GetPost("Module"), JVar::GetPost("Helper"));
         }
         
         /*
          * Sauvegarde les fichier
          */
         function SaveFileProject()
         {
             echo ElementHelper::SaveFile($this->Core, JVar::GetPost("Projet"), JVar::GetPost("Name"));
         }
         
         /**
          * Popin d'ajout de module
          */
         function ShowAddModule()
         {
            $moduleBlock = new ModuleBlock($this->Core);
            echo $moduleBlock->ShowAddModule();
         }
         
         /**
          * Cree le module
          */
         function AddModule()
         {
            $moduleBlock = new ModuleBlock($this->Core);
            echo $moduleBlock->AddModule();
         }
         
         /**
          * Charge les modules du projet
          */
         function LoadModule()
         {
           echo ElementHelper::GetBlock($this->Core, JVar::GetPost('Projet'));  
         }
         
         /**
          * Popin d'ajout d'une action à un module
          */
         function ShowAddActionModule()
         {
            $moduleBlock = new ModuleBlock($this->Core);
            echo $moduleBlock->ShowAddActionModule();
         }
         
         /*
          * Ajoute l'action au module
          */
         function AddActionModule()
         {
            $moduleBlock = new ModuleBlock($this->Core);
            echo $moduleBlock->AddActionModule();
         }
         
         /**
          * Popin d'ajout d'entite
          */
         function ShowAddEntity()
         {
            $entityBlock = new EntityBlock($this->Core);
            echo $entityBlock->ShowAddEntity();
         }
         
         /**
          * Creation d'un entite
          */
         function CreateEntity()
         {
             $name = JVar::GetPost("Name");
             $shared = JVar::GetPost("Shared");
             $projet = JVar::GetPost("Projet");
             $fields = JVar::GetPost("Fields");
             $keys = JVar::GetPost("Keys");
            
             EntityHelper::CreateEntity($this->Core, $name, $shared, $projet, $fields, $keys);
             
             echo "<span class='success' >".$this->Core->GetCode("EeIde.EntityCreated")."</span>";
         }

         /**
          * Joue le script d'installation
          */
         function CreateTable()
         {
             EntityHelper::CreateTable($this->Core, JVar::GetPost("Projet"));
             
             echo $this->Core->GetCode("SaveOk");
         }
         
         /**
          * Charge les entite
          */
         function LoadEntity()
         {
           echo ElementHelper::GetEntity($this->Core, JVar::GetPost('Projet'));  
         }
         
         /**
          * Affiche les donnée de l'entite
          */
         function ShowDataEntity()
         {
            $entityBlock = new EntityBlock($this->Core);
            echo $entityBlock->ShowDataEntity();
         }
         
         /**
          * Supprime une entite
          */
         function DeleteEntity()
         {
             EntityHelper::DeleteEntity($this->Core, JVar::GetPost("Projet"), JVar::GetPost("Name"));
         }
         
         /**
          * Affiche les templates d'un module
          */
         function ShowTemplate()
         {
            $templateBlock = new TemplateBlock($this->Core);
            echo $templateBlock->Show();
         }
         
         /**
          * Charge le code du template
          */
         function LoadCodeTemplate()
         {
             $templateBlock = new TemplateBlock($this->Core);
             echo $templateBlock->LoadCodeTemplate();
         }
         
         /**
          * Sauvegarde un template
          */
         function SaveTemplate()
         {
             $templateBlock = new TemplateBlock($this->Core);
             echo $templateBlock->SaveTemplate();
         }
         
         /**
          * Popin d'ajout de fonction Js
          */
         function ShowInsertJs()
         {
             $insertBlock = new InsertBlock($this->Core);
             echo $insertBlock->ShowInsertJs();
         }
         
         /**
          * Popin d'ajout de fonction Php
          */
         function ShowInsertPhp()
         {
             $insertBlock = new InsertBlock($this->Core);
             echo $insertBlock->ShowInsertPhp();
         }
         
         /**
          * Récupère les parametres d'une fonction js
          */
         function GetParameterJsFonction()
         {
             $insertBlock = new InsertBlock($this->Core);
             echo $insertBlock->GetParameterJsFonction();
         }
         
         /**
          * Récupère les parametres d'une fonction js
          */
         function GetParameterPhpFonction()
         {
             $insertBlock = new InsertBlock($this->Core);
             echo $insertBlock->GetParameterPhpFonction();
         }
         
         /**
          * Récupère le code d'un template avec les paramètres
          */
         function GetCodeTemplate()
         {
             $insertBlock = new InsertBlock($this->Core);
             echo $insertBlock->GetCodeTemplate();
         }
         
         /**
          * Popin d'ajout d'helper
          */
         function ShowAddHelper()
         {
            $helperBlock = new HelperBlock($this->Core);
            echo $helperBlock->ShowAddHelper();
         }
         
          /**
          * Cree le module
          */
         function AddHelper()
         {
            $helperBlock = new HelperBlock($this->Core);
            echo $helperBlock->AddHelper();
         }
         
         /**
          * Charge les helper
          */
         function LoadHelper()
         {
           echo ElementHelper::GetHelper($this->Core, JVar::GetPost('Projet'));  
         }
         
         /**
          * Affiche le détail d'une image
          */
         function ShowImage()
         {
            // $file = "../Data/Apps/EeIde/".JVar::GetPost("Projet")."/Images/".JVar::GetPost("File");
            $file = EeIde::$Destination. "/".JVar::GetPost("Projet")."/Images/".JVar::GetPost("File");
            $image = new Image($file);
            echo $image->Show();
         }
         
        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName)
        {
           //Ajout de l'image dans le repertoire correspondant
           //$directory = "../Data/Apps/EeIde/".$idElement."/Images";
           $directory = EeIde::$Destination."/".$idElement."/Images";
            //Sauvegarde
            move_uploaded_file($tmpFileName, $directory."/". $fileName);
        }
        
         /**
          * Charge les entite
          */
         function LoadImage()
         {
           echo ElementHelper::GetImage($this->Core, JVar::GetPost('Projet'));  
         }
         
         /**
          * Deploit l'application
          */
         function Deploy()
         {
             echo DeployHelper::Deploy($this->Core, JVar::GetPost("Projet"));
         }
         
         /**
          * Récupere les informations de l'utilisateur sur l'application
          */
         function GetInfo()
         {
             $projets = ProjetHelper::GetProjet($this->Core);
             
             $html = "<h4>".$this->Core->GetCode("EeIde.MyProjet")."</h4>";
             if(count($projets) > 0)
             {   
                 $html .= "<ul class='alignLeft'>";
                     
                 foreach($projets as $projet)
                 {
                     $link = new Link($projet->Name->Value, "#");
                     $link->OnClick = "Eemmys.StartApp('', '".$projet->Name->Value."')";
                     $html .= "<li>".$link->Show()."</li>";
                 }
                 
                 $html .= "</ul>";
             }
            else 
            {
                $html .= $this->Core->GetCode("EeIde.NoProjet");
            }
            
            return $html;
         }
         
         /**
          * Obtient les prototype d'un projet
          * @param type $appName
          * @param type $entityName
          * @param type $entityId
          */
         function GetByApp($appName, $entityName, $entityId)
         {
             return ProjetHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
         }
         
         /**
          * Gestion de la landing page personnalisé
          */
         function LoadLandingPage()
         {
             echo LandingPageHelper::LoadLandingPage(JVar::GetPost("Projet"));
         }
         
         /*
          * install la base de webemyos
          * Base de donnée
          */
         function InstallWebemyos()
         {
             $serverName = JVar::GetPost("tbServerName");
             $login = JVar::GetPost("tbLogin");
             $password = JVar::GetPost("tbPassWord");
             $dataBaseName = JVar::GetPost("tbDataBaseName");
         
             if($serverName != "" && $login != "" && $dataBaseName != "")
             {
                 InstallHelper::InstallWebemyos($this->Core,
                                                $serverName,
                                                $login,
                                                $password,
                                                $dataBaseName
                         );
            
                 echo "<br/><br/><span class='success'>Installation réussie.</span>";
                 
                 echo "<h2>Création de votre compte</h2>";
                 echo $this->GetRegistration();
             }
             else
             {
                 echo "<span class='error'>Vous devez remplir tous les champs</span>";
                 
                 echo $this->GetContent();
             }
         }
         
          /**
         * Obtient le contenu de la page
         */
        function GetContent()
        {
            $jbInstall = new AjaxFormBlock($this->Core, 'jbInstall');
            $jbInstall->App = "EeIde";
            $jbInstall->Action = "InstallWebemyos";
              
            // //App liée
            //  $jbBudget->AddArgument("AppName", $appName);
            $jbInstall->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbServerName", "Libelle" => "Serveur" ),
                                            array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => "Identifiant" ),
                                            array("Type"=>"PassWord", "Name"=> "tbPassWord", "Libelle" => "Mot de passe" ),
                                            array("Type"=>"TextBox", "Name"=> "tbDataBaseName", "Libelle" => "Base de donnée" ),
                                            array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => "Installer"),
                                )
                      );
              
              return $jbInstall->Show();
        }
        
        /*
         * Permet de se créer un compte
         */
        function GetRegistration()
        {
            $jbUser = new AjaxFormBlock($this->Core, 'jbUser');
            $jbUser->App = "EeIde";
            $jbUser->Action = "CreateUser";
              
            // //App liée
            //  $jbBudget->AddArgument("AppName", $appName);
            $jbUser->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => $this->Core->GetCode("Login") ),
                                            array("Type"=>"PassWord", "Name"=> "tbPassWord", "Libelle" => $this->Core->GetCode("Password") ),
                                            array("Type"=>"PassWord", "Name"=> "tbVerify", "Libelle" => $this->Core->GetCode("verify") ),
                                            array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                                )
                      );
              
              return $jbUser->Show();
        }
        
        /*
         * Crée un utilisateur
         */
        function CreateUser()
        {
             $login = JVar::GetPost("tbLogin");
             $password = JVar::GetPost("tbPassWord");
             $verify = JVar::GetPost("tbVerify");
             
             if($login != "")
             {
                 if($password != "")
                 {
                    if($password == $verify)
                    {
                            $user = new User($this->Core);
                            $user->Email->Value = $login;
                            $user->PassWord->Value = $password;
                            $user->GroupeId->Value = 2;
                            $user->Save();
                            
                            //Chargement de l'utilisateur
                            $userId = $this->Core->Db->GetInsertedId();
                           
                            //Connecte l'utilisateur
                            JVar::Connect("", 2, $this->Core, $userId);

                            echo "<span class='success'><i class='fa fa-check' >&nbsp;</i>Création du compte réussie</span>";
                            echo "<p><br/>Vous pouvez accèder à l'application en cliquant sur le lien suivant <a href='Membre/'>Accéder a l'application</a></p>";
                    }
                    else
                    {
                       echo "Le mot de passse et la vérification ne sons pas identique";
                       echo $this->GetRegistration();
                    }
                 }
                 else
                 {
                    echo "Vous devez saisir un mot de passe";
                    echo $this->GetRegistration();
                 }
             }
             else
             {
                 echo "Vous devez saisir un login";
                 echo $this->GetRegistration();
             }
        }
        
        /*
         * Pop in d'ajout de dépot
         */
        function ShowAddDepot()
        {
            $depotBlock = new DepotBlock($this->Core);
            echo $depotBlock->ShowAddDepot();
        }
        
        /*
         * Télecharge un dépot
         */
        function UploadDepot()
        {
            DepotHelper::Upload($this->Core, JVar::GetPost("depot"));
        }
        
        /*
         * Popin de suprression de Dépôt
         */
        function ShowDeleteDepot()
        {
            $depotBlock = new DepotBlock($this->Core);
            echo $depotBlock->ShowDeleteDepot();
        }
        
        /*
         * Supprime un dépot
         */
        function DeleteDepot()
        {
            DepotHelper::Delete($this->Core, JVar::GetPost("depot"));
        }
        
        /**
         * POp in pour commiter un dépot
         */
        function ShowCommitDepot()
        {
            $depotBlock = new DepotBlock($this->Core);
            echo $depotBlock->ShowCommitDepot();
        }
        
         /*
         * Commit un dépot
         */
        function CommitDepot()
        {
            DepotHelper::Commit(JVar::GetPost("depot"));
        }
        
}

?>
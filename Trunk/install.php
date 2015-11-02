 <?php
 /**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/**
 * Page d'installation de WebemyosIde
 *
 * */
 class install
 {
	function install()
	{
		//Version
 		$this->Version = "2.1.0.0";

		//Initialisation du coeur
		$this->Core=new Core(true);

	        //Initialisation de la masterPage
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");

		// Ajout du titre
		$this->Core->Page->Title = $this->Core->GetCode("home");

		//Ajout de la description
		$this->Core->Page->Masterpage->AddBlockTemplate("!Description", "Installation de Webemyos");
                $this->Core->Page->Masterpage->AddBlockTemplate("!Title", "Installation de WebemyosIde");

                // Ajout du template
		$this->Core->Page->Template = "Template/install.tpl";

                
                if(JVar::Get("Action") != "")
                {
                    $methode = JVar::Get("Action");
                    $this->Core->Page->AddBlockTemplate("!content" , $this->$methode());
                    
                }
                else
                {
                    $this->Core->Page->AddBlockTemplate("!content" , $this->GetContent());
                }
                
	}
	
	function CreatePage()
	{
	}
        
        /**
         * Obtient le contenu de la page
         */
        function GetContent()
        {
            $jbInstall = new AjaxFormBlock($this->Core, 'jbInstall');
            $jbInstall->App = "EeIde";
            $jbInstall->Action = "InstallWebemyos";
            $jbInstall->CssClass = "alignCenter";
              
            // //App liée
            //  $jbBudget->AddArgument("AppName", $appName);
            $jbInstall->AddControls(array(
                                           array("Type"=>"TextBox", "Name"=> "tbServerName", "Libelle" => "Serveur " ),
                                           array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => "Identifiant" ),
                                           array("Type"=>"PassWord", "Name"=> "tbPassWord", "Libelle" => "Mot de passe" ),
                                           array("Type"=>"TextBox", "Name"=> "tbDataBaseName", "Libelle" =>  "Nom de la base de donnée"  ),
                                           array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => "Installer"),
                                )
                      );
              
              return $jbInstall->Show();
        }
        
        /**
         * Charge la base de donnée
         */
        function LoadDataBase()
        {
            $html = "<h1>Chargement de la base de donnée</h1>";
            
            //Récupere et execute le script
            $request = JFile::GetFileContent("Db/eemmys.sql", false);
            $this->Core->Db->ExecuteMulti($request);
            
            $html .= "<p>Chargement des données réussie</p>";
            
            return $html;
        }
 }

?>



<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 * Page de creation de compte
 *
 * */
 class inscription
 {
	function inscription()
	{
		//Version
 		$this->Version = "2.1.0.0";

		//Initialisation du coeur
		$this->Core=new Core(true);

	    //Initialisation de la masterPAge
		$this->Core->Page->SetMasterPage("masterPage.php","masterPage");

		//Ajout du titre
		$this->Core->Page->Title = $this->Core->GetCode("Create account");

		//Ajout de la description
		$this->Core->Page->Masterpage->AddBlockTemplate("!Title", $this->Core->GetCode("Inscription"));

		// Ajout du template
		$this->Core->Page->Template = "Template/inscription.tpl";

                $html = "<div class='row'>";
                
                /*
                * Module d'ionscription spécifique Webemyos
                */
                include("Blocks/WRegistrationBlock/WRegistrationBlock.php");

                switch(JVar::Get("Theme"))
                {
                    case "projet" :
                        $html .= "<div class='col-md-6 presentation'>";
                       	$html .= $this->GetTextPorteur();
                        $html .=  "</div>";
                                
                        $registratrion = new WRegistrationBlock($this->Core);
                        $registratrion->AddProjet = true;
                        
                        $html .= "<div class='col-md-6'>". $registratrion->Show()."</div>";
                        break;
                    case "testeur" :
                        $html .= "<div class='col-md-6 presentation'>";
                       	$html .= $this->GetTextTesteur();
                        $html .=  "</div>";
                                
                        $registratrion = new WRegistrationBlock($this->Core);
                        $registratrion->AddTesteur = true;
                        
                        $html .= "<div class='col-md-6'>". $registratrion->Show()."</div>";
                        break;
                    case "prestataire" :
                        $html .= "<div class='col-md-6 presentation'>";
                       	$html .= $this->GetTextPrestataire();
                        $html .=  "</div>";
                                
                        $registratrion = new WRegistrationBlock($this->Core);
                        $registratrion->AddPrestataire = true;
                        
                        $html .= "<div class='col-md-6'>". $registratrion->Show()."</div>";
                        break;
                }
                
                $html.= "</div>";
                
		$this->Core->Page->AddBlockTemplate("!content",$html);
	}

	function CreatePage()
	{
	}
	
	/*
	* Retourne le texte de présentation pour les porteurs de projets
	*/
	function GetTextPorteur()
	{
            $html = "<h2 class='blueOne' >En créant mon projet sur Webemyos je peux :</h2>";
                        
            $html .= "<ul>";

            $html .= "<li class='icon-desktop'>&nbsp;Créer rapidement une page de présentation du projet.</li>";
            $html .= "<li class='icon-edit'>&nbsp;Proposer une préinscription.</li>";
            $html .= "<li class='icon-bullhorn'>&nbsp;Réaliser et diffuser des enquêtes.</li>";
            $html .= "<li class='icon-group'>&nbsp;Trouver des associées, des partenaires.</li>";
            $html .= "<li class='icon-food'>&nbsp;Construire mon projet avec des outils adaptés.</li>";
            $html .= "<li class='icon-cloud'>&nbsp;Disposer d'un espace de travail et de partage.</li>";
            $html .= "<li class='icon-comment'>&nbsp;Communiquer sur mon blog, les réseaux sociaux.</li>";
            $html .= "<li class='icon-laptop'>&nbsp;Créer rapidement un Produit Minimum Viable.</li>";
            $html .= "<li class='icon-beaker'>&nbsp;Obtenir des avis, des conseils et des statistiques.</li>";
            $html .= "<li><h3 class='blueOne icon-star'>&nbsp;Lancer et réussir mon site web en toute simplicité.</h3></li>";
            $html .= "</ul>";

            return $html;
	}
        
        /**
         * Retourne les texte de présentation pour les testeurs
         */
        function GetTextTesteur()
        {
            $html = "<h2 class='blueTwo' >En participant sur Webemyos je peux :</h2>";
                        
            $html .= "<ul>";

            $html .= "<li class='icon-desktop'>&nbsp;Decouvir de nouveaux projets.</li>";
            $html .= "<li class='icon-edit'>&nbsp;Proposer des idées.</li>";
            $html .= "<li class='icon-bullhorn'>&nbsp;Répondre aux enquêtes.</li>";
            $html .= "<li class='icon-comment'>&nbsp;Donner mes besoins, mes ressentis, être entendu.</li>";
            $html .= "<li class='icon-laptop'>&nbsp;Tester et utiliser des applications web.</li>";
            $html .= "<li class='icon-money'>&nbsp;Obtenir des réductions et des avantages sur les sites qui sortent de Webemyos.</li>";
            $html .= "<li><h3 class='blueTwo icon-star'>&nbsp;Devenir acteur du web de demain.</h3></li>";
            
            $html .= "</ul>";

            return $html;
        }
        
         /**
         * Retourne les texte de présentation pour les prestataires
         */
        function GetTextPrestataire()
        {
            $html = "<h2 class='blueTree' >En m'inscrivant sur Webemyos je peux :</h2>";
                        
            $html .= "<ul>";

            $html .= "<li class='icon-desktop'>&nbsp;Decouvir de nouveaux projets.</li>";
            $html .= "<li class='icon-edit'>&nbsp;Répondre aux annonces.</li>";
            $html .= "<li class='icon-bullhorn'>&nbsp;Proposer mes compétences.</li>";
            $html .= "<li class='icon-laptop'>&nbsp;Tester et utiliser des applications web.</li>";
            $html .= "<li><h3 class='blueTree icon-star'>&nbsp;Construire le web de demain.</h3></li>";
            
            $html .= "</ul>";

            return $html;
        }
	
 }
?>

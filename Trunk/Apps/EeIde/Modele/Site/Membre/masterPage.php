<?php
//Creation de la master page

 class masterPage extends JHomPage
 {
 	//Constructeur
 	function masterPage($core="")
 	{
		//Coeur
 		$this->Core = $core;

		//Ajout du skin
 		$this->InsertCss($this->Core->GetSkin());

		//Ajout des js
		$this->InsertJsScript("Eemmys.js");
		$this->InsertJsScript("JHom/Jscripts/jquery.js");
		$this->InsertJsScript("JHom/Jscripts/moodular.js");
		$this->InsertJsScript("JHom/Jscripts/calendar/calendar.js");

		//Definition du template
		$this->Template = "../JHom/Template/Pages/masterPageMember.tpl";

                //Ajout du module de connection
                $passBlock = new PassBlock($this->Core);
                $passBlock->Frame = false;
                $passBlock->Table = false;
                        
                
                //$this->AddBlockTemplate("!passBlock", $passBlock->Show());
                
                //Ajout de menu de gauche
                $app = new CooltureInstitute($this->Core);
                
                //Tableau de boird du membre
                $this->AddBlockTemplate("!menuLeft", $app->GetMenuLeft());
                
                //Lien en bas
                $lkContact = new Link("<li>Nous Contacter</li>", "#");
                $lkContact->Title = "Nous Contacter";
                $lkContact->OnClick = "CooltureInstituteAction.LoadFormContact()"; 
                
                $this->AddBlockTemplate("!lkContact", $lkContact->Show());
                
                //Lien en bas
                $lkQuiSommeNous = new Link("<li>Qui sommes nous</li>", "#");
                $lkQuiSommeNous->Title = "Nous Contacter";
                $lkQuiSommeNous->OnClick = "CooltureInstituteAction.LoadFormQuiSommeNous()"; 
                
                $this->AddBlockTemplate("!lkQuiSommeNous", $lkQuiSommeNous->Show());
                
		return $this;
 	}
}
?>

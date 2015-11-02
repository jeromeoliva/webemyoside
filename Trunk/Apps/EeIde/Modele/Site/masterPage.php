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

		//Definition du template
		$this->Template = "Template/masterPage.tpl";

		//Logo
		if(JVar::IsConnected($this->Core))
		{
			$url = $this->Core->User->Groupe->Value->Section->Value->Directory->Value;
			$imgLogo = new LinkImage($url,"Images/Logo/logo.png", "Eemmys", "", false);
                        
                        //Accès au bureau
                        $profilLightBlock = new ProfilLightBlock($core);
                        $this->AddBlockTemplate("!passBlock", $profilLightBlock->Show());
                }
		else
		{
			$imgLogo = new LinkImage(".","Images/Logo/logo.png","Eemmys", "", false);
		 
                       //Block de connection
                       $passBlock = new PassBlock($this->Core);
                       $passBlock->Table = false;
                       $passBlock->Frame = false;

                       $this->AddBlockTemplate("!passBlock", $passBlock->Show());
                }
               
                $this->AddBlockTemplate("!imgLogo", $imgLogo->Show());
                
               //Cree le menu
                $this->SetMenu();
                
                //Traduit les textes multilangue
                $this->SetLangue();
                $this->SetDataText();
                
		return $this;
 	}
        
        /**
         * Crée les différents menu
         */
        function SetMenu()
        {
            $html = "<div class='menu-menu1-container'>
                        <ul id='sticky-menu' class='primary-menu inline'>
                        <li id='menu-item-22' class='menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-5'><a title='home' href='home.html'>".$this->Core->GetCode("home")."</a></li>
                        </ul>
                     </div>";
            
            $this->AddBlockTemplate("!menu", $html); 
        }
        
        /**
         * Traduit les texte multilangue
         */
        function SetLangue()
        {
            $textes = array("!home");
            
            foreach($textes as $texte)
            {
                 $this->AddBlockTemplate($texte, $this->Core->GetCode(str_replace("!", "", $texte)));
            }
        }
        
        /**
         * Traduit les DataTexte
         */
        function SetDataText()
        {
            $textes = array("!home");
            
            foreach($textes as $texte)
            {
                 $this->AddBlockTemplate($texte, $this->Core->GetCode(str_replace("!", "", $texte)));
            }
        }
}
?>

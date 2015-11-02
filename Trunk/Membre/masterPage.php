 <?php
 /**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/**
 * Page principale de la partie membre
 * */
class masterPage extends JHomPage
 {
 	//Constructeur
 	function masterPage($core="")
 	{
 		//Coeur
 		$this->Core = $core;

		//Ajout de la Google WebFont
		$this->InsertCss("http://fonts.googleapis.com/css?family=Varela+Round");

 		//Ajout du skin
 		$this->InsertCss($this->Core->GetSkin());

		//Definition du template
		$this->Template = "../JHom/Template/Pages/masterPageMembre.tpl";

	
                echo "je suis la";    
		return $this;
 	}

 }
?>
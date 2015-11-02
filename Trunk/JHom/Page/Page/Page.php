<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Page extends JHomPage
{
	public  $Masterpage;
	private $AdvancedText;

	function Page($core)
	{
		//Version
		$this->Version = "2.0.1.0";

		$this->Core = $core;
		$this->Message= new JMessage($core);
		$this->AdvancedText = true;
	}

	//Propriete
	function SetMasterPage($file, $name)
	{
		//recuperation du ficher de la master page
		if(file_exists($file))
		{
			include $file;
			$this->Masterpage = new $name($this->Core);
		}
	}

	//Affichage
	function Show()
	{
		//Insertion des script js
		$this->InsertJsScript("script.php");
		//$this->InsertJsScript("script.js");
		
		//JS compresse
		//$this->InsertJsScript("trunk/script.js");

		//$this->InsertJsScript($this->Core->GetJsScript()."tiny_mce/tiny_mce.js");

		//Initialisation de tini_mce
		if($this->AdvancedText)
		{
		    $this->Core->Page->InsertScript(AdvancedText::Initialise());
		}

		if($this->Template != "" || (isset($this->MasterPage) && $this->Masterpage->Template != "") )
		{
		    // Recuperation du template de la masterPage
			$textControl = JFile::GetFileContent($this->Masterpage->Template);

			//Recuperation du template de la page
			$textControlCenter =  JFile::GetFileContent($this->Template);

			//Chargement des données
			$textControl = str_replace("!title",(($this->Title != "")?$this->Core->GetSiteName() . " ".$this->Title:"JHomSoft"), $textControl );
			$textControl = str_replace("!head", $this->Masterpage->Head.$this->Head, $textControl);
			$textControl = str_replace("!toper", $this->Masterpage->Header.$this->Header, $textControl);
			$textControl = str_replace("!lefter", $this->Masterpage->Lefter.$this->Lefter, $textControl);

			//Chargement de la partie commune
			foreach($this->BlockTemplate as $key => $value)
			{
				$textControlCenter = str_replace($key, $value, $textControlCenter);
			}

			$textControl = (str_replace("!center",$this->Masterpage->Center.$this->Center . $textControlCenter ,$textControl ));

			$textControl = str_replace("!righter", $this->Masterpage->Righter.$this->Righter, $textControl);
			$textControl = str_replace("!footer", $this->Masterpage->Footer.$this->Footer, $textControl);

			//Ajout des modules templates de la masterPage
			foreach($this->Masterpage->BlockTemplate as $key => $value)
			{
				$textControl = str_replace($key, $value, $textControl);
			}

			// Ajout des eventuelles action javascript
			$textControl .= $this->Message->Action;

			echo $textControl;
		}
		else
		{

		//Si il y a une variable $MasterPage On recupere les donn�es de la masterPage
		if(isset($this->Masterpage) && $this->Masterpage !="")
		{
			$page =$this->Masterpage->Doctype.$this->Doctype."\n";
			$page .= "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fr-fr' lang='fr-fr'>";

			//gestion du titre de la page
			$Title="\n<title>".(($this->Title != "")?$this->Core->GetSiteName() . " ".$this->Title:"JHomSoft")."</title>";

			$page .="\n<head>".$Title.$this->Masterpage->Head.$this->Head."\n</head>\n";
			$page .=($this->Style !="")?"\n<body  style='".$this->Style."'>"  :  "\n<body>";
			$page .=$this->Body."\n";
		    $page .= "<div id='head'>".$this->Masterpage->Header.$this->Header."</div>";
			$page .= "<div id='left'>".$this->Masterpage->Lefter.$this->Lefter."</div>";
			$page .= "\n<div id='center'>".$this->Masterpage->Center.$this->Center."</div>";
			$page .= "\n<div id='right'>".$this->Masterpage->Righter.$this->Righter."</div>";
			$page .= "\n<div id='foot'>".$this->Masterpage->Footer.$this->Footer."</div>";


			$page .=$this->Message->Action."\n";
			$page .="</body>\n</html>";
		}
		//Sinon c'est une page standard
		else
		{
			//gestion du titre de la page
			$Title="\n<title>".(($this->Title != "")?$this->Core->GetSiteName() . " ".$this->Title:"JHomSoft")."</title>";

			$page =$this->Doctype."\n";
			$page .="<head>".$Title.$this->Head."\n</head>\n";
			$page .=($this->Style !="")?"  <html>\n<body  style='".$this->Style."'>"  :  "<body>";
			$page .=$this->Body."\n";
			$page .= "<div id='head'>".$this->Header."</div>";
			$page .= "<div id='left'>".$this->Lefter."</div>";
			$page .= "\n<div id='center'>".$this->Center."</div>";
			$page .= "\n<div id='right'>".$this->Righter."</div>";
			$page .= "\n<div id='foot'>".$this->Footer."</div>";
			$page .=$this->Message->Action."\n";
			$page .="</body>\n</html>";
		}
		echo $page;
	  }
	}
	//Asseceurs
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
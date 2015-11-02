<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class LinkAriane extends JHomControl implements IJHomControl
{
	//Propriete
	private $Link;
	private $Url;
	private $Links =array();

	//Constructeur
	function LinkAriane($name)
	{
		//Version
		$this->Version ="2.0.1.0";

		$this->Name=$name;
		$this->Id=$name;
	}

	//Ajout de lien
	function Add($link,$url)
	{
		$Link = new Link($link,$url);
		$this->Links[] = $Link;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<span '";
		$TextControl .= $this->getProperties();
		$TextControl .=">";

		if(sizeof($this->Links)>0)
		{
			foreach($this->Links as $link)
			{
				$TextControl .= $link->Show() .  " > ";
			}
		}

		$TextControl .=$this->Link."</span>";

		return $TextControl ;
	}
}
?>

<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class TextArea extends JHomControl implements IJHomControl
{
	//Proprietes
	private $Title="";
	private $Text="";

	//Constructeur
	public function TextArea($name, $resize=false)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
 		$this->Name=$name;

 		$this->AutoCapitalize = 'None';
    	$this->AutoCorrect = 'None';
    	$this->AutoComplete = 'None';

		if($resize==true) $this->AddAttribute("onkeyup","FitToContent(this,500)");
	}

	//Affichage
	function Show()
	{
		//Recuperation d'une eventuelle valeur
		if(JVar::GetPost($this->Name))
		{
			$this->Value=JVar::GetPost($this->Name);
		}

		//Declaration de la balisepx
		$TextControl ="\n<textArea  " ;
		$TextControl .= $this->getProperties(false);
		$TextControl .=">";

		$TextControl .=$this->Title;
		$TextControl .=$this->Text;
		$TextControl .=$this->Value;

		$TextControl .="</textArea>\n";

		return $TextControl;
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
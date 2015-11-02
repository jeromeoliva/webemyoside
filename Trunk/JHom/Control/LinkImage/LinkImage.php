<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class LinkImage extends JHomControl implements IJHomControl
{
	//Propriete
	private $Image;
	private $Url;
	private $Title;
	private $LinkColor;
	private $ShowTitle;
	private $Alt;

	//Constructeur
	function LinkImage($url,$image,$title="",$linkColor="white",$showTitle=true)
	{
		//Version
		$this->Version ="2.0.0.1";

		$this->Url=$url;
		$this->Image=$image;
		$this->Title = $title;
		$this->LinkColor = $linkColor;
		$this->ShowTitle = $showTitle;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<a href='".$this->Url."' ";
		$TextControl .=">";

		$TextControl .="\n<img src='";

		$TextControl .= $this->Image."' " ;
		$TextControl .= $this->getProperties();
		$TextControl .=" title='".$this->Title."'";
		$TextControl .="  />";
		$TextControl .="</a>";

		if($this->ShowTitle)
			$TextControl .= $this->Title;

		return $TextControl ;
	}

	//asseceurs
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

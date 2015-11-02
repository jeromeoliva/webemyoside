<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Menu extends JHomControl implements IJHomControl
{
	//Proprietes
	private $item;
	private $subItem;
	private $iItem=0;
	private $iSubItem=0;

	//Constructeur
	public function Menu($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
	}

	//Ajout d'un menu principal
	function AddItem($Libelle,$Url)
	{
		$this->item[$this->iItem]["libelle"]=$Libelle;
		$this->item[$this->iItem]["url"]=$Url;
		$this->iItem ++;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<div ";
		$TextControl .= $this->getProperties();
		$TextControl .=">";
		$TextControl .="\n<table><tr>";

		foreach($this->item as $items)
		{
			$TextControl .="\n\t<td class='headItem'>";
				if($items["url"] !="")
					$TextControl.="<a class='item' href='".$items["url"]."'>".$items["libelle"]."</a>";
				else
					$TextControl .= "<a class='item' href='#".$items["libelle"]."'>".$items["libelle"]."</a>";


			$TextControl .="</td>";
		}
		$TextControl .="\n</tr></table>\n</div>";

		return $TextControl;
	}
}
?>
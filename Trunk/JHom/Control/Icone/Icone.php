<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class Icone extends JHomControl implements IJHomControl
{
	//Proprietes
	private $Directory;
	private $Src;
	private $Title;
	private $Description;
	private $Alt;
	public $Color;

	//Constructeur
	function Icone()
	{
		//Version
		$this->Version ="2.0.0.1";
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<span ";
	
		$this->CssClass .= " ".$this->Color;
	
		$TextControl .= $this->getProperties();
		$TextControl .=" title='".$this->Title."'";
		$TextControl .=" alt ='".$this->Alt."'";
		$TextControl .="  >";
	
		$TextControl .="</span>";

		return $TextControl ;
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

/*
* Icone de suppression
*/
class DeleteIcone extends Icone 
{
	function DeleteIcone()
	{	
		$this->CssClass = "icon-remove ";
		$this->Color= 'red';
	}
}

/*
* Icone d'edition
*/
class EditIcone extends Icone
{
	function EditIcone()
	{
		$this->CssClass = "icon-edit";
	}
}

/*
* Icone de partage
*/
class GroupIcone extends Icone
{
	function GroupIcone()
	{
		$this->CssClass = "icon-group";
	}
}

/*
* Icone de validation
*/
class ValideIcone extends Icone
{
	function ValideIcone()
	{
		$this->CssClass = "icon-ok";
		$this->Color = "green";
	}
}

/*
* Icone de boite de recepetion
*/
class EnvelopeIcone extends Icone
{
	function EnvelopeIcone()
	{
		$this->CssClass = "icon-envelope";
	}
}

/*
* Icone de extendn
*/
class ExpandIcone extends Icone
{
	function ExpandIcone()
	{
		$this->CssClass = "icon-expand";
	}
}

/*
* Icone d'ajout
*/
class AddIcone extends Icone
{
	function AddIcone()
	{
		$this->CssClass = "icon-plus-sign";
	}
}

/*
* Icone de fermeture
*/
class CloseIcone extends Icone
{
	function CloseIcone()
	{
		$this->CssClass = "icon-off";
	}
}

/*
* Icone d'information
*/
class InformationIcone extends Icone
{
	function InformationIcone()
	{
		$this->CssClass = "icon-exclamation";
	}
}

/*
* Icone d'information
*/
class HelpIcone extends Icone
{
	function HelpIcone()
	{
		$this->CssClass = "icon-question";
	}
}

/*
* Icone d'information
*/
class CommentIcone extends Icone
{
	function CommentIcone()
	{
		$this->CssClass = "icon-comment";
	}
}

/*
* Icone d'information
*/
class BugIcone extends Icone
{
	function BugIcone()
	{
		$this->CssClass = "icon-bug";
	}
}

/*
* Icone de dossier
*/
class FolderIcone extends Icone
{
	function FolderIcone()
	{
		$this->CssClass = "icon-folder-open";
	}
}

/*
* Icone de parametre
*/
class ParameterIcone extends Icone
{
	function ParameterIcone()
	{
		$this->CssClass = "icon-gear";
	}
}

/*
* Icone d'accueil
*/
class HomeIcone extends Icone
{
	function HomeIcone()
	{
		$this->CssClass = "icon-home";
	}
}

/*
* Icone Search
*/
class SearchIcone extends Icone
{
	function SearchIcone()
	{
		$this->CssClass = "icon-search";
	}
}

/*
* Icone dechange
*/
class ExchangeIcone extends Icone
{
	function ExchangeIcone()
	{
		$this->CssClass = "icon-exchange";
	}
}

/*
* Icone de partage
*/
class ShareIcone extends Icone
{
	function ShareIcone()
	{
		$this->CssClass = "icon-share";
	}
}

/*
* Icone de de panier
*/
class CartIcone extends Icone
{
	function CartIcone()
	{
		$this->CssClass = "icon-shopping-cart";
	}
}

/**
 * Disquette
 */
class SaveIcone extends Icone
{
    function SaveIcone()
    {
        $this->CssClass = "icon-save";
    }
}

/**
 * Utilisateurs
 */
class UsersIcone extends Icone
{
    function UsersIcone()
    {
        $this->CssClass = "icon-group";
    }
}

/**
 * Zoom +
 */
class ZoomInIcone extends Icone
{
    function ZoomInIcone()
    {
        $this->CssClass = "icon-zoom-in";
    }
}

/**
 * icone type liste
 */
class ListIcone extends Icone
{
    function ListIcone()
    {
        $this->CssClass = "icon-list";
    }
}

?>
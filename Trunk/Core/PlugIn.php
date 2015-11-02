<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/**
 * Classe qui permet de récuperer les configuration de l'utilisateur
 * pour l'application
 */
class PlugIn
{
	private $Core;
	private $Name;
	private $Config;
	private $FileName;
	private $Plugs = array();

	/**
	 * Constructeur
	 */
	function PlugIn($core, $name, $directory, $type = "App")
	{
		$this->Core = $core;
		$this->Name = $name;

		if($type == "App")
		{
			$fileName = "../Apps/$this->Name/plugin.xml";
			$this->FileName = $fileName;
		}
		else
		{
			$fileName = "../Widgets/$this->Name/plugin.xml";
			$this->FileName = $fileName;
		}
	}

	//Retourne les plugn associé
	function GetPlugin()
	{
		if(file_exists($this->FileName))
		{
			$this->Dom = new DomDocument();
			$this->Dom->load($this->FileName);

			$Plugs = $this->Dom->getElementsByTagName("plugins");
			$PlugIns = $Plugs->item(0);

			foreach($PlugIns->childNodes as $node)
			{
				$this->Plugs[] = $node->getAttribute("name");
			}

			return $this->Plugs;
		}
	}

	/**
	 * Defini un parametre
	 */
	function Set($key, $value)
	{
		if($this->Config != null)
		{
			$exist = false;

			//Verification
			if($this->Config->childNodes != null)
			{
				foreach($this->Config->childNodes as $node)
				{
					if($node->getAttribute("key") == $key)
					{
						$node->setAttribute("value",$value);
						$exist = true;
					}
				}
			}
			if(!$exist)
			{
				$element 	= $this->Dom->createElement("element");
				$element->setAttribute("value", $value);
				$element->setAttribute("key", $key);

				$this->Config->appendChild($element);
			}

			$this->Dom->Save($this->FileName);
		}
	}

	/**
	 * Obtient un parametre
	 */
	function Get($key)
	{
		if($this->Config != null)
		{
			foreach($this->Config->childNodes as $node)
			{
				if($node->getAttribute("key") == $key)
				{
					return $node->getAttribute("value");
				}
			}
		}

		return false;
	}

	/**
	 * Retourne tous les elements
	 */
	function GetElements($field = "value")
	{
		$widgets = array();
		if($this->Config != null)
		{
			foreach($this->Config->childNodes as $node)
			{
				if($field == "value")
					$widgets[] = $node->getAttribute("value");
				else
					$widgets[] = $node->getAttribute($field);
			}
		}

		return $widgets;
	}

	/**
	 * Ajoute un element
	 */
	function AddElement($key)
	{
		$this->Set($key, $key);
	}

	/**
	 * Supprime un element
	 */
	function DeleteElement($key)
	{
		if($this->Config != null)
		{
			foreach($this->Config->childNodes as $node)
			{
				if($node->getAttribute("key") == $key)
				{
					$this->Config->removeChild($node);
				}
			}
		}

		$this->Dom->Save($this->FileName);
	}
}

?>
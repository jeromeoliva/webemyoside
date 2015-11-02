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
class Config
{
	private $Core;
	private $Name;
	private $Config;
	private $FileName;
	private $Directory;

	/**
	 * Constructeur
	 */
	function Config($core, $name, $directory, $front= false)
	{
		$this->Core = $core;
		$this->Name = $name;
		$this->Directory = $directory;

		$fileName = "User/".md5($this->Core->User->IdEntite)."/".$directory."/".$this->Name.".xml";
		
		//Repertoire courant ou depuis Tools
		if(!file_exists($fileName))
		{
            if($front == true)
            {
                $fileName = "Membre/User/".md5($this->Core->User->IdEntite)."/".$directory."/".$this->Name.".xml";
            }
            else
            {
                $fileName = "../Membre/User/".md5($this->Core->User->IdEntite)."/".$directory."/".$this->Name.".xml";
            }
    }
		
		$this->FileName = $fileName;

		if(file_exists($fileName))
		{
			$this->Dom = new DomDocument();
			$this->Dom->load($fileName);

			$Config = $this->Dom->getElementsByTagName("config");
			$this->Config = $Config->item(0);
		}
	}

	/**
	 * Defini un parametre
	 */
	function Set($key, $value)
	{
     
        //Creation du fichier si il existe pas
		if($this->Config == null)
	  {  
    	$Text = '<?xml version="1.0"?><config></config>';
			JFile::Create($this->FileName, $Text);

			$this->Dom = new DomDocument();
			$this->Dom->load($this->FileName);

			$Config = $this->Dom->getElementsByTagName("config");
			$this->Config = $Config->item(0);
		}

		if($this->Config != null)
		{
			$exist = false;

			//Verification
			if($this->Config->childNodes != null)
			{
				foreach($this->Config->childNodes as $node)
				{
					if($node->getAttribute("key") == Format::EscapeString($key))
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
				$element->setAttribute("key", Format::EscapeString($key));

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
				if($node->getAttribute("key") == Format::EscapeString($key))
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
	function GetElements($field = "value", $keyValue = false)
	{
		$widgets = array();
		if($this->Config != null)
		{
			foreach($this->Config->childNodes as $node)
			{
				if($keyValue)
				{
					$widgets[$node->getAttribute("key")] = $node->getAttribute("value");
				}
				else if($field == "value")
				{
					$widgets[] = $node->getAttribute("value");
				}
				else
				{
					$widgets[] = Format::ReplaceString($node->getAttribute($field));
				}
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
				if($node->getAttribute("key") == Format::EscapeString($key))
				{
					$this->Config->removeChild($node);
				}
			}
		}

		$this->Dom->Save($this->FileName);
	}

	/***
	 * Supprimme tout les élements
	 */
	function DeleteAll()
	{
		$elements = $this->GetElements('key');

		foreach($elements as $element)
		{
			$this->DeleteElement($element);
		}
	}
}

?>
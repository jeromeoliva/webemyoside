<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */


class JHomConfig
{
	//Proprietes
    private $Conf;
	public $File;
	public $Version;
	public $FileName;

	//Constructeur
	function JHomConfig($File="")
	{
		//Version
		$this->Version ="2.0.1.0";
		$this->FileName = $File;

		if($File != "")
		{
			if(file_exists($File))
			{
				$this->File=new JDOMDocument();
				$this->File->load($File);
			}
			else
			{
				echo $File;
				throw new Exception('Fichier de configuration non trouv�');
			}
		}
	}

	//Recuperation d'une valeur
	function GetKey($Key)
	{
		$element = $this->File->GetElementsByTagName($Key);
		if($element->item(0) != null)
		   return $element->item(0)->nodeValue;
	}

	//Afftectation d'une cle
	function SetKey($Key,$Value)
	{
		$element = $this->File->GetElementsByTagName($Key);
                $element->item(0)->nodeValue = $Value;
		$this->File->Save($this->FileName);
	}

	// Recuperation de toutes les valeurs
	function GetKeys($Key)
	{
		return $this->File->GetElementsByTagName($Key);
	}
}
?>
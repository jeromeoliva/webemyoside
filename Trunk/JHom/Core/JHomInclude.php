<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class JHomInclude
 {
 	//Proprietes
	private $Document;
	private $Folder;
	private $ReturnContent;
	public $Content;
	public $Version;

    //Constructeur
	function JHomInclude($doc="",$type="",$JDirectory="", $returnContent = false )
	{
		//Version
		$this->Version = "2.1.0.0";
		$this->ReturnContent = $returnContent;
		$this->Content ='';

		if($doc != "")
		{
			if(file_exists($doc))
			{
				$this->Document=new JDOMDocument();
				$this->Document->load($doc);

				//Recuperation des dossiers � inclure
				$Directory=$this->GetDirectory();
				$i=0;

				foreach($Directory as $folder)
				{
					//Parcourt des dossiers (classe DomDocument)
					if(is_object($folder))
					{
						$File=$JDirectory.$folder->nodeValue."/".$folder->nodeValue.".xml";
						//Inclusion des fichiers
						if(file_exists($File))
						{
							$this->Folder=new DOMDocument();
							$this->Folder->load($File);
							$this->IncludeFolder($JDirectory.$folder->nodeValue,$type);
						}
					}
					else
					{
						//Classe JHomDomDocument
						for($i=0;$i<sizeof($folder);$i++)
						{
							$File=$JDirectory.$Directory->item($i)->nodeValue."/".$Directory->item($i)->nodeValue.".xml";
							if(file_exists($File))
							{
								$this->Folder=new JDOMDocument();
								$this->Folder->load($File);
								$this->IncludeFolder($JDirectory.$Directory->item($i)->nodeValue,$type);
							}
						}
					}
				}
			}
			else
			{
				throw new Exception("Fichier de listing des repertoires non trouv�.");
			}
		}
	}

	//Recuperation des dossiers a inclures
 	private function GetDirectory()
 	{
 		return $this->Document->GetElementsByTagName("DIRECTORY");
 	}

 	//inclusion des fichiers dans les dossier
 	private function IncludeFolder($directory,$type)
 	{
 		$Folders=$this->Folder->GetElementsByTagName("ELEMENT");
 		foreach($Folders as $File)
 		{
 			if(is_object($File))
			{
              	$FileName = $directory."/".$File->nodeValue."/".$File->nodeValue.$type;
 				//Test de la presence du fichier et inclusion
 				if(file_exists($FileName))
 				{
 			 		if($this->ReturnContent)
					{
 						$this->Content .= JFile::GetFileContent($FileName);
					}
					else
					{
						include($FileName);
					}

 				}
			}
			else
			{
				for($i=0;$i<sizeof($File);$i++)
				{
					$FileName = $directory."/".$File[$i]->nodeValue."/".$File[$i]->nodeValue.$type;
 					//Test de la presence du fichier et inclusion
 					if(file_exists($FileName))
 					{
 						if($this->ReturnContent)
						{
	 						$this->Content .= JFile::GetFileContent($FileName);
						}
						else
						{
							include($FileName);
						}
					}
				}
			}
 		}
 	}
 }
?>
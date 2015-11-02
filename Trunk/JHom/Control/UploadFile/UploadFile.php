<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class UploadFile extends JHomControl implements IJHomControl
 {
 	//Propriete
 	private $FileType;
 	private $FileName;
 	private $Directory;

    //Constructeur
 	function UploadFile($name,$directory="",$fileName="",$fileType="")
 	{
 		//Version
		$this->Version ="2.0.0.0";

	    $this->Name=$name;
	    $this->Directory = $directory;
	    $this->FileName=$fileName;
	    $this->FileType =$fileType;

 	}

	//Telechargement du fichier
	function Upload($createMiniature = false, $createSmall = false)
	{
		if ($_FILES[$this->Name]['error'])
		{
			$error="";

          switch ($_FILES[$this->Name]['error']){
                   case 1: // UPLOAD_ERR_INI_SIZE
                   $error = "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                   $error = "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                   $error = "L'envoi du fichier a été interrompu pendant le transfert !";
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                   $error = "Le fichier que vous avez envoyé a une taille nulle !";
                   break;
          }

          JHomLog::Title(CORE,"Erreur",ERR);
		  JHomLog::Write(CORE,$error,ERR);

       	}
		else
		{
		if($this->FileName != "")
			$fileName= $this->FileName;
		else
		    {
		    	$fileName=$_FILES[$this->Name]['name'];
		    	$this->FileName = $fileName;
		    }

		$nameFile = JFile::UploadFile($_FILES[$this->Name]['tmp_name'], $this->Directory,$fileName, $createMiniature, $createSmall, $this->FileType);
		return $nameFile;
 		}
	}

	//Test si le fichier n'est pas  vide
	function IsValid()
	{
		return $_FILES[$this->Name]['tmp_name'] != "";
	}

 	//Affichage du control
 	function Show()
 	{
		$TextControl ="\n<INPUT type=file name=".$this->Name.">";
                         //<INPUT type=submit value='Envoyer'>";

          return $TextControl;
 	}

 	//Assesseurs
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

<?php
/*
 * Edition d'une entit�
 */
 class EditTemplate extends JHomTemplate
 {
 	//Constructeur
	function EditTemplate($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		$this->Core = $core;
	}

	/**
	 * Affiche le détail d'une entité'
	 *
	 */
	function Detail()
	{
		$EntityName = JVar::GetPost("Entity");

                if(JVar::GetPost("Projet"))
                {
                    include("../Apps/".JVar::GetPost("Projet")."/Entity/".$EntityName .".php");	
		}
                else if(JVar::GetPost("AppName") != "")
		{
                    include("../Apps/".JVar::GetPost("AppName")."/Entity/".$EntityName .".php");	
		}
		
		//Creation de l'entite
		$entity = $EntityName;
		$this->Entity = new $entity($this->Core);

	
		//Recuperation de l'identite
		if(JVar::Get("idEntity"))
		{
			$this->Entity->GetById(JVar::Get("idEntity"));
			$this->Created = true;
		}
		else
		{
			$this->Created =false;
		}

		 //Relections sur les propriete de l'entity
	$reflection = new ReflectionObject(new $EntityName($this->Core));
	$Properties=$reflection->getProperties();

	//Formulaire de saisie
	$Form = new JBlock($this->Core,"jbDetailEntity");
	$Form->Table = true;
	$Form->Frame = false;

	//resultat
	$Form->AddNew(new Libelle("<span id='lbResultEntity'></span>"), 2);

	//Action
	$Action = new AjaxAction('EditTemplate', 'SaveEntite');
	$Action->AddArgument("Entity", JVar::GetPost("Entity"));
	//TODO APPELER LA fermeter
	$Action->ClosePopup = true;

	//Identifiant du projet
	if(JVar::GetPost("ProjetId"))
	{
		$Action->AddArgument("ProjetId", JVar::GetPost("ProjetId"));
	}
	if(JVar::GetPost("AppName") != "")
	{
		$Action->AddArgument("AppName", JVar::GetPost("AppName"));
	}
	if(JVar::GetPost("Projet") != "")
	{
		$Action->AddArgument("Projet", JVar::GetPost("Projet"));
	}
        
	$Action->ChangedControl = 'lbResultEntity';

	//Recuperation de l'identite
	if(JVar::Get("idEntity"))
	{
		$Action->AddArgument("idEntity", JVar::Get("idEntity"));
	}

	$PropertyName = array();
	foreach($Properties as $property)
	{
		$name = $property->getName();

		if($name != "Version" && $name != "IdEntite" && get_class($this->Entity->$name) != "EntityProperty" &&  $name != "ProjetId")
		{
			if(isset($this->Entity->$name->Control) && get_class($this->Entity->$name->Control) == "TextArea")
			{
				$this->Entity->$name->Control->AddStyle("width","400px");
				$this->Entity->$name->Control->AddStyle("height","200px");

			}
			$Form->AddNew($this->Entity->$name);
			$Action->AddControl($this->Entity->$name->Control->Id);
		}
	 }


		//Champs spécifique suplémentaire
		$Form->AddNew(new Libelle($this->Entity->GetOtherInfo()), 2);

		//Enregisttrement
		$BtnSave=new Button(BUTTON);
		$BtnSave->Value=$this->Core->GetCode("Save");

		$BtnSave->OnClick= $Action;

		$Form->AddNew($BtnSave, 2, ALIGNRIGHT);

		echo $Form->Show();
	}

	/**
	 * Enregistrement
	 * */
	function SaveEntite()
	{
		$EntityName = JVar::GetPost("Entity");

		if(JVar::GetPost("Projet"))
                {
                    include("../Apps/".JVar::GetPost("Projet")."/Entity/".$EntityName .".php");	
		}
                else if(JVar::GetPost("AppName") != "")
		{
			include("../Apps/".JVar::GetPost("AppName")."/Entity/".$EntityName .".php");	
		}
                
		//Creation de l'entite
		$entity = $EntityName;
		$Entity = new $entity($this->Core);

		if(JVar::GetPost("idEntity"))
		{
			$Entity->GetById(JVar::GetPost("idEntity"));
		}
		
		if($Entity->IsValid())
		{
			$Entity->Save();
			$message = $this->Core->GetMessageValid();
		}
		else
		{
			$message =  $this->Core->GetMessageError();
		}

		echo "<span id='lbResultEntity'>".$message."</span>";

	}

 }

?>

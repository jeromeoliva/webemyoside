<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
* Liste et edition d'une entite
 */
 class ListEditTemplate extends JHomTemplate
 {
   //Propri�t�s
   private $Column;
   private $ActionColumn;
   private $UrlPopUp;
   private $EditedField;
   private $Action;
   private $Argument = array();
   private $ProjetId = null;
   private $Columns = array();
   public $AppName;
   private $Projet ;


   //Constructeur
   function ListEditTemplate($core,$form="",$entity="", $appName="", $projet = "")
   {
     //Version
    $this->Version ="2.0.1.0";

     $this->Core = $core;
     $this->Form = $form;
     $this->Entity = $entity;
     $this->AppName = $appName;
     $this->Projet = $projet;
   }

  //Initialisation
  function Init()
  {
    //Block
     $this->Block = new JBlock($this->Core, 'jb'.$this->Entity);
     $this->Block->Frame = false;    
     
     //Grille de l'entite
    $this->Grid = new EntityGrid("Grid_".$this->Entity, $this->Core);
    $this->Grid->Entity = $this->Entity;
    $this->Grid->CssClass="grid";
    
    $args = "";
    
    if(count($this->Argument) > 0)
    {
      foreach($this->Argument as $argument)
      {
        $this->Grid->AddArgument($argument);
      }
    }

    //PopUp de detail
    $PopUpDetail  = new PopUp("EditTemplate","Detail","");
    $PopUpDetail->Width="700px";
    $PopUpDetail->Height="500px";
    $PopUpDetail->Title=$this->Core->GetCode("Gestion")." ".$this->Entity;
    $PopUpDetail->AddArgument("Entity",$this->Entity);
    $PopUpDetail->AddArgument("AppName",$this->AppName);
    $PopUpDetail->AddArgument("Projet",$this->Projet);

    //Ajout de l'identifiant du projet
    if($this->ProjetId != null)
    {
      $PopUpDetail->AddArgument("ProjetId", $this->ProjetId);
    }

    if(is_object($this->Action))
      $PopUpDetail->AddAction("OnClose",$this->Action->DoAction());
    else
      $PopUpDetail->AddAction("OnClose",$this->Action);

    if(sizeof($this->EditedField)>0)
    {
      $i=0;
      foreach($this->EditedField as $field)
      {
        $PopUpDetail->AddArgument("field".$i,$field);
        $i++;
      }
    }

    //Ajout d'une entite
    $PopUpNew  = new PopUp("EditTemplate","Detail","");
    //$PopUpNew->Width="700px";
   // $PopUpNew->Height="500px";
    $PopUpNew->Title=$this->Core->GetCode("Gestion")." ".$this->Entity;
    //Ajout de l'identifiant du projet
    $PopUpNew->AddArgument("Entity",$this->Entity);
    $PopUpNew->AddArgument("ProjetId", $this->ProjetId);
    $PopUpNew->AddArgument("AppName", $this->AppName);
    $PopUpNew->AddArgument("Projet",$this->Projet);

    
    if(is_object($this->Action))
      $PopUpNew->AddAction("OnClose",$this->Action->DoAction());
    else
      $PopUpNew->AddAction("OnClose",$this->Action);

    $this->ImgAdd=new Button(BUTTON);
    $this->ImgAdd->CssClass="btn btn-primary";
    $this->ImgAdd->Value = $this->Core->GetCode("Add".$this->Entity);
    $this->ImgAdd->OnClick = new Action($PopUpNew);

    //Ajout des colonnes
    if(sizeof($this->Column) > 0)
    {
      foreach($this->Column as $column)
      {
        if($column != "Text" && $column != "Libelle" && $column != "Description"
          && $column != "Notice" && $column != "Commentaire" )
        {
          if($column == "Actif")
          {
            $this->Grid->AddColumn(new EntityControlColumn($this->Core->GetCode("Actif"),"Actif"));
          }
          else
          {
             $this->Grid->AddColumn(new EntityColumn($this->Core->GetCode($column),$column));
          }
        }
      }
    }

	//Ajout de colonne
	if(sizeof($this->Columns) > 0)
	{
	  foreach($this->Columns as $column)
      {
        $this->Grid->AddColumn($column);
      }
	}

    //Ajout des colonnes d'action
    if(sizeof($this->ActionColumn) > 0)
    {
      foreach($this->ActionColumn as $column)
      {
        switch($column)
        {
          case EDIT:
            $this->Grid->AddColumn(new ActionColumn("",$PopUpDetail,"",$this->Core->GetCode("Edit"), "icon-edit"));
          break;
          case DELETE:
			{
           		$argument = array();
           		$argument[] = "Entity&".$this->Entity;
                    $this->Grid->AddColumn(new AjaxActionColumn("",
                                                                "ListEditTemplate",
                                                                "DeleteEntity",
                                                                "Entity=".$this->Entity."&AppName=".$this->AppName."&Action=".$this->Action."&ProjetId=".$this->ProjetId,
                                                                "",
                                                                $this->Core->GetCode("Delete"),
                                                                'jb'.$this->Entity,
                                                                true,
                                                                "icon-remove"));
			}
          break;
        }
      }
    }

    $this->Block->Add($this->Grid);
    $this->Block->AddNew($this->ImgAdd, 2, ALIGNRIGHT);

  }

   //Ajout d'un parametre
  public function AddArgument($argument)
  {
  	$this->Argument[] = $argument;
  }

   //Ajout d'un parametre
  public function AddColumn($column)
  {
  	$this->Columns[] = $column;
  }

  function Refresh()
  {
    $this->Core->Ajax->AddControl($this->Grid);
    $this->Core->Ajax->RefreshControl();
  }

  /*
   * Supprime une entite
   */
  function DeleteEntity()
  {
  		$EntityName = JVar::GetPost("Entity");

		//Specifique au projet
		include('../Apps/EeProjet/Entity/EeProjetBesoin.php');
		include('../Apps/EeProjet/Entity/EeProjetValeur.php');
		include('../Apps/EeProjet/Entity/EeProjetChiffre.php');
		include('../Apps/EeProjet/Entity/EeProjetConcurrent.php');
		include('../Apps/EeProjet/Entity/EeProjetProduitService.php');
		include('../Apps/EeProjet/Entity/EeProjetFinanceur.php');
		include('../Apps/EeProjet/Entity/EeProjetUserPartenaire.php');
		include('../Apps/EeProjet/Entity/EeProjetStrategie.php');


		//Creation de l'entite
		$entity = $EntityName;
		$this->Entity = new $entity($this->Core);
		$this->Entity->GetById(JVar::GetPost("idEntity"));
		$this->Entity->Delete();

		//Relections sur les propriete de l'entity
		$reflection = new ReflectionObject(new $EntityName($this->Core));
		$Properties= $reflection->getProperties();

		$this->Entity = $EntityName;
		$this->ActionColumn = array("Edit", "Delete");


		$objet = new $EntityName($this->Core);

		$PropertyName = array();
		foreach($Properties as $property)
		{
			$name = $property->getName();

			if($name != "Version" && $name != "IdEntite" && get_class($objet->$name) != "EntityProperty" && $name != "ProjetId")
			{
				if($name != "Text")
				{
					$PropertyName[] = $name;
				}
			}
		}

		$this->Column = $PropertyName;
                    
                if(JVar::GetPost("AppName"))
                {
                    $this->AppName = JVar::GetPost("AppName");
                }
                
                if(JVar::GetPost("Action"))
                {
                    $this->Action = JVar::GetPost("Action");
                }
                
                if(JVar::GetPost("ProjetId"))
                {
                    $this->ProjetId = JVar::GetPost("ProjetId");
                }
                
		echo $this->Show();
  }

  function Show()
  {
    $this->Init();
    return $this->Block->Show();
  }

   //Assecceurs
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

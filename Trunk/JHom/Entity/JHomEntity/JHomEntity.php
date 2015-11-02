<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class JHomEntity
{
	//propriete
	public  $IdEntite;
	private $Core;
	private $CssClass;
	private $Table;
	private $TableName;
	private $Select=" SELECT ";
	private $Update=" UPDATE ";
	private $Insert=" INSERT INTO ";
	private $Delete=" DELETE FROM ";
	private $From=" FROM ";
	private $Where =" WHERE (1=1) ";
	private $GroupBy=" GROUP BY s";
	private $OrderBy=" ORDER BY ";

	private $Property=array();
	private $EntityProperty=array();
	private $Argument=array();
	private $Order=array();
	private $Join=array();
	private $PrimaryKey = array();
	private $Alias;
	private $LangAlias;
	private $LangClass;
	private $CascadeDelete =array();

	//limite
	private $LimitStart;
	private $LimitNumber;
	private $Asc;

	public $Version;

	//Nouvelle version de base de donnï¿½es
	private $Fields=array();
	private $Tables;
	private $Arguments=array();


	/*
	 * Constructeur
	 * @param $core Coeur de framework
	 *
	 * */
	function JHomEntity ($core)
	{
		//Version
		$this->Version ="2.0.2.0";

		$this->Core=$core;
		//tri ascendant par defaut
		$this->Asc=true;
	}

	/*
	 * Construction de l'entite
	 * */
	function Create()
	{
		//Insertion des proprietes dans un tableau
		//Creation d'un objet reflection afin de recuperer toutes les proprietes
		$Reflection = new ReflectionObject($this);
		$Properties=$Reflection->getProperties();

		//Parcourt des propriete afin de les inserer dans le tableau Properties
		foreach($Properties as $Propertie)
		{
			//Recuperation du nom de la propriï¿½te
			$Name=$Propertie->getName();

			if( is_object($this->$Name)   && (get_class($this->$Name)=="Property"
				|| get_class($this->$Name)=="LangProperty"
				|| get_class($this->$Name)=="SqlProperty") )
			{
				//Suffixe de la propriete par le nom de l'entite
				$this->Property[]=$this->$Name;
			}
			else if(is_object($this->$Name) && get_class($this->$Name)=="EntityProperty")
			{
				$this->EntityProperty[]=$this->$Name;
			}
		}
	}

	/*
	 * Ajout de clï¿½ ï¿½trangï¿½re
	 * @param $key Clï¿½
 	 * * */
	function AddPrimaryKey($key)
	{
		$this->PrimaryKey[] = $key;
	}

	/*
	 * Ajout d'un argument
	 * @param $arg Argument
	 * */
	function AddArgument($arg)
	{
		$this->Argument[]=$arg;
	}

	/*
	 * Ajout d'un ordre de tri
	 * @param $order Ordre
	 * */
	function AddOrder($order)
	{
		$this->Order[]=$order;
	}

	/*
	 * Ajout d'un jointure
	 *@param $join Jointure
	 * */
	function AddJoin($join)
	{
		$this->Join [] = $join;
	}

	/*
	 * Ajout des ï¿½lements liï¿½es ï¿½ suprrimer
	 * En mï¿½me temps
	 * @param $cascadeDelete elements
	 * */
	function AddCascadeDelete($cascadeDelete)
	{
		$this->CascadeDelete[] = $cascadeDelete;
	}

	/*
	 * Definit les nombres et les limites
	 * D'entitï¿½es a rï¿½cuperer
	 * @param $start Debut
	 * @param $number nombre d'ï¿½lement
	 * */
	function SetLimit($start,$number)
	{
		 $this->LimitStart = $start;
		 $this->LimitNumber = $number;
	}

	/*
	 * Recupere une entitï¿½ par son id
	 * @param $id Identifiant recherchï¿½
	 * @param $show definit si on doit voir le requete generï¿½
	 * */
	function GetById($id, $show = false)
	{
		if($id != "")
		{
			$this->Init();
			$this->IdEntite=$id;
			$request =$this->CreateSelect();
			$request .=$this->CreateFrom();
			$request .=$this->CreateWhere();

			if($show)
				echo $request."<br/>";

			$this->Load($this->Core->Db->GetLine($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments));
		}
	}

	/*
	 * Recupere toutes les entitï¿½s dans  un tableau
	 * */
	function GetTabAll($show=false)
	{
		$this->Init();
		$request =$this->CreateSelect();
		$request .=$this->CreateFrom();

		$request .=$this->CreateOrder();
		$request .= $this->CreateLimit();

		if($show)
			echo $request."<br/>";

		return $this->Core->Db->GetArray($request, $this->Fields, $this->Tables);
	}

	/*
	 * Recupere toutes les entitï¿½ dans un tableau d'entitï¿½s
	 * */
	function GetAll($show=false)
	{
		$tabEntity=array();
		$entites=$this->GetTabAll($show);

		if(sizeof($entites) > 0 && $entites != false)
		{
			//Instancation d'une nouvelle entitï¿½
			foreach($entites as $tabEntite)
			{
				$entite= new $this($this->Core);
				$entite->GetById($tabEntite["Id"]);

				//enregistrement dans le tableau
				$tabEntity[]=$entite;
			}
		}
		return $tabEntity;
	}

	/*
	 * Recupere des entitï¿½s dans un tableau filtrï¿½es par arguments
	 * */
	function GetTabByArg($show=false)
	{
		$this->Init();
		$request  =$this->CreateSelect();
		$request .=$this->CreateFrom();
		$request .=$this->CreateWhere();
		$request .=$this->CreateOrder();
		$request .= $this->CreateLimit();

		if($show)
		 echo $request."<br/>";

		$result = $this->Core->Db->GetArray($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments);

		if($result)
			return $result;
		else
		 {
			JHomLog::Write(EN," GetLine : ".$this->TableName ,ERR);
		}
	}

	/*
	 * Recupere des entitï¿½s dans un tableau d'entitï¿½e filtrï¿½es par arguments
	 * */
	function GetByArg($show=false)
	{
		$tabEntity=array();
		$entites=$this->GetTabByArg($show);

		if($entites !=false)
		{
			//Instancation d'une nouvelle entitï¿½
			foreach($entites as $tabEntite)
			{
				$entite= new $this($this->Core);
				$entite->GetById($tabEntite["Id"]);
				//enregistrement dans le tableau
				$tabEntity[]=$entite;
			}

			return $tabEntity;
		}
	}
	/**
	 * Recuper une liste des entite
	 * */
	function GetList()
	{
		$list = $this->GetTabAll();
		$text ="";

		foreach($list as $line)
		{
			foreach($line as $cell)
			{
				$text .= $cell."!";
			}
			$text .=":";
		}
		return $text;
	}

	/**
	 * Nombre d'elements'
	 * */
	function GetNumber()
	{
		$entity = $this->GetTabAll();
		return sizeof($entity);
	}

	/**
	 * Obtient le nom des colonnes
	 * */
	function GetColmunName()
	{
		//Premier pour l'identifiant
		$text =":";
		foreach($this->Property as $propertie)
		{
			$text .=$propertie->Name. ":";
		}
		echo $text;
	}

	/*
	 * Retourne un entite selon son code
	 * @param $code Code recherchï¿½
	 * */
	function GetByCode($code)
	{
		//Ajout de l'argument code
		$this->AddArgument(new Argument(get_class($this),"Code",EQUAL,$code));

		$request =$this->CreateSelect();
		$request .=$this->CreateFrom();
		$request .=$this->CreateWhere();
		//Ajout du code
		$this->Arguments["Code"] = $code;

		$this->Load($this->Core->Db->GetByCode($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments));
	}

	 /** Retourne un entite selon son code
	 * @param $name Nom recherchï¿½
	 * */
	function GetByName($name)
	{
		//Ajout de l'argument code
		$this->AddArgument(new Argument(get_class($this),"Name",EQUAL,$name));

		$request =$this->CreateSelect();
		$request .=$this->CreateFrom();
		$request .=$this->CreateWhere();

		//Ajout du code
		$this->Arguments["Name"] = $name;

		$this->Load($this->Core->Db->GetByName($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments));
	}

	/**
	 * Recupere un etntitÃ© par son Email
	 * */
	function GetByEmail($email)
	{
		//Ajout de l'argument code
		$this->AddArgument(new Argument(get_class($this),"Email",EQUAL,$email));

		$request =$this->CreateSelect();
		$request .=$this->CreateFrom();
		$request .=$this->CreateWhere();

		//Ajout du code
		$this->Arguments["Name"] = $email;

		$this->Load($this->Core->Db->GetByName($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments));
	}

	//Initialisation des parties de la requete
	protected function Init()
	{
		$this->Select=" SELECT ";;
		$this->From=" FROM ";
		$this->Where=" WHERE (1=1) ";
		$this->Update=" UPDATE ";
	    $this->Insert=" INSERT INTO ";
		$this->GroupBy=" GROUP BY ";
		$this->OrderBy=" ORDER BY ";

		$this->Fields = array();
	}

	//Construction de la clause select
	protected function CreateSelect()
	{
		$fields ="";
		if(sizeof($this->PrimaryKey)>0)
		{
			$fields=$this->Alias.".Id" ;

			foreach($this->PrimaryKey as $primarykey)
			{
				if($fields == "")
		     		$fields=$this->Alias.'.'.$primarykey ;
				else
			    	$fields .=",".$this->Alias.'.'.$primarykey ;
			}
		}
		else
		{
			 $fields=$this->Alias.".Id" ;
			 //Enregistrement des champs
			 $this->Fields[] ="Id";
		 }
		//Parcours des proprietes
		foreach($this->Property as $propertie)
		{
			if(get_class($propertie)=="Property")
			{
				if($fields=="")
					$fields .= $propertie->Alias.'.'.$propertie->TableName." as ".$this->Alias.'_'.$propertie->TableName;
				else
					$fields .= ",".$propertie->Alias.'.'.$propertie->TableName." as ".$this->Alias.'_'.$propertie->TableName;
			}
			else if(get_class($propertie)=="LangProperty")
			{
				if($fields=="")
					$fields .= $this->LangAlias.'.'.$propertie->TableName." as ".$this->LangAlias.'_'.$propertie->TableName;
				else
					$fields .= ",".$this->LangAlias.'.'.$propertie->TableName." as ".$this->LangAlias.'_'.$propertie->TableName;
			}
			else if(get_class($propertie)=="SqlProperty")
			{
				if($fields=="")
					$fields .= $propertie->Request." as ".$this->LangAlias.'_'.$propertie->Name;
				else
					$fields .= ",".$propertie->Request." as ".$this->LangAlias.'_'.$propertie->Name;
			}
			//Enregistrements des champs
			$this->Fields[] = $propertie->TableName;
		}

		$this->Select .= $fields;

		return $this->Select;
	}

	//Construction de la clause insert
	protected function CreateInsert()
	{
		$fields="";
		$values="";

		//Parcours des proprietes
		foreach($this->Property as $propertie)
		{
			if(get_class($propertie) != "SqlProperty" && get_class($propertie) != "LangProperty" && $propertie->TableName != "Id" && $propertie->Value !="" )
			{
				//Control de type password
				if(get_class($propertie->Control) == PASSWORD || get_class($propertie->Control) == "BsPassword")
				{
					if($fields=="")
					{
						$fields .= $propertie->TableName;
						$values .= "'".md5(JFormat::EscapeString($propertie->Value))."'";
					}
					else
					{
						$fields .= ",".$propertie->TableName;
						$values .= ",'".md5(JFormat::EscapeString($propertie->Value))."'";
					}
				}
				else if(get_class($propertie->Control) == DATEBOX )
				{
					$date = explode("/",$propertie->Value);

					if($fields=="")
					{
						$fields .= $propertie->TableName;
						$values .= "'".$date[2]."-".$date[1]."-".$date[0]."' ";
					}
					else
					{
						$fields .= ",".$propertie->TableName;
						$values .= ",'".$date[2]."-".$date[1]."-".$date[0]."' ";
					}
				}
				else if(get_class($propertie->Control) == DATETIMEBOX)
				{
					//Separation heure et jour
					$dateJour  =  explode(" ", $propertie->Value);

					if($fields=="")
					{
						$fields .= $propertie->TableName;

						$date = explode("/",$dateJour[0]);
						$values .= "'".$date[2]."-".$date[1]."-".$date[0] . " ".$dateJour[1]."' ";
					}
					else
					{
						$fields .= ",".$propertie->TableName;

						$date = explode("/",$dateJour[0]);
						$values .= ",'".$date[2]."-".$date[1]."-".$date[0] . " ".$dateJour[1]."' ";
					}
				}
				else
				{
					if($fields=="")
					{
						$fields .= $propertie->TableName;
						$values .= "'".JFormat::EscapeString($propertie->Value)."'";
					}
					else
					{
						$fields .= ",".$propertie->TableName;
						$values .= ",'".JFormat::EscapeString($propertie->Value)."' ";
					}
					//Enregistrement des champs
				 	$this->Fields[$propertie->TableName] = $propertie->Value;
				}
			}
		}

		$this->Insert .=$this->TableName." ( ".$fields." ) VALUES (".$values.")  ";

		$this->Tables = $this->TableName;

		//echo $this->Insert;
		return $this->Insert;
	}

	//Construction de la clause update
	protected function CreateUpdate($field="")
	{
		$fields="";

		//Parcours des proprietes
		foreach($this->Property as $propertie)
		{

			if(get_class($propertie) != "SqlProperty")
			{

				//Update du champ passï¿½ en parametre
				if($field != "")
				{
					if($propertie->TableName == $field->TableName)
					{
					   if(get_class($propertie->Control) == PASSWORD)
					   		$fields .= $this->Alias.".".$propertie->TableName."='".md5(JFormat::EscapeString($propertie->Value))."' ";
					   else
              				$fields .= $this->Alias.".".$propertie->TableName."='".JFormat::EscapeString($propertie->Value)."' ";
				  }
        		}
				else
				{
					//Control de type password
					if(get_class($propertie->Control) == PASSWORD)
					{
						//Mot de passe on ne fais rien
						/*if($fields=="")
							$fields .= $this->Alias.".".$propertie->TableName."='".md5(JFormat::EscapeString($propertie->Value))."' ";
						else
							$fields .= ",".$this->Alias.".".$propertie->TableName."='".md5(JFormat::EscapeString($propertie->Value))."' ";

						*/
					}
					else if(get_class($propertie->Control) == DATEBOX)
					{
						$date = explode("/",$propertie->Value);

						if($fields=="")
						{
							$fields .= $this->Alias.".".$propertie->TableName."='".$date[2]."-".$date[1]."-".$date[0]."' ";
						}
						else
						{
							if(isset($date[2]))
							{
								$fields .= ",".$this->Alias.".".$propertie->TableName."='". $date[2]."-".$date[1]."-".$date[0]."' ";
							}
						}
					}
					else if(get_class($propertie->Control) == DATETIMEBOX)
					{
						//Separation heure et jour
						$dateJour  =  explode(" ", $propertie->Value);

						if($fields=="")
						{
							$date = explode("/",$dateJour[0]);
							$fields .= $this->Alias.".".$propertie->TableName."='".$date[2]."-".$date[1]."-".$date[0]." ".$dateJour[1]."' ";
						}
						else
						{
							$date = explode("/",$dateJour[0]);
							$fields .= ",".$this->Alias.".".$propertie->TableName."='".$date[2]."-".$date[1]."-".$date[0]." ".$dateJour[1]."' ";
						}
					}
					//Update de tous les champs
					else if(get_class($propertie)=="Property" && $propertie->Update)
					{
						if($fields=="")
							$fields .= $this->Alias.".".$propertie->TableName."='".JFormat::EscapeString($propertie->Value)."' ";
						else
							$fields .= ",".$this->Alias.".".$propertie->TableName."='".JFormat::EscapeString($propertie->Value)."' ";

						//Enregistrement des champs
				 	    $this->Fields[$propertie->TableName] = $propertie->Value;
					}
					else if(get_class($propertie)=="LangProperty")
					{
						 $elementlang = new $this->LangClass($this->Core);
						 $elementlang->SaveElement($this->Core->GetLang("code"), $this->IdEntite, $this->Libelle->Value, isset($this->Description)?$this->Description->Value:"");
					}
				}
			}
		}
		$this->Update .=$this->TableName." as ".$this->Alias." SET ".$fields;

		$this->Tables = $this->TableName;

		//echo $this->Update."<br/>";
		return $this->Update;
	}

	//Construction de la selection de la table
	private function CreateFrom()
	{
		$this->From .= $this->TableName. " as ".$this->Alias ;

		$this->Tables = $this->TableName;

		//Ajout des jointures
		if(sizeof($this->Join)>0)
		{
			foreach($this->Join as $join)
			{
				$this->From .= "  ".$join->TypeJoin." join ".$join->Table;
				$this->From .=" as ".$join->Alias;
				$this->From .= " on  ".$join->Alias.".".$join->PrimaryKey."=".$this->Alias.".".$join->ForeignKey."  ";

				//Ajout des argument des jointures
				if(sizeof($join->Argument)>0)
				{
					foreach($join->Argument as $argument)
					$this->From .=" AND ".$argument->Entity->Alias.".".$argument->Data;
				}
			}
		}

		return $this->From;
	}

	//Construction de la clause Where
	private function CreateWhere()
	{
		//Si on a passer des argument on construit la clause en fonction d'eux'
		if(sizeof($this->Argument)>0)
		{
			foreach($this->Argument as $arg)
			{
				if($arg->Value != "")
			 	{
			 		$this->Where .= " AND ".$arg->Data;
			 		$this->Arguments[$arg->Field] = $arg->Value;
			 	}
			}
		}
		//Sinon on prend l'id
		else
		{
			//Cle primaire composï¿½e
			if(sizeof($this->PrimaryKey)>0)
			{
				foreach($this->PrimaryKey as $primaryKey)
				{
					$fields = "";
					$fields =" AND ";
					$fields .= $this->Alias.".".$primaryKey."=".$this->$primaryKey->Value ;

					$this->Where .= $fields ;
				}
			}
			else
			{
				$fields=" AND ";
				$fields .= $this->Alias.".Id =".$this->IdEntite ;
				$this->Where .= $fields ;

				$this->Ids = $this->IdEntite;
				$this->Arguments["Id"] = $this->IdEntite;
			}
		}
		return $this->Where;
	}

	//Construction de la clause order by
	private function CreateOrder()
	{
		$orders="";

		//Si on a passï¿½s des orders on construit la clause en fonction d'eux'
		if(sizeof($this->Order)>0)
		{
			foreach($this->Order as $order)
			{
				if(is_object($order))
				{
					if($orders == "")
				 		$orders .=$order->TableName ;
				 	else
				 		$orders .=",".$order->TableName ;
				}
				else
				{
					if($orders == "")
				 		$orders .=$order ;
				 	else
				 		$orders .=",".$order;
				}
			}
		}

		if($orders != "")
			{
				$order = $this->OrderBy.$orders;
				 if($this->Asc)
				 	$order .= " asc";
				 else
				 	$order .= " desc";

				return $order;
			}
		else
			return "";
	}

	//Nombre d'element
	private function CreateLimit()
	{
		if($this->LimitStart !="")
		  return " limit ".($this->LimitStart-1).",".$this->LimitNumber;
	}

	//Chargement des donnees dans l'entitï¿½e
	private function Load($data)
	{
		//Ajout de l'identifiant
		$this->IdEntite = $data["Id"];


		//Chargement des property
		foreach($this->Property as $propertie)
		{
			if(get_class($propertie)=="Property")
			{
			    $propertie->Value=JFormat::ReplaceString($data[$this->Alias."_".$propertie->TableName]);
			}
			else
			if(get_class($propertie)=="LangProperty")
			{
				if(isset($data[$this->LangAlias."_".$propertie->TableName]))
					$propertie->Value=JFormat::ReplaceString($data[$this->LangAlias."_".$propertie->TableName]);
			}

			else
			if(get_class($propertie)=="SqlProperty")
			{
				$propertie->Value= $data[$this->LangAlias."_".$propertie->Name];
			}

			if(get_class($propertie)!="SqlProperty" && ( get_class($propertie->Control) == DATEBOX))
			{
				if($propertie->Value)
				{
					$date = explode("-",$propertie->Value);
					$propertie->Value = $date[2]."/".$date[1]."/".$date[0];
				}
			}
			if(get_class($propertie)!="SqlProperty" && get_class($propertie->Control) == DATETIMEBOX)
			{
				//Separation heure et jour
				$dateJour  =  explode(" ", $propertie->Value);

				if($propertie->Value)
				{
					$date = explode("-",$dateJour[0]);
					$propertie->Value = $date[2]."/".$date[1]."/".$date[0] . " ".$dateJour[1];
				}
			}
		}
	}

	//Verification des donnï¿½es
	public function IsValid()
	{
		//Verification de chaque propriï¿½tï¿½
		$IsValid=true;

		foreach($this->Property as $property)
		{
			if(get_class($property)=="Property" && !$property->IsValid())
			{		//echo $property->Name;
					$IsValid=false;
			}
		}
		return $IsValid;
	}

   // Retourne le nombre d'element
   public function GetCount($Argument="")
   {
   		$request =  "Select Count(".$this->Alias.".Id) as count";
		$request .= $this->CreateFrom();

		if($Argument != "")
			$this->AddArgument($Argument);

		$request .= $this->CreateWhere();

		$count= $this->Core->Db->GetLine($request);
		return $count["count"];
   }

   //Sauvegarde d'un enregistrement
	public function Save($field="")
	{
		$this->Init();
		$request="";

		//Verification de la donnï¿½e en fonction du type de control
		foreach($this->Property  as $propertie)
		{
			if(get_class($propertie)=="Property" && !$propertie->IsValid())
			{
				echo $propertie->Name;
				return false;
			}
		}
		//Cle primaire composï¿½e
        if(sizeof($this->PrimaryKey)>0)
        {
        		//Verification de l'existance de l'enregistrement
				$request = $this->CreateSelect();
				$request .= $this->CreateFrom();
				$request .= $this->CreateWhere();

				$tab= $this->Core->Db->GetLine($request);

				//echo $request;
				$this->Where =" Where (1=1) ";
				if(sizeof($tab)>1)
					{
						$request = $this->CreateUpdate($field);
						$request .= $this->CreateWhere();
					}
				else
					{
						$request = $this->CreateInsert();
					}
					//echo "<br/>".$request;
					return $this->Core->Db->Execute($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments);
        }
        else
        {
            //Si l'objet possede un Id on est en update
			if($this->IdEntite != "" )
			{
				//On est en update
			    $request .= $this->CreateUpdate($field);
				$request .= "WHERE ".$this->Alias.".Id =".$this->IdEntite ;

				$this->Fields["Id"] = $this->IdEntite;
			}
		   else
			{
				//Sinon on est en insertion
				$request .= $this->CreateInsert();
			}
        }
		
        //echo $request."<br/>";
        //Sauvegarde en base
		//JHomLog::Title(EN,"Entity ".get_class($this),INFO);
		//JHomLog::Log(EN," Save :".$request,INFO);

        return  $this->Core->Db->Execute($request,$this->Fields, $this->Tables,$this->Alias,$this->Arguments);
	}

   //Retourne le dernier identifiant inserer
   public function GetInsertedId()
   {
   	 return $this->Core->Db->GetInsertedId();
   }

   //Suppression d'un enregistrement
	public function Delete()
	{
		$this->Init();
		$request="";
		$request .= $this->Delete .$this->TableName ;
		$request .= " WHERE Id =".$this->IdEntite ;

		JHomLog::Title(EN,"Entity ".get_class($this),INFO);
		JHomLog::Log(EN," Delete :".$request,INFO);

       //Suppression des elements liï¿½s
       foreach($this->CascadeDelete as $cascadeDelete)
       {
       	$cascadeDelete->Delete($this->Core,$this->IdEntite);
       }

       $this->Fields["Id"] = $this->IdEntite;

       //Supression des l'element
      	//echo $request;
       return  $this->Core->Db->Execute($request,"",$this->Tables,"",$this->Fields,"Delete");
	}

	/*
	* Obtient les élements supplémentaire d'une entité
	*/
	public function GetOtherInfo()
	{
		$TextControl =  "";
		return $TextControl;
	}
	        
        /**
         * Ajoute les propietés
         * de partage
         */
        function AddSharedProperty()
        {
            $this->AppName = new Property("AppName", "AppName", TEXTBOX,  false, $this->Alias); 
            $this->AppId = new Property("AppId", "AppId", NUMERICBOX,  false, $this->Alias); 
            $this->EntityName = new Property("EntityName", "EntityName", TEXTBOX,  false, $this->Alias); 
            $this->EntityId = new Property("EntityId", "EntityId", NUMERICBOX,  false, $this->Alias); 
        }
        
	//asseceurs
	public function __get($name)
	{
		if(isset($this->$name) && is_object($this->$name) && get_class($this->$name) == "EntityProperty")
		{
			$entityPropertie = $this->$name;
			$entite= new $entityPropertie->Entity($this->Core);
			$Field=$entityPropertie->EntityField ;
			$entite->GetById($this->$Field->Value);
			$entityPropertie->Value=$entite;
		}
		return $this->$name;
	}

	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}

//Classe de base pour toutes les proprietes
//propriete d'une entite
class Property
{
	//Proprietes
	private $Name;
	private $TableName;
	private $Type;
	private $Obligatory;
	private $Libelle;
	private $ToolTip;
	private $Value;
	private	$Valid=true;
	private $Control;
	private $Alias;
	private $Insert;
	private $Update;

	//Constructeur
	function Property($name,$tableName,$type,$obligatory,$alias="",$insert=true,$update=true)
	{
		$this->Name =$name;
		$this->Libelle=$name;
		$this->TableName =$tableName;
		$this->Type =$type;
		$this->Obligatory=$obligatory;
		$this->Alias=$alias;
		$this->Insert = $insert;
		$this->Update = $update;
		$this->Init();
	}

	//Initialisation du control afin qu'il soit accessible a l'exterieur
	function Init()
	{
		if($this->Type)
			$this->Control=new $this->Type($this->TableName);
	}

	//Chargement du control et verification
	function Load()
	{
		//Creation du control asscociï¿½
		if($this->Type)
		{
			//Chargement avec les valeur postï¿½ ou les valeur de l'entitï¿½
	 		if(JVar::GetPost($this->TableName) != false)
	 		{
        		$this->Control->Value=JVar::GetPost($this->TableName);
	 			$this->Value=JVar::GetPost($this->TableName);
			}
	 		else
	 		{
	 			// Dans le cas d'une checbox non cochï¿½ et que c'est une action utilisateur ormis reception de commande la case et initialiser ï¿½ 0
	 			if(get_class($this->Control) == "CheckBox" && JVar::GetPost("UserAction") != false)
	 			{
					$this->Control->Value = 0;
					$this->Value=0;
				}
				// Sinon la variable est initialisï¿½e avec la valeur de l'entitï¿½
				else
				{
					$this->Control->Value= $this->Value;
					$this->Value= $this->Value;
			 	}
	 		}
			//Verification
			$Verif=true;

			if(!$this->Control->Verify())
				$Verif=false;

			if($this->Obligatory && $this->Value == ""/*(JVar::GetPost($this->TableName)=="")*/)
				{
					$Verif=false;
					$this->Control->Obligatory=false;
				}

			$this->Valid = $Verif;
		}
	}

	//Verification
	function IsValid()
	{
		$this->Load();
		return $this->Valid;
	}
	//Affichage
 	function Show()
  	{
  		$this->Load();
  	 	return $this->Control->Show();
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

//Class pour obtenir une propriï¿½tï¿½ d'une autre entitï¿½
class EntityProperty
{
	private $EntityField;
	private $Entity;
	private $Value;
	private $TableName;
	private $IdEntite;

	//Constructeur
	function EntityProperty($entity,$entityField)
	{
		$this->Entity=$entity;
		$this->EntityField=$entityField;
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

//Propriete localisï¿½
class LangProperty extends Property
{

}

/**
 * Classe pour appliquer des sous requete sql
 * */
class SqlProperty extends Property
{
	private $Request;

	/**
	 * Constructeur
	 * */
	function SqlProperty($name , $request)
	{
		$this->Name = $name;
		$this->Request = $request;
		$this->TableName= $name;
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
//Argument d'une entite utilise pour la selection
class Argument
{
	//propriete
	private $Entity;
	private $Field;
	private $EntityField;
	private $Operator;
	private $Value;
	private $Data;

	//Constructeur
	function Argument($entity, $field, $operateur, $value="")
	{
		$core=new Core(false);
		$this->Entity=new $entity($core);
		if(is_object($this->Entity->$field))
			$this->Field=$this->Entity->$field->TableName;
		else
		{
		if($field == "IdEntite")
			$this->Field = "Id";
		else
			$this->Field = $field;
		}

		$this->EntityField=$field;
		$this->Operator=$operateur;
		$this->Value=JFormat::EscapeString($value);

		switch($operateur)
		{
			case "Equal":
				$this->Data= $this->Field . " = '".JFormat::EscapeString($value)."' " ;
			break;
			case "NotEqual":
				$this->Data = $this->Field ." <> '".JFormat::EscapeString($value)."' ";
			break;
			case "Less":
				$this->Data =$this->Field ." < '".JFormat::EscapeString($value)." '";
			break;
			case "More":
				$this->Data =$this->Field ." > '".JFormat::EscapeString($value)." '";
			break;
			case "Like":
				$this->Data =$this->Field ." like '".JFormat::EscapeString($value)."%'";
			break;
			case "IsNull":
				$this->Data = $this->Field." is null";
				$value = ISNULL;
			break;
			case "In":
				$this->Data = $this->Field ." in( ".$value.") ";
			break;
                        case NOTIN:
				$this->Data = $this->Field ." not in( ".$value.") ";
			break;
		}

		$this->Value=$value;
	}

	//Assesseur
	public function __get($name)
	{
		return $this->$name;
	}
	//acsesceur
	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}

//Classe pour les jointures
class Joins
{
	//Propriete
	private $TypeJoin;
	private $Table;
	private $PrimaryKey;
	private $ForeignKey;
	private $Alias;
    private $Argument=array();

	//Constructeur
	function Joins($typeJoin,$table,$primaryKey,$foreignKey,$alias)
	{
		$this->TypeJoin = $typeJoin;
		$this->Table = $table;
		$this->PrimaryKey =$primaryKey;
		$this->ForeignKey =$foreignKey;
		$this->Alias = $alias;
	}

	//Ajout d'un argument
	function AddArgument($arg)
	{
		$this->Argument[]=$arg;
	}

	//Assesseur
	public function __get($name)
	{
		return $this->$name;
	}
	//acsesceur
	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}

//Classe pour les suprression en cascade
class CascadeDelete
{
	private $Class;
	private $Field;

	//Constructeur
	function CascadeDelete($class,$fiels)
	{
		$this->Class = $class;
		$this->Field = $fiels;
 	}

	function Delete($Core,$id)
	{
		$obj = new $this->Class($Core);
		$obj->AddArgument(new Argument($this->Class,$this->Field,EQUAL,$id));

		foreach($obj->GetByArg() as $delete)
		{
			$delete->Delete();
		}
	}


	//Assesseur
	public function __get($name)
	{
		return $this->$name;
	}
	//acsesceur
	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}
?>
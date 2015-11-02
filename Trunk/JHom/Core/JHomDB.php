<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */


class JHomDB implements IJHomDb
{
	//Proprietes
	public $CommandText="";
	public $Count=0;

	private $connection;
	public $Version;

	/*Constructeur
	 * @param nom du serveur
	 * @param nom de la base
	 * @param utilisateur
	 * @param mot de passe
	 */
	function JHomDB($server="",$baseName="",$login="",$pass="")
	{
		//Version
		$this->Version = "2.1.0.0";

		if($server != "")
		{
			$erreur="";

			//Connection � la base de donn�e
			$this->connection = @mysql_connect($server,$login,$pass) ;
			$erreurBase = @mysql_select_db($baseName,$this->connection);

			if(!$this->connection)
			 throw new exception("Probl�me serveur :".mysql_error());
			if(!$erreurBase)
			 throw new exception("Probl�me Base de donn�e :" .mysql_error() );

			JHomLog::Title(DB,"Connection",INFO);
		}
	}

        /**
         * Selection de la base de donnée
         */
        function SelectDb($baseName)
        {
            @mysql_select_db($baseName, $this->connection);
        }
        
	/*
	 * Retourne une ligne
	 * @param requete sql
	 * \return un tableau de donnee
	 */
	function GetLine($requete="")
	{
		$result="";

		if($requete !="")
			$res=mysql_query(''.$requete.'');
		else
			$res=mysql_query($this->CommandText);

		//Log de l'erreur
		if(!$res)
		{
			JHomLog::Write(DB," GetLine : ".mysql_error() ,ERR);
			return false;
		}
		else
		{
			$result=mysql_fetch_assoc($res);

			JHomLog::Write(DB," GetLine : ".$requete ,INFO);

			return $result;
		}
	}

	/**
	 * Retourne plusieurs lignes
	 * @param requete sql
	 * \return un tableau de donnee
	 * */
	function GetArray($requete="")
	{
		//Execution de la requete
		if($requete !="")
			$res=mysql_query($requete);
		else
			$res=mysql_query($this->CommandText);

		//Log de l'erreur
		if(!$res)
		{
			JHomLog::Write(DB," GetArray : ".mysql_error() ,ERR);
		 	return false;
		}
		else
		{

			$i=0 ;
			$Tab=array();
			//Parcourt des lignes
			while($lines=mysql_fetch_assoc($res))
			{
				foreach($lines as $Key=>$Value)
				{
					$Tab[$i][$Key]=$Value;
				}
				$i++;
			}
			//Nombre de ligne
			$this->Count=sizeof($Tab);

			JHomLog::Write(DB," GetArray : ".$requete , INFO);

			return $Tab;
		}
	}

	/*
	 * Recupere un element par son code
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByCode($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		return $this->GetLine($request);
	}

	 /** Recupere un element par son code
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByName($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		return $this->GetLine($request);
	}
	/**
	 * Execute une requete
	 * @param requete sql
	 *  \return un tableau de donnee
	 */
	function Execute($requete)
	{
		JHomLog::Write(DB," Execute : ".$requete , INFO);
         if(mysql_query($requete))
         {}
         else
         {
             echo mysql_error();
         }
         
         return true ;
	}

	/**
	 * Execute plusieurs requetes (separateur ;)
	 * @param requete sql
	 * \return true ou false
	 */
	function ExecuteMulti($requete, $separator =";")
	{
		$request = split($separator,$requete);

		for($i=0;$i<sizeof($request)-1;$i++)
		{
			if(!JHomDb::Execute($request[$i]))
			{
				JHomLog::Write(DB,mysql_error(),ERR);
				return false;
			}
		}
		return true;
	}


	/*
	 * Retourne le dernier identifiant inserer
	 * \return l'identifiant insere
	 */
	function GetInsertedId()
	{
            return mysql_insert_id();
	}
}

/*
 * Interface obligatoires pour toutes les classe de gestion de base
 */
interface IJHomDb
 {
	public function GetLine();
	public function GetArray();
	public function Execute($request);
 }


?>
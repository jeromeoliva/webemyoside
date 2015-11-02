<?php
/*
 *Classe de gestion des url
 */
 class JUrl
 {
 	//Propri�tes
 	private $Url;
 	private $Rewrite;
 	private $Parametre =array();

 	// Constructeur
 	function JUrl($url,$rewrite=false)
 	{
 	  //Version
 	  $this->Version ="2.0.1.1";

      $this->Url=$url;
      $this->Rewrite = $rewrite;
 	}

 	//Ajout d'un parametres
 	public function AddParametre($paramName, $paramValue)
 	{
 		$this->Parametre[$paramName] = $paramValue;
 	}

   //Cree l'url avec les bon parametres
	public function GetUrl()
	{
		if($this->Rewrite)
		{
			$this->Url = str_replace(".php","",$this->Url);

			$param = "";

			foreach($this->Parametre as $key=>$value)
			{
				$param .= "-".$value;
			}
			return $this->Url.$param;
		}
		else
		{
			$param = "";

			foreach($this->Parametre as $key=>$value)
			{
				if($param == "")
				{
					if((strrpos($this->Url,'?')) > 0)
					{
	              		$param .= "&".$key."=".$value;
					}
					else
					{
				  		$param .= "?".$key."=".$value;
					}
				}
				else
				{
				   		$param .= "&".$key."=".$value;
				}
			}

			return $this->Url.$param;
		}
	}

	//Recupere un variable d'url
	public static function GetParametre($parametre)
	{
		return JVar::Get($parametre);
	}

	//Recupere l'identifiant de l'entite
	public static function GetEntity()
	{
		if(JVar::Get("idEntity"))
		{
			return "?idEntity=".JVar::Get("idEntity");
		}
	}
 }
?>

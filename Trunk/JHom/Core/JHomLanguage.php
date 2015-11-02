<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class JHomLanguage
 {
 	//Propri�t�s
 	private $Core;
 	public $Version;

	//Constructeur
 	function JHomLanguage($core="")
 	{
 		//Version
		$this->Version = "2.0.0.0";

 		$this->Core=$core;
 	}

	//Retourne un code dans une langue
	function GetCode($code,$langue)
	{
		//Recuperation du libelle d'un code
		$requete ="	SELECT Libelle FROM ee_lang_code AS code
					JOIN ee_lang_element as element ON code.Id = element.CodeId
					JOIN ee_lang AS lang ON element.LangId = lang.Id
					WHERE code.Code='".$code."'
					AND lang.Code = '".$langue."' ";

		$element = $this->Core->Db->GetLine($requete);

		if(!empty($element["Libelle"]))
		{
				return JFormat::ReplaceString($element["Libelle"]);
		}
		else
		{
			// Recherche si le code existe
			$requete ="	SELECT Code FROM ee_lang_code AS code
					WHERE code.Code='".$code."' ";

			$element = $this->Core->Db->GetLine($requete);

			if(empty($element["Code"]))
			{
			// Creation du code dans la base de donn�e
			$requete ="INSERT INTO ee_lang_code (Code) VALUES ('$code')";

			$element = $this->Core->Db->execute($requete);

			return $code;
			}
			return $code;
		}
	}

	/**
	 * Retourne tous les élements multiluange traduit
	 */
	function GetAllCode($langue)
	{
		$requete ="	SELECT code.Code,Libelle FROM ee_lang_code AS code
					JOIN ee_lang_element as element ON code.Id = element.CodeId
					JOIN ee_lang AS lang ON element.LangId = lang.Id
					AND lang.Code = '".$langue."' ";
		$elements = $this->Core->Db->GetArray($requete);

		$codes = array();

		foreach($elements as $code)
		{
			$codes[$code["Code"]] = JFormat::ReplaceString($code["Libelle"]);
		}

		return Serialization::Encode($codes);
	}
 }
?>

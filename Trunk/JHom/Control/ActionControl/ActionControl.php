<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class ActionControl
{
	//Constructeur
	function ActionControl()
	{
		//Version
		$this->Version ="2.0.0.0";
	}

	///Charge une entit�
	public static function LoadEntity($Arg)
	{
		$Control=$Arg[0];
		$Argument=$Arg[1];
		$SenderValue=$Arg[2];

		$Core=new Core(false);
		$Bloc=new Bloc($Core);

		//chargement des blos appartenant aux pages
		$ArgPage=new Argument($Bloc->Page,EQUAL,$SenderValue);
		$Bloc->AddArgument($ArgPage);

		return $Bloc->GetByArg();
	}

	//Charge une entit� dans une listeBox
	public static function LoadEntityInList($arg)
	{
		$Entites =ActionControl::LoadEntity($arg);
		$Option ="";

		foreach($Entites as  $Entite)
		{
			$Option .= "<option value='".$Entite["Id"]."'>".$Entite["Nom"]."</option>";
		}
		return $Option;
	}
}

?>
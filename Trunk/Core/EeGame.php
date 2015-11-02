<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/**
 * Classe de base des jeux
 **/
class Game extends Application
{
	/**
	 * Constructeur
	 * */
	function Game($core, $name)
	{
	 	parent::__construct($core, $name);
	 	$this->Core = $core;
	}

	function Run($core, $name)
	{
		$textControl = parent::Run($core, $name, $name);
		$this->GetMenu();
		return $textControl;
	}

	/**
	 * Retourne l'écran à afficher'
	 */
	function GetScreen()
	{}

	/**
	 * Retourne le menu principal
	 * */
	function GetMenu()
	{}

	/**
	 * Retourne le fond d'écran
	 * */
	function GetBackGround()
	{
	}
}
?>
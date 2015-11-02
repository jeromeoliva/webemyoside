<?php

/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/*
Template de message simple
 */
 class MessageTemplate
 {
 	private $Title;
 	private $Body;
 	private $User;

 	/**
 	 * Constructeur
 	 * */
 	function MessageTemplate()
 	{

 	}

 	/**
 	 * Affichage
 	 * */
 	function Show()
 	{

		
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

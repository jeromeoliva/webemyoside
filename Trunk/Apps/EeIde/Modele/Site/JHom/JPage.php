<?php
/*
 * Classe de base pour les pages executé par le runner
 */
class JPage implements IJpage
{
	//constructeur
	function JPage()
	{
	}

	//Initialisation : charge les controls avec leurs bonnes valeurs
	function Init()
	{

	}

	//Insertion des control dans la page
	function Create()
	{

	}

	//Affichage de la page
	function Show()
	{

	}

	//Definit si toutes les valeurs dans les controls sont valides
	function IsValid()
	{

	}
}

interface IJPage
{
	public function Init();
	public function Create();
	public function Show();
}
?>
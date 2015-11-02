<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class StatBlock extends JHomBlock implements IJhomBlock
{
	// Propriété
	private $EditMode;

	//Constructeur
	function StatBlock($core="")
	{
		//Version
 		$this->Version = "2.2.0.0";

		$this->Core=$core;
	}

	function Init()
	{}

	function Create()
	{}

	function Show()
	{
		$TextControl = '';

		//Liste des statistique disponible
		$lstStatistique = new ListBox('lstStat');
		$lstStatistique->Value = 'Choix de la statistique';
		$lstStatistique->Add('UserDay', 'UserDay');
		$lstStatistique->Add('UserPage', 'UserPage');

		$TextControl .= $lstStatistique->Show();

		//Action
		$Action = new AjaxAction("StatBlock", "ShowStat");
		$Action->ChangedControl = "dvResultat";
		$Action->AddControl('lstStat');

		//Bouton d'action
		$btnShow = new button(BUTTON);
		$btnShow->Value = 'Show';
		$btnShow->OnClick = $Action;

		$TextControl .= $btnShow->Show();

		//Resultat
		$TextControl .= '<div id = "dvResultat">resultat</div>';

		return $TextControl;

	}

	//Affiche la statistique
	function ShowStat()
	{

		switch(JVar::GetPost('lstStat'))
		{
			case 'UserDay':
				$request = 'SELECT DateCreate, count(id), GROUP_CONCAT(URL)  FROM stat_front GROUP BY  to_days(DateCreate) ';
				$entetes = array('Date', 'Nombre utilisateur', 'Page');
			break;
			case 'UserPage':
				$request = 'SELECT DateCreate, Adresse, UserId, GROUP_CONCAT(URL), Navigator,DateCreate FROM stat_front GROUP BY to_days(DateCreate), Adresse';
				$entetes = array('Date','adresse', 'User', 'Url','navigator');
				break;
		}

		//Creation du tableau
		$tableau = "<table class='profil'>";

		//Creation des entetes
		$tableau .= '<tr>';
		foreach($entetes as $entete)
		{
			$tableau .= '<th>'.$entete.'</th>';
		}
		$tableau .= '<tr>';

		$results = $this->Core->Db->GetArray($request);

		foreach($results as $ligne)
		{
			$tableau .= '<tr>';

				foreach($ligne as $cellule)
				{
					$tableau .= '<td>'.$cellule.'</td>';
				}

			$tableau .= '</tr>';

		}
		$tableau .= '</table>';

		echo $tableau;

	}
}

/*
Module des statistiques
*/
class StatAppBlock extends JHomBlock implements IJhomBlock
{
	// Propriété
	private $EditMode;

	//Constructeur
	function StatAppBlock($core="")
	{
		//Version
 		$this->Version = "2.2.0.0";

		$this->Core=$core;
	}

	function Init()
	{}

	function Create()
	{}

	function Show()
	{
		$TextControl = '';

		//Liste des statistique disponible
		$lstStatistique = new ListBox('lstStat');
		$lstStatistique->Value = 'Choix de la statistique';
		$lstStatistique->Add('UserDay', 'UserDay');
		$lstStatistique->Add('UserPage', 'UserPage');

		$TextControl .= $lstStatistique->Show();

		//Action
		$Action = new AjaxAction("StatAppBlock", "ShowStat");
		$Action->ChangedControl = "dvResultat";
		$Action->AddControl('lstStat');

		//Bouton d'action
		$btnShow = new button(BUTTON);
		$btnShow->Value = 'Show';
		$btnShow->OnClick = $Action;

		$TextControl .= $btnShow->Show();

		//Resultat
		$TextControl .= '<div id = "dvResultat">resultat</div>';

		return $TextControl;

	}

	//Affiche la statistique
	function ShowStat()
	{

		switch(JVar::GetPost('lstStat'))
		{
			case 'UserDay':
				$request = 'SELECT DateCreate, count(id), GROUP_CONCAT(Distinct(App)) FROM stat_app GROUP BY  to_days(DateCreate) ';
				$entetes = array('Date', 'Nombre utilisateur', 'App');
			break;
			case 'UserPage':
				$request = 'SELECT DateCreate, Adresse, UserId,GROUP_CONCAT(Distinct(App)), Navigator,DateCreate FROM stat_app GROUP BY to_days(DateCreate),Adresse';
				$entetes = array('Date','adresse', 'User', 'App', 'navigator', 'DateCreate');
				break;
		}

		//Creation du tableau
		$tableau = "<table class='profil'>";

		//Creation des entetes
		$tableau .= '<tr>';
		foreach($entetes as $entete)
		{
			$tableau .= '<th>'.$entete.'</th>';
		}
		$tableau .= '<tr>';

		$results = $this->Core->Db->GetArray($request);

		foreach($results as $ligne)
		{
			$tableau .= '<tr>';

				foreach($ligne as $cellule)
				{
					$tableau .= '<td>'.$cellule.'</td>';
				}

			$tableau .= '</tr>';

		}
		$tableau .= '</table>';

		echo $tableau;

	}
}


/*
Module des statistiques
*/

class StatWidgetBlock extends JHomBlock implements IJhomBlock
{
	// Propriété
	private $EditMode;

	//Constructeur
	function StatWidgetBlock($core="")
	{
		//Version
 		$this->Version = "2.2.0.0";

		$this->Core=$core;
	}

	function Init()
	{}

	function Create()
	{}

	function Show()
	{
		$TextControl = '';

		//Liste des statistique disponible
		$lstStatistique = new ListBox('lstStat');
		$lstStatistique->Value = 'Choix de la statistique';
		$lstStatistique->Add('UserDay', 'UserDay');
		$lstStatistique->Add('UserPage', 'UserPage');

		$TextControl .= $lstStatistique->Show();

		//Action
		$Action = new AjaxAction("StatWidgetBlock", "ShowStat");
		$Action->ChangedControl = "dvResultat";
		$Action->AddControl('lstStat');

		//Bouton d'action
		$btnShow = new button(BUTTON);
		$btnShow->Value = 'Show';
		$btnShow->OnClick = $Action;

		$TextControl .= $btnShow->Show();

		//Resultat
		$TextControl .= '<div id = "dvResultat">resultat</div>';

		return $TextControl;

	}

	//Affiche la statistique
	function ShowStat()
	{

		switch(JVar::GetPost('lstStat'))
		{
			case 'UserDay':
				$request = 'SELECT DateCreate, count(id), GROUP_CONCAT(Distinct(Widget)) FROM stat_widget GROUP BY  to_days(DateCreate) ';
				$entetes = array('Date', 'Nombre utilisateur', 'Widget');
			break;
			case 'UserPage':
				$request = 'SELECT DateCreate, Adresse, UserId, GROUP_CONCAT(Distinct(Widget)), Navigator FROM stat_widget GROUP BY to_days(DateCreate), Adresse';
				$entetes = array('Date', 'adresse', 'User', 'Widget','navigator');
				break;
		}

		//Creation du tableau
		$tableau = "<table class='profil'>";

		//Creation des entetes
		$tableau .= '<tr>';
		foreach($entetes as $entete)
		{
			$tableau .= '<th>'.$entete.'</th>';
		}
		$tableau .= '<tr>';

		$results = $this->Core->Db->GetArray($request);

		foreach($results as $ligne)
		{
			$tableau .= '<tr>';

				foreach($ligne as $cellule)
				{
					$tableau .= '<td>'.$cellule.'</td>';
				}

			$tableau .= '</tr>';

		}
		$tableau .= '</table>';

		echo $tableau;

	}

}


?>
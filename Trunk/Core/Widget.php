<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
/**
 * Classe de base des applications
 * */
class Widget
{
	protected $Config;
	protected $AddWindowsTool;
	public $PlugIn;

	/**
	 * Constucteur
	 * */
	public function Widget($core, $name)
	{
		//Recuperation du coeur
		$this->Core = $core;

		//Configuration
		if($this->Core->User)
		{
			$this->Config = new Config($this->Core, $name, "Widgets");
			$this->AddWindowsTool = true;

			//PlugIN
			$this->PlugIn = new PlugIn($this->Core, $name,"Widgets", "Widgets");
		}
	}

	/**
	 * Démarrage
	 * */
	public function Run($core, $title, $name)
	{
		//Recuperation du template de base
		$textControl = $this->GetWidgetTemplate();
		//Recuperation de l'interface utilisateur
		$this->GetInterface($name);

		//Ajout des informations de base
		$textControl = str_replace("!title", $title, $textControl);
		$textControl = str_replace("!name", $name, $textControl);

		//Ajout du menu
		$Menu = $this->SetMenu();
		$textControl = str_replace("!widgetMenu", $Menu, $textControl);

		//Ajout des outils
		$Tool = $this->SetTool($name);
		$textControl = str_replace("!widgetTool", $Tool, $textControl);

		//Ajout des informations de la partie central
		$Center = $this->SetBlock($name, "center");
		$textControl = str_replace("!widgetCenter", $Center, $textControl);

		return $textControl;
	}

	/**
	 * Récupére le template des applications
	 * */
	protected function GetWidgetTemplate()
	{
		return JFile::GetFileContent("../JHom/Template/Pages/widget.tpl");
	}

	/**
	 * Recuperation de l'inteface utilisateur
	 * */
	protected function GetInterface($widget)
	{
	    $fileName = "../Widgets/$widget/".$widget.".xml";

		if(file_exists($fileName))
		{
			$this->Interface=new JDOMDocument();
			$this->Interface->load($fileName);
		}
		else
		{
		    $fileName = "Widgets/$widget/".$widget.".xml";
			$this->Interface=new JDOMDocument();
			$this->Interface->load($fileName);
		}
	}

	/**
	 * Récupere et crée le menu
	 */
	protected function SetMenu()
	{
		$xmlMenu = $this->Interface->GetElementsByTagName("menu");

		if($xmlMenu->item(0) != null)
		{
			$Menu = $xmlMenu->item(0);
			$MenuV = new MenuV("widgetMenu");

			//Recuperation des item
			$items = $Menu->GetElementsByTagName("item");

			foreach($items as $item)
			{
					$MenuV->AddItem($this->Core->GetCode($item->getAttribute("name")),"", "", "", $item->getAttribute("action"));

					//Recuperation des sous menu
					$subItems = $item->GetElementsByTagName("subitem");

					if(sizeof($subItems) > 0)
					{
						foreach($subItems as $subItem)
						{
							//Onglet Admin que pour le groupe Root
							if( ($subItem->getAttribute("name") == 'Admin' && $this->Core->User->Email->Value == "jerome.oliva@gmail.com") || $subItem->getAttribute("name") != 'Admin')
							{
								$MenuV->AddSubItem($this->Core->GetCode($item->getAttribute("name")),$this->Core->GetCode($subItem->getAttribute("name")),"",$subItem->getAttribute("action"), $subItem->getAttribute("img"));
							}
						}
					}
			}

			return $MenuV->Show();
		}

		return "";
	}

	/**
	 * Récupere et crée la barre d'outil
	 */
	protected function SetTool($widget)
	{
		$xmlToolBar = $this->Interface->GetElementsByTagName("toolbar");

		if($xmlToolBar->item(0) != null)
		{
			$tools = $xmlToolBar->item(0)->GetElementsByTagName("tool");
			$textControl = "<table><tr>";

			foreach($tools as $tool)
			{
				$img = new Image("../Widgets/$widget/images/".$tool->getAttribute("img"));
				$img->AddStyle("width","20px");
				$img->Title = $tool->getAttribute("title");
				$img->Alt = $tool->getAttribute("title");
				$img->Id= $tool->getAttribute("action");

				$textControl .= "<td>".$img->Show()."</td>";
			}
			$textControl .= "</tr></table>";

			return $textControl;
		}

		return "";
	}

	/*
	 * Récupère et crée la partie gauche
	 * */
	protected function SetBlock($widget, $div)
	{
		$xmlLeft = $this->Interface->GetElementsByTagName($div);
		$textControl = "";

		if($xmlLeft->item(0) != null)
		{
			//Le premier enfant determine si on utilise des onglet
			//Verification
			if($xmlLeft->item(0)->childNodes->item(0)->nodeName != "#text")
			{
				$i = 0;
			}
			else
			{
				$i = 1;
			}

			if($xmlLeft->item(0)->childNodes->item($i)->nodeName == "item")
			{
				//Creation du tabStrip
				$tabStrip = new TabStrip($xmlLeft->item(0)->childNodes->item($i)->getAttribute("TabStripName"), '', $widget);

				//Ajout des onglets
				foreach($xmlLeft->item(0)->childNodes as $node)
				{
					if($node->nodeName != "#text")
					{
						//Recuperation des elements enfants
						$textTab  = "";
						$textTab .= $this->SetControls($node);

						if($node->getAttribute("img"))
						{
							$img = "../Widgets/$widget/images/".$node->getAttribute("img");
						}
						else
						{
							$img = '';
						}

						$tabStrip->AddTab($node->getAttribute("text"),new libelle($textTab),"", $img);
					}
				}

				$textControl = $tabStrip->Show();
			}
			else
			{
				foreach($xmlLeft->item(0)->childNodes as $node)
				{
					if($node->nodeName != "#text")
					{
						 $textControl .= $this->SetControl($node);
					}
				}
			}

			return $textControl;
		}

		return "";
	}

	function SetControl($child)
	{
		$textTab ="";

		switch($child->nodeName)
				{
					case "label":
						$textTab .= $child->nodeValue;
					break;
					case "module":
						$nameBlock  = $child->getAttribute("type");
						$block = new $nameBlock($this->Core);

						//Verification des parametres
						$properties = $child->getElementsByTagName("property");

						if(sizeof($properties) > 0)
						{
							foreach($properties as $propertie)
							{
								$name = $propertie->getAttribute("Name");

								$block->$name->Value = $propertie->getAttribute("Value");
							}
						}

						$textTab .= $block->Show();
					break;
					default :
						$nameControl = $child->nodeName;
						$control = new $nameControl($child->getAttribute("name"));
						$control->Id = $child->getAttribute("name");
						$control->Value = $child->getAttribute("value");
						$textTab .= $control->Show();
					break;
				}

				return $textTab;
	}

	/**
	 * Crée le controle
	 */
	function SetControls($node)
	{
		$textTab = "";
		//Ajout des controle ou module
		foreach($node->childNodes as $child)
		{
			if($child->nodeName != "#text")
			{
				$textTab .= $this->SetControl($child);
			}
		}
		return $textTab;
	}

	/**
	 * Crée la partie du bas
	 */
	function SetFoot()
	{
		return "Eemmys";
	}
}



?>
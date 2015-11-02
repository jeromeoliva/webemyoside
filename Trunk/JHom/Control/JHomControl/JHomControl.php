<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class JHomControl
{
	//Proprietes
	protected $Id;
	protected $Name;
	protected $Enabled=true;
	protected $Type;
	protected $CssClass;
	protected $Style;
	protected $Attribute;
	protected $Libelle;
	protected $Value;
	protected $OnClick;
	protected $OnMouseMove;
	protected $OnMouseOver;
	protected $OnMouseEnter;
	protected $OnMouseLeave;
	protected $OnMouseOut;
	protected $OnChange;
	protected $OnKeyUp;
	protected $RegExp;
	protected $MessageErreur;
	protected $MessageObligatoire;
	protected $IsValid=true;
	protected $Obligatory=true;
	protected $PlaceHolder;
    protected $AutoCapitalize = 'None';
    protected $AutoCorrect = 'None';
    protected $AutoComplete = 'None';


	//Constructeur
	function JHomControl($name)
	{
		//Version
		$this->Version ="2.0.1.1";

		$this->Name=$name;
	}

	//Ajout de style
	function AddStyle($property,$value)
	{
		$this->Style.=$property.":".$value.";";
	}

	//Ajout d'attributs
	function AddAttribute($event,$action)
	{
		$this->Attribute.=$event."='".$action."' ";
	}

	//Fonction d'affichage du control
	function Show()
	{
		$TextControl ="\n<input type='".$this->Type."'";
		$TextControl .= $this->getProperties();
		$TextControl .="></input>";

		//Affichage d'une eventuelle erreur d'expression reguliere saisie
		if(!$this->IsValid)
		{
			$TextControl .="<span style='color:red;'> ".(($this->MessageErreur)?$this->MessageErreur:'Invalide')." </span>";
		}

		//Affichage d'un champ obligatoire non saisi
		if(!$this->Obligatory)
		{
			//TODO gerer si on vu on non l'�toile'$TextControl .="<span style='color:blue;'> ".(($this->MessageObligatoire)?$this->MessageObligatoire:'*')." </span>";
			//$TextControl .="<span style='color:blue;'> ".(($this->MessageObligatoire)?$this->MessageObligatoire:'')." </span>";
		}

		return $TextControl ;
	}

	//Retourne les propri�tes du control
	protected function getProperties($addValue = true)
	{
		$TextControl ="";

		$TextControl .=($this->Id  !="")?"id='".$this->Id."' ":"";
		$TextControl .=($this->Name !="")?"name='".$this->Name."' ":"";
		$TextControl .=($this->Enabled !=true)?" Disabled " :"";
		$TextControl .=($this->CssClass !="")?" class='".$this->CssClass."' " :  "";
		$TextControl .=($this->Style !="")?"    style='".$this->Style."'    "  :  "";
		$TextControl .=($this->Attribute !="")? $this->Attribute : "";
	
		if($addValue)
		{
			$TextControl .=($this->Value !="")? "  value='".$this->Value. "'" : "";
		}
		
		//Gestion des actions
		if(is_object($this->OnClick))
			$TextControl .=($this->OnClick != "")? " onclick=\"".$this->OnClick->DoAction()."\"": "";
		else
			$TextControl .=($this->OnClick != "")? " onclick=\"".$this->OnClick."\"": "";

		//Survol de la sourie
		if(is_object($this->OnMouseMove))
			$TextControl .=($this->OnMouseMove != "")? " onmousemove=\"".$this->OnMouseMove->DoAction()."\"": "";
		else
			$TextControl .=($this->OnMouseMove != "")? " onmousemove=\"".$this->OnMouseMove."\"": "";

		//Passage de la sourie
		if(is_object($this->OnMouseOver))
			$TextControl .=($this->OnMouseOver != "")? " onmouseover=\"".$this->OnMouseOver->DoAction()."\"": "";
		else
			$TextControl .=($this->OnMouseOver != "")? " onmouseover=\"".$this->OnMouseOver."\"": "";

		//Entr�e de la sourie
		if(is_object($this->OnMouseEnter))
			$TextControl .=($this->OnMouseEnter != "")? " onmouseenter=\"".$this->OnMouseEnter->DoAction()."\"": "";
		else
			$TextControl .=($this->OnMouseEnter != "")? " onmouseenter=\"".$this->OnMouseEnter."\"": "";

		//Sourie de la sourie
		if(is_object($this->OnMouseLeave))
			$TextControl .=($this->OnMouseLeave != "")? " onmouseleave=\"".$this->OnMouseLeave->DoAction()."\"": "";
		else
			$TextControl .=($this->OnMouseLeave != "")? " onmouseleave=\"".$this->OnMouseLeave."\"": "";

		//Sortie de la sourie
		if(is_object($this->OnMouseOut))
			$TextControl .=($this->OnMouseOut != "")? " onmouseout=\"".$this->OnMouseOut->DoAction()."\"": "";
		else
			$TextControl .=($this->OnMouseOut != "")? " onmouseout=\"".$this->OnMouseOut."\"": "";

		//Changement de la valeur
		if(is_object($this->OnChange))
			$TextControl .=($this->OnChange != "")? " onchange=\"".$this->OnChange->DoAction()."\"": "";
		else
			$TextControl .=($this->OnChange != "")? " onchange=\"".$this->OnChange."\"": "";

		//Sortie du clavier
		if(is_object($this->OnKeyUp))
			$TextControl .=($this->OnKeyUp != "")? " onkeyup=\"".$this->OnKeyUp->DoAction()."\"": "";
		else
			$TextControl .=($this->OnKeyUp != "")? " onkeyup=\"".$this->OnKeyUp."\"": "";

		//TODO d�finir la prorri�t� Ben
		if($this->PlaceHolder != "")
		{
			$TextControl .= " placeholder=".$this->PlaceHolder;
		}

		//TODO d�finir la prorri�t� Ben
		if($this->AutoCapitalize === true)
		{
			$TextControl .= " autocapitalize = 'on'";
		}
		else if($this->AutoCapitalize == 'None')
		{
		}
		else
		{
			$TextControl .= " autocapitalize = 'off'";
		}

		//TODO d�finir la prorri�t� Ben
		if($this->AutoCorrect === true)
		{
			$TextControl .= " autocorrect = 'on'";
		}
		else if($this->AutoCorrect == 'None')
		{
		}
		else
		{
			$TextControl .= " autocorrect = 'off'";
		}

		if($this->AutoComplete === true)
		{
			$TextControl .= " autocomplete = 'on'";
		}
		else if($this->AutoComplete == 'None')
		{
		}
		else
		{
			$TextControl .= " autocomplete = 'off'";
		}

		return $TextControl;
	}

	//fonction de verification
	public function Verify()
	{
		$verif=true;

		if($this->Value !="")
			{
				//Test d'une expression reguliere
				if($this->RegExp != "")
				{
					if(!preg_match(''.$this->RegExp.'', $this->Value))
				    	 $verif=false;
				}
			}
			$this->IsValid=$verif;

		return $verif;
	}

	//asseceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
	  $this->$name=$value;
	}
}

//Interface obligatoires pour tout les controls
interface IJHomControl
 {
	public function Show();
	public function Verify();
 }

?>
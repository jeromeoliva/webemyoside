<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class ListCheckBox extends JHomControl implements IJHomControl
{
	//Propri�te
	private $CheckBox=array();
	private $Count = 0;
	private $Span;

	/**
	 * Constucteur
	 * @param $name nom du contr�le
	 * */
	 public function ListCheckBox($name, $span = false)
	 {
	 	//Version
		$this->Version ="2.0.1.1";

		$this->Id=$name;
	 	$this->Name = $name;
	 	$this->Span = $span;
	 }

	 /**
	  * Ajout d'une case à cocher
	  * @param $key cl�
	  * @param $value valeur
	  * @param $checked coch�
	  * */
	 public function Add($key,$value,$checked,$imgDetail="", $onClick ="", $autoCompleteName = true)
	 {
	 	$this->Count++;
	 	if($autoCompleteName == false)
	 	{
	 		$check = new CheckBox($key, true);
	 	}
	 	else
	 	{
	 		$check = new CheckBox($key."_".$value,true);
	 	}

	 	if($imgDetail)
	 	{
	 		$imgDetail->AddStyle("width", "50px");
		 	$check->Libelle .= $imgDetail->Show();
	 	}
		$check->Libelle .= $key;


	 	$check->Value   = $value;
	 	$check->Checked = $checked;

	 	if($onClick != "")
	 	{
	 		$check->OnClick = $onClick;
	 	}

	 	$this->CheckBox[]=$check;
	 }

	 /**
	  * Affiche le contr�le
	  * */
	 public function Show()
	 {
	 	$textControl="";

		if($this->Span)
		{
			$textControl = "<dl id='".$this->Id."' style='text-align:left;' >";
		}

		foreach($this->CheckBox as $checkBox)
		{
			$textControl .= "<li><span>".$checkBox->Show().$checkBox->Libelle."</span></li>";
		}

		if($this->Span)
		{
			$textControl .= "</dl>";
		}
		return $textControl;
	 }
}
?>

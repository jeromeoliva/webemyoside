<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class DateBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function DateBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->RegExp="'([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4})'";
		$this->MessageErreur="Date invalide elle doit être au format jj/mm/aaaa";
		$this->Type="text";
		$this->CssClass="dateBox";
		
		$this->AddStyle("width","100px");
		$this->AddAttribute("OnBlur","DateBox.Verify(this,\"".JFormat::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")");

		$this->AutoCapitalize = false;
    	$this->AutoCorrect = false;
    	$this->AutoComplete = false;
    }

    function Show()
    {
		$TextControl = parent::show();

		$img = new Image('../Images/icones/calendar.png');
		$img->Title = 'Date';
		$img->OnClick ="var element=document.getElementById('".$this->Id."');displayCalendar(element,'dd/mm/yyyy',this)";

		if($this->Enabled)
			$TextControl .=  $img->Show();

		return $TextControl;
    }
}
?>
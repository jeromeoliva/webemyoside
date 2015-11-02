<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class RadioButton extends JHomControl implements IJHomControl
{
	private $Checked;

	//Constructeur
	function RadioButton($name)
	{
		//Version
		$this->Version ="2.0.2.0";

		$this->Id=$name;
		$this->Type="Radio";
		$this->Name=$name;
	}

	//Affichage du control
	function Show()
	{
		$chek ="";

		if($this->Checked == 1 )
			$chek = " checked=checked  ";

		$TextControl  =" \n<input type=".$this->Type."  value='$this->Value'" ;
		$TextControl .= $this->getProperties();
		$TextControl .= $chek.">";

		return $TextControl;
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
?>

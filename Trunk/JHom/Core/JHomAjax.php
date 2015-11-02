<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */


class JHomAjax
{
	//Proprietes
	private $Controls = array();
	public $Version;

	function JHomAjax()
	{
		//Version
		$this->Version = "2.1.0.0";
	}

	//Ajout de control
	function AddControl($control, $value)
	{
		if(is_object($control))
		{
			$this->Controls[$control->Id] = $control->Show();
		}
		else
		{
			$this->Controls[$control] = $value;
		}
	}

	//Rafraichissement des controls
	function RefreshControl()
	{
		echo  utf8_encode(Serialization::Encode32($this->Controls));
	}
}

?>
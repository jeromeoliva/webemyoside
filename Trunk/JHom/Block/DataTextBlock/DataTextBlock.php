<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 class DataTextBlock extends JHomBlock implements IJhomBlock
{
	/*
	 * Constrcucteur
	 * @param $core coeur du framework
	 * @param $code code du texte recherch�
	 * @param $typeDb fichier
	 * */
	function DataTextBlock($core,$code="")
	{
		//Version
 		$this->Version = "2.0.2.0";

		$this->Text = new DataText($core);
		if($code != "")
			$this->Text->GetByCode($code);

		$this->CssClass = "BlockGris";
		$this->Frame =true;
		$this->Table =true;
	}

	public function Create()
	{

	}

	public function Init(){}

	/*
	 * Affiche le texte
	 * */
	function Show()
	{
		//$this->Body .= "<h2>".$this->Text->Title->Value."</h2>";
		$this->Body .= $this->Text->Text->Value;
	   return parent::Show();
	}

	//Asseceur
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

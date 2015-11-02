<?php
/*
 * Classe de base pour les fenetres
 *
 * */

 class Window
 {
 	private $File;
 	private $Class;
 	private $Parameter=array();
 	private $Argument=array();
	private $Url ;
 	private $Body;

	//Constructeur
 	function Window($file="",$class="",$url="")
 	{
 		//Version
 		$this->Version = "2.0.0.0";

 		$this->File= $file;
 		$this->Class = $class;
 		$this->Url = $url;
		$this->i=0;
 	}

	//Ajout d'un parametre
 	function AddParameter($key,$value)
	{
		$this->Parameter[$key]=$value;
	}

	function Show()
	{
		echo "<script type='text/javascript' src='script.php' ></script>";

		$balise = Script::GetJsBalise();
 		$function ="Window.Show(".$this->Body.")";
 		echo Format::Text($balise,$function);
	}

	//Ouvre un nouvel onglet
	function OpenWindow($url,$id)
	{

		return "window.open('".$url."?idEntity=".$id."');";
	}

	//Ouvre une popup
	function OpenPopUp($arg,$id)
	{
		return 	"var popUp=new PopUp('".Serialization::Encode($arg)."');popUp.Open();";
	}

	//Ajoute des arguments pour la methode Serveur
	function AddArgument($key, $value)
	{
		$this->Argument[$key]=$value;
	}

	//Enregistrement de l'action à effectuer
	function DoAction()
	{
		return $this->OpenWindow($this->Url,$this->Argument["idEntity"]);
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

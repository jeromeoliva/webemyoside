<?php
/*09/05/2009
 * Classe pour le gestion des messages
 *
 * */

 class JMessage
 {
 	private $Action;
 	private $Core;

 	//constructeur
 	function JMessage($core)
 	{
		//Version
		$this->Version = "2.0.0.0";
		$this->Core = $core;
 	}

	//affiche un message
 	public function Show($text)
 	{
 		$balise = JScript::GetJsBalise();
 		$function =" JMessage.Show('".$text."', '".$this->Core->GetCode("Close")."'); ";

		$this->Action .= JFormat::Text($balise,$function);
 	}

	//Affiche une demande
	public function Ask($text)
	{
		$balise = JScript::GetJsBalise();
 		$function =" Message.Ask('".$text."'); ";

		$this->Action .= JFormat::Text($balise,$function);
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

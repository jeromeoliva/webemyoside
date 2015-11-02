<?php
/*
 *27/04/2009
 * Classe utilisé
 *
 */
 include "Core/JHomCore.php";
 include "JVar.php";

class Core extends JHomCore
{
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

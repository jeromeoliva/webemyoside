<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

//Interface de base pour les colonnes
interface IColumn
{
  public function GetCell($cell);
}

//Classe de base pour les colonne
class GridColumn
{
	function GridColumn()
	{
		$this->Version ="2.0.1.0";
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

//Classe de base pour les colonnes
class Column extends JHomControl implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;

  function Column($headerName,$value)
  {
    $this->HeaderName = $headerName;
    $this->Value = $value;
  }

  //Retourne les data
  public function GetCell($Tab)
  {
    return "\n\t<td>".$Tab[$this->Value]."</td>";
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

//Classe les colonnes coontenant un control
class ControlColumn extends JHomControl implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $TypeControl;

  function ControlColumn($headerName,$value,$typeControl,$style="")
  {
    $this->HeaderName = $headerName;
    $this->TypeControl = $typeControl;
    $this->Value = $value;
    $this->Style = $style;
  }

  //Retourne les data
  public function GetCell($Tab,$idName="")
  {
  	if(is_object($Tab))
  	{
  		$TextControl = new $this->TypeControl($Tab->IdEntite);
  	}
  	else
  	{
  		$TextControl = new $this->TypeControl($Tab[$idName]);
  		$TextControl->Value = $Tab[$this->Value];
  	}
  	//Ajout de style sur les controls
  	if(is_array($this->Style))
  	{
	  	foreach($this->Style as $style)
	  	{
          $styleValue= split(":",$style);
          $TextControl->AddStyle($styleValue[0],$styleValue[1]);
	  	}
  	}


    return "\n\t<td>".$TextControl->Show()."</td>";
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

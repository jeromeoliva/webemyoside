<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class ModuleAction extends JHomAction
{
  //Propriete
  private $Files;
  private $Classe;
  private $Methode;
  private $Argument=array();

  //Constructeur
  function ModuleAction($files,$classe="",$methode="")
  {
  	$this->Version ="2.0.1.0";

    $this->Files = $files;
    $this->Classe = $classe;
    $this->Methode = $methode;
  }

  //Ajoute des arguements pour la methode Serveur
  function AddArgument($key, $value)
  {
    $this->Argument[$key]=$value;
  }

  function DoAction()
  {
  	$arg="";
  	foreach($this->Argument as $key=>$value)
  	{
  		if($arg =="")
  			$arg = $key."=".$value;
  		else
  			$arg .= "&".$key."=".$value;
  	}

    $action =" var JAjax = new ajax();";
    $action .="JAjax.RefreshModule(*".$this->Classe."*,*".$this->Methode."*,*".$arg."*); ";

     return $action;
  }
}
?>

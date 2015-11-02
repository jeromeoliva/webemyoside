<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class PageAction extends JHomAction
{
  //Propriete
  private $Files;
  private $Classe;
  private $Methode;
  private $Argument=array();

  //Constructeur
  function PageAction($files,$classe="",$methode="")
  {
  	$this->Version ="2.0.1.0";

    $this->Files = $files;
    $this->Classe = $classe;
    $this->Methode = $methode;
  }

  function DoAction()
  {
    $action =" var JAjax = new ajax();";
    $action .="JAjax.Refresh(*".$this->Files."*,*".$this->Classe."*,*".$this->Methode."*); ";

     return $action;
  }
}
?>

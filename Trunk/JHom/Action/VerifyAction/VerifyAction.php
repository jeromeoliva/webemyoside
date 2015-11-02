<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class VerifyAction extends JHomAction
{
  private $Sender;
  private $Class;
  protected $Arg;
  private $IdEntity;
  private $Argument=array();
  private $SourceControl;
  private $ErrorMessage;

  //Constructeur
  function VerifyAction($class="", $methode="")
  {
  	//Version
	$this->Version = "2.0.2.0";

    $this->Class=$class;
    $this->Methode=$methode;
  }

  //Enregistrement de l'action � effectuer
  function DoAction()
  {
  $Property = array();

  $reflection = new ReflectionObject($this);
  $Properties=$reflection->getProperties();

  //Ajout des propri�t�s
  foreach($Properties as $control)
  {
    $name=$control->getName();
      $Property[$name]=$this->$name;
  }

  //Ajout des arguments
  $this->AddArgument("Class",$this->Class);
  $this->AddArgument("Methode",$this->Methode);
  $this->AddArgument("Argument",$this->Argument);
  $this->AddArgument("ErrorMessage",$this->ErrorMessage);

  //return "var JAjaxAction=new AjaxAction('".Serialization::Encode($Property)."','".Serialization::Encode($this->Argument)."');JAjaxAction.DoAction()";
	return "JVerify('".Serialization::Encode($Property)."','".Serialization::Encode($this->Argument)."')";


  }
  //Ajoute des arguements pour la methode Serveur
  function AddArgument($key, $value)
  {
    $this->Argument[$key]=$value;
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

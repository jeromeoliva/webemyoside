<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class EntityGridColumn
{
	function EntityGridColumn()
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
 //Classe de base pour les colonnes d'entite
class EntityColumn extends JHomControl implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $EntityProperty;
  private $ClassCss ;

  private $CellClassCss ;

  //Constructeur
  function EntityColumn($headerName,$propertyName,$entityProperty="", $cellClassCss="")
  {
    $this->HeaderName = $headerName;
    $this->PropertyName = $propertyName;
    $this->EntityProperty = $entityProperty;
    $this->CellClassCss = $cellClassCss;
  }

  //Retourne les data
  public function GetCell($Entite)
  {
    $Propertie = $this->PropertyName;
   	if($this->CellClassCss)
   	{
   		$CssClass = " class='".$this->CellClassCss."'";
   	}
   	else
   	{
   		$CssClass ="";
   	}

    if($Entite->$Propertie && is_object($Entite->$Propertie->Value))
    {
      $class=$Entite->$Propertie->Value;
      $property = $this->EntityProperty;
      return "\n\t<td $CssClass>".$class->$property->Value."</td>";
    }
    else if($Entite->$Propertie)
    {
      return "\n\t<td $CssClass>".$Entite->$Propertie->Value."</td>";
    }
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

//Classe pour afficher des control dans les cellules
class EntityControlColumn extends JHomControl implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;
  protected $Enabled;
  private $ClassCss ;


  function EntityControlColumn($headerName,$propertyName,$enabled="")
  {
    $this->HeaderName = $headerName;
    $this->PropertyName = $propertyName;
    $this->Enabled = $enabled;
  }

  //Retourne les data
  public function GetCell($Entite)
  {
    $Propertie = $this->PropertyName;
    if(is_object($Entite->$Propertie->Control))
    {
      $control=$Entite->$Propertie->Control;
      $control->Enabled = $this->Enabled;
      $control->Value = $Entite->$Propertie->Value;

      return "\n\t<td>".$control->Show()."</td>";
    }
    else
    {
      return "\n\t<td>".$Entite->$Propertie->Value."</td>";
    }
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
//Classe de base pour les colonnes qui appele une fonction utilisateur
class UserActionColumn extends JHomControl implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $FormName;
  private $UserAction;
  private $Image;
  private $Title;
  protected $ClassCss;

  //Constructeur
  function UserActionColumn($headerName, $userAction , $formName,$image,$title)
  {
    $this->HeaderName = $headerName;
    $this->PropertyName = $image;

  	if(is_object($formName))
    	$this->FormName = $formName->Name;

    $this->UserAction = $userAction;
    $this->Image = $image;
    $this->Title = $title;
  }

  //Retourne les data
  function GetCell($Entite)
  {
    return "\n\t<td onClick='UserActionColumn.DoAction(\"".$this->UserAction."\",\"".$this->FormName."\",\"".$Entite->IdEntite."\");'><img src='".$this->Image."' title='".$this->Title."'></td>";
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

//Classe de base qui appele une fonction de classe quelconque
class ActionColumn extends JHomControl implements IColumn
{
  //Propriete
  private $HeaderName;
  private $Classe;
  private $Methode;
  private $Argument;
  private $Image;
  private $Title;
  private $ClassCss;

  //Constructeur
  function ActionColumn($headerName , $classe, $image, $title, $classCss = "")
  {
    $this->HeaderName = $headerName;
    $this->Image= $image;
    $this->Classe = $classe;
    $this->Title = $title ;
    $this->ClassCss = $classCss;
  }

  function GetCell($Entite)
  {
    //Ajout de l'identifiant de l'entit�
    $this->Classe->AddArgument("idEntity",$Entite->IdEntite);
    
    if($this->Image != "")
    {
    	$img= "<img src='".$this->Image."'     title='".$this->Title."'>";
    }
    else
    {
    	$img ="";
    }
    
    if($this->ClassCss != '')
    {
 		$class= " class=".$this->ClassCss;   
    }
    else
    {
    	$class = "";
    }
    
    return "\n\t<td style='text-align:center;' onClick=\"".$this->Classe->DoAction()."\"    title='".$this->Title."' ><b $class>".$img."</b></td>";
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

/**
 * Class pour les actions JS
 */
class JsActionColumn extends JHomControl implements IColumn
{
    private $HeaderName;
    private $action;
    private $ClassCss;
    private $Title;
    
    function JsActionColumn($headerName, $action, $classCss, $title = "" )
    {
        
        $this->HeaderName = $headerName;
        $this->action = $action;
        $this->ClassCss = $classCss;
        $this->Title = $title;
    }
    
      //Retourne les data
  public function GetCell($Entite)
  {
     //print_r($Entite); 

    // return "\n\t<td>".$Entite->$Propertie->Value."</td>";
     return "\n\t<td><span class='".$this->ClassCss."' onclick='".$this->action."(".$Entite->IdEntite.");' title='".$this->Title."'></span></td>";
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



//Column Dinsertion d'image
//Column Dinsertion d'image
class ImageColumn extends JHomControl implements IColumn
{
    //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $EntityProperty;
  private $Directory;

  //Constructeur
  function ImageColumn($headerName,$propertyName,$entityProperty="",$directory)
  {
    $this->HeaderName = $headerName;
    $this->PropertyName = $propertyName;
    $this->EntityProperty = $entityProperty;
    $this->Directory = $directory;
  }

  //Retourne les data
  public function GetCell($Entite)
  {
    $Propertie = $this->PropertyName;

    if(is_object($Entite->$Propertie->Value))
    {
      $class=$Entite->$Propertie->Value;
      $property = $this->EntityProperty;
      return "\n\t<td><img style='width:40px;height:40px;'  src='".$this->Directory."/".$class->$property->Value."'></td>";
    }
    else
    {
     // return "\n\t<td>".$Entite->$Propertie->Value."</td>";
     return "\n\t<td><img style='width:40px;height:40px;'  src='".$this->Directory."/".$Entite->$Propertie->Value."'></td>";

    }
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
//Column d'action ajax
class AjaxActionColumn extends JHomControl implements IColumn
{
    //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $EntityProperty;
  private $Methode;
  private $Title;
  private $Directory;
  private $ChangedControl;
  private $ClassCss;
  private $Argument;

  //Constructeur
  function AjaxActionColumn($headerName , $classe, $methode,$argument="",$image,$title,$changedControl ="", $confirm = false, $classCss ="")
  {
    $this->HeaderName = $headerName;
    $this->Image= $image;
    $this->Classe = $classe;
    $this->Methode = $methode;
    $this->Title = $title;
    $this->ChangedControl = $changedControl;
    $this->Argument = $argument;
    $this->Confirm = $confirm;
  	$this->ClassCss = $classCss;
  }

  //Retourne les data
  public function GetCell($Entite)
  {
  	$Action = new AjaxAction($this->Classe,$this->Methode);

  	if($this->Confirm)
  		$Action->Confirm = $Entite->Core->GetCode("DeleteElement")."?";

  	$Action->AddArgument("idEntity",$Entite->IdEntite);
  	$Action->AddArgument($this->Argument);
  	$Action->ChangedControl =$this->ChangedControl;
  
  
     if($this->Image != "")
    {
	  	$Image = new Image($this->Image);
  		$Image->Title = $this->Title;
    	$img = $Image->Show();
    }
    else
    {
    	$img ="";
    }
    
    if($this->ClassCss != '')
    {
 		$class= " class='".$this->ClassCss."'";   
    }
    else
    {
    	$class = "";
    }


    return "\n\t<td onClick =\"".$Action->DoAction()."\"  title='".$this->Title."'><b $class>".$img."</b></td>";
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

//Colonne de lien
 class LinkColumn
 {
 	private $HeaderName;
 	private $PropertyName;
 	private $EntityProperty;
 	private $Url;

 	function LinkColumn($headerName,$propertyName,$entityProperty="",$url="")
 	{
 		$this->HeaderName     = $headerName;
 		$this->PropertyName   = $propertyName;
 		$this->EntityProperty = $entityProperty;
 		$this->Url = $url;
 	}

	 //Retourne les data
  	public function GetCell($Entite)
  	{
    	$Propertie = $this->PropertyName;

    	if(is_object($Entite->$Propertie->Value))
    	{
    		//Prevoir le passage d'une entite
    	}
      	else
      	{
      	 	$Url = new JUrl($this->Url);
    		$Url->AddParametre("idEntity",$Entite->IdEntite);

			//Utile pour la reecriture url
    		if(is_object($Entite->Name) && $Entite->Name->Value != "")
          	{
          		$Url->AddParametre("Name",$Entite->Name->Value);
          	}
        	if(isset($Entite->Title) && is_object($Entite->Title) && $Entite->Title->Value != "")
        	{
          		$Url->AddParametre("Title",str_replace(" ","", $Entite->Title->Value));
        	}

    		$Link =new Link($Entite->$Propertie->Value,$Url->GetUrl());
      		return "<td>".$Link->Show()."</td>";
      	}
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

//Colone de lien avec de images
 class LinkImageColumn
 {
 	private $Src;
 	private $Title;
 	private $Url;
 	private $HeaderName;
 	private $ShowTitle;

 	function LinkImageColumn($src, $title="", $url="", $showTitle = false)
 	{
 		$this->Src     = $src;
 		$this->Title = $title;
 		$this->Url = $url;
 		$this->ShowTitle = $showTitle;
 	}

	 //Retourne les data
  	public function GetCell($Entite)
  	{
      	$Url = new JUrl($this->Url);
		$Url->AddParametre("idEntity",$Entite->IdEntite);

		$LinkImage =new LinkImage($Url->GetUrl(), $this->Src, $this->Title, "WHITE", $this->ShowTitle);
  		return "<td style='text-align:center;'>".$LinkImage->Show()."</td>";
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

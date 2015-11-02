<?php
/*
classe qui ecrit dans le flux HTML
05/02/2009
*/

class JHomPage
{
	//Propri�tes
	protected $Core;
	protected $Doctype;
	protected $Head;
	protected $Body;
	protected $Style;
	protected $Title;

	//Les diff�rentes parties de la page
	protected $Header="\n";
	protected $Lefter="\n";
	protected $Center="";
	protected $Righter="";
	protected $Footer="";

	protected $Message="";
	protected $Template ="";
	protected $BlockTemplate = array();


	function JHomPage($core="")
	{
		//Version
		$this->Version = "2.0.1.0";

		$this->Core=$core;
	//	$this->Title = $this->Core->GetSiteName(). "sdfsf ";
		$this->Message=new Message();
	}

	//Fonctions
	//Insertion du doctype
	public function InsertDoctype($Type)
	{
		switch($Type)
		{
			case "strict":
				$this->Doctype="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' DTD/xhtml1-strict.dtd>";
			break;

			case "transitional":
			   $this->Doctype="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' DTD/xhtml1-transitional.dtd>";
			break;

			case "frameset":
			   $this->Doctype="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' DTD/xhtml1-frameset.dtd>";
			break;
		}
	}

	//Insetion des meta
	public function InsertMeta($meta,$content="")
	{
    	if($content == "")
		    $this->Head .= "\n<meta>".$meta."</meta>" ;
		 else
		 	  $this->Head .= "\n<meta $meta content=\"".$content."\"/>";
	}


    //Definition de lencodage
    public function SetCharset($charset)
    {
    	$this->Head .="\n<meta http-equiv='content-type' content='text/html; charset=".$charset."' />";
    }

	//Insertion d'un balise meta content
    public function InsertMetaContent($name,$content)
    {
		$this->Head .= "\n<meta name='".$name."' content='".$content."'/>";
	}

	//Insertion des javascript
	public function InsertJsScript($file)
	{
		$this->Head .="\n<script type='text/javascript' src='".$file."' ></script>";
	}

	//Insertion de script
    public function InsertScript($text)
    {
    	$this->Header .="\n<script type='text/javascript' >".$text."</script>";
	}

	//Insertion  des lien css
	public function InsertCss($file)
	{
		$this->Head .="<link rel='stylesheet' type='text/css' href='".$file."' />";
	}

	//Insertion d'un control
	public function Insert($part,$control)
	{
		switch($part)
		{
			case "head":
				$this->Header.= $control->Show();
			break;
			case "left":
				$this->Lefter .= $control->Show();
			break;
			case "center":
				$this->Center .= $control->Show();
			break;
			case "right":
				$this->Righter .= $control->Show();
			break;
			case "footer":
				$this->Footer .= $control->Show();
			break;
		}
	}
	//Ajout de style
	function AddStyle($property,$value)
	{
		$this->Style.=$property.":".$value.";";
	}

	//Ajout d'un bloc à remplacer'
	function AddBlockTemplate($key,$value)
	{
		$this->BlockTemplate[$key] = $value;
	}

	//Affichage
	public function Show()
	{
		$page =$this->Doctype."\n";
		$page = "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fr-fr' lang='fr-fr'>";

		//gestion du titre de la page
		$Title="\n<title>".(($this->Title != "")?$this->Core->GetSiteName() . $this->Title:"JHomSoft")."</title>";

		$page .="\n<head>".$Title.$this->Head."\n</head>\n";
		$page .=($this->Style !="")?" \n<body  style='".$this->Style."'>"  :  "<body>";
		$page .=$this->Body."\n";
		$page .="<div id='head'>".$this->Header."</div>";
		$page .="<div id='left'>".$this->Lefter."</div>";
		$page .="\n<div id='center'>".$this->Center."</div>";
		$page .= "\n<div id='right'>".$this->Righter."</div>";
		$page .= "\n<div id='foot'>".$this->Footer."</div>";
		$page .=$this->Message->Action."\n";
		$page .="</body>\n</html>";

		echo $page;
	}

	//Asseceurs
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
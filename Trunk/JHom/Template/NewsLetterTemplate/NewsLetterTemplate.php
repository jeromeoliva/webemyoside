<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

/**
 Template de pub
 */
 class NewsLetterTemplate
 {
 	private $Title;
 	private $Body;

 	/**
 	 * Constructeur
 	 * */
 	function NewsLetterTemplate()
 	{

 	}

 	/**
 	 * Affichage
 	 * */
 	function Show()
 	{
		$TextControl = "<html><head>";

		//Ajout du style

		$TextControl .="<div id='head'>" ;
		$TextControl .="<img src='http://monmariagemesenvies.com/ImagesUser/Banniere.jpeg'  Style='width:800px;height:150px;' />";
		$TextControl .=	"</head>";
		$TextControl .="<title>".$this->Title."</title></head>";
		$TextControl .="<body><div id='center'>".$this->Body."</div>";

		$TextControl .="<div id='foot'>";
		$TextControl .=" Rejoignez-nous sur <a href='http://monmariagemesenvies.com'>notre site</a>";
		$TextControl .= "<br/> a bientot.";
		$TextControl .="</div>";
		$TextControl .="</body>";
		$TextControl .="</html>";

		return $TextControl;
 	}

 	//Assecceurs
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

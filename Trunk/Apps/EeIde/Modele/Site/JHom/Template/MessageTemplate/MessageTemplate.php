<?php
/*
Template de message simple
 */
 class MessageTemplate
 {
 	private $Title;
 	private $Body;
 	private $User;

 	/**
 	 * Constructeur
 	 * */
 	function MessageTemplate()
 	{

 	}

 	/**
 	 * Affichage
 	 * */
 	function Show()
 	{

		//TODO : modifier les phrases par du GetCode !

		$TextControl = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>'.$this->Title.'</title></head>
			<body>
			<div style="width:100%;height:100%;background:white;padding:0 auto;">
			<table width="600" cellpadding="0" cellspacing="0" style="background:white;font-family:Verdana, sans-serif;font-size: 11px; margin:15px;">
			<tr>
				<td colspan="3"><a href="http://'.$_SERVER['HTTP_HOST'].'" target="_blank" title="WebEmyos"><img src="http://'.$_SERVER['HTTP_HOST'].'/Images/logo.png" border="0" /></a></td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
				<td width="10px"></td>
				<td width="580px" style="margin:40px 0; padding-bottom:20px;">'.$this->Body.'<br /><br />L\'équipe de WebEmyos vous remercie.</td>
				<td width="10px"></td>
			</tr>
			<tr>
				<td></td>
				<td style="border-top:1px solid #E2E6EF; padding:6px;">
				<a href="http://twitter.com/WebEmyos" target="_blank" title="WebEmyos sur Twitter"><img src="http://'.$_SERVER['HTTP_HOST'].'/Images/twitter.png" border="0" align="right" /></a><a href="https://www.facebook.com/WebEmyos" target="_blank" title="WebEmyos sur Facebook"><img src="http://'.$_SERVER['HTTP_HOST'].'/Images/facebook.png" border="0" align="right" style="margin-right:5px;" /></a>
				<strong>WebEmyos</strong> &bull; <a href="" target="_blank" title="WebEmyos">www.webemyos.com</a></td>
				<td></td>
			</tr>
			</table></div></body></html>';

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

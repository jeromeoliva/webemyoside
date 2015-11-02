<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class AdvancedText extends JHomControl implements IJHomControl
{
	function AdvancedText($name)
	{
		//Version
		$this->Version ="2.0.0.0";
 		$this->Name=$name;
	}

    //Affichage
    function Show()
    {
    	//Recuperation d'une eventuelle valeur
		if(JVar::GetPost($this->Name))
		{
			$this->Value=JVar::GetPost($this->Name);
		}

		$TextControl  ="<textarea id='elm1' name='".$this->Name."' rows='15' cols='80' style='width: 80%'>";
		$TextControl .= $this->Value;
		$TextControl .="</textarea>";

		return $TextControl;

    }

	//Initialise tiny_mce
	static function Initialise()
	{
		return "tinyMCE.init({
		// General options
		mode : 'textareas',
		theme : 'advanced',

		// Theme options
		theme_advanced_buttons1 : 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
		theme_advanced_buttons4 : 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : 'css/content.css',

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : 'lists/template_list.js',
		external_link_list_url : 'lists/link_list.js',
		external_image_list_url : 'lists/image_list.js',
		media_external_list_url : 'lists/media_list.js',

		// Replace values for the template plugin
		template_replace_values : {
			username : 'Some User',
			staffid : '991234'
		}
		});";
	}

}
?>

<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class BsEmailBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function BsEmailBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="text";

                $this->RegExp="'^([a-zA-Z0-9].+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,4})$'";
                $this->MessageErreur="Email invalide";
            
		$this->AutoCapitalize = false;
                $this->AutoCorrect = false;
                $this->AutoComplete = false;
	}
        
        /**
         * Affiche le control
         */
        function Show()
        {       
            $OnBlur ="EmailBox.Verify(this,\"".JFormat::RegEx($this->RegExp)."\",\"".$this->MessageErreur."\")";

            $TextControl = "<div class='global-input-material'>
                           <input type='text' required='' name='".$this->Name."'  id='".$this->Id."' onblur='$OnBlur' >
          
                            <span class='highlight'></span>         
                            <span class='bar'></span>
                            <label>".$this->Title."</label>
                            </div>";
            
            return $TextControl;
        }
}
?>
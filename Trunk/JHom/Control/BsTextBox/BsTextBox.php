<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class BsTextBox extends JHomControl implements IJHomControl
{
	//Constructeur
	function BsTextBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="text";

		$this->AutoCapitalize = false;
                $this->AutoCorrect = false;
                $this->AutoComplete = false;
	}
        
        /**
         * Affiche le control
         */
        function Show()
        {                   
            $TextControl = "<div class='global-input-material'>
                           <input type='text' required='' name='".$this->Name."'  id='".$this->Id."'>
          
                            <span class='highlight'></span>         
                            <span class='bar'></span>
                            <label>".$this->Title."</label>
                            </div>";
            
            return $TextControl;
        }
}
?>
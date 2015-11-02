<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class StarCheckBox extends JHomControl implements IJHomControl
{
        //Action valable ou non
        public $Enabled;

        //Constructeur
	function StarCheckBox($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
                $this->Enabled = true;
	}
        
        function Show()
        {
            $TextControl = "<span>";
            
            for($i = 1; $i <= 5; $i++)
            {
                if($i <= $this->Value)
                {
                    if(file_exists("../JHom/Control/StarCheckBox/on.png"))
                    {    
                        $img = new Image("../JHom/Control/StarCheckBox/on.png");
                    }
                    else
                    {
                        $img = new Image("JHom/Control/StarCheckBox/on.png");
                    }
                }
                else
                {
                    if(file_exists("../JHom/Control/StarCheckBox/off.png"))
                    { 
                        $img = new Image("../JHom/Control/StarCheckBox/off.png"); 
                    }
                    else
                    {
                          $img = new Image("JHom/Control/StarCheckBox/off.png"); 
                    }
                }
                
                if($this->Enabled )
                {
                    $img->OnMouseEnter = "StarCheckBox.Enter(this)";
                    $img->OnMouseLeave = "StarCheckBox.Leave(this)";
                    $img->OnClick = $this->OnClick;
                }
                
                $img->Id = $this->Id;
                $img->Name = $i;      
                $img->Alt = $i;      
                
                //Ajout de l'étoile
                $TextControl .= $img->Show();
            }
            
            $TextControl .= "</span>";
            
            return $TextControl;
        }
}
?>
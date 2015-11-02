<?php
/**
 * Outil pour deployer l'application sur Webemyos
 */
class Deployer extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "icon-share";
        $this->Title = $this->Core->GetCode("Deploy");
        $this->OnClick = "IdeTool.Deploy();";
        
        return parent::Render();
    }
}

<?php
/**
 * Outil pour rafraichir l'application
 */
class Refresh extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "icon-share";
        $this->Title = $this->Core->GetCode("Refresh");
        $this->OnClick = "IdeTool.Refresh();";
        
        return parent::Render();
    }
}

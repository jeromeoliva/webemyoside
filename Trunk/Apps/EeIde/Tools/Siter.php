<?php
/**
 * Outil pour travailler sur le site final
 */
class Siter extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "icon-desktop";
        $this->Title = $this->Core->GetCode("Site");
        $this->OnClick = "IdeTool.LoadSite();";
        
        return parent::Render();
    }
}

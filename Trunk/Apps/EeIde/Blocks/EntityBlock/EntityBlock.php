<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */
class EntityBlock extends JHomBlock implements IJhomBlock
{
	function EntityBlock($core)
	{
            $this->Core = $core;
	}
	
	/*
	* Crée le module
	*/	
	function Create()
	{
	}

	/*
	* Initialise
	*/
	function Init()
	{
	}
	
	/*
	* Affiche le module
	*/
	function Show()
        {}
        
        /**
         * Pop in d'ajout d'entite
         */
        function ShowAddEntity()
        {
             $this->SetTemplate(EeIde::$Directory . "/Blocks/EntityBlock/AddEntityBlock.tpl");
             
             //Nomp 
             $tbNameEntity = new TextBox("tbNameEntity");
             $tbNameEntity->PlaceHolder = $this->Core->GetCode("Name");
             
             //Entité paretragé entre application
             $cbShared = new CheckBox("cbShared");
             
             
             //Bouton de creation
             $btnCreate = new button(BUTTON);
             $btnCreate->CssClass = "button orange";
             $btnCreate->Value = $this->Core->GetCode("Create");
             $btnCreate->OnClick = "IdeElement.CreateEntity();";
             
            //Passage des parametres à la vue
            $this->AddParameters(array('!tbName' =>    $tbNameEntity->Show(),
                                        '!btnCreate'=> $btnCreate->Show(),
                                        '!cbShared' => $cbShared->Show()
             
                                 
                                ));
           
            return $this->Render();
        }
        
        /**
         * Affiche les donnée de l'entité
         */
        function ShowDataEntity()
        {
            //Inclusion de la class
            //Inclusion des toutes les fichier entités
            $app = Eemmys::GetApp(JVar::GetPost("Projet"), $this->Core);
            
            $EntityName = JVar::GetPost("Entity");
            
            //Template des grille
            $lstTemplate = new ListEditTemplate($this->Core, "", JVar::GetPost("Entity"), "EeIde", JVar::GetPost("Projet"));
            
            //Ajout des colonnes
                    //Relections sur les propriete de l'entity
            $reflection = new ReflectionObject(new $EntityName($this->Core));
            $Properties=$reflection->getProperties();

            $objet = new $EntityName($this->Core);

            $PropertyName = array();
            foreach($Properties as $property)
            {

                    $name = $property->getName();

                    //echo get_class($objet->$name);

                    if($name != "Version" && $name != "IdEntite" && get_class($objet->$name) != "EntityProperty")
                    {
                            if($name != "Text")
                            {
                                    $PropertyName[] = $name;
                            }
                    }
            }

            $lstTemplate->Column = $PropertyName;
            $lstTemplate->UrlPopUp = "DetailEntity.php?Entity=".$EntityName;
            $lstTemplate->ActionColumn = array("Edit");
            
            return $lstTemplate->Show();
        }
}

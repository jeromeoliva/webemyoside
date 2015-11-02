<?php

/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
 session_start();

 class JHomRunner
 {
 	//Retourne la version
 	public function JHomRunner()
 	{
 		$this->Version = "2.0.0.0";
 	}

 	//Execute une instance
 	static function RunInstance($instance)
 	{
		try
		{
 		//Instancation de la page
		$page=new $instance;
		$IsValid=true;

		//Creation d'un objet reflection afin de recuperer toutes les proprietes
		$reflection = new ReflectionObject($page);
		$Properties=$reflection->getProperties();

		//Chargement des controls
		foreach($Properties as $control)
		{
			$name=$control->getName();
			//Test des control implementant l'interface IJHomControl
		     if($page->$name instanceof IJHomControl && get_class($page->$name)!= "Button")
			  {
			  	 $page->$name->Value=JVar::GetPost($page->$name->Name);

				//Test Des valeurs saisies
				if(!$page->$name->Verify())
					$IsValid=false;
			  }
		}

		$page->IsValid=$IsValid;

		// Appelle de la fonction Init si elle a �t� impl�ment�
		if(method_exists($page,"Init"))
		call_user_func(array($page,"Init"));

		//Execution de la fonction pass�;
		//Fonction da la classe
		$Method=JVar::GetPost("UserAction");
		//Recuperation d'argument
		$Arg = JVar::GetPost("Arg");

		if($Method != "")
		{
			if(method_exists($page,$Method))
			call_user_func(array($page,$Method));
		}

		//Execution d'une fonction statique d'une classe
		else if(JVar::GetPost("Action") != "")
		{
			$control=JVar::GetPost("ControlAction");
			$propertie=JVar::GetPost("ControlProperty");

			$page->$control->$propertie=call_user_func(array(JVar::GetPost("ClassAction"),JVar::GetPost("Action")),array(JVar::GetPost("ControlAction"), JVar::GetPost("ArgumentAction"),JVar::GetPost("Sender")));
		}

        if(JVar::Get("CallType"))
        {
			if(method_exists($page,JVar::Get("Action")))
				call_user_func(array($page,JVar::Get("Action")));
		}
        else
        {
			//Insertion des controls dans la page
			$page->CreatePage();

			//Affichage de la page
			$page->Core->Page->Show();
	        }
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
 }
?>

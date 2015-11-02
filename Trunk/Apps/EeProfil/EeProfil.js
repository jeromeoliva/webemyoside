var EeProfil = function() {};

	/*
	* Chargement de l'application
	*/
	EeProfil.Load = function(parameter)
	{
		this.LoadEvent();
                
                EeProfilAction.LoadInformation();
	};

	/*
	* Chargement des �venements
	*/
	EeProfil.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeProfil.Execute, "", "EeProfil");
		Eemmys.AddEventWindowsTool("EeProfil");
	};

   /*
	* Execute une fonction
	*/
	EeProfil.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeProfil");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeProfil.Comment = function()
	{
		Eemmys.Comment("EeProfil", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeProfil.About = function()
	{
		Eemmys.About("EeProfil");
	};

	/*
	*	Affichage de l'aide
	*/
	EeProfil.Help = function()
	{
		Eemmys.OpenBrowser("EeProfil","{$BaseUrl}/Help-App-EeProfil.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeProfil.ReportBug = function()
	{
		Eemmys.ReportBug("EeProfil");
	};

	/*
	* Fermeture
	*/
	EeProfil.Quit = function()
	{
		Eemmys.CloseApp("","EeProfil");
	};
        
        // Evenement
        EeProfilAction = function(){};
        
        /**
         * Charge les informations du profil
         */
        EeProfilAction.LoadInformation = function()
        {
            var data = "Class=EeProfil&Methode=LoadInformation&App=EeProfil";
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeProfil");
        };
        
        /**
         * Charge les compétences du profil
         */
        EeProfilAction.LoadCompetence = function()
        {
            var data = "Class=EeProfil&Methode=LoadCompetence&App=EeProfil";
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeProfil");
        };
        
        /**
         * Sauvagarde les compétences de l'utilisateur
         */
        EeProfilAction.SaveCompetence = function()
        {
            //Recuperation des controles
            var dvCompetenceUser = document.getElementById("dvCompetenceUser");
            
            var controls = dvCompetenceUser.getElementsByTagName("input");
            idCompetences = Array();
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked )
                {
                    idCompetences.push(controls[i].id);
                }
            }
            
             var data = "Class=EeProfil&Methode=SaveCompetence&App=EeProfil";
                 data += "&competenceId=" + idCompetences.join(";");
                 
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeProfil");
            
        }
        
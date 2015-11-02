var EeApp = function() {};

	/*
	* Chargement de l'application
	*/
	EeApp.Load = function(parameter)
	{
		this.LoadEvent();
                
                //Chargement des app de l'utilisateur
                EeAppAction.LoadMyApp();
	};

	/*
	* Chargement des �venements
	*/
	EeApp.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeApp.Execute, "", "EeApp");
		Eemmys.AddEventWindowsTool("EeApp");
	};

   /*
	* Execute une fonction
	*/
	EeApp.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeApp");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeApp.Comment = function()
	{
		Eemmys.Comment("EeApp", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeApp.About = function()
	{
		Eemmys.About("EeApp");
	};

	/*
	*	Affichage de l'aide
	*/
	EeApp.Help = function()
	{
		Eemmys.OpenBrowser("EeApp","{$BaseUrl}/Help-App-EeApp.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeApp.ReportBug = function()
	{
		Eemmys.ReportBug("EeApp");
	};

	/*
	* Fermeture
	*/
	EeApp.Quit = function()
	{
		Eemmys.CloseApp("","EeApp");
	};
        
        /**
         * Evenement utilisateur
         * @returns {undefined}
         */
        EeAppAction = function(){};
        
        /**
         * Charge les applications de l'utilisateurs
         * @returns {undefined}
         */
        EeAppAction.LoadMyApp =function()
        {
           var data = "Class=EeApp&Methode=LoadMyApp&App=EeApp";
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeApp");
        };
        
        /**
         * Charge les applications disponibles
         * @returns {undefined}
         */
        EeAppAction.LoadApps = function()
        {
           var data = "Class=EeApp&Methode=LoadApps&App=EeApp";
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeApp");
            
        };
        
        /**
         * Ajoute une application au bureau
         * @returns {undefined}
         */
        EeAppAction.Add = function(appId, control)
        {
          var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Add&App=EeApp&appId="+ appId ;

            alert(JAjax.GetRequest("Ajax.php"));
            
            control.parentNode.removeChild(control);
        };
        
        //Supprime une application au bureau
        EeAppAction.Remove = function(appId, control)
        {
             if(confirm(Eemmys.GetCode("ConfirmDelete")))
             {
            var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Remove&App=EeApp&appId="+ appId ;

               JAjax.GetRequest("Ajax.php");
                control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
            }
        };
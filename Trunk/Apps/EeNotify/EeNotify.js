var EeNotify = function() {};

	/*
	* Chargement de l'application
	*/
	EeNotify.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des évenements
	*/
	EeNotify.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeNotify.Execute, "", "EeNotify");
		Eemmys.AddEventWindowsTool("EeNotify");
	};

   /*
	* Execute une fonction
	*/
	EeNotify.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeNotify");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeNotify.Comment = function()
	{
		Eemmys.Comment("EeNotify", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeNotify.About = function()
	{
		Eemmys.About("EeNotify");
	};

	/*
	*	Affichage de l'aide
	*/
	EeNotify.Help = function()
	{
		Eemmys.OpenBrowser("EeNotify","{$BaseUrl}/Help-App-EeNotify.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeNotify.ReportBug = function()
	{
		Eemmys.ReportBug("EeNotify");
	};

	/*
	* Fermeture
	*/
	EeNotify.Quit = function()
	{
		Eemmys.CloseApp("","EeNotify");
	};
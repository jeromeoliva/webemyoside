var EeInfo = function() {};

	/*
	* Chargement de l'application
	*/
	EeInfo.Load = function(parameter)
	{
		this.LoadEvent();

		if(typeof(parameter) != 'undefined')
		{
			var data = serialization.Decode(parameter);

			if(typeof(data["Type"]) != "undefined")
			{
//				alert('Info user');
			}
		}
	};

	/*
	* Chargement des évenements
	*/
	EeInfo.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeInfo.Execute, "", "EeInfo");
		Eemmys.AddEventWindowsTool("EeInfo");
	};

	/*
	* Lance une application
	*/
	EeInfo.StartApp = function(appName)
	{
		Eemmys.StartApp('',appName);
	};

   /*
	* Execute une fonction
	*/
	EeInfo.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeInfo");
		return false;
	};
	/*
	*	Affichage de a propos
	*/
	EeInfo.About = function()
	{
		Eemmys.About("EeInfo");
	};

	/*
	*	Affichage de l'aide
	*/
	EeInfo.Help = function()
	{
		Eemmys.OpenBrowser("EeInfo","{$BaseUrl}/Help-App-EeInfo.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeInfo.ReportBug = function()
	{
		Eemmys.ReportBug("EeInfo");
	};

	/*
	* Fermeture
	*/
	EeInfo.Quit = function()
	{
		Eemmys.CloseApp("","EeInfo");
	};
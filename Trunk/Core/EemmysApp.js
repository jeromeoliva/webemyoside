/*
*------------------- Fonction pour les applications
*/
/*
* Ouvre la div de applications
*/
Eemmys.ShowDvApp = function()
{
	Eemmys.HideDvWidget();
	Eemmys.HideWidget();
    $('#dvApp').show('200');
};
/*
* Cache les div des applications
*/
Eemmys.HideDvApp = function()
{	
	$('#dvApp').hide('200');
};

Eemmys.ShowDvWidget = function()
{
	Eemmys.HideDvApp();
	 $('#dvWidget').show('200');
};
Eemmys.HideDvWidget = function()
{
	$('#dvWidget').hide('200');
};

/*
* Ferme les div Widget et App
*/
Eemmys.CloseDvWidgetApp = function()
{
	Eemmys.HideDvWidget();
	Eemmys.HideDvApp();
};
/*
* Demarre l'application
*/
Eemmys.StartApp = function(event, appName, parameter, url)
{
	//Ferme la div des widget et le div des applications
	Eemmys.CloseDvWidgetApp();

	if(typeof(appName) != "undefined")
	{
		var app = appName;
		var automatic = true;
	}
	else
	{
		var automatic = false;
	  //IE
	  if(event.srcElement)
	  {
	    var app = event.srcElement.parentNode.id;

	    if(app == '')
	      app = event.srcElement.parentNode.parentNode.id;
	  }
	  else
	  {
	    var app = this.id;
	  }
	}

  Eemmys.CloseMenu();
  Eemmys.CloseTchat();

   //Cache les eventuel widget demar�
  Eemmys.HideWidget();

  //TODO FERMER les applications lanc�e depuis d'autre
  Eemmys.IncludeJs(app, '', url);
  Eemmys.IncludeCss(app, '', url);

  //Ajout a la liste des applications
  if(Eemmys.applications == null)
      Eemmys.applications = Array();

      var exist = false;
      var i= 0;

      for(appli in Eemmys.applications)
      {
        if(Eemmys.applications[i] == app)
      {
        exist = true;
      }
       i++;
      }

      if(!exist)
      {
        Eemmys.applications[i] = app;
      }

  //Recuperation de la div central
  if(Eemmys.AppStarted != app && !exist)
  {
    if(Eemmys.AppStarted != null)
    {
      Eemmys.MnimizeApp();
    }

    Eemmys.LoadDiv("dvCenter" , "StartApp", "App:"+app + "&params=" + parameter , url);
    Eemmys.AppStarted = app;

    //On agrandit l'applications au maximum
    Eemmys.Resize();

    //Appel de la fonction de load apres 1 seconde
    //car sinon elle est pas pris en compte
    loading = app + ".Load('"+parameter+"')";
    setTimeout(loading, 1000);
  }
  else if(automatic == true)
  {
  	//Reouverture
  	 Eemmys.RestoreApp("", app );

	loading = app + ".Load('"+parameter+"')";
    setTimeout(loading, 1000);
  }

  //Donne le focus
  var appRun = document.getElementById("appRun"+app);
  //Eemmys.Focus(appRun);
};

/*
* Lance une application
*/
Eemmys.AppRun = function (app, parameter)
{
	//alert('Verifier que l"application n"est pas lancer');

	Eemmys.IncludeJs(app);
	Eemmys.IncludeCss(app);
	//Creation d'une nouvelle div
	var dvApp = document.createElement("div");
	dvApp.id= "dv"+app;
	dvApp.className = "subApp";
	dvApp.innerHTML = "<img src='../Images/loading.gif'>";

	document.body.appendChild(dvApp);

   	Eemmys.LoadDiv("dv"+app , "StartApp", "App:"+app);

	//Eemmys.MaximiseApp('', 'appRun'+app);

   	//Appel de la fonction de load apres 1 seconde
    
    //car sinon elle est pas pris en compte
     loading = app + ".Load('"+parameter+"')";
     setTimeout(loading, 1000);
};

/**
 * Ajoute un app au bureau  utilisateur
 * @param {type} app
 * @returns {undefined}
 */
Eemmys.AddAppUser = function(app)
{
    alert(app);
};

/**
 * Supprime une application au bureau utilisateur
 * @param {type} app
 * @returns {undefined}
 */
Eemmys.RemoveAppUser = function(app)
{
    alert(app);
};

/*
* Fermeture
*/
Eemmys.AppQuit = function(app)
{
	var divApp = document.getElementById("dv"+app);
	document.body.removeChild(divApp);
};


// Resize la partie central
// Avec ou sans la partie gauche
Eemmys.Resize = function(small)
{
  var appCenter = document.getElementById("appCenter");
  var appLeft = document.getElementById("appLeft");
  
  if(appLeft.innerHTML == "" )
  {
        $(appLeft).removeClass('span2');
        $(appCenter).removeClass('span10');
        $(appCenter).addClass('span12');
   }
};

Eemmys.ResizeElement = function(element, width, height)
{
	element.style.width = width;

	if(height != '')
		element.style.height = height ;
};

/*
* Redimensionne un element
*/
Eemmys.SetSize = function (element, width, height, appName)
{
	// var appElement = document.getElementById(element);
	var appElement = Eemmys.GetElement(element,"div", appName);

	 if(width != "")
	 {
		 appElement.style.width = width;
	 }
	 if (height != "")
	 {
	 	 appElement.style.height = height;
	 }
};

/*
* Ouvre l'application au maximum
*/
Eemmys.MaximiseApp = function(e, div)
{
	  //TODO creer une foncion recursive pour trouver le bon element
	 if(e == '')
	 {
	  	element = document.getElementById(div);
	  	Eemmys.open = false;
	 }
	 else
	 {
		  if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;
	 }
	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;

  if(!Eemmys.open)
  {
    appRun.style.position = "fixed";
    appRun.style.left = "40";
    appRun.style.top = "40";

    //appRun.style.width = (window.innerWidth - 20)  + "px";
    appRun.style.height = (window.innerHeight + document.body.clientHeight  - 205) + "px";
    appRun.style.width = (document.body.clientWidth - 40)  + "px";

    //appRun.style.height = 800 + "px";

//    appRun.style.height = (  document.body.clientHeight  - 55) + "px";

    Eemmys.open = true ;

    //Div Central
    var appCenter = document.getElementById("appCenter");
    appCenter.style.width = "550px";
   // appCenter.style.height =(window.innerHeight + document.body.clientHeight  - 300) + "px";

	//appCenter.style.height =( 800  - 130) + "px";

	//On resize la partie central
    Eemmys.Resize(false);

  }
  else
  {
    appRun.style.position = "relative";
    appRun.style.width = "960px";
    appRun.style.height = "520px";
    Eemmys.open = false ;

    //Div Central
    var appCenter = document.getElementById("appCenter");
    appCenter.style.width = "550px";
    appCenter.style.height ="415px";

  	//On resize la partie central
    Eemmys.Resize(true);
  }
};
/*
* Met l'application dans la barre de menu
*/
Eemmys.MnimizeApp = function(e)
{
  //TODO creer une foncion recursive pour trouver le bon element
  if(typeof(e) != "undefined")
  {
	  if(e.srcElement)
	   	element = e.srcElement;
	  else
	  	element =  this;

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;
  }
  else
  {
  	var appRun = document.getElementById("appRun"+Eemmys.AppStarted) ;
  }
  var context = document.getElementById("context");

  var appName = appRun.getElementsByTagName("input");

  //Verification en xml que la balise nexiste pas
  context.innerHTML += "<div  id='"+appName[0].value+"' style='display:none;'>"+appRun.innerHTML+"</div>";

  //Ajout dans la barre de menu
  var tdApp = document.getElementById("tdApp");
  tdApp.innerHTML += "<img onclick='Eemmys.RestoreApp(this)'  id='"+appName[0].value+"' src='../Apps/"+appName[0].value +"/Images/logo.png'  title='" + appName[0].value +"' />    ";    
   
  Eemmys.AppStarted = null;

    //Suppression si c'est une r�ouverture
  if(document.getElementById(appRun.id) != null)
  {
  	 appRun.parentNode.removeChild(appRun);
  }
  else
  {
  	var dvCenter = document.getElementById("dvCenter");
  	dvCenter.innerHTML = '';
  }
};

/*
* Restore l'application
*/
Eemmys.RestoreApp = function (element, appName)
{
    //Passage de l'appli en cours dans la tool bar
    if(Eemmys.AppStarted != null)
    {
      Eemmys.MnimizeApp();
    }
    
	if(element == "")
	{
		var element = new Object();
		element.id = appName;
		Eemmys.AppStarted = element.id;
	}
	else
	{
	   Eemmys.AppStarted = element.id;
	}
        
  //Recuperation du context
  var context = document.getElementById("context");

  apps = context.getElementsByTagName("div");

  for(i=0 ; i<apps.length ; i++)
  {
    if(apps[i].id == element.id)
    {
        var dvCenter = document.getElementById("dvCenter");
        dvCenter.innerHTML = "<div id='appRun"+  element.id +"' class='App'> "+ apps[i].innerHTML + "</div>";
            
        context.removeChild(apps[i]);
      break;
    }
  }

  //Suppression de la barre
  var tdApp = document.getElementById("tdApp");

  appStarted = tdApp.getElementsByTagName("img");

  for(i = 0; i <appStarted.length; i++)
  {
     if(appStarted[i].id == element.id)
    {
            tdApp.removeChild(appStarted[i]);
      break;
    }
  }
 
    //Appel de la fonction de load apres 1 seconde
    //car sinon elle est pas pris en compte
    loading = element.id + ".LoadEvent()";
    setTimeout(loading, 1000);
};

/*
* Ferme l'application
*/
Eemmys.CloseApp = function(e, appName)
{
	if(typeof(appName) != "undefined")
	{
		var element = document.getElementById("appRun" + appName);
	}
	else
	{
	    if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;
	}

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;

	var dvRun = document.getElementById(appRun.id);
	var dvParent = document.getElementById(appRun.id.replace("appRun","dv"));

	 //Suppression si c'est une r�ouverture
	 if(dvRun != null)
	 {
	 	dvRun.parentNode.removeChild(dvRun);
	 }
	 else
	 {
	  	 var dvCenter = document.getElementById("dvCenter");
	  	 dvCenter.innerHTML = '';
	 }

	//Fermeture de la div parent
	if(dvParent != null)
		dvParent.parentNode.removeChild(dvParent);

	 var newApplication = Array();
	 var i=0;
	 var j=0;

	 for(appli in Eemmys.applications)
	 {
	    if(Eemmys.applications[j] != Eemmys.AppStarted)
	    {
	      newApplication[i] = Eemmys.applications[j];
	      i++;
	     }
	    j++;
	  }

  //Suppression du fichier javascript
  Eemmys.RemoveJs(Eemmys.AppStarted);
  Eemmys.AppStarted = null;
  Eemmys.applications = newApplication;

  Eemmys.CloseSearch();
  //Application dans la partie centrale
  if($("#dvCenter .App").length == 0	)
  {
  	Eemmys.LoadNew();
  }
};

/*
* Ouvre le navigateur a une url pr�cise
*/
Eemmys.OpenBrowser = function(name, url)
{
	var parameter = Array();
	parameter["name"] = name;
	parameter["url"] = url;

	Eemmys.StartApp("","EeBrowser", ''+serialization.Encode(parameter)+'');
};

/*
* Recuperer les information A propos
*/
Eemmys.About = function(name)
{
	var parameters = Array();
		parameters["AppWidget"] = name;

	Eemmys.OpenPopUp("EeInfo","About", "","", "","",serialization.Encode(parameters) );
};

/*
* Ouvre une fenetre pour rapport� un bug
*/
Eemmys.ReportBug = function(app)
{
	var parameters = Array();
		parameters["AppWidget"] = app;

	Eemmys.OpenPopUp("EeBug","ReportBug", "","", "","",serialization.Encode(parameters) ,'bug');
};

/*
* Ouvre une fenetre pour rapport� un bug
*/
Eemmys.Comment = function(app, appWidget)
{

	var parameters = Array();
		parameters["AppWidget"] = app;
		parameters["Type"] = appWidget;

	Eemmys.OpenPopUp("EeComment","AddComment", "","", "","", serialization.Encode(parameters), "Comment" );
};

/**
 * 
 * @param {type} idApp
 * @returns {undefined}Supprile une appp du bureau
 */
Eemmys.RemoveAppUser = function(appId, control)
{
    if(confirm(Eemmys.GetCode("EeApp.RemoveApp")))
    {
        var JAjax = new ajax();
            JAjax.data = "Class=EeApp&Methode=Remove&App=EeApp&appId="+ appId ;

           JAjax.GetRequest("Ajax.php");
          control.parentNode.parentNode.removeChild(control.parentNode); 
    }
};

/**
 * 
 * @param {type} idApp
 * @returns {undefined}Supprile une appp du bureau
 */
Eemmys.AddAppUser = function(appName)
{
    if(confirm(Eemmys.GetCode("EeApp.AddToDesktopApp")))
    {
           var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Add&App=EeApp&appName="+ appName ;

            alert(JAjax.GetRequest("Ajax.php"));
    }
};
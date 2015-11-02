/*
*--------------------------- Fonction Global -------------------------------------------------------
*/

// Gestion des evenements
document.onkeypress = press;
//document.onclick = bodyclick;

function press(e)
{
	Eemmys.keyPress(e);
};

function bodyclick(e)
{
	alert(e.id);
	//Eemmys.CloseSearch();
};

/*
*------------------------------ Fonction EEmmys ----------------------------------------------------
*/

//Creation de l'objet principale
var Eemmys = function(){};

/**
Chargement de l'application
*/
Eemmys.Load = function()
{
   //On cache les div
   Eemmys.HideDvApp();
   Eemmys.HideDvWidget();

   //Div de d�marrage
	var parameters = Array();
		parameters["Class"] = 'Eemmys';
		parameters["Methode"] = 'GetImageLoading';
		parameters["Argument"] = 'Array';
		parameters["Action"] = 'Array';
		parameters["SourceControl"] = 'Array';
		parameters["Name"] = 'popup';
		parameters["SourceControl"] = 'popup';
		parameters["Title"] = 'Login';
		parameters["Width"] = '600px';
		parameters["Height"] = '400px';
		parameters["Opacity"] = '50';
		parameters["BackGroundColor"] = 'White';
		parameters["ShowBack"] = '1';
		parameters["Top"] = '';
		parameters["Left"] = '';
		parameters["Type"] = 'true';

  var popup = new PopUp(serialization.Encode(parameters),serialization.Encode(parameters),'','');
  popup.Open();

  //Chargement de la page
  this.LoadTool();
  this.LoadWidget();
  this.LoadApp();
  this.LoadNew();

  //Chargement des evenements
  this.LoadEvent();

  //Chargement de �lements multilingue
  this.LoadLanguage();

  //Redimensionnement a faire

  //Demarrage des messages Flash
  EeFlashMessage.Start();

  //Fermeture de la div lorsque tout est charg�
  ClosePopUp();

  //Ouverture du message d'info si c'est la premi�re connexion
  //alert(document.location.href);
  if(document.location.href.indexOf("new") > -1)
  {
  	Eemmys.StartApp("","EeInfo");
  }
};

/*
* Gestion des �venements
*/
Eemmys.LoadEvent = function()
{
  //bouton demarrer
  this.AddEventById("btnStart","click",Eemmys.ShowMenu);
  this.AddEventById("btnInfo","click", Eemmys.LoadNew);
  this.AddEventById("btnTchat","click",Eemmys.ShowTchat);
  this.AddEventById("btnAddWidget","click",Eemmys.StartAppBase);
  this.AddEventById("btnAddApp","click",Eemmys.StartAppBase);

  this.AddEventById("btnDeconnect","click",Eemmys.Deconnect);
  this.AddEventById("btnCloseDesktop","click",Eemmys.Deconnect);

  this.AddEventById("btnProfil","click",Eemmys.StartAppBase);
  this.AddEventById("btnExplorer","click",Eemmys.StartAppBase);
  this.AddEventById("btnParameter","click",Eemmys.StartAppBase);
  this.AddEventById("btnComunity","click",Eemmys.StartAppBase);
  this.AddEventById("btnMessage","click",Eemmys.StartAppBase);

  //Evenement sur les applications
  this.AddEventById("btnApp","mouseover", Eemmys.ShowDvApp);
  //Evenement sur les widget
  this.AddEventById("btnWidget","mouseover", Eemmys.ShowDvWidget);
  this.AddEventById("dvCenter","click", Eemmys.CloseAll);

  //Evenement du menu
  this.AddEventMenu();
};

/*
* Charge un tableau des �lements traduits
*/
Eemmys.LoadLanguage = function()
{
	var LangElement = Array();

	var JAjax = new ajax();
	JAjax.data = 'Class=Eemmys&Methode=LoadLanguage';
	
	var elements = JAjax.GetRequest("Ajax.php");

	codes = serialization.Decode(elements);

	for(code in codes)
	{
		LangElement[code] = codes[code];
	}

	this.LangElement = LangElement;
};

/**
* Ajoute les �venements au menu
*/
Eemmys.AddEventMenu = function()
{
  var dvMenu = document.getElementById("dvMenu");

  var Row = dvMenu.getElementsByTagName("tr");

  for(i= 0 ; i <Row.length;i++)
  {
    this.AddEvent(Row[i],"click",Eemmys.StartApp);
  }
};

/*
* Ajoute les �venements au menu de l'application
*/
Eemmys.AddEventAppMenu = function(appFunction, widget, app )
{
  //Gestion des evnement sur le menu
  if(typeof(widget) != "undefined" && widget != "")
  	var menu = Eemmys.GetElement("widgetMenu", "div", widget, true);
  else
  	var menu = document.getElementById("appMenu"+ app);

  if(menu != null)
  {
    var item = menu.getElementsByTagName("a");
    if(item.length > 0 )
    {
      for(i= 0; i < item.length; i++)
      {
        Eemmys.AddEvent(item[i],"click",appFunction);
      }
    }
  }
};

/*
* Ajoute les evenements au menu du widget
*/
Eemmys.AddEventWidgetMenu = function (appFunction, widget)
{
	Eemmys.AddEventAppMenu(appFunction, widget, "");
};

/*
* Ajoute les evenements au toolbar
*/
Eemmys.AddEventAppTool = function(appFunction)
{
  //Gestion des evnement sur le menu
  var menu = document.getElementById("appTool");

  if(menu != null)
  {
    var item = menu.getElementsByTagName("img");
    if(item.length > 0 )
    {
      for(i= 0; i < item.length; i++)
      {
        Eemmys.AddEvent(item[i],"click",appFunction);
      }
    }
  }
};

/*
* Ajoute un evenement aux controls d'un conteneur
*/
Eemmys.AddEventControls = function(conteneur, typeControl , functionToExecute)
{
	var cont = document.getElementById(conteneur);
	var controls = cont.getElementsByTagName(typeControl);

	for(i=0; i< controls.length; i++)
	{
		Eemmys.AddEvent(controls[i], "click", functionToExecute)
	}
};

/*
* Deconnect l'utilisateur
*/
Eemmys.Deconnect = function()
{
	if(Eemmys.Confirm("deconect"))
	{
	  location.href = "disconnect.php";
   }
};

/*
* Inclu le fichier javascript
*/
Eemmys.IncludeJs = function(application, widget, url, source)
{
    var script = document.createElement('script');
    script.setAttribute('type','text/javascript');

  if(typeof(source) != 'undefined')
  {
  	alert(source);
     script.setAttribute('src', source);
  }
  if(typeof(url) != 'undefined')
  {
     script.setAttribute('src', url + "/" + application +".js");
  }
  else if(widget)
  {
    script.setAttribute('src', '../Widgets/' + application + "/" + application +".js");
  }
  else
  {
  	 script.setAttribute('src', '../Apps/' + application + "/" + application +".js");
  }
  document.body.appendChild(script);
  //TODO Verifier que le script existe
};

/*
* Inclu le fichier css
*/
 Eemmys.IncludeCss = function(application, widget, url)
{
    var script = document.createElement('link');
    script.setAttribute('type','text/css');

  if(typeof(url) != 'undefined')
  {
     script.setAttribute('href', url + "/" + application +".css");
  }
  else if(widget)
  {
    script.setAttribute('href', '../Widgets/' + application + "/" + application +".css");
  }
  else
  {
  	 script.setAttribute('href', '../Apps/' + application + "/" + application +".css");
  }
  script.setAttribute('rel', 'stylesheet');
  document.body.appendChild(script);
  //TODO Verifier que le script existe
};

/*
* Supprime le fichier javasript
*/
Eemmys.RemoveJs = function(application)
{
	var scripts = document.getElementsByTagName("script");

	for(i = 0; i < scripts.length ; i ++)
	{
		if(scripts[i].src.indexOf(application) > -1)
		{
		  document.body.removeChild(scripts[i]);
		}
	}
};

/**
* Execute une fonction d'une application
*/
Eemmys.Execute = function (element, event, appName)
{
  if(event.srcElement)
  {
    var app = event.srcElement.id;

    if(app == '')
      app = event.srcElement.id;
  }
  else
  {
    var app = element.id;
  }

  //Execution de la fonction
  eval(appName+ "."+app+"();");
};

/**
* Ajoute un evenement sur un control grace a son identifiant
*/
Eemmys.AddEventById= function(element, event, methode, app, balise)
{
 if(element == '')
 {
 	return;
 }

 if(typeof(app) == "undefined")
 {
	  var control = document.getElementById(element);
	  this.AddEvent(control, event, methode);
  }
  else
  {
		var divRun = document.getElementById("appRun" + app);

		if(typeof(balise) != "undefined")
		{
			var controls = divRun.getElementsByTagName(balise);

			for(i=0; i<controls.length; i++)
			{
				if(controls[i].id == element)
				{
					 this.AddEvent(controls[i], event, methode);
				}
			}
		}
  }
};

/**
Ajoute un evenement
*/
Eemmys.AddEvent = function(control, event, methode)
{
	if(control != null)
	{
		  if(control.addEventListener)
		  {
		    control.addEventListener(event, methode, false);
		  }
		  else
		  {
		    control.attachEvent("on"+event,methode);
		  }
  	}
};

/**
supprime un evenement
*/
Eemmys.RemoveEvent = function(control, event)
{
	if(control != null)
	{
		  if(control.addEventListener)
		  {
		    control.removeEventListener(event, '');
		  }
		  else
		  {
		    control.removeEvent("on"+event);
		  }
  	}
};
/**
* Ajoute les evenements des fenetres
*/
Eemmys.AddEventWindowsTool = function(app)
{
  //this.AddEventById("btnMaximize", "click", Eemmys.MaximiseApp, app , "img");
  this.AddEventById("btnMinimize", "click", Eemmys.MnimizeApp, app, "img");
  this.AddEventById("btnClose", "click", Eemmys.CloseApp, app, "img");

  var name =  "appRun"+app ;

  this.AddEventById(name, "click", Eemmys.HideWidget);

  this.AddEventById("appToolTip", "mousedown", Eemmys.Mousseon, app, "td");
  this.AddEventById("appToolTip", "mousemove", Eemmys.Moussemouve, app, "td");
  this.AddEventById("appToolTip", "mouseup", Eemmys.Mousseout, app, "td");
};

/*
* Deplacement de la sourie
*/
Eemmys.Mousseon = function(e)
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

   Eemmys.Capture = true;
   Eemmys.appRun = element;
   Eemmys.appRun.style.position = "fixed";

   Eemmys.Focus(element);
};

/*
* Donne le focus sur une application
*/
Eemmys.Focus = function(appRun)
{
	//On repasse les autre app en dessous
  	for(i = 0; i < Eemmys.applications.length; i ++)
	{
		var app = document.getElementById("appRun" + Eemmys.applications[i]);
		if(app != null)
			app.style.zIndex = 9970;
	}

	//Recuperation de l'application
    appRun.style.zIndex = 9980;
};

Eemmys.Mousseout = function(e)
{
	 Eemmys.Capture = false;

	 if(e.srcElement)
	   	element = e.srcElement;
  	else
  		element =  this;

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}
};

Eemmys.Moussemouve = function(e)
{
	if(e.srcElement)
	   	element = e.srcElement;
  	else
  		element =  this;

  		element.style.cursor = "move";
//e.cursor = "hand";
  if(Eemmys.Capture == true)
  {
    Eemmys.appRun.style.left = e.clientX - 500 + "px";
    Eemmys.appRun.style.top = e.clientY - 25 +  "px";
  }
};

/*
* Gestionnaire du clavier
*/
Eemmys.keyPress = function(e)
{
	var code = "";
	if(e != null)
		code = e.which;
	else
	{
		code = event.keyCode;
	}

	if(Eemmys.keyPressFunction)
	{
		Eemmys.keyPressCode = code;
		setTimeout(Eemmys.keyPressFunction,100);
	}
};

/*
* Retourne la position d'une element
*/
Eemmys.GetPosition = function(element)
{
	var left = 0;
	var top = 0;
	/*On r�cup�re l'�l�ment*/
	var e = element;
	/*Tant que l'on a un �l�ment parent*/
	while (e.offsetParent != undefined && e.offsetParent != null)
	{
		/*On ajoute la position de l'�l�ment parent*/
		left += e.offsetLeft + (e.clientLeft != null ? e.clientLeft : 0);
		top += e.offsetTop + (e.clientTop != null ? e.clientTop : 0);
		e = e.offsetParent;
	}
	return new Array(left ,top + 50);
};

/**
Chargement des outils
*/
Eemmys.LoadTool = function()
{
  this.LoadDiv('dvTool' , 'LoadTool');
};

/**
Chargement des news dans la partie central
*/
Eemmys.LoadNew = function()
{
	
	var dvLoading = document.getElementById("dvLoading");
	
	if(dvLoading == null)
	{
		var dvLoading = document.createElement("hidden");
			dvLoading.innerHTML = "loading";
			dvLoading.id = "dvLoading";
		
		var div = document.getElementById('dvCenter');
		div.appendChild(dvLoading);
	   
		if(Eemmys.AppStarted != null)
	    {
	      Eemmys.MnimizeApp();
	    }
	
		Eemmys.LoadDiv('dvCenter' , 'LoadNew', '', '' ,'A');
	}
};

/**
Chargement des donn�es dans une div
*/
Eemmys.LoadDiv = function(searchDiv, methode, parameter, url, mode)
{
   var JAjax = new ajax();
   JAjax.data = "Class=Eemmys&Methode=" + methode;
   JAjax.data += "&Parameter=" + parameter;

   if(typeof(url) != 'undefined')
   {
   		JAjax.data += "&Url=" + url;
   }
   
   var div = document.getElementById(searchDiv);
   
 	if(typeof(mode) != 'undefined')
   {
   		JAjax.mode = mode;
   		
   		JAjax.Control = div;
   		JAjax.GetRequest("Ajax.php");
   }
   else
   {
   		div.innerHTML = JAjax.GetRequest("Ajax.php");
   }
};

/*
* Recupere un element d'une application
*/
Eemmys.GetElement= function(element, type, appName, widget)
{
	if(typeof(widget) != "undefined")
		var divRun = document.getElementById("widgetRun" + appName);
	else
		var divRun = document.getElementById("appRun" + appName);

	if(typeof(type) != "undefined")
	{
		if(divRun != null)
		{
			var controls = divRun.getElementsByTagName(type);

			for(i=0; i<controls.length; i++)
			{
				if(controls[i].id == element)
				{
					 var dvControl = controls[i];
				}
			}
		}
	}

	return dvControl;
};

/**
* Charge les donn�es dans un control
*/
Eemmys.LoadControl = function (searchDiv, data, height, balise, appName, mode)
{
	//Recuperation depuis la div parente
	if(typeof(appName) != "undefined")
	{
		var dvControl = Eemmys.GetElement(searchDiv, balise, appName);
	}
	else
	{
		var dvControl = document.getElementById(searchDiv);
	}

	dvControl.innerHTML = "<img src='../Images/loading/load.gif'/>";

	var JAjax = new ajax();
		JAjax.data = data;

		if(mode == 'A')
		{
			JAjax.mode = 'A';
			JAjax.Control = dvControl;
			JAjax.GetRequest("Ajax.php");
		}
		else
		{
			dvControl.innerHTML = JAjax.GetRequest("Ajax.php");
		}

	if(typeof(height) != "undefined")
		dvControl.style.height = height;
	else
		dvControl.style.height = "250px";
};

/**
ouvre le menu
*/
Eemmys.ShowMenu = function()
{
 var dvMenu = document.getElementById("dvMenu");
 dvMenu.style.height = '250px';
 dvMenu.style.width = '200px';

 $('#dvMenu').show('200');

  //Cache les eventuel widget demar�
  Eemmys.CloseDvWidgetApp();
  Eemmys.CloseTchat();
};

Eemmys.CloseAll = function()
{
  Eemmys.CloseDvWidgetApp();
  Eemmys.CloseMenu();
};

/*
*Affiche les information des base
*/
Eemmys.ShowInfo = function()
{
	var parametres = new Array();
	parametres['Type'] = 'All';

	Eemmys.StartApp('','EeInfo', serialization.Encode(parametres));
};

Eemmys.StartAppBase = function(e)
{
	if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;

	switch(element.id)
	{
		case 'btnProfil' :
			var app = 'EeProfil';
		break;
		case 'btnExplorer' :
			var app = 'EeExplorer';
		break;
		case 'btnParameter' :
			var app = 'EeParameter';
		break;
		case 'btnComunity' :
			var app = 'EeComunity';
		break;
		case 'btnMessage' :
			var app = 'EeMessage';
		break;
		case 'btnAddWidget' :
			var app = 'EeWidget';
		break;
		case 'btnAddApp' :
			var app = 'EeApp';
		break;
	}

	Eemmys.StartApp('',app, '');
};

/**
* Affiche la fen�tre de Tchat
*/
Eemmys.ShowTchat = function()
{
 var dvTchat = document.getElementById("dvTchat");
 dvTchat.style.height = '250px';
 dvTchat.style.width = '200px';

	$('#dvTchat').show('200');
	  //Cache les eventuel widget demar�
	  Eemmys.CloseDvWidgetApp();
	  Eemmys.CloseMenu();

	  //Rafrachit le tchat
	  var data = "Class=Eemmys&Methode=GetTchat";
	  Eemmys.LoadControl("dvTchat", data, "250px","div");
};

/*
* R�cupere les message du tchat
*/
Eemmys.GetMessageTchat = function(link)
{
	 //Rafrachit le tchat
	  var data = "Class=Eemmys&Methode=GetMessageTchat";
	  	  data += "&UserId = " + link.id;

	  //Enregistrement du contact en cours
	  Eemmys.IdContactTchat = link.id;

	  Eemmys.LoadControl("dvMessageTchat", data, "250px","div");
};

/*
* Envoi un nouveau message
*/
Eemmys.SendMessageTchat = function()
{
	var lstMessageTchat = document.getElementById("lstMessageTchat");
	var tbNewMessageTchat = document.getElementById("tbNewMessageTchat");
	var message = tbNewMessageTchat.value;

	lstMessageTchat.innerHTML += "<br/> Me : " + message;
	tbNewMessageTchat.value = '';
	alert(Eemmys.IdContactTchat);

	var JAjax = new ajax();
        JAjax.data = 'App=Eemmys&Methode=SendMessageTchat';
        JAjax.data += '&IdContactTchat=' + Eemmys.IdContactTchat;
        JAjax.data += "&Message=" + message;
		JAjax.GetRequest('Ajax.php');
};

/**
Ferme le menu
*/
Eemmys.CloseMenu = function(event)
{
	$('#dvMenu').hide('200');
};

/**
Ferme le menu
*/
Eemmys.CloseTchat = function(event)
{
	$('#dvTchat').hide('200');
};

/*
* Ferme les popup de recherche
*/
Eemmys.CloseSearch = function()
{
	var divResult = document.getElementById("divResult");

	if(divResult != null)
		document.body.removeChild(divResult);
};

/*
* Ouvre une popup
*/
Eemmys.OpenPopUp = function(classe, methode, url, width, height, RefreshFunction, param, title)
{
	var parameters = Array();
		parameters["Argument"] = 'Array';
		parameters["Action"] = 'Array';
		parameters["SourceControl"] = 'Array';
		parameters["Name"] = 'popup';
		parameters["SourceControl"] = 'popup';
		parameters["Title"] = Eemmys.GetCode(title);
		parameters["Width"] = width;
		parameters["Height"] = height;
		parameters["Opacity"] = '50';
		parameters["BackGroundColor"] = 'White';
		parameters["ShowBack"] = '1';
		parameters["Top"] = '';
		parameters["Left"] = '';
		parameters["Type"] = 'true';

	var actions = Array();
		actions["OnClose"] = RefreshFunction;

  if(url != "")
  {
		parameters["Url"] = url;
		var popup = new PopUp(serialization.Encode(parameters) + param, serialization.Encode(parameters) + param, serialization.Encode(actions),'');

	  	popup.Open();
  }
  else
  {
  	parameters["Class"] = classe;
	parameters["Methode"] = methode;
	parameters["App"] = classe;

	var popup = new PopUp(serialization.Encode(parameters) + param, serialization.Encode(parameters) + param, serialization.Encode(actions),'');

  	popup.Open();
  }
  //TODO gestion des popup avec class et methode
};

/*
* Chargement des outils
*/
Eemmys.LoadApp = function()
{
  this.LoadDiv('dvApp' , 'LoadApp');
  setTimeout(Eemmys.AddEventApp, 500);
};

/*
* Ajoute les �venements au applications
*/
Eemmys.AddEventApp = function()
{
  //Ajout des evenements
  var dvApp = document.getElementById("dvApp");
  var apps = dvApp.getElementsByTagName("img");

  for(i = 0;i < apps.length ; i++)
  {
  	Eemmys.AddEventById(apps[i].id,"click", Eemmys.StartApp);
  }
};

/*
* Message de confirmation de suppressions
*/
Eemmys.ConfirmDelete = function()
{
	return Eemmys.Confirm('Delete');
};

/*
* Message de confirmation d'ajout
*/
Eemmys.ConfirmAdd = function()
{
	return Eemmys.Confirm("AddElement");
};

/*
* Message d'alerte
*/
Eemmys.Alert = function(code)
{
	if(this.LangElement[code] != 'undefined')
	{
		return alert(Eemmys.GetCode(code));
	}
	else
	{
		alert('Element de multilangue Inconnu :  ' + code);
	}
};

/*
* r�cupere un code multilibgue
*/
Eemmys.GetCode = function(code)
{
    if(typeof(code)== "undefined" )
    {
        return code;
    }
    
	if(typeof(this.LangElement[code]) != 'undefined' )
	{
		return this.LangElement[code];
	}
	else
	{
		//Creation du code multilingue si il n'existe pas
		var JAjax = new ajax();
   		    JAjax.data = 'Class=Eemmys&Methode=GetCode';
		    JAjax.data += '&Code=' + code;

			return	JAjax.GetRequest('Ajax.php');
	}
};

/*
* Demande de confirmation
*/
Eemmys.Confirm = function(code)
{
	if(this.LangElement[code] != 'undefined' )
	{
		return confirm(Eemmys.GetCode(code) + '?');
	}
	else
	{
		alert('Element multilangue inconnue : ' + code);
	}
};

/*
* R�cup�re le contenu d'une iframe
*/
Eemmys.GetFrameContent = function(Frame, idTextArea)
{
	IE  = window.ActiveXObject ? true : false;
	MOZ = window.sidebar       ? true : false;

  if(IE)
  {
  	edoc = Frame.document;
  	//document.getElementById('id_textarea'').value = edoc.body.innerHTML;
  }

  else if (MOZ)
   {
  	edoc = Frame.contentDocument;
  // document.getElementById('id_textarea').value = document.getElementById("id_iframe").contentDocument.body.innerHTML;
   }
	return edoc;
};

Eemmys.LoadAppAfter = function()
{
	var dvApp = document.getElementById('dvApp');
	var dvBlockApp = dvApp.getElementsByTagName('div');

	for(i= 0; i < dvBlockApp.length ; i++)
	{
		if(dvBlockApp[i].className == 'blockAppSelected')
		{
			idSelect = dvBlockApp[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index--;

	var newDivSelect = document.getElementById("blockApp_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockAppSelected';
	}
};

Eemmys.LoadAppBefore = function()
{
	var dvApp = document.getElementById('dvApp');
	var dvBlockApp = dvApp.getElementsByTagName('div');

	for(i= 0; i < dvBlockApp.length ; i++)
	{
		if(dvBlockApp[i].className == 'blockAppSelected')
		{
			idSelect = dvBlockApp[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index++;

	var newDivSelect = document.getElementById("blockApp_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockAppSelected';
	}
};


Eemmys.LoadWidgetAfter = function()
{
	var dvWidget = document.getElementById('dvWidget');
	var dvBlockWidget = dvWidget.getElementsByTagName('div');

	for(i= 0; i < dvBlockWidget.length ; i++)
	{
		if(dvBlockWidget[i].className == 'blockWidgetSelected')
		{
			idSelect = dvBlockWidget[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index--;

	var newDivSelect = document.getElementById("blockWidget_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockWidgetSelected';
	}
};

Eemmys.LoadWidgetBefore = function()
{
	var dvWidget = document.getElementById('dvWidget');
	var dvBlockWidget = dvWidget.getElementsByTagName('div');

	for(i= 0; i < dvBlockWidget.length ; i++)
	{
		if(dvBlockWidget[i].className == 'blockWidgetSelected')
		{
			idSelect = dvBlockWidget[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index++;

	var newDivSelect = document.getElementById("blockWidget_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockWidgetSelected';
	}
};

//Agrandit l'application au maximum
Eemmys.SetSizeApp = function()
{
	//Recuperation de la taille de l'�cran

};

/**
* PopIn de creation de compte

*/
Eemmys.CreateCompte = function()
{
	parameters =Array();
 	parameters["Class"] = 'Eemmys';
	parameters["Methode"] = 'AskCreateCompte';
	parameters["Title"] = 'Creation compte';

	//parameters["App"] = classe;

	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , '','');
	popup.Open();
};

Eemmys.ShowProjet = function(idProjet)
{
	parameters =Array();
 	parameters["Class"] = 'EeProjet';
	parameters["Methode"] = 'ShowProjet';
	parameters["Title"] = 'Detail projet';
	parameters["App"] = 'EeProjet';
	parameters["IdProjet"] = idProjet;
	parameters["App"] = 'EeProjet';
	parameters["ShowBack"] = '1';
	parameters["Width"] = '400';
	parameters["Height"] = '400';
	parameters["Top"] = '';
	parameters["Left"] = '';

	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , '','');
	popup.Open();
};

/*
* Edite un formulaire
*/
Eemmys.ShowForm = function(idForm)
{
	parameters =Array();
 	parameters["Class"] = 'EeForm';
	parameters["Methode"] = 'TryForm';
	parameters["Title"] = 'Detail projet';
	parameters["App"] = 'EeForm';
	parameters["idForm"] = idForm;
	parameters["App"] = 'EeForm';
	parameters["ShowBack"] = '1';
	parameters["CanComplete"] = 'true';
	parameters["Width"] = '400';
	parameters["Height"] = '400';
	parameters["Top"] = '';
	parameters["Left"] = '';

	action = Array();
	action['OnClose'] = "Eemmys.LoadNew()";

	Eemmys.IncludeCss('EeForm');
	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , serialization.Encode(action),'');
	popup.Open();
};

/**
* Envoi du formulaire compl�t�
*/
Eemmys.SendForm = function(idForm)
{
	var dvForm = document.getElementById('dvForm');
	var data = Array();

	//Recuperation des reponses de l'utilisateur
	var controls = document.getElementsByTagName('input');
	for(i = 0; i < controls.length; i++)
	{
		switch(controls[i].type)
		{
			case 'text' :
				data.push(controls[i].id + '-_' + controls[i].value);
			break;
			case 'radio' :
				if(controls[i].checked)
				{
					data.push(controls[i].id + '-_' + controls[i].value);
				}
			break;
			case 'checkbox' :
				if(controls[i].checked)
				{
					data.push(controls[i].id + '-_' + controls[i].value);
				}
			break;
		}
	}

	//Recuperation des liste d�roulante
	var controls = document.getElementsByTagName('select');
		for(i = 0; i < controls.length; i++)
		{
				data.push(controls[i].id + '-_' + controls[i].value);
		}

	//Recuperation des textArea
	var controls = document.getElementsByTagName('textarea');
		for(i = 0; i < controls.length; i++)
		{
				data.push(controls[i].id + '-_' + controls[i].value);
		}

	var JAjax = new ajax();
	    JAjax.data = 'App=EeForm&Methode=SendFormUser';
	    JAjax.data += '&idForm='+ idForm;
	    JAjax.data += '&data='+ data.join('-!');

	dvForm.innerHTML = JAjax.GetRequest('Ajax.php');
};

/*
* Lance le bureau
*/
Eemmys.LoadDesktop = function()
{
	window.location.href='Membre/';

};

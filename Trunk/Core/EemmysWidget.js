
/**
Chargement des widgets
*/
Eemmys.LoadWidget = function()
{
  this.LoadDiv('dvWidget' , 'LoadWidget');
  setTimeout(Eemmys.AddEventWidget, 500);
};
/*
* Ajoute les évenements au widget
*/
Eemmys.AddEventWidget = function()
{
  //Ajout des evenements
  var dvWidget = document.getElementById("dvWidget");
  var widgets = dvWidget.getElementsByTagName("img");

  for(i = 0;i < widgets.length ; i++)
  {
  	if(widgets[i].src.indexOf('after') == -1  && widgets[i].src.indexOf('before') == -1)
  	{
  		Eemmys.AddEvent(widgets[i], "click", Eemmys.StartWidget);
  	}
  }
};

/*
* Demarre un widget
*/
Eemmys.StartWidget = function(e)
{
 //Cache les eventuel widget demaré
  Eemmys.HideWidget();

  if(e.srcElement)
  {
  	img = e.srcElement;
  }
  else
  {
	img =  this;
  }

  Eemmys.WidgetStarted = img.parentNode.id;

  var widget = img.parentNode.id;

  //Si le widget a été démarré
  if(Eemmys.WidgetsStarted(widget))
  {
  	Eemmys.ShowWidget(widget);
	return;
  }

  //Creation de la div
  var widgetRun = document.createElement("div");
  widgetRun.className = "widgetRun";
  widgetRun.id = "widgetRun" + widget;

  //Gestion de la position du widget
  var position = Eemmys.GetPosition(img.parentNode);
 // widgetRun.style.position = "fixed";
 widgetRun.style.position = "absolute";
  widgetRun.style.left = position[0] + "px";
  widgetRun.style.top = position[1] + "px";


  widgetRun.style.backgrounColor = "white";

  Eemmys.IncludeJs(widget, true);
  Eemmys.IncludeCss(widget, true);

  widgetRun.innerHTML = "<img src='../Images/loading/load.gif'>";
  document.body.appendChild(widgetRun);

  Eemmys.LoadDiv("widgetRun" + widget , "StartWidget", "Widget:"+widget);
  Eemmys.AddEventWindowsTool();

   Eemmys.AddWidgetStarted(widget);

    //car sinon elle est pas pris en compte
   loading = widget + ".Load()";
   setTimeout(loading, 1000);
};

/*
* Ajout le widget a la liste des widgets
*/
Eemmys.AddWidgetStarted = function(widgetStarted)
{
	//Ajout a la liste des applications
  if(Eemmys.Widgets == null)
      Eemmys.Widgets = Array();

      var exist = false;
      var i= 0;

      for(widget in Eemmys.Widgets)
      {
        if(Eemmys.Widgets[i] == widgetStarted)
	    {
	        exist = true;
	     }
      	i++;
      }

      if(!exist)
      {
        Eemmys.Widgets[i] = widgetStarted;
      }
};

/*
* Défini si le widget est deja démarè
*/
Eemmys.WidgetsStarted = function(widgetStarted)
{
	var exist = false;
    var i= 0;

	for(widget in Eemmys.Widgets)
    {
      if(Eemmys.Widgets[i] == widgetStarted)
      {
        exist = true;
      }
      	i++;
    }

    return exist;
};

Eemmys.RemoveWidgetStarted = function(widgetStarted)
{
	var widgets = Array();
 	var i = 0;
 	var j=0;

	for(widget in Eemmys.Widgets)
    {
      if(Eemmys.Widgets[i] != widgetStarted)
      {
        widgets[j] = Eemmys.Widgets[i];
        j++;
      }
      	i++;
    }

    Eemmys.Widgets = widgets;
};

/*
* cache le widget en cours
*/
Eemmys.HideWidget = function()
{
	i=0;

	for(widget in Eemmys.Widgets)
    {
    	var widgetRun = document.getElementById("widgetRun" + Eemmys.Widgets[i]);

			if(widgetRun != null)
				widgetRun.className = "widgetHide";
      i++;
    }
    Eemmys.WidgetStartedHide = true;
};
/*
* ----------------- Fonction pour les widgets -----------------------
*/


/*
* cache le widget en cours
*/
Eemmys.ShowWidget = function()
{
	//Cache les eventuel widget demaré
  	Eemmys.HideWidget();

	//Recuperation du widget
	var widgetRun = document.getElementById("widgetRun" + Eemmys.WidgetStarted);
	//widgetRun.style.display = '';
	//widgetRun.style.width = '200px';
	//widgetRun.style.height = '200px';
	Eemmys.WidgetStartedHide = false;
	widgetRun.className = "widgetRun";
};

/*
*Ferme un widget
*/
Eemmys.CloseWidget = function(widgetName)
{
	if(typeof(widgetName) != "undefined")
		var dv = document.getElementById("widgetRun"+widgetName);
	else
		var dv = document.getElementById("widgetRun"+Eemmys.WidgetStarted);
	document.body.removeChild(dv);

	Eemmys.RemoveJs(Eemmys.WidgetStarted);
	Eemmys.RemoveWidgetStarted(Eemmys.WidgetStarted);
};

/*
* Fonctions pour les gadgets en Front Office
*/

Eemmys.TryWidget = function(widget)
{
	//Fond Grisé
	var backGround = document.createElement('div');
	backGround.style.height = document.body.parentNode.scrollHeight + "px";
	backGround.id = "back";
	document.body.appendChild(backGround);

	//Div pour le widget
	var dvWidget = document.createElement("div");
		dvWidget.className = "popup";
		dvWidget.id = "dvWidget";
		dvWidget.style.left = "25%";
		dvWidget.style.top = "25%";

	document.body.appendChild(dvWidget);

	Eemmys.LoadDiv("dvWidget" , "StartWidget", "Widget:"+widget );
 };

/**
* Ouvre ou cache la div des widgets
*/
Eemmys.ShowHideWidget = function()
{
 	var dvWidget =document.getElementById('dvWidget');
 	if(dvWidget.style.display == 'none')
 	{
 		dvWidget.style.display = '';
 	}
 	else
 	{
 		dvWidget.style.display = 'none';
 	}
};


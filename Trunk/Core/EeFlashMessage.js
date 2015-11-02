var EeFlashMessage = function(){};

/*
* Demarre les messages
*/
EeFlashMessage.Start = function()
{
	EeFlashMessage.Open = false;
	setInterval(EeFlashMessage.GetInfo, 50000);
};

/*
*	Recupere une info (contact, appli, widget comunaut� ...)
*/
EeFlashMessage.GetInfo = function()
{
	if(EeFlashMessage.Open == false)
		EeFlashMessage.LoadFlashMessage();
};

/*
* Charge un message
*/
EeFlashMessage.LoadFlashMessage = function()
{
	EeFlashMessage.Open = true;
	
	//recuperation de la div des messages si elle existe
	var dvFlashMessage = document.getElemntById("dvFlashMessage");
	
	if(dvFlashMessage != null)
	{
		//Chargement des donn�es
		var data = "Class=Eemmys&Methode=GetInfo" ;
	   		Eemmys.LoadControl("dvFlashMessage", data, "", "", undefined, "A" );
	
		//Ouverture
		var dvFlashMessage = document.getElementById("dvFlashMessage");
		dvFlashMessage.style.height = "150px";
		dvFlashMessage.style.width = "400px";
	
		setTimeout(EeFlashMessage.Close, 3000);
	}
};

/*
* Ferme le message
*/
EeFlashMessage.Close = function()
{
	var dvFlashMessage = document.getElementById("dvFlashMessage");
	dvFlashMessage.style.height = "0px";
	dvFlashMessage.style.width = "0px";

	EeFlashMessage.Open = false;
};
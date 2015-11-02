//Calcule du temps avant le lancement du jeu
var Home = function(){};
	Home.IdProjet = 0;

/*
* Charge les projets
*/
Home.LoadProject = function()
{
	$('#dvPres').hide();
	$('#dvPro').show();	
};

/*
* Edite un projet
*/
Home.EditProjet = function()
{
	Popup = new Popup();
	Popup.Open();
};

/*
* Charge le projet précedent
*/
Home.PreviousProjet = function()
{
	if(Home.IdProjet >0)
	{
		//Projet courant
		$("#Projet_"+ Home.IdProjet).hide();
		
		Home.IdProjet--;
		
		//Projet precedent
		$("#Projet_"+ Home.IdProjet).show();
	}	
};

/*
* Charge le projet suivant
*/
Home.NextProjet = function()
{
	//Projet courant
	$("#Projet_"+ Home.IdProjet).hide();
	
	Home.IdProjet++;
	
	//Projet precedent
	$("#Projet_"+ Home.IdProjet).show();

};

/*
* Calcule du temps avant le lancement du projet
*/
Home.CalculateTimeStart = function()
{
	/*var spHours = document.getElementById("spHour");
	var spMinutes = document.getElementById("spMinute");
	var spSecondes = document.getElementById("spSeconde");
	
	var hours = parseInt(spHours.innerHTML);
	var minutes = parseInt(spMinutes.innerHTML);
	var secondes = parseInt(spSecondes.innerHTML);
	
	if(secondes == "00")
	{
		minutes--;
		secondes = 59;
	}
	else
	{
		secondes --;
	}
	
	if(minutes == 0)
	{
		hours--;
		minutes= 59;	
	}
	
	
	textControl = "Le jeu démarreras dans ";
	textControl += "<span  id='day'>20</span> jours "; 
	textControl += "<span id='spHour'>"+ hours +"</span>:";
	textControl	+= "<span id='spMinute'>"+minutes+"</span>:";
	textControl += "<span id='spSeconde'>"+secondes+"</span>"; 
	
	var dvTimeStart = document.getElementById("dvTimeStart");
	dvTimeStart.innerHTML = textControl;*/
	
};

/*
* test avec le compte de demo
*/
Home.TryWithDemo = function()
{
	var JAjax = new ajax();
    	JAjax.data = 'Class=Eemmys&Methode=ConnectDemo';
		JAjax.GetRequest('Ajax.php');

		window.location.replace('Membre');
};

jQuery('#moodular').moodular({
/* core parameters */
	// effects separated by space
	effects: 'mosaic',
	// controls separated by space
	controls: 'keys',
	// if you want some yummy transition
	easing: '',
	// step 
	step: 1,
	// selector is to specify the children of your element (tagName)
	selector: 'li',
	// if timer is 0 the carrousel isn't automatic, else it's the interval in ms between each step
	timer: 10000,
	// speed is the time in ms of the transition
	speed: 2000,
	// queuing animation ?
	queue: true,
/* parameters for controls or effects */
	// keys control
	keyPrev: 37, // left key
	keyNext: 39, // right key
	// mosaic effects
	slices: [10, 4],
	mode : 'random',
	// others
	your_params : 'cause you can create your own effect or control'
});


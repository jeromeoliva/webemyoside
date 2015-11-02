var JMessage=new JMessage();

function JMessage()
{

	this.Show = function(message, close)
	{
		//alert(message);
		// Ajout d'un div Grise
		divbackGround = document.createElement('div');
		divbackGround.style.height = document.body.parentNode.scrollHeight + "px";
		divbackGround.id = "back";

		document.body.appendChild(divbackGround);

		//Creation de la div
		divMessage = document.createElement('div');
		divMessage.id = "message";
		divMessage.className = "popup";
		divMessage.style.top = 300 + document.body.scrollTop + document.documentElement.scrollTop +"px";

		divMessage.style.left = "50%";
	 	divMessage.style.top = "50%";

		//Construction du message
		var textControl = "<table style='width:100%;height:100%'>";
		textControl += "<tr><td><span class='close' title='" + close + "' onclick='JMessage.Close();'></span></td></tr>";
		textControl += "<tr><td style='text-align:center;' class='error'>" + message +"</td></tr>";
		textControl +="</table>";
		//Ajout a la div
	 	divMessage.innerHTML = textControl;

  		document.body.appendChild(divMessage);

		setTimeout("JMessage.Close()" ,2000);
  	};

	this.Ask=function(message)
	{
		confirm(message);
	};

	this.Close = function()
	{
		var	message = document.getElementById('message');
	    document.body.removeChild(message);
		var	background = document.getElementById('back');
	    document.body.removeChild(background);
	};
};
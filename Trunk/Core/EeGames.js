/*
* Javascript principal des jeux
*/
//Creation de l'objet principale
var EeGames = function(){};

/*
* Déplace un Element vers le haut
*/
EeGames.MoveUp = function(element, speed)
{
	//alert(element);
};

EeGames.MoveRight = function()
{
	var perso = new Character
};

function sleep(temps){
	this.awake.appelante= this.sleep.caller ;
	this.awake.contexte = this.sleep.caller.my ;
	this.awake.timer = setTimeout(awake, temps);
};
function awake(){
	this.awake.appelante.etape ++ ;
	this.awake.appelante(this.awake.contexte) ;
};

/*
* Classe des personnages
*/
function Character(id, img, height, width)
{
	/*
	* Attribut
	*/
	this.id = id;
	this.img = img;
	this.height = height;
	this.width = width;

	/*
	* Crée le personnage
	*/
	this.Create = function()
	{
		this.character = document.createElement('div');
		this.character.id = this.id;
		this.character.style.backgroundImage = 'url("'+this.img+'")';
		this.character.style.height = this.height;
		this.character.style.width = this.width;
		this.character.style.position = 'relative';
		this.character.style.top = '0px';
		this.character.style.left = '0px';

		EeGames.CharactereMove	= false;
	};

	/*
	* Ajoute le personnage à la map
	*/
	this.Append = function(map)
	{
		//map.innerHTML = this.character;
		map.appendChild(this.character);
	};

	/*
	* Déplace le pesronnage à droite
	*/
	this.GoRight = function(char)
	{
		var x = this.character.style.left.replace('px','');
		x++;x++;
		this.character.style.left = x + 'px';
	   	this.SetBackround(this.defineLastX('right'),-130);
	   	this.LastDirection = 'right';
	};

	/*
	* Déplace le pesronnage à gauche
	*/
	this.GoLeft = function()
	{
		var x = this.character.style.left.replace('px','');
		x--;x--;
		this.character.style.left = x + 'px';
	   	this.SetBackround(this.defineLastX('left') ,-70);

		this.LastDirection= 'left';
	};

	/*
	* Déplace le pesronnageen haut
	*/
	this.GoUp = function()
	{
		var y = this.character.style.top.replace('px','');
		y--;y--;
		this.character.style.top = y + 'px';
		this.SetBackround(this.defineLastX('right'), -190);

		this.LastDirection = 'right';
	};

		/*
	* Déplace le pesronnageen haut
	*/
	this.GoDown = function()
	{
		var y = this.character.style.top.replace('px','');
		y++;
		y++;
		this.character.style.top = y + 'px';

	 	this.SetBackround(this.defineLastX('down'), 0);
	   	this.LastDirection = 'down';
	};

	this.SetBackround = function(x, y)
	{
		this.character.style.backgroundPosition = x + "px "+ y+"px";
		this.character.positionX = x;
		this.character.positionY = y;
	};

	/*
	*
	*/
	this.defineLastX = function(direction)
	{
		if(direction == this.LastDirection)
		{
			switch(this.character.positionX)
			{
				case 0 :
					return -32;
				break;
				case -32 :
					return -64;
				break;
				case -64:
					return -96;
				break;
				case -96 :
					return 0;
				break;
			}
		}
		else
		{
			//Sens différente au remet a zéro
			return 0;
		}
	};

	/*
	* Déplace un personnage
	* Si pas de vitesse donnée déplacement en direct.. Sinon
	* Deplacement grace au fonction GoLEft, GoRight...
	*/
	this.Move = function(top, left, speed)
	{
		if(typeof(speed) == 'undefined')
		{
			this.character.style.top = top + "px";
			this.character.style.left = left +"px"   ;
		}
		else
		{
			var characterTop = this.character.style.top.replace('px','');
			var characterLeft = this.character.style.left.replace('px','');
			EeGames.CharactereMove = true;

			//Determine si il doit aller a droite ou a gauche
			if(characterLeft < left)
			{
					EeGames.CharactereToMove = this;
					EeGames.DestinationX = left;
					EeGames.interval = setInterval(function()
							{
								EeGames.CharactereToMove.GoRight();

								//Arreter l'interval un fois atteint
								if(EeGames.CharactereToMove.character.style.left.replace('px','') == EeGames.DestinationX)
								{
									clearInterval(EeGames.interval);
									EeGames.CharactereMove = false;
								}
							}
						, 100);
			}

			//Determine si il doit aller a droite ou a gauche
			if(characterLeft > left)
			{
					EeGames.CharactereToMove = this;
					EeGames.DestinationX = left;
					EeGames.interval = setInterval(function()
							{
								EeGames.CharactereToMove.GoLeft();

								//Arreter l'interval un fois atteint
								if(EeGames.CharactereToMove.character.style.left.replace('px','') == EeGames.DestinationX)
								{
									clearInterval(EeGames.interval);
									EeGames.CharactereMove = false;
								}
							}
						, 100);
			}


			//Determine si il doit aller en haut ou en bas
			if(characterTop < top)
			{
					EeGames.CharactereToMove = this;
					EeGames.DestinationY = top;

					EeGames.intervalTop = setInterval(function()
							{
								EeGames.CharactereToMove.GoDown();

								//Arreter l'interval un fois atteint
								if(EeGames.CharactereToMove.character.style.top.replace('px','') == EeGames.DestinationY)
								{
									clearInterval(EeGames.intervalTop);
									EeGames.CharactereMove = false;
								}
							}
						, 100);
			}

			if(characterTop > top)
			{
					EeGames.CharactereToMove = this;
					EeGames.DestinationY = top;

					EeGames.intervalTop = setInterval(function()
							{
								EeGames.CharactereToMove.GoUp();

								//Arreter l'interval un fois atteint
								if(EeGames.CharactereToMove.character.style.top.replace('px','') == EeGames.DestinationY)
								{
									clearInterval(EeGames.intervalTop);
									EeGames.CharactereMove = false;
								}
							}
						, 100);
			}
		}
	};
};

function Maps(id, width, height)
{
	/*
	* Attribut
	*/
	this.id = id;
	this.canvas = "<canvas id='" + this.id + "' width='" + width +"' height='" + height + "'><p>Ne supporte pas canvas<p></canvas>";

	this.SetBackground = function(img)
	{
		var conteneur = document.getElementById(this.id);
		conteneur.style.background = 'url("'+ img +'")';
	};

	/*
	* Ajoute la map au conteneur
	*/
	this.Render = function(conteneur)
	{
		conteneur.innerHTML = this.canvas;

		//l'objet Canvas devient la balise Javascript
		this.canvas = document.getElementById(this.id);
		this.context = this.canvas.getContext("2d");
	};

	/*
	* Dessine un rectangle
	*/
	this.DrawRectangle = function(style, x, y, width, height)
	{
		this.context.fillStyle = style;
		this.context.fillRect (x, y, width, height);
	};

	//dessine un forme
	this.Draw = function(forme)
	{
		var context = this.canvas.getContext("2d");
		context.fillStyle = forme.style;
		context.fillRect ( forme.x, forme.y, forme.width, forme.height);
	}

	this.Move = function(forme, x, y , time)
	{
		animation = function(){};

		animation.formeMoved = forme;
		animation.context = this.context;
		animation.destinationX = x;
		animation.destinationY = y;
		animation.interval = setInterval(this.MoveForme, time);
	};

	this.MoveForme = function()
	{
		//supprimer la forme
		animation.context.clearRect(animation.formeMoved.x,animation.formeMoved.y,animation.formeMoved.width, animation.formeMoved.height);

		//change les coordonnée
		if(animation.formeMoved.x <= animation.destinationX)
		{
			animation.formeMoved.x++;
		}

		if(animation.formeMoved.y <= animation.destinationY)
		{
			animation.formeMoved.y++;
		}

		if( animation.formeMoved.x == animation.destinationX
			&& animation.formeMoved.y == animation.destinationY
			)
		{
			clearInterval(animation.interval);
			//return;
		}

		//redessine la forme
		animation.context.fillStyle = animation.formeMoved.style;
		animation.context.fillRect( animation.formeMoved.x, animation.formeMoved.y, animation.formeMoved.width, animation.formeMoved.height);

		//	this.Draw(animation.formeMoved);
	}
};

/*
* Objet rectangle
*/
function Rectangles(style, x, y, width, height)
{
	this.style = style;
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
}
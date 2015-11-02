//Recuperation des control
var JhomControl = function(){};

JhomControl.Initialiser = function()
{
	IE  = window.ActiveXObject ? true : false;

	if(IE)
	{
		//TODO NE FAIRE QUE POUR IE
		var controls = document.getElementsByTagName('input');

		for(i=0; i< controls.length; i++)
		{
			if(controls[i].type == 'text' || controls[i].type == 'email' || controls[i].type == 'password' )
			{
				if(typeof(controls[i].placeholder) != 'undefined' && controls[i].placeholder != '')
				{
					controls[i].value =  controls[i].placeholder;
					controls[i].attachEvent("onkeydown", JhomControl.Enter);
				}
			}
		};

		var controls = document.getElementsByTagName('textarea');

		for(i=0; i< controls.length; i++)
		{
				if(typeof(controls[i].placeholder) != 'undefined' && controls[i].placeholder != '')
				{
					//TODO VERIFIER SI C'EST IE
					controls[i].value =  controls[i].placeholder;
					controls[i].attachEvent("onkeydown", JhomControl.Enter);
				}
		};
	}
};

JhomControl.Enter = function(e, control)
{
	control = e.srcElement;

	if(control.value == control.placeholder)
	{
		control.value = '';
	}
};

window.setTimeout(JhomControl.Initialiser, 500);

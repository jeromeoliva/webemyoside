var PassBlock = function(){};

PassBlock.AsskNewPassword = function()
{
	var parameters = Array();
		parameters["Class"] = 'PassBlock';
		parameters["Methode"] = 'ShowForget';
		parameters["Argument"] = 'Array';
		parameters["Action"] = 'Array';
		parameters["SourceControl"] = 'Array';
		parameters["Name"] = 'popup';
		parameters["SourceControl"] = 'popup';
		parameters["Title"] = 'NewPassword';
		parameters["Width"] = '200px';
		parameters["Height"] = '200px';
		parameters["Opacity"] = '50';
		parameters["BackGroundColor"] = 'White';
		parameters["ShowBack"] = '1';
		parameters["Top"] = '';
		parameters["Left"] = '';

	var popUp=new PopUp(serialization.Encode(parameters),serialization.Encode(parameters),'','');popUp.Open();
};


PassBlock.SaveNewPassWord = function(user)
{
	var tbNewPassWord = document.getElementById("tbNewPassWord");
	var tbConfirmPassWord = document.getElementById("tbConfirmPassWord");

	if(tbNewPassWord.value == '' || tbConfirmPassWord.value == '')
	{
		alert('Un des champs est vide!');
		return false;
	}

	if(tbNewPassWord.value != tbConfirmPassWord.value)
	{
		alert('Les champs ne sont pas identiques');
		return false;
	}

	var JAjax = new ajax();
		JAjax.data = "Class=PassBlock&Methode=NewPassWord";
		JAjax.data += "&u=" + user;
		JAjax.data += "&p="+tbNewPassWord.value;

	var result = JAjax.GetRequest("Ajax.php");

	if(result.indexOf('Ok') > -1)
	{
		alert('Enregistrement valide.Vous pouvez vous connecter');
		//Redirection sur la page d'accueil
		document.location.replace('index.php');
	}
	else
	{
		alert(result);
	}
};


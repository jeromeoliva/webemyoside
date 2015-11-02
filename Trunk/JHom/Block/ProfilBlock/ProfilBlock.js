function AddInvitation(idContact)
{
	if(Eemmys.Confirm("ConfirmSendInvitation"))
	{
		var data = "App=EeComunity&Class=ContactsBlock&Methode=AddInvitation";
			data += "&IdContact=" + idContact;

		Eemmys.LoadControl("dvProfil", data);
	}
};


function AcceptInvitation(idUserContact)
{
	var JAjax = new ajax();
		JAjax.data = "Class=ProfilBlock&Methode=AcceptInvitation";
		JAjax.data += "&IdInvitation="+idUserContact;
		var result = JAjax.GetRequest("Ajax.php");

		if(result != "")
		{
			RemoveInvitation(idUserContact, result);
		}
};

function RefuseInvitation(idUserContact)
{
	var JAjax = new ajax();
		JAjax.data = "Class=ProfilBlock&Methode=RefuseInvitation";
		JAjax.data += "&IdInvitation="+idUserContact;
		var result = JAjax.GetRequest("Ajax.php");

		if(result)
		{
			RemoveInvitation(idUserContact,result);
		}
};

function RemoveInvitation(idUserContact, result)
{
	var invitation = document.getElementById("Invitation"+idUserContact);
	invitation.parentNode.removeChild(invitation);

	 var nbInvit = document.getElementById("nbInvit");
	 nbInvit.innerHTML = result;
};

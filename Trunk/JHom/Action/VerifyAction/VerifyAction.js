function JVerify(propriete, argument)
{
	var Action = new VerifyAction(propriete, argument);
	Action.DoAction();
};

function VerifyAction(propriete, argument)
{
	//Deserialisation
	property=new Array();
	property = serialization.Decode(propriete);

	arg=new Array();
	arg = serialization.Decode(argument);

	//Propriete
	this.page = "Ajax.php";

	this.data +="&Arg="+argument;

	for(ar in arg)
	{
 		 this.data += "&"+ar+"="+arg[ar];
	}

	this.DoAction = function (propriete, argument)
	{
		var sourceControl = document.getElementById(property["SourceControl"]);

		if(sourceControl != null)
		{
			this.data +="&sourceControl="+sourceControl.value;
		}

		if(this.Send().indexOf("False") > -1)
		{
			alert(arg['ErrorMessage']);
			sourceControl.value ="";
		}
	};

	this.Send=function()
	{
	  var JAjax = new ajax();
	  JAjax.data = this.data;
	  return JAjax.GetRequest(this.page);
	};
}
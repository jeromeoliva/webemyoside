var TelBox = new TelBox();

function TelBox()
{
	this.Verify = function(control,exp,message)
	{
		var Expression = new RegExp(exp);
		if(!Expression.test(control.value))
			alert(message);
	};
};
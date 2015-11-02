var DateTimeBox = new DateTimeBox();

function DateTimeBox()
{
	this.Verify = function(control,exp,message)
	{
		var Expression = new RegExp(exp);
		if(!Expression.test(control.value))
			alert(message);
	};
};
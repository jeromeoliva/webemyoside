var DateBox = new DateBox();

function DateBox()
{
	this.Verify = function(control,exp,message)
	{
		var Expression = new RegExp(exp);
		if(control.value.length > -1  && !Expression.test(control.value))
		{
			alert(message);
		}
	};
};
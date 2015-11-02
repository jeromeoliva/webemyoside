var LogBlock=new LogBlock();

function LogBlock()
{
	this.Delete	= function()
	{

		this.data = "Action=Delete";
		this.Send();
	};

	this.Send=function()
	{
	  var ajax=new XMLHttpRequest();
	  ajax.open('POST','Ajax.php',false);
	  ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  ajax.send(this.data);

	  return ajax.responseText;
	};
};
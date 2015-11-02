var WRegistrationBlock = function(){};

WRegistrationBlock.GetLoginFacebook = function(url)
{
    
  var features = "resizable= no; status= no; scroll= no; help= no; center= yes;width=650px;height=140px;menubar=no;directories=no;location=no;modal=yes";
    window.showModalDialog(url, 'Facebbok', features);
    
    window.setInterval("WRegistrationBlock.Refresh()", 2000);
};

/**
 * Verification tout les deux secondes si l'utilisateur est connecté 
 * Dans ce cas on charge la partie membre de l'utilisateur
 * @returns {undefined}
 */
WRegistrationBlock.Refresh = function()
{
    var data = "Class=WRegistrationBlock&Methode=IsConnected";
           
    var JAjax = new ajax();
        JAjax.data = data;

    var response = JAjax.GetRequest('Ajax.php');
        

    if(response.indexOf("connected") > -1)
    {
       window.location.href = "http://webemyos.fr/Membre/";
    }
};



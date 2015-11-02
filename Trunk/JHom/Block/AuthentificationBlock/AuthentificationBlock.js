var AuthentificationBlock = function(){};

/**
 * Connect l'utilisateur
 */
AuthentificationBlock.Connect = function()
{
    //Recuperation des champs 
    var tbEmail = document.getElementById("tbAuthEmail");
    var tbPass = document.getElementById("tbAuthPass");
   
   //Icone de chargement
    var dvAuthentification = document.getElementById("dvAuthentification");
    dvAuthentification.innerHTML = "<img src='Images/loading/load.gif' /> ";
   
    //Requête Ajax
    var JAjax = new ajax();
       JAjax.data = "Class=AuthentificationBlock&Methode=Connect";
       JAjax.data += "&Email=" + tbEmail.value;
       JAjax.data += "&Pass=" + tbPass.value;
     
     //Execution
     dvAuthentification.innerHTML = JAjax.GetRequest("Ajax.php");
     
     //Rafrachit le pass block
     AuthentificationBlock.RefreshPassBlock();
};
/*
 * Créer le comtpe et connect l'utilisateur
*/
AuthentificationBlock.CreateCompte = function()
{
      //Recuperation des champs 
    var tbEmail = document.getElementById("tbCreateEmail");
    var tbPass = document.getElementById("tbCreatePass");
    var tbCreateVerifPass = document.getElementById("tbCreateVerifPass");
    
   //Icone de chargement
    var dvAuthentification = document.getElementById("dvAuthentification");
    dvAuthentification.innerHTML = "<img src='Images/loading/load.gif' /> ";
   
    //Requête Ajax
    var JAjax = new ajax();
       JAjax.data = "Class=AuthentificationBlock&Methode=CreateCompte";
       JAjax.data += "&Email=" + tbEmail.value;
       JAjax.data += "&Pass=" + tbPass.value;
       JAjax.data += "&Verif=" + tbCreateVerifPass.value;
     
     //Execution
     dvAuthentification.innerHTML = JAjax.GetRequest("Ajax.php");
     
     //Rafrachit le pass block
     AuthentificationBlock.RefreshPassBlock();
};

/**
 * Rafrachit le module de connection sur la page courante
 */
AuthentificationBlock.RefreshPassBlock = function()
{
    var dvLogin = document.getElementById("dvLogin");
      
       //Requête Ajax
    var JAjax = new ajax();
       JAjax.data = "Class=AuthentificationBlock&Methode=RefreshPassBlock";
       
     //Execution
     dvLogin.innerHTML = JAjax.GetRequest("Ajax.php");
      
};


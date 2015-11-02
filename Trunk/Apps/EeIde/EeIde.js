var EeIde = function() {};

/*
* Chargement de l'application
*/
EeIde.Load = function(parameter)
{
        this.LoadEvent();
       EeIde.LoadJsApp();
};

/**
 * Charge les js des applications
 * @returns {undefined}
 */
EeIde.LoadJsApp = function()
{
    var apps = Array("IdeElement", "IdeTool", "IdeInsert");

    for(i=0 ; i< apps.length ; i++)
    {
        var name = apps[i];
        EeIde.IncludeJs(name + ".js");
    }  
};

/*
* Chargement des �venements
*/
EeIde.LoadEvent = function()
{
        Eemmys.AddEventAppMenu(EeIde.Execute, "", "EeIde");
        Eemmys.AddEventWindowsTool("EeIde");
};

/*
* Execute une fonction
*/
EeIde.Execute = function(e)
{
        //Appel de la fonction
        Eemmys.Execute(this, e, "EeIde");
        return false;
};

/*
 * Charge la page d'accueil
 */
EeIde.LoadHome = function()
{
    var data = "Class=EeIde&Methode=LoadHome&App=EeIde";
    Eemmys.LoadControl("appCenter", data, "" , "div", "EeIde");
};

/*
* Inclu le fichier javascript
*/
EeIde.IncludeJs = function(file)
{
     //TODO verifier que les script n'a pas déjà été ajouté
    var script = document.createElement('script');
    script.setAttribute('type','text/javascript');
    script.setAttribute('src', "../Apps/EeIde/" + file);

    document.body.appendChild(script);
};

/**
 * Creation d'un nouveau projet
 **/
EeIde.NewProjet = function()
{
 var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.NewProjet';
    
    Eemmys.OpenPopUp('EeIde','ShowCreateNewProjet', '','','', 'EeIdeAction.LoadUserProjet()', serialization.Encode(param));
};

/**
 * Popin d'ajout de fonction javascript
 * @returns 
 */
EeIde.ShowInsertJs= function()
{
    var param = Array();
        param['App'] = 'EeIde';
        param['Title'] = 'InsertJs';

        Eemmys.OpenPopUp('EeIde','ShowInsertJs', '','','', '', serialization.Encode(param));
};

/**
 * Popin d'ajout de fonction php
 * @returns 
 */
EeIde.ShowInsertPhp= function()
{
    var param = Array();
        param['App'] = 'EeIde';
        param['Title'] = 'InsertPhp';

        Eemmys.OpenPopUp('EeIde','ShowInsertPhp', '','','', '', serialization.Encode(param));
};

/*
 * Gestion des dépot
 */
EeIde.AddDepot = function()
{
    var param = Array();
        param['App'] = 'EeIde';
        param['Title'] = 'AddDepot';

        Eemmys.OpenPopUp('EeIde','ShowAddDepot', '','','', '', serialization.Encode(param));
};

/*
 * Supprime une dépot
 */
EeIde.DeleteDepot = function()
{
    
    var param = Array();
        param['App'] = 'EeIde';
        param['Title'] = 'DeleteDepot';

        Eemmys.OpenPopUp('EeIde','ShowDeleteDepot', '','','', '', serialization.Encode(param));
   
};

/**
 * Commit un dépot
 * Uniquement les dépots de l'utilisateur
 * @returns {undefined}
 */
EeIde.CommitDepot = function()
{
     var param = Array();
        param['App'] = 'EeIde';
        param['Title'] = 'CommitDepot';

        Eemmys.OpenPopUp('EeIde','ShowCommitDepot', '','','', '', serialization.Encode(param));   
};

/*
*	Affichage de commentaire
*/
EeIde.Comment = function()
{
    Eemmys.Comment("EeIde", "1");
};

/*
*	Affichage de a propos
*/
EeIde.About = function()
{
    Eemmys.About("EeIde");
};

/*
*	Affichage de l'aide
*/
EeIde.Help = function()
{
        Eemmys.OpenBrowser("EeIde","{$BaseUrl}/Help-App-EeIde.html");
};

/*
*	Affichage de report de bug
*/
EeIde.ReportBug = function()
{
        Eemmys.ReportBug("EeIde");
};

/*
* Fermeture
*/
EeIde.Quit = function()
{
        Eemmys.CloseApp("","EeIde");
};


/**
 * Evenements
 */
EeIdeAction = function(){};

/**
 * Creation d'un nouveau projet
 */
EeIdeAction.NewProjet = function()
{
    EeIde.NewProjet();
};

/**
 * Rafraichit la liste des projets de l'utilisateur
 */
EeIdeAction.LoadUserProjet = function()
{
    var data = "Class=EeIde&Methode=LoadUserProjet&App=EeIde";
    Eemmys.LoadControl("lstProjet", data, "" , "div", "EeIde");
};

/**
 * Charge un projet complet
 */
EeIdeAction.LoadProjet = function(projet)
{
    //Memorisation du projet
    EeIde.Projet = projet;
    
    var data = "Class=EeIde&Methode=LoadProjet&App=EeIde&Projet="+projet;
    Eemmys.LoadControl("appCenter", data, "" , "div", "EeIde");
};

/*
 * upload un dépot
 */
EeIdeAction.UploadDepot = function()
{
    var lstDepots = document.getElementById("lstDepots");
    
    var data = "Class=EeIde&Methode=UploadDepot&App=EeIde&depot=" + lstDepots.value;
    Eemmys.LoadControl("spResultUpload", data, "" , "span");
};

/*
 * Supprime une dépot
 */
EeIdeAction.DeleteDepot=function()
{
    if(confirm('Attention cette action va supprimer les fichiers et eventuellement votre projet lié. Souhaitez-vous continuez ?  '))
    {
        var lstDepots = document.getElementById("lstDepots");

        var data = "Class=EeIde&Methode=DeleteDepot&App=EeIde&depot=" + lstDepots.value;
        Eemmys.LoadControl("spResultUpload", data, "" , "span");
    }
};

/*
 * Dépose l'application utilisateur sur le dépot
 */
EeIdeAction.CommitDepot = function()
{
    var lstDepots = document.getElementById("lstDepots");
    
    var data = "Class=EeIde&Methode=CommitDepot&App=EeIde&depot=" + lstDepots.value;
    Eemmys.LoadControl("spResultUpload", data, "" , "span");
    
};



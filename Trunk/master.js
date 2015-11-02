
   
     
   /**
    *   Js du front office
    */       
   function master(){}; 
   
   /*
    * Initialise les js de base
   */
   master.Init  = function()
   {
      Eemmys.LoadLanguage();
      $("#dvLogin").click(function(){ master.OpenLogin();});
   };
     
    /*
    * Ouvre ou ferme la popin de connection
    */      
   master.OpenLogin = function()
   {
       var  passBlock = document.getElementById("passBlock");
       
       if(passBlock.style.display == "none")
       {
          $("#passBlock").show(200);
       }
       else
       {
          $("#passBlock").hide(200);
       }
   };

//Initialisation des js
master.Init();
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plateforme de développement Webemyos</title>
    <link href="../Skin/bootstrap.min.css" rel="stylesheet">
    <link href="../Skin/global.css" rel="stylesheet">
    <link href="../Skin/desktop.css" rel="stylesheet">
    <link href="../Skin/font-awesome.min.css" rel="stylesheet">
    <meta name="Description" content="!description" />
    <meta name="Keyword" content="!keyword">
    
    <link rel="stylesheet" type="text/css" href="../JHom/Skin/FONT/css/font-awesome.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
    <script src='../JHom/Jscripts/jquery.js' ></script>
    <script src='../JHom/Jscripts/joyride/jquery-1.8.3.js' ></script>
    <script src="../Jscripts/bootstrap.min.js"></script>
    <script src="../Jscripts/script.js"></script>
    <script src="../script.php"></script>
    <script src="../Core/Eemmys.js"></script>
    <script src="../Core/EemmysApp.js"></script>
    <script src="../Core/EemmysWidget.js"></script>
    <script type='text/javascript' src='../JHom/Jscripts/ajaxfileupload.js' ></script>
    <script type='text/javascript' src='../JHom/Jscripts/ckeditor/ckeditor.js' ></script>
    <script src="../js/master.js"></script>
  
  </head>
  <body>
    <!--==================== NAV ====================-->
    <div class="top-nav">
      <div class="container">
      <span class="slogan"><a href="index.php" alt="CdsP" title="Plateforme de développement Webemyos "></a><h5>Plateforme de développement Webemyos</h5></span>
        <ul class="nav navbar-nav navbar-right">
           <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> !membre.dashboard <span class="caret"></span></a>
             <ul class="dropdown-menu" role="menu">
               <li><a href="#" id='btnStart'><i class="fa fa-tachometer"></i>!membre.myDashboard</a></li>
               <li class="divider"></li>
               <li><a href="#" id='btnProfil'><i class="fa fa-user"></i>!membre.myProfil</a></li>
               
               <li class="divider"></li>
               <li><a href="disconnect.php"><i class="fa fa-power-off"></i>!membre.myDisconnect</a></li>
             </ul>
           </li>
         </ul>
      </div>
    </div>

    <div class="navbar-wrapper">
      <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
           <ul class="nav navbar-nav navbar-right">
            <li> 
              <div class='span2'>
                    <h6>Bienvenue !pseudo</h6>
                </div>
            </li>
           <li>
                <div id='tdApp' class='span8'>
                </div>
           </li>
           </ul>
          </div>
        </div>
      </nav>
    </div>
    
    <!--=====================Partie Central ===============-->
    <section class='section-application parallax-bg'>
        <div class="container home "  >
            <div class="row-fluid"  >

                <!-- partie central du bureau  -->
                <div id='dvCenter'>
                
                </div>
                
                <!-- fin central du bureau  -->
              
                <!-- script js  -->
                
                !script
            
                !joyride
                
                <!-- fin des script  -->
                
            <div id='context'>
            </div>
            
            </span>
            </div>
        </div>
    </section>
    
    
    <!------------ Notifications ------------->
    
    <div id="dvNotify" >
        <h3>Notifications</h3>
        <span id='notifyContent'>
            
        </span>
    </div>
    
   
    
    <!--===================================================-->
    
    
    
    <!--==================== FOOTER ====================-->

    <footer>
      <div class="container">
        <div class="row">
        </div>
        <hr class="footer-divider">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p><a href="#" alt="Copyright">© 2015 WebEmyos</a></p>
      </div> <!-- ./container -->
    </footer>

    <!--==================== SCRIPTS ====================-->

  
  </body>
</html>
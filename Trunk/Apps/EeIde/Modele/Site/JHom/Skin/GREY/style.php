<?php
/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */
header('Content-Type: text/css;charset=UTF-8');
session_start();
?>
/*    Principale          */

html{}
body{ width:1200px;text-align: center;margin: auto;background:<?php include("../../../Core/Eemmys.php");$img = Eemmys::GetBackground();
	if($img != ''){echo "url('".URLSITEMEMBRE."/images.php?file=../Membre/".$img."')";}
	else{echo 'url("Images/background/fond10.jpg")';}?>;}
body{font-family : FontAwesome, arial;font-size :0.8em; }

/* Menu de gauche */
#menuLeft {width:150px; position : fixed; top : 0px; left : 0px; height: 800px; background-color: #393939;color: #C0C0C0}
#menuLeft ul{text-align:left}
#menuLeft ul li{border-top: 1px #ABABAB}
#menuLeft ul{text-align:left}
#menuLeft ul li{border-bottom: 1px solid #151515;box-shadow: 0 1px rgba(255, 255, 255, 0.1);cursor: pointer;font-size: 11px;font-weight: bold;padding: 11px 0 10px 18px;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);}
#menuLeft ul li:hover{transition: all 0.2s ease 0s;background-color:#555555;}

/* Barre d'outil */
#top{width:1200px; height:40px;position : fixed; top : 0px; left : 150px; background-color: #1673FF;color: white; text-align: left; padding:5px;}

#tdApp img {width:25px;border-left:1px solid white; padding:5px;cursor:pointer}


#toolBar{border:1px solid #1EACFF;height:50px; background:white;text-align:left;vertical-align:middle;  margin:2px;padding:2px;margin-bottom :10px }
#toolBar ul li{display:inline;}
#toolBar ul li img{width:50px}
#toolBar b{font-size:2em;margin:5px;cursor:pointer}

/*  Menu des applications */
.menuApp{background-color :#24D6FF; margin:0px}
.headItem a{color: #6B6854;	z-index: 9999;margin:10px}
.sub{overflow : hidden;visibility : hidden;z-index:9999;border: 1px solid grey;background-color: white;box-shadow:0 0 3px grey;width : 150px;position : absolute;top:65px}
.subitem{text-align:left;}
.subitem img{border-right : 1px solid grey;width : 20px;padding : 5px;marging :0px;background: url("Images/toolbar.png");border-radius: 0 0 8px 0;}
.subitem span{margin:5px;}

/* Mise en page*/
#login {text-align : left; color:white;height:20px}
.dateBox{font-size : 12px;}
.borderRight{border-right: 1px solid #1EACFF;}
.alignLeft {text-align:left}

/*------------------------------------------------------------------------ 
                                 Webemyos
/------------------------------------------------------------------------*/
/*  Différents bleu */
.blueOne{color:#1673FF}
.blueTwo{color:#1EACFF}
.blueTree{color:#24D6FF}

.btnblueOne{background-color: #1673FF ; color  : white; cursor : pointer}
.btnblueTwo{background-color: #1EACFF ; color  : white; cursor : pointer}
.btnblueTree{background-color: #24D6FF ; color  : white; cursor : pointer}

.btnblueOne, .btnblueTwo,  .btnblueTree {width:200px; height:100px;}
.btnblueOne:hover, .btnblueTwo:hover,.btnblueTree:hover   {background-color: #0000FF ;}

.separation {width:100%; height:1px;border-top : 1px solid grey;}

.titleBlue {margin:0px;background-color: #1EACFF ;color:white;border-radius: 5px 5px 0 0}

/** fond des popin */
#back{position:absolute;width:100%;background:white;left:0;top:0;height:100%;opacity:0.7;z-index:9980;filter:alpha(opacity='70');}

/** Pop in */
.popup{background:white;position:absolute;z-index:10037;border:1px solid grey;text-align:center;padding : 5px; opacity:1; filter:alpha(opacity='100')}
.popup div{float:left;clear:both;width:100%;margin-bottom:10px;text-align:left;}
.popup div .title{font-weight:bold;font-size:1.4em;color:#ebebeb;}
.popup div .close{float:right;width:25px;height:25px;background: url('images/controls.png') no-repeat -50px top;position:relative;z-index:9995;}
.popup div .close:hover{cursor:pointer;background-position:-50px -25px;}


#dvCenter , .RestoreApp{position : fixed; top : 52px; left : 150px;padding-left:0px; overflow:scroll}
#dvCenter , .RestoreApp{background:white; border:1px solid #1EACFF; border-radius :8px;}
#dvCenter div , .RestoreApp div{margin:0px; padding:5px}

/*  Barre d'outil */
#appToolBar{ background-color: #1EACFF ; color  : white; width:98%}
#appToolTip{ margin : 0px}
#appToolBar i {cursor:pointer}
.menuApp {width:98%}

/* resultat des autocomplete */
#divResult {padding:5px; background: none repeat scroll 0 0 white;border: 1px solid grey;border-radius: 6px 6px 6px 6px;height: 200px;overflow: auto;position: absolute;z-index: 10040;}
#divResult ul {text-align:left}

/* message d'rreur ou de validation*/
.success {width:100%; background :green; color : white; font-style : italic}
.error {width:100%; background :red; color : white;font-style : italic}

/* **/
.EemysProfil {padding:5px; background: #666666; height: 60px; color :white}
.EemysProfil img {margin :5px}

.VTabStripEnabled, .VTabStripDisabled, .TabStripEnabled, .TabStripDisabled, .button{
	text-decoration:none;
	color:white;
	display:inline-block;
	position: relative;
	top:0;
	left:0;
	line-height:100%;
	background:#1EACFF;
	-webkit-box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);
	-moz-box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);
	box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);
	border:1px solid #e5e5e5;
	border-bottom:0;
	font-size:0.9em;
	zoom:1;
	width:95%;
	padding : 10px;
        border-radius : 6px;
}

.TabStripEnabled, .TabStripDisabled
{
	display:inline;
}

.VTabStripEnabled, .TabStripEnabled
{
	background:#24D6FF;
}

*
ul.tabs li a:hover, .VTabStripDisabled:hover, .TabStripDisabled:hover, .button:hover{
	background:#1673FF;cursor:pointer;
}

ul.tabs li.active a, .VTabStripEnabled .active, .TabStripEnabled .active{
	position:relative;
	padding:13px 18px 10px 18px;
	top:1px;
	left:0;
	background:#fff;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	color:#222;
}

/* Responsive */
/* Téléphones */
@media all and (max-width: 479px) 
{
}

/* Tableau de bord */
#dashBoard div{margin:5px}

/* Widget du tableau de bord*/
.widget {width:200px; height:200px; display:inline-block; border-radius:5px;border:1px solid grey;overflow:auto; -webkit-box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);
	-moz-box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);
	box-shadow: inset 0px -3px 3px rgba(0,0,0,0.03);}
.widget .title{color:white; background-color : #1673FF}

.widget .launcher{cursor:pointer; float:right}
.widget h4 {color : #1EACFF}

/* Tablette */
@media all and (min-width: 320px) and (max-width: 600px) 
{
	#dvCenter{width: 995px;height: 650px;}
       #dvMenuLeft{height:568px}
}

/* Tablette Paysage */
@media all and (min-width: 600px) and (max-width: 768px)
{
    #dvCenter{width: 995px;height: 800px; }
    #fsCenter{width:1000px;height: 700px}
    #dvMenuLeft{height:800px}
}

/* Bureau 1024 * 780*/
@media all and (min-width: 768px) and (max-width: 1278px) 
{
  #dvCenter{width: 995px;height: 1000px;};
  #fsCenter{width:1000px;height: 800px}
  #dvMenuLeft{height:1000px}
}


/* Bureau 1280*/
@media all and (min-width: 1278px)   and (max-width: 1646px)   
{
  #dvCenter{width: 1200px;height: 800px;};
  #appLeft{width : 400px;height: 600px}
  #fsCenter{width:1000px;height: 600px}
  #dvMenuLeft{height:800px}
}

/* Bureau 1280*/
@media all and (min-width: 1648px) and (max-width: 1800px)  
{
  #dvCenter{width: 1600px;height: 800px; border 1px solid black;};
  #appLeft{width : 400px;height: 600px}
  #fsCenter{width:1000px;height: 600px}
  #dvMenuLeft{height:800px}
}

/* Bureau 1280*/
@media all and (min-width: 1900px) 
{
  #dvCenter{width: 1900px;height: 1070px; };
  #appLeft{width : 400px;height: 800px}
  #fsCenter{width:1000px;height: 800px}
}

/* icon */ 
.icon-remove, icon-check, icon-edit, icon-arrow-left, icon-arrow-right {cursor:pointer}

/* boutton */
.btnGreen{border-left:  1px solid grey; background-color: #24D6FF}
#appCenter .grey{background-color: #bebebe}
#appCenter .grey:hover{aeaeae}
.green{background-color: #75cc5b}
.green:hover{background-color: #70ca50}


#appCenter .green{background-color: #75cc5b}
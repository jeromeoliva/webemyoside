<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class ProfilLightBlock extends JHomBlock implements IJhomBlock
{
  //Membre du profils
  protected $UserId;

  //Constructeur
  function ProfilLightBlock($core="", $userId ="")
  {
    $this->Core = $core;
    $this->Table = false;
    $this->Frame = false;
    $this->UserId = $userId;
  }

  //Initialisation
  function Init()
  {
  	$user = $this->Core->User;
    $me = true;

    if($user != null)
    {
	// Affichage de la photo du profil + correction file_exists par Benoit
   	$urlImage = str_replace('../', '', $user->GetImageMini());
    $imgUser = new Image($urlImage);

	//TODO lorsque l'on aura les miniature
	// Miniature de profil en 100x100px
	$imgUser->AddStyle("width","50px");
	$TextControl = "<span class='photo'>".$imgUser->Show()."</span>";

    //url
    $Jurl = new JUrl($this->Core->User->Groupe->Value->Section->Value->Directory->Value."index.php");
    $Jurl->AddParametre("page","userProfil");
    $Jurl->AddParametre("profil",$user->IdEntite);


	//Bouton de deconnection
	$linkDeconnect = new Link($this->Core->GetCode('Deconnect'), 'disconnect.php');
	$linkDeconnect->Alt = $linkDeconnect->Title = $this->Core->GetCode("Deconnect");
	$linkDeconnect->Value = $this->Core->GetCode('Deconnect');
	$linkDeconnect->CssClass = 'btn btn-success';
	//$TextControl .= "<span class='action'>".$linkDeconnect->Show() ;

	//Acces direct
	$lkAcces = new Link($this->Core->GetCode('AccesDestkop'), 'Membre/');
	$lkAcces->CssClass = 'btn btn-success';
	$lkAcces->Alt = $lkAcces->Title = $this->Core->GetCode("AccesDestkop");
	$TextControl .= $lkAcces->Show()."</span>";


	//lien
	$lkProfil = new link($user->GetPseudo(), "#");
	$lkProfil->Alt = $lkProfil->Title = $this->Core->GetCode("ViewProfil");
	//$TextControl .= "<span class='name'>".$lkProfil->Show()."</span>";

  	$this->Add(new Libelle($TextControl));
    }
  }

  //Insertion des controls
  function Create()
  {

  }

  //Affichage
  function Show()
  {
    $this->LoadControl();
    $this->CallMethod();
    $this->Init();
    $this->Create();
    return parent::Show();
  }

  //Asseceur
  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name,$value)
  {
      $this->$name=$value;
  }



}



?>

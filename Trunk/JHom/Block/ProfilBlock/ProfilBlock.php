<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

class ProfilBlock extends JHomBlock implements IJhomBlock
{
  //Membre du profils
  protected $UserId;
  protected $Invitation;
  protected $Type;
  protected $NumberPerfectMatch;
  protected $NumberContact;
  protected $AddAsFriend;
  protected $Friend;
  protected $DeleteAction;
  protected $Select = false;
  
  /**
   * Variable pour les appel depuis les autre Apps
   * @var type 
   */
  public $App; 
  public $Entite;
  public $IdEntity;
  
  
  //Constructeur
  function ProfilBlock($core="", $userId ="" , $invitation = false , $type = CONTACTS,$addInvitation = false)
  {
    $this->Core = $core;
    $this->Table = false;
    $this->Frame = false;
    $this->UserId = $userId;
    $this->Invitation = $invitation;
    //$this->Type = $type;
    $this->AddAsFriend = false;
    $this->Friend = false;
    $this->AddInvitation = $addInvitation;
    $this->Id = "dvProfil";
  }

  //Initialisation
  function Init()
  {
  	//Recuperation du profil
    if($this->UserId == $this->Core->User->IdEntite || $this->UserId  =="")
    {
      $user = $this->Core->User;
      $me = true;
    }
    else
    {
      $user = new User($this->Core);
      $user->GetById($this->UserId);
      $me = false;
    }

    // Affichage de la photo du profil + correction file_exists
    if($user->Image->Value == "" || !file_exists($user->Image->Value))
    {
      $imgUser = new Image("../Images/icones/nophoto.png");
    }
    else
    {
      $imgUser = new Image($user->GetImageMini());

	  //TODO recuperer la miniature du profil
	  $imgUser->AddStyle("Width","50px");

      //Popup de visioneuse d'image
	  $popup = new Popup("NewsBlock","ShowDetail");
	  $popup->Width = "600";
	  $popup->Height = "400";
      $popup->AddArgument("UrlImage","../ImagesUser/User/".$user->Image->Value);

	  $imgUser->OnClick = $popup;
    }

	$TextControl = '';

	//Si on peut selectionner les membres
	if($this->Select)
	{
		$cbSelect = new CheckBox('cb_'.$this->UserId);
		$TextControl .= $cbSelect->Show();
	}

	//TODO lorsque l'on aura les miniature
	// Miniature de profil en 100x100px
	//$imgUser->AddStyle("width","100px");
	$TextControl .= "<span class='photo'>".$imgUser->Show()."</span>";

    //url
    $popup = new Popup("ConfidentialityBlock","ShowProfil");
    $popup->Title = $this->Core->GetCode("ProfilOf") . ' '. $user->GetPseudo();
	$popup->AddArgument("App","EeProfil");
	$popup->AddArgument("ProfilId", $user->IdEntite);
	$popup->AddArgument("ProfilTypeId", UserProfilType::GetType($this->Core,"PRIVE"));

	//lien
	$lkProfil = new link($user->GetPseudo(), "#");
	$lkProfil->Alt = $lkProfil->Title = $this->Core->GetCode("ViewProfil");
	$lkProfil->OnClick = $popup;
	$TextControl .= "<span class='name'>".$lkProfil->Show()."</span>";

	if(!$this->Invitation && !$this->AddInvitation/*&& ($this->Friend || $this->AddAsFriend)*/)
	{
			//supression du contact
		    $popup = new PopUp("ProfilBlock" , "ConfirmDelete");
		    $popup->Width = "300";
                    $popup->Height = "120";
                    $popup->Title = $this->Core->GetCode("RemoveContactTitle");
                    $popup->AddArgument("UserId" , $this->Core->User->IdEntite);
                    $popup->AddArgument("ContactId" , $this->UserId);

			 //Rafraichissement
		    $Action = new PageAction("index.php?page=contacts","contacts","Refresh");
		    $popup->AddAction("OnClose",$Action->DoAction());
			//popup
			$imgDelete = new Libelle("<b onclick='".$this->DeleteAction."' class='icon-remove' title='Delete'></b>");
			//$imgDelete->Id = $this->UserId;
			//$link->CssClass = 'delete';
			//$imgDelete->Alt = $imgDelete->Title = $this->Core->GetCode("DeleteContact");
			//$imgDelete->OnClick = $this->DeleteAction;

			if($this->DeleteAction != '')
			{
				$TextControl .=$imgDelete->Show();
			}
		}
	else if($this->AddInvitation)
	{
		//Bouton d'ajout
		$btnAddInvitation = new Button(BUTTON);
		$btnAddInvitation->Value = $this->Core->GetCode("AddInvitation");
		$btnAddInvitation->AddStyle("width","150px");
		$btnAddInvitation->OnClick = "AddInvitation($this->UserId);";
		$TextControl .= "<br/>".$btnAddInvitation->Show();
	}

	//Perfect match
    if(!$me)
    {
		//Sexe
		if($this->Invitation || (!$this->Friend && !$this->AddAsFriend))
    	{

			if($user->Sexe->Value == 0)
			{
				$TextControl .="<br /><span class='Female' title='".$this->Core->GetCode("Female")."'></span>";
			}
			else
			{
				$TextControl .="<br /><span class='Male' title='".$this->Core->GetCode("Male")."'></span>";
			}

			//Date de naissance
			$TextControl .="<span class='birthdate'>".$user->BirthDate->Value."</span>"; // Modifié par Benoit

		}


		//$lbPerfectMatch = 	new Libelle(UserContact::GetPerfectMatch($this->Core->User->IdEntite, $this->UserId));

		if(isset($_GET['page']) && $_GET['page']=='userProfil') $text = '<span class="txt">'.$this->Core->GetCode("Compatibility").'<br /></span>';
		else $text = '';

    	//Définir comme ami
    /*	if(!$this->Invitation && !$this->Friend && $this->AddAsFriend)
    	{
    		//Confirmation d'ajout comme ami
			$popup = new popup("ProfilBlock" , "AddFriend");
			$popup->Width = "300";
			$popup->Height = "120";
			$popup->Title = $this->Core->GetCode("AddFriendConfirmationTitle");
			$popup->AddArgument("UserContactId" , $this->UserId);

	    	//Rafraichissement
	   		$Action = new PageAction("index.php?page=contacts","contacts","Refresh");
	  	   	$popup->AddAction("OnClose",$Action->DoAction());

			$link = new Link("","#");
			$link->CssClass = 'noFriend';
			$link->Alt = $link->Title = $this->Core->GetCode("DefineAsFriend");
			$link->OnClick = $popup;

			$TextControl .= $link->Show();

    	}
    	elseif($this->Friend)
    	{
    		//Si le contact est déjà défini comme ami, on doit pouvoir lui enlever le statut ami
			$popup = new popup("ProfilBlock" , "RemoveStatusFriend");
			$popup->Width = "300";
			$popup->Height = "120";
			$popup->Title = $this->Core->GetCode("RemoveFriendConfirmationTitle");
			$popup->AddArgument("UserContactId" , $this->UserId);

			//Rafraichissement
			$Action = new PageAction("index.php?page=contacts","contacts","Refresh");
	  	   	$popup->AddAction("OnClose",$Action->DoAction());


	    	$link = new Link("","#");
			$link->CssClass = 'yesFriend';
			$link->Alt = $link->Title = $this->Core->GetCode("RemoveAsFriend");
			$link->OnClick = $popup;
	    	$TextControl .= $link->Show();
		}
*/
		if(!$this->Invitation && !$this->AddInvitation)
		{
			//Popup d'envoi de message
			$popup = new PopUp("InvitationBlock","ShowSendMessage");
			$popup->Title = $this->Core->GetCode("WriteMessage");
			$popup->Width = "400";
			$popup->Height = "300";
			$popup->AddArgument("FromId", $this->Core->User->IdEntite);
			$popup->AddArgument("ToId", $this->UserId);

                        //Appel depuis une application
                        if($this->App != "")
                        {
                            $popup->AddArgument("App", $this->App);
                            $popup->AddArgument("Entite", $this->Entite);
                            $popup->AddArgument("EntityId", $this->IdEntity);
                        }
                        
			//Envoi d'un message
			$btnWriteMessage = new Button(BUTTON);
			$btnWriteMessage->Value = $this->Core->GetCode("WriteMessage");
			//$btnWriteMessage->CssClass = "button_write";
			//$btnWriteMessage->AddStyle("width","110px");
			$btnWriteMessage->OnClick = $popup;

			$TextControl .= $btnWriteMessage->Show();
		}
    }
    else
    {
		$lkEditProfil = new Link('<span>'.$this->Core->GetCode("ConfigYourProfil").'</span>',"index.php?page=profil");
		$lkEditProfil->CssClass = "config";
		$lkEditProfil->Alt = $lkEditProfil->Title = $this->Core->GetCode("ConfigYourProfil");
		$TextControl .= $lkEditProfil->Show();

		$TextControl .= "<span class='city'>".$user->City->Value->Name->Value." </span>";
		$TextControl .= "<span class='counters'> PM : ".$this->NumberPerfectMatch."<br />";
		$TextControl .= $this->NumberContact." ". $this->Core->GetCode("Contact")."</span>";
    }


    //Si c'est une invitation on peut ajouté a ces contacts
    if($this->Invitation)
    {
    	$linkAdd = new Link($this->Core->GetCode("AddToMyContact"),"#");
		$linkAdd->Alt = $linkAdd->Title = $this->Core->GetCode("AddToMyContact");
		$linkAdd->CssClass = 'button';
		$linkAdd->AddStyle("width","165px");
		$linkAdd->OnClick = "AcceptInvitation('".$this->UserId."_".$this->Core->User->IdEntite."')";
		$TextControl .= $linkAdd->Show();

		//Refuser une invitation
		$linkRefuse  = new Link($this->Core->GetCode("RefuseInvitation"),"#");
		$linkRefuse->CssClass = 'button orange';
		$linkRefuse->AddStyle("width","165px");
		$linkRefuse->Alt = $linkRefuse->Title = $this->Core->GetCode("RefuseInvitation");
		$linkRefuse->OnClick = "RefuseInvitation('".$this->UserId."_".$this->Core->User->IdEntite."')";
		$TextControl .= "<br/><br/>".$linkRefuse->Show();
	}

	$this->Add(new Libelle($TextControl));
  }

//Enregistrement du contact
  function ConfirmDelete()
  {
  	$block = new JBlock ();
	$block->CssClass = 'actioner';
	$block->Table = false;
	$block->Frame = false;
  	$block->AddNew(new Libelle($this->Core->GetCode("ConfirmDelete"),"lbInfo"));

	$btnCancel = new Button(BUTTON);
	$btnCancel->CssClass = "button violet";
	$btnCancel->Value = $this->Core->GetCode("Cancel");
	// Ajouter la bonne action sur le bouton CANCEL (même que la croix = close popup)
	//$btnCancel->OnClick = "document.body.removeChild(this.parentNode);";
	$block->Add($btnCancel);

	//Action
	$Action = new AjaxAction("ProfilBlock" , "DeleteContact");
	$Action->ChangedControl = "lbInfo";
	$Action->AddArgument("UserId" , JVar::GetPost("UserId"));
	$Action->AddArgument("ContactId" , JVar::GetPost("ContactId"));

	// Bouton d'enregistrement
  	$btnSave = new Button(BUTTON);
	$btnSave->CssClass = "btn btn-success";
  	$btnSave->Value = $this->Core->GetCode("Save");
	$btnSave->OnClick = $Action;

	$block->AddNew($btnSave , "2" ,ALIGNRIGHT);
  	echo $block->Show();
  }


 //Enregistrement d'une invitation
  function DeleteContact()
  {
  	//Recuperation du contact
 	$userContact = new UserContact($this->Core);
 	$user =	$userContact->GetUserContact(JVar::GetPost("UserId"),JVar::GetPost("ContactId"));

	$user->Delete();

	echo $this->Core->GetCode("SaveOk");
  }

  //Enregistrement d'une invitation
  function SaveInvitation()
  {
  	//Recuperation du contact
 	$userContact = new UserContact($this->Core);
  	$userContact->AddArgument(new Argument("UserContact","ContactId",EQUAL,$this->Core->User->IdEntite));
	$userContact->AddArgument(new Argument("UserContact","UserId",EQUAL, JVar::GetPost("InvitationContactId")));

	$users = $userContact->GetByArg();

	$user = $users[0];

	$user->Invitation->Value = 0;
	$user->Save();

	echo $this->Core->GetCode("SaveOk");
  }

  /**
   * Ajout d'une invitation
   * */
  function AcceptInvitation()
  {
  	//Recuperation de l'invitation
 	$userContact = new UserContact($this->Core);

	//Recuperation de id
	$id = explode("_",JVar::GetPost("IdInvitation"));

	$userContact->AddArgument(new Argument("UserContact","UserId",EQUAL,$id[0]));
	$userContact->AddArgument(new Argument("UserContact","ContactId",EQUAL, $id[1]));

	$invitation = $userContact->GetByArg();

	//Acceptation de l'invitation
	$invitation[0]->Invitation->Value = "0";
	$invitation[0]->Save();

	echo UserContact::GetNumberInvitation($this->Core);
  }


  /**
   * Refuse l'invitation
   */
  function RefuseInvitation()
  {
	  	//Recuperation de l'invitation
	 	$userContact = new UserContact($this->Core);

		//Recuperation de id
		$id = explode("_",JVar::GetPost("IdInvitation"));

		$userContact->AddArgument(new Argument("UserContact","UserId",EQUAL,$id[0]));
		$userContact->AddArgument(new Argument("UserContact","ContactId",EQUAL, $id[1]));

		$invitation = $userContact->GetByArg();

		//Acceptation de l'invitation
		$invitation[0]->Invitation->Value = "0";
		$invitation[0]->Blocked->Value = "1";
		$invitation[0]->Save();

		echo UserContact::GetNumberInvitation($this->Core);
}

  //Ajout d'un contact comme ami
  function SaveFriend()
  {
	//Recuperation du contact
	$userContact = new UserContact($this->Core);

	$userContact = $userContact->GetUserContact($this->Core->User->IdEntite, JVar::GetPost("UserContactId"));
  	$userContact->Friend->Value = 1;
  	$userContact->Save();

  	echo $this->Core->GetCode("SaveOk");
	// Commentaire de Benoit : La popin doit se fermer automatiquement au bout de 2 sec
  }

  // Suppression du status ami d'un contact
  function RemoveFriend()
  {
	//Recuperation du contact
	$userContact = new UserContact($this->Core);

	$userContact = $userContact->GetUserContact($this->Core->User->IdEntite, JVar::GetPost("UserContactId"));
  	$userContact->Friend->Value = 0;
  	$userContact->Save();

  	echo $this->Core->GetCode("SaveOk");
	// Commentaire de Benoit : La popin doit se fermer automatiquement au bout de 2 sec
  }

  // Ajout comme ami
  function AddFriend()
  {
 	$block = new JBlock ();
	$block->CssClass = 'actioner';
	$block->Table = false;
	$block->Frame = false;
  	$block->AddNew(new Libelle($this->Core->GetCode("ConfirmAddAsFriend"),"lbInfo"));

	$btnCancel = new Button(BUTTON);
	$btnCancel->CssClass = "button violet";
	$btnCancel->Value = $this->Core->GetCode("Cancel");
	// Ajouter la bonne action sur le bouton CANCEL (même que la croix = close popup)
	//$btnCancel->OnClick = "document.body.removeChild(this.parentNode);";
	$block->Add($btnCancel);

	//Action
	$Action = new AjaxAction("ProfilBlock" , "SaveFriend");
	$Action->ChangedControl = "lbInfo";
	$Action->AddArgument("UserContactId" , JVar::GetPost("UserContactId"));

	// Bouton d'enregistrement
  	$btnSave = new Button(BUTTON);
	$btnSave->CssClass = "btn btn-success";
  	$btnSave->Value = $this->Core->GetCode("Save");
	$btnSave->OnClick = $Action;

	$block->AddNew($btnSave , "2" ,ALIGNRIGHT);
  	echo $block->Show();
  }

  // Suppression du status Ami
  function RemoveStatusFriend()
  {
 	$block = new JBlock ();
	$block->CssClass = 'actioner';
	$block->Table = false;
	$block->Frame = false;
  	$block->AddNew(new Libelle($this->Core->GetCode("ConfirmRemoveAsFriend"),"lbInfo"));

	$btnCancel = new Button(BUTTON);
	$btnCancel->CssClass = "button_cancel";
	$btnCancel->Value = $this->Core->GetCode("Cancel");
	// Ajouter la bonne action sur le bouton CANCEL (même que la croix = close popup)
	//$btnCancel->OnClick = "document.body.removeChild(this.parentNode);";
	$block->Add($btnCancel);

	//Action
	$Action = new AjaxAction("ProfilBlock" , "RemoveFriend");
	$Action->ChangedControl = "lbInfo";
	$Action->AddArgument("UserContactId" , JVar::GetPost("UserContactId"));

	// Bouton d'enregistrement
  	$btnSave = new Button(BUTTON);
	$btnSave->CssClass = "btn btn-success";
  	$btnSave->Value = $this->Core->GetCode("Save");
	$btnSave->OnClick = $Action;

	$block->AddNew($btnSave , "2" ,ALIGNRIGHT);
  	echo $block->Show();
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

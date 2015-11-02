<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

include("../JHom/Runner.php");
Runner::RunInstance("ListLangsElements");

class ListLangsElements
 {
	function ListLangsElements()
	{
	  $this->Core = new Core(true);
	  $this->Core->Page->SetMasterPage("MasterPage.php","MasterPage");
	  $this->Core->Page->SetCharset("UTF-8");

	  $this->Core->Page->Title=$this->Core->GetCode("LangsElements");
	  $this->Form=new FormBlock("ListLangsElements",URLSITEMEMBRE."ListLangsElements.php?user=".JVar::Get("user")."&idEntity=".JVar::Get("idEntity")."&element=".JVar::Get("element"),POST,PAGE,$this->Core);
	  $this->Form->Table=true;

	  $this->Core->Page->InsertJsScript("script.js");


	 //blocage de l'accès direct
	if($this->Core->User->Email->Value != 'jerome.oliva@gmail.com')
	{
		$this->Core->Redirect("../index.php");
	}

	  $NbElement = 100;

	  //Grille des element
	  $this->Elements =new LangsElement($this->Core);

	  $this->GridElements = new Grid("grid");
	  $this->GridElements->IdName="Id";
	  $this->GridElements->CssClass ="grille";
	  $this->Source = $this->Elements->GetAllByLang($this->Core->GetLang(),JVar::Get("element"),$NbElement);

	  $this->GridElements->DataSource = $this->Source;
	  $this->GridElements->AddColumn(new Column($this->Core->GetCode("Identifiant"),"Id"));
	  $this->GridElements->AddColumn(new Column($this->Core->GetCode("Code"),"Code"));
	  $this->GridElements->AddColumn(new ControlColumn($this->Core->GetCode("Libelle"),"Libelle",TEXTBOX, array("Width:200px")));

      //Enregistrement
	  $this->BtnSave=new Button(BUTTON);
	  $this->BtnSave->Value=$this->Core->GetCode("Save");
	  $this->BtnSave->OnClick=new UserAction("Save");

	  //Lien de recherche
	  $this->NbPage = $this->Elements->GetCount();
	  $this->LinkBlock = new LinkBlock("");

	  for($i=0;$i<$this->NbPage/$NbElement;$i++)
	  {
		$this->LinkBlock->Add(new Link($i,"ListLangsElements.php?user=".JVar::Get("user")."&element=".$i));
	  }
	}
	//Enregistrement
	function Save()
	{
		//Recuperation de l'identifiant de la langue
		$Lang = new Langs($this->Core);
		$Lang->AddArgument(new Argument("Langs","Code",EQUAL,$this->Core->GetLang()));
		$Langs=$Lang->GetByArg();

		//Recuperation des control
		foreach($this->Source as $source)
		 {
		 	if(JVar::GetPost($source["Id"]))
		 	{
				$element = new LangsElement($this->Core);
				$element->CodeId->Value = $source["Id"];
				$element->LangId->Value = $Langs[0]->IdEntite;
				$element->Libelle->Value = JVar::GetPost($source["Id"]);

				$element->Save();
 		 	}
		 }

		 $this->Core->Redirect("ListLangsElements.php?element=".JVar::Get("element"));
	}
	//Creation de la page
	function CreatePage()
	{
	  //Ajout des controls au formulaire
	  $this->Form->AddNew($this->GridElements);
	  $this->Form->AddNew($this->LinkBlock,"2",ALIGNRIGHT);
	  $this->Form->AddNew($this->BtnSave,"2",ALIGNRIGHT);

	  //Ajout des controls � la page
	  $this->Core->Page->Insert(CENTER,$this->Form);
	 }
}
?>
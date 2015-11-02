<?php
/*
Page de déconnection
 */
include("JHom/Runner.php");
Runner::RunInstance("disconnect");

class disconnect
{
	//Propriet�s
	public $Core;
	public $Form;

	//
	function disconnect()
	{
		$this->Core=new Core(true);
		$this->Core->Page->SetMasterPage("MasterPage.php","MasterPage");
		$this->Core->Page->Title= $this->Core->GetCode("disconnect");

		//Deconnection de l'utilisateur
		JHomVar::Disconnect($this->Core);

		$this->Core->Redirect("index.php?action=disconnect");
	}

	function CreatePage()
	{}
}

?>

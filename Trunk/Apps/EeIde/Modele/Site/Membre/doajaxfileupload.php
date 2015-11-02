<?php

/**
 * Fichier de gestion des upload ajax
 
 */
session_start();
/*
 * Page et Classe Ajax
 * Page appelé par les appel Ajax
 ***/
include("../JHom/Core.php");
include("../Core/Eemmys.php");

//Initialisation du coeur de framework
$Core= new Core(true);
    
$error = "";
$msg = "";
$fileElementName = 'fileToUpload';

if(!empty($_FILES[$fileElementName]['error']))
{
        switch($_FILES[$fileElementName]['error'])
        {
                case '1':
                        $error = 'Votre fichier est trop volumineux';
                        break;
                case '2':
                        $error = 'Votre fichier est trop volumineux';
                        break;
                case '3':
                        $error = 'Votre fichier ne peut pas être téléchargé';
                        break;
                case '4':
                        $error = "Vous n'avez pas selectionné de fichier";
                        break;

                case '6':
                        $error = "Il n'y a pas de dossier temporaire";
                        break;
                case '7':
                        $error = "Impossible d'ecrire sur le disque";
                        break;
                case '8':
                        $error = 'Type de fichier non permis';
                        break;
                case '999':
                default:
                        $error = 'Erreur';
        }
}
elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
{
        $error = 'Vous devez selectionner un fichier';
}
else 
{
    $msg .= "App : ".$_POST["name"]. " :" .$_POST["id"];
    
    //Récuperation des variables
    $idElement = $_POST["id"];
    $tmpFileName = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];
    
    //Apppel de la méthode de l'application correspondante
    $appName = $_POST["name"];
    $app = Eemmys::GetApp($appName, $Core);
    $app->DoUploadFile($idElement, $tmpFileName, $fileName);
    
    //Message de retour
    $msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
                $msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
                //for security reason, we force to remove all uploaded file
               // @unlink($_FILES['fileToUpload']);		
}		
echo "{";
echo				"error: '" . $error . "',\n";
echo				"msg: '" . $msg . "'\n";
echo "}";
?>
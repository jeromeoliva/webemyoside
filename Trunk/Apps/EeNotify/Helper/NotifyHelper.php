<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Classe d'aide pour les notifications
 */

class NotifyHelper
{
    /**
     * Obtient les notifications de l'utilisateur 
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId, $limit = "")
    {
        $notify = new EeNotifyNotify($core);
        $notify->AddArgument(new Argument("EeNotifyNotify", "DestinataireId", EQUAL, $userId ));
        
        $notify->AddOrder("Id");
        
        //Limit
        if($limit != "")
        {
            $notify->SetLimit(1, $limit);
        }
        
        //TODO Rajouter les notification des cointacts qui me concerne
        return $notify->GetByArg();
    }
    
    /**
     * Ajoute une notification
     * @param type $userId
     * @param type $code
     * @param type $destinataireId
     * @param type $AppName
     * @param type $EntityId
     */
    public static function AddNotify($core, $userId, $code, $destinataireId, $AppName, $EntityId, $emailSubjet, $emailMessage)
    {
        $notify = new EeNotifyNotify($core);
        $notify->UserId->Value = $userId;
        $notify->Code->Value = $code;
        $notify->DestinataireId->Value = $destinataireId;
        $notify->AppName->Value = $AppName;
        $notify->EntityId->Value = $EntityId;
        $notify->DateCreate->Value = JDate::Now();
        $notify->Save();
        
        if($emailSubjet != "")
        {
            //Creation de l'email
            $Email  = new JEmail();
            $Email->Template = "MessageTemplate";
            $Email->Sender = WEBEMYOSMAIL;

             // sujet et message de l'email
             $Email->Title = $emailSubjet . " ".  $core->User->GetPseudo();
             $Email->Body .= $emailMessage;
             $contact = new User($core);
             $contact->GetById($destinataireId);

             $Email->Send($contact->Email->Value);
             $Email->SendToAdmin();
        }
    }
    
    /**
     * Obtient les notification d'une appli et d'une entité
     * 
     * @param type $core
     * @param type $appName
     * @param type $entityId
     */
    public static function GetNotify($core, $appName, $entityId)
    {
         $notify = new EeNotifyNotify($core);
         
         $notify->AddArgument(new Argument("EeNotifyNotify","AppName", EQUAL, $appName));
         $notify->AddArgument(new Argument("EeNotifyNotify","EntityId", EQUAL, $entityId));
         
         return $notify->GetByArg();
    }
    
    /*
     * Obtient les dernières notifications par utilisateur
     */
    public static function GetLastByUser($core, $userId)
    {
        return self::GetByUser($core, $userId, 3);
    }
}
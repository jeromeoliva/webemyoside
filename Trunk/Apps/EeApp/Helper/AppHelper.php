<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */

class AppHelper
{
    /**
     * Obtient les applications utilisateurs
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId)
    {
        $appUser = new EeAppUser($core);
        $appUser->AddArgument(new Argument("EeAppUser", "UserId", EQUAL, $userId));
        
        return $appUser->GetByArg();
    }
    
    /**
     * Obtient les app selon les critères
     * @param type $core
     */
    public static function GetByParameters($core)
    {
        $app = new EeAppApp($core);
        
        return $app->GetAll();
    }
    
    /**
     * Ajoute une app à l'utilisateur
     * @param type $core
     * @param type $appId
     */
    public static function Add($core, $appId, $appName)
    {
        $appUser = new EeAppUser($core);
        $appUser->UserId->Value = $core->User->IdEntite;
        
        if($appId != false)
        {
            $appUser->AppId->Value = $appId;
        }
        else
        {
            $app = new EeAppApp($core);
            
            $app->GetByName($appName);
            $appId = $app->IdEntite;
           $appUser->AppId->Value = $app->IdEntite;
        }
        
        if(!AppHelper::UserHave($core, $appId))
        {
            return $appUser->Save();
        }
        else
        {
            return $core->GetCode("EeApp.AppInDesktop");
        }
    }
    
    /**
     * Supprime une app a l'utilisateur
     * @param type $core
     * @param type $appId
     */
    public static function Remove($core, $appId)
    {
        $appUser = new EeAppUser($core);
        $appUser->GetById($appId);
        $appUser->Delete();
    }
    
    /**
     * Verifie si l'utilisateur à l'app
     * @param type $core
     * @param type $appId
     */
    public static function UserHave($core, $appId)
    {
         $appUser = new EeAppUser($core);
         $appUser->AddArgument(new Argument("EeAppUser", "UserId", EQUAL, $core->User->IdEntite));
         $appUser->AddArgument(new Argument("EeAppUser", "AppId", EQUAL, $appId));
         
         return (count($appUser->GetByArg()) > 0);
    }
    
    /**
     * Obtient les applications actives
     */
    public static function GetActif($core)
    {
         $app = new EeAppApp($core);
         $app->AddArgument(new Argument("EeAppApp", "Actif", EQUAL, "1"));
         
         return $app->GetByArg();
    }
    
    /**
     * Obtient les applications actives
     */
    public static function GetByCategory($core, $category)
    { 
        //Recuperation de la categorie par son nom
        $appCategory = new EeAppCategory($core);
        $appCategory->GetByName($category);
        
         $app = new EeAppApp($core);
         $app->AddArgument(new Argument("EeAppApp", "Actif", EQUAL, "1"));
         $app->AddArgument(new Argument("EeAppApp", "CategoryId", EQUAL, $appCategory->IdEntite));
         
         return $app->GetByArg();
    }
    
    /**
     * Retourne une app depuis son Id
     * @param type $core
     * @param type $id
     */
    public static function GetById($core, $id)
    {
         $app = new EeAppApp($core);
         $app->GetById($id);
         
         return $app;
    }
    
    /**
     * Retourne une app depuis son nom
     * @param type $core
     * @param type $id
     */
    public static function GetByName($core, $name)
    {
         $app = new EeAppApp($core);
         $app->GetByName($name);
         
         return $app;
    }
    
    /**
     * Retourne es catégories des applications
     * @param type $core
     */
    public static function GetCategory($core)
    {
        $category = new EeAppCategory($core);
        return $category->GetAll();
    }
}
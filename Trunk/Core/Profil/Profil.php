<?php
/**
 * WebemyosIde
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */
 
class Profil
{
    /**
     * Obtient le menu selon le type utilisateur 
     */
    public static function GetMenu($core)
    {
    //    return All::GetMenu($core);
        
       switch($core->User->TypeId->Value)
    	{
    		case 1 : 
    			return Contractor::GetMenu($core);
       		break;
                case 2 : 
    			return Tester::GetMenu($core);
       		break;
                case 3 : 
    			return Worker::GetMenu($core);
       		break;
       		default :
    	    
    	    	//Faire un switch sur le type utilisateur
        		return Developper::GetMenu($core);
                return Tester::GetMenu($core);
        
        		return Worker::GetMenu($core);
        break;
        }
    }
    
    /**
     * Obtient le tableau de bord selon le profil
     * @param type $core
     */
    public static function GetDashBoard($core)
    {
        return Developper::GetDashBoard($core);
        
        
        
        switch($core->User->TypeId->Value)
    	{
    		case 1 : 
    			return Contractor::GetDashBoard($core);
       		break;
                case 2 : 
    			return Tester::GetDashBoard($core);
       		break;
                case 3 : 
    			return Worker::GetDashBoard($core);
       		break;
       		default :
    	    
    	    	//Faire un switch sur le type utilisateur
        		return Developper::GetDashBoard($core);
                return Tester::GetDashBoard($core);
        
        		return Worker::GetDashBoard($core);
        break;
        }

    }
    
    /**
     * Obtient l'aide selonle profil
     * @param type $core
     */
    public static function GetHelp($core)
    {
        switch($core->User->TypeId->Value)
    	{
    		case 1 : 
    			return Contractor::GetHelp($core);
       		break;
                case 2 : 
    			return Tester::GetHelp($core);
       		break;
                case 3 : 
    			return Worker::GetHelp($core);
       		break;
       		default :
    	    
    	    	//Faire un switch sur le type utilisateur
        	return Worker::GetHelp($core);
        break;
        }

    }
}



?>

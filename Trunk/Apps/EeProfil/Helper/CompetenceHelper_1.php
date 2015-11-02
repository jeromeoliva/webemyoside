<?php

/*
 * Classe d'aide pour les compétences
 * 
 */
class CompetenceHelper
{
    /**
     * Obtient les catégorie de compétences
     * 
     * @param type $core
     */
    public static function GetCategorie($core)
    {
        $categories = new EeProfilCompetenceCategory($core);
        return $categories->GetAll();
    }
    
    /**
     * Récupére toutes les compétences dont celle de l'utilisateur
     * @param type $core
     */
    public static function GetByCategoryByUser($core, $categoryId, $userId)
    {
        $request = "SELECT competence.id as Id, competence.Code as Code, competenceUser.Id as Selected
                    FROM EeProfilCompetence as competence
                    LEFT JOIN EeProfilCompetenceEntity as competenceUser ON competenceUser.CompetenceId = competence.Id AND competenceUser.UserId =" .$userId."
                    WHERE competence.CategoryId = ".$categoryId;
        
        return $core->Db->GetArray($request);
    }
    
   
           
}
?>

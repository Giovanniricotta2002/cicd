<?php
/**
 * Ce fichier permet d'afficher le tableau des dossier d'autorisation avec une
 * selection spécifique 
 */

include('../sql/pgsql/dossier_autorisation.inc.php');

/*Liste des champs affichés dans le tableau de résultat*/
$champAffiche = array(
    'dossier_autorisation.dossier_autorisation as "'._("dossier").'"',
    'dossier_autorisation.dossier_autorisation_libelle as "'._("dossier").'"',
    $case_demandeur.' as "'._("nom du demandeur").'"',
    'TRIM(
        CASE
            WHEN dossier_autorisation.adresse_normalisee IS NULL
                OR TRIM(dossier_autorisation.adresse_normalisee) = \'\'
            THEN
                '.DB_PREFIXE.'adresse(
                    dossier_autorisation.terrain_adresse_voie_numero::text,
                    dossier_autorisation.terrain_adresse_voie::text,
                    \'\'::text,
                    dossier_autorisation.terrain_adresse_lieu_dit::text,
                    dossier_autorisation.terrain_adresse_bp::text,
                    dossier_autorisation.terrain_adresse_code_postal::text,
                    dossier_autorisation.terrain_adresse_localite::text,
                    dossier_autorisation.terrain_adresse_cedex::text,
                    \'\'::text,
                    \' \'::text
                )
            ELSE
                dossier_autorisation.adresse_normalisee
        END
    ) as "'._("localisation").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("type").'"',
    'to_char(dossier_autorisation.depot_initial ,\'DD/MM/YYYY\') as "'._("date de premier depot").'"',
    $case_etat.' as "'._("etat").'"',
    );

/*Tables sur lesquels la requête va s'effectuer*/
$table .= " 
    INNER JOIN ( 
        SELECT DISTINCT dossier_autorisation
        FROM ".DB_PREFIXE."dossier 
        INNER JOIN (
            SELECT DISTINCT dossier 
            FROM ".DB_PREFIXE."consultation 
            LEFT JOIN ".DB_PREFIXE."service
                ON service.service=consultation.service
            LEFT JOIN ".DB_PREFIXE."lien_service_om_utilisateur
                ON lien_service_om_utilisateur.service=service.service
            LEFT JOIN ".DB_PREFIXE."om_utilisateur
                ON om_utilisateur.om_utilisateur=lien_service_om_utilisateur.om_utilisateur
            WHERE om_utilisateur.login='".$_SESSION['login']."') AS C1 
        ON C1.dossier = dossier.dossier) AS D1
    ON D1.dossier_autorisation = dossier_autorisation.dossier_autorisation ";

$tab_actions['content'] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_autorisation&action=3&idx=',
          'id' => '&amp;premier='.$premier.'&amp;tricol='.$tricol.'&amp;advs_id='.$advs_id.'&amp;retourtab=dossier_autorisation_avis',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
          'ordre' => 10,);

// Actions a gauche : consulter 
$tab_actions['left']['consulter'] =$tab_actions['content'];

?>

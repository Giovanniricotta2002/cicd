<?php
//$Id: affectation_automatique.inc.php 4651 2015-04-26 09:15:48Z tbenita $ 
//gen openMairie le 30/11/2012 12:37

include('../gen/sql/pgsql/affectation_automatique.inc.php');
$ent = _("parametrage")." -> "._("gestion des dossiers")." -> "._("affectation_automatique");

// FROM
$table .= "
    LEFT JOIN ".DB_PREFIXE."division as division2
        ON instructeur3.division = division2.division
    LEFT JOIN ".DB_PREFIXE."division as division3
        ON instructeur4.division = division3.division
";

// SELECT 
$champAffiche = array(
    'affectation_automatique.affectation_automatique as "'._("affectation_automatique").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("dossier_autorisation_type_detaille").'"',
    'CASE WHEN affectation_automatique.dossier_instruction_type IS NOT NULL
        THEN CONCAT(dossier_instruction_type.libelle, \' (\', dossier_instruction_type.code, \')\')
        ELSE \'\'
     END as "'._("dossier_instruction_type").'"',
    'CASE WHEN instructeur3.nom IS NOT NULL
        THEN CONCAT(instructeur3.nom, \' (\', division2.code, \')\') 
        ELSE \'\'
    END as "'._("instructeur").'"',
    'CASE WHEN instructeur4.nom IS NOT NULL
        THEN CONCAT(instructeur4.nom, \' (\', division3.code, \')\') 
        ELSE \'\'
    END as "'._("instructeur_2").'"',
    'arrondissement.libelle as "'._("arrondissement").'"',
    'quartier.libelle as "'._("quartier").'"',
    'affectation_automatique.section as "'._("section").'"',
    'affectation_automatique.affectation_manuelle as "'._("affectation manuelle").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \""._("collectivite")."\"");
}
if ($f->is_option_dossier_commune_enabled()) {
    array_push($champAffiche, "affectation_automatique.communes as \"".__("communes")."\"");
}

$champRecherche = array(
    'affectation_automatique.affectation_automatique as "'._("affectation_automatique").'"',
    'affectation_automatique.affectation_manuelle as "'._("affectation manuelle").'"',
    'arrondissement.libelle as "'._("arrondissement").'"',
    'quartier.libelle as "'._("quartier").'"',
    'affectation_automatique.section as "'._("section").'"',
    'CASE WHEN instructeur3.nom IS NOT NULL
        THEN CONCAT(instructeur3.nom, \' (\', division2.code, \')\') 
        ELSE \'\'
    END as "'._("instructeur").'"',
    'CASE WHEN affectation_automatique.dossier_instruction_type IS NOT NULL
        THEN CONCAT(dossier_instruction_type.libelle, \' (\', dossier_instruction_type.code, \')\')
        ELSE \'\'
     END as "'._("dossier_instruction_type").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("dossier_autorisation_type_detaille").'"',
    'CASE WHEN instructeur4.nom IS NOT NULL
        THEN CONCAT(instructeur4.nom, \' (\', division3.code, \')\') 
        ELSE \'\'
    END as "'._("instructeur_2").'"',
);

if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \""._("collectivite")."\"");
}

if ($f->is_option_dossier_commune_enabled()) {
    array_push($champRecherche, 'affectation_automatique.communes as "'.__("communes").'"');
}

// si en sous-formulaire instructeur alors on cache le bouton ajouter
if (isset($retourformulaire) && $retourformulaire === 'instructeur') {
    // Actions en coin : ajouter
    $tab_actions['corner']['ajouter'] = NULL;
}



// Recherche avancée
$advsearch_fields= array(
    //
    'affectation_automatique' => array(
        'colonne' => 'affectation_automatique',
        'table' => 'affectation_automatique',
        'libelle' => __("affectation_automatique"),
        'type' => 'text',
        'taille' => '',
        'max' => ''
    )
    ,
    "dossier_autorisation_type_detaille" => array(
        'colonne' => "dossier_autorisation_type_detaille",
        'table' => 'affectation_automatique',
        'libelle' => __("dossier_autorisation_type_detaille"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    "dossier_instruction_type" => array(
        'colonne' => "dossier_instruction_type",
        'table' => 'affectation_automatique',
        'libelle' => __("dossier_instruction_type"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'instructeur' => array(
        'colonne' => 'instructeur',
        'table' => 'affectation_automatique',
        'libelle' => __("instructeur"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'instructeur_2' => array(
        'colonne' => 'instructeur_2',
        'table' => 'affectation_automatique',
        'libelle' => __("instructeur_2"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'arrondissement' => array(
        'colonne' => 'arrondissement',
        'table' => 'affectation_automatique',
        'libelle' => __("arrondissement"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'quartier' => array(
        'colonne' => 'quartier',
        'table' => 'affectation_automatique',
        'libelle' => __("quartier"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'section' => array(
        'colonne' => 'section',
        'table' => 'affectation_automatique',
        'libelle' => __("section"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'affectation_manuelle' => array(
        'colonne' => 'affectation_manuelle',
        'table' => 'affectation_automatique',
        'libelle' => __("affectation manuelle"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
);

if ($_SESSION['niveau'] == '2') {
    $advsearch_fields['om_collectivite'] = array(
        'table' => 'affectation_automatique',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => _('om_collectivite')
    );
}

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'affectation_automatique',
    'export' => array("csv"),
);





?>

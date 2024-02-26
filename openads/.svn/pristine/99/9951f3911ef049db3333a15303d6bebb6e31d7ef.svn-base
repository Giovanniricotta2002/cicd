<?php
//$Id$ 
//gen openMairie le 28/02/2022 16:08

include "../gen/sql/pgsql/motif_consultation.inc.php";

$ent = __("parametrage")." -> ".__("gestion des consultations")." -> ".__("motif de consultation");


// SELECT 
$champAffiche = array(
    'motif_consultation.motif_consultation as "'.__("motif_consultation").'"',
    'motif_consultation.code as "'.__("code").'"',
    'motif_consultation.libelle as "'.__("libelle").'"'
    );

if ($f->get_submitted_get_value('mode') === 'export_csv') {
    $table .= 
        "LEFT JOIN
            (SELECT
                motif_consultation,
                ARRAY_TO_STRING(ARRAY_AGG(om_collectivite.libelle ORDER BY lien_motif_consultation_om_collectivite.om_collectivite ASC), ', ') AS om_collectivite
            FROM
                ".DB_PREFIXE."lien_motif_consultation_om_collectivite
                INNER JOIN ".DB_PREFIXE."om_collectivite
                    ON lien_motif_consultation_om_collectivite.om_collectivite = om_collectivite.om_collectivite
            GROUP BY
                motif_consultation) AS motif_consultation_om_collectivite
            ON
                motif_consultation_om_collectivite.motif_consultation = motif_consultation.motif_consultation";

    $champAffiche[] = 'motif_consultation_om_collectivite.om_collectivite as "Service(s)"';
}

$args_type_consultation = array(
    //
    0 => array("", "avec_avis_attendu", "pour_conformite", "pour_information"),
    1 => array(__("choisir")." ".__("type_consultation"), __("Avec avis attendu"), __("Pour conformite"), __("Pour information")),
);

$args_delai_type = array(
    //
    0 => array("", "mois", "jour"),
    1 => array(__("choisir")." ".__("delai_type"), __("mois"), __("jour")),
);

$args_service_type = array(
    //
    0 => array("", PLATAU, "openads"),
    1 => array(__("choisir")." ".__("service_type"), __("Plat'AU"), __("openADS")),
);

// Options pour les select de faux booléens
$args_bool = array(
    //
    0 => array("", "t", "f", ),
    1 => array(__("choisir")." ".__("valeur"), __("Oui"), __("Non"), ),
);

 // Recherche avancée
 $advsearch_fields= array(
    //
    'motif_consultation' => array(
        'colonne' => 'motif_consultation',
        'table' => 'motif_consultation',
        'libelle' => __("motif_consultation"),
        'type' => 'text',
        'taille' => '',
        'max' => ''
    )
    ,
    "code" => array(
        'colonne' => "code",
        'table' => 'motif_consultation',
        'libelle' => __("code"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    "description" => array(
        'colonne' => "description",
        'table' => 'motif_consultation',
        'libelle' => __("description"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'libelle' => array(
        'colonne' => 'libelle',
        'table' => 'motif_consultation',
        'libelle' => __("libelle"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'notification_email' => array(
        'colonne' => 'notification_email',
        'table' => 'motif_consultation',
        'libelle' => __("notification_email"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_bool,
    )
    ,
    'delai_type' => array(
        'colonne' => 'delai_type',
        'table' => 'motif_consultation',
        'libelle' => __("delai_type"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_delai_type
    )
    ,
    'delai' => array(
        'colonne' => 'delai',
        'table' => 'motif_consultation',
        'libelle' => __("delai"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'consultation_papier' => array(
        'colonne' => 'consultation_papier',
        'table' => 'motif_consultation',
        'libelle' => __("consultation_papier"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_bool,
    )
    ,
    'om_validite_debut' => array(
        'colonne' => 'om_validite_debut',
        'table' => 'motif_consultation',
        'libelle' => __("om_validite_debut"),
        'lib1'=> __("debut"),
        'lib2' => __("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    )
    ,
    'om_validite_fin' => array(
        'colonne' => 'om_validite_fin',
        'table' => 'motif_consultation',
        'libelle' => __("om_validite_fin"),
        'lib1'=> __("debut"),
        'lib2' => __("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    )
    ,
    'type_consultation' => array(
        'colonne' => 'type_consultation',
        'table' => 'motif_consultation',
        'libelle' => __("type_consultation"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_type_consultation
    )
    ,
    'om_etat' => array(
        'colonne' => 'om_etat',
        'table' => 'motif_consultation',
        'libelle' => __("om_etat"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
    ,
    'service_type' => array(
        'colonne' => 'service_type',
        'table' => 'motif_consultation',
        'libelle' => __("service_type"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_service_type
    ),
    'generer_edition' => array(
        'colonne' => 'generer_edition',
        'table' => 'motif_consultation',
        'libelle' => __("generer_edition"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_bool,
    )
    
);

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'motif_consultation',
    'export' => array("csv"),
);

$sousformulaire = array('lien_motif_consultation_om_collectivite');

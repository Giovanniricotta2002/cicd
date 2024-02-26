<?php
/**
 * LISTING - Retours de consultation
 *
 * Le listing 'Retours de consultation' permet d'afficher la même liste de
 * dossiers que le widget 'Retours de consultation'. Ce script permet de
 * définir les paramètres génériques du listing qui se trouvent dans la
 * définition du widget obj/om_widget.class.php et a pour objectif d'être
 * inclus par les scripts de définition des listings spécifiques à chaque
 * filtre : instructeur, division, aucun.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
include "../gen/sql/pgsql/consultation.inc.php";
include "../sql/pgsql/app_om_tab_common_select.inc.php";

/**
 * Filtres
 */
// Selon l'entrée de menu sélectionné, on réalise l'affichage des éléments
// en leur appliquant un filtre. Même principe de filtre que pour les widgets
if ($obj === "consultation_tous_retours") {
    // Aucun filtre appliqué, affiche toutes les consultations ayant un retour
    // non lu
    $filtre = "aucun";
} elseif ($obj === "consultation_retours_ma_division") {
    // filtre division appliqué, affiche toutes les consultations appartenant
    // à un dossier affecté à la même division que l'utilisateur
    $filtre = "division";
} else {
    // filtre ? appliqué, affiche toutes les consultations appartenant
    // à un dossier ayant pour instructeur ou instructeur secondaire
    // l'utilisateur
    $filtre = 'instructeur_ou_instructeur_secondaire';
}
// Filtre selon le filtre passé en paramètre dans l'url
$filtreContexte = $this->get_submitted_get_value('filtre');
if (! empty($filtreContexte)) {
    $filtre = $filtreContexte;
}

$params = array(
    "filtre" => $filtre,
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_consultation_retours($params);
// Ajout d'une jointure sur l'instructeur secondaire pour permettre la recherche
// simple par instructeur secondaire
$conf["query_ct_from"] .= sprintf(
    'LEFT JOIN %1$sinstructeur as instructeur_secondaire
        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
    LEFT JOIN %1$som_utilisateur as utilisateur_2
        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur',
    DB_PREFIXE
);
// Récupération du filtre
$sqlFiltre = $om_widget->get_query_filter(
    $conf["query_ct_from"].' WHERE '.$conf["query_ct_where_common"],
    $filtre
);

/**
 *
 */
//
$tab_description = $conf["message_help"];

//
$tab_title = _("consultation");

// Traduction des termes technique du type de consultation.
// Pour les consultations des tiers et des service la traduction est la même
// sauf qu'on ne cherche pas les résultats dans la même table. Ce template
// existe donc pour pouvoir être utilisé dans les 2 cas sans réécrire ce code
$template_case_traduction_type_consultation =
    'CASE WHEN %1$s.type_consultation=\'avec_avis_attendu\' 
            THEN \''._("avec avis attendu").'\'
            WHEN %1$s.type_consultation=\'pour_conformite\' 
            THEN \''._("pour conformite").'\'
            WHEN %1$s.type_consultation=\'pour_information\' 
            THEN \''._("pour information").'\'
    END';
// Affichage du type de consultation traduit selon l'élément consulte (tiers ou service)
$case_type_consultation = sprintf(
    'CASE WHEN consultation.service IS NOT NULL
        THEN (%1$s)
        ELSE (%2$s)
    END',
    sprintf($template_case_traduction_type_consultation, 'service'),
    sprintf($template_case_traduction_type_consultation, 'motif_consultation')
);

// Affichage du nom du service ou du tiers consulte
$case_element_consulte =
"CASE WHEN consultation.service IS NOT NULL
    THEN concat(service.abrege, ' - ', service.libelle)
    ELSE concat(tiers_consulte.abrege, ' - ', tiers_consulte.libelle)
END";

//
$displayed_fields_begin = array(
    'consultation.consultation as "'._("consultation").'"',
    $select__dossier_libelle__column_as,
    $case_element_consulte.' as "'._("service / tiers").'"',
    $case_type_consultation.' as "'._("type_consultation").'"',
    'to_char(consultation.date_reception ,\'DD/MM/YYYY\') as "'._("date_reception").'"',
    'to_char(consultation.date_retour ,\'DD/MM/YYYY\') as "'._("date_retour").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    'avis_consultation.libelle as "'._("avis_consultation").'"',
);
$displayed_field_instructeur = array(
    'instructeur.nom as "'._("instructeur").'"',
    'instructeur_secondaire.nom as "'.__("instructeur secondaire").'"',
);
$displayed_field_division = array(
    'division.code as "'._("division").'"',
);
$displayed_field_collectivite = array(
    'om_collectivite.libelle as "'._("collectivite").'"',
);
$displayed_fields_end = array(
    'CASE WHEN dossier.enjeu_erp is TRUE THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_erp-16" title="'._('Enjeu ERP').'">ERP</span>\' ELSE \'\' END ||
     CASE WHEN dossier.enjeu_urba is TRUE THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_urba-16" title="'._('Enjeu Urba').'">URBA</span>\' ELSE \'\' END
     as "'._("enjeu").'"',
);

// FROM
$table =
    $conf["query_ct_from"].
    $sqlFiltre['FROM'];
// WHERE
$selection = sprintf(
    "WHERE 
        %s
        %s
    ",
    $conf["query_ct_where_common"],
    $sqlFiltre['WHERE']
);

//
$tri = " ORDER BY dossier.enjeu_erp, dossier.enjeu_urba, consultation.date_retour ";
//
$tab_actions['corner']['ajouter'] = null;

/**
 * Options - Style CSS sur certaines lignes
 * On met la ligne en couleur selon le type de consultation
 */
$options[] = array(
    "type" => "condition",
    "field" => 'CASE WHEN service.type_consultation=\'avec_avis_attendu\' 
            THEN \''._("avec avis attendu").'\'
            WHEN service.type_consultation=\'pour_conformite\' 
            THEN \''._("pour conformite").'\'
            WHEN service.type_consultation=\'pour_information\' 
            THEN \''._("pour information").'\'
    END',
    "case" => array(
        array(
            "values" => array(_("avec avis attendu"), ),
            "style" => "consultation-avec-avis-attendu",
        ),
        array(
            "values" => array(_("pour conformite"), ),
            "style" => "consultation-pour-conformite",
        ),
        array(
            "values" => array(_("pour information"), ),
            "style" => "consultation-pour-information",
        ),
    ),
);

/**
 * Options - ADVSEARCH
 */
//
$advsearch_fields_begin = array(
    //
    'service_abrege' => array(
        'table' => 'service',
        'colonne' => 'abrege',
        'type' => 'text',
        'libelle' => _('Service (abrege)'),
        'taille' => '',
        'max' => '',
    ),
    //
    'service' => array(
        'table' => 'service',
        'colonne' => 'libelle',
        'type' => 'text',
        'libelle' => _('Service'),
        'taille' => '',
        'max' => '',
    ),
);
//
$advsearch_field_instructeur = array(
    'instructeur' => array(
        'colonne' => 'nom',
        'table' => 'instructeur',
        'libelle' => _('Instructeur'),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),
    'instructeur_2' => array(
        'table' => 'dossier',
        'colonne' => 'instructeur_2',
        'type' => 'select',
        'libelle' => __('Instructeur secondaire'),
        'subtype' => 'sqlselect',
        'sql' => "SELECT instructeur.instructeur, instructeur.nom
            FROM ".DB_PREFIXE."instructeur 
            INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
            WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
                AND LOWER(instructeur_qualite.code) = LOWER('instr')
            ORDER BY nom",
    ),
);

$advsearch_field_division = array(
    //
    'division' => array(
        'colonne' => 'code',
        'table' => 'division',
        'libelle' => _('Division'),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),
);
//
$advsearch_field_collectivite = array(
    //
    'collectivite' => array(
        'table' => 'om_collectivite',
        'colonne' => 'libelle',
        'type' => 'text',
        'libelle' => _('om_collectivite'),
        'taille' => '',
        'max' => '',
    ),
);
//
$advsearch_fields_end = array(
    //
    'date_envoi' => array(
        'colonne' => 'date_envoi',
        'table' => 'consultation',
        'libelle' => _('Date d\'envoi'),
        'type' => 'date',
        'where' => 'intervaldate',
        'taille' => '',
    ),
    //
    'date_retour' => array(
        'colonne' => 'date_retour',
        'table' => 'consultation',
        'libelle' => _('Date de retour'),
        'type' => 'date',
        'where' => 'intervaldate',
        'taille' => '',
    ),
    //
    'date_limite' => array(
        'colonne' => 'date_limite',
        'table' => 'consultation',
        'libelle' => _('Date limite'),
        'type' => 'date',
        'where' => 'intervaldate',
        'taille' => '',
    ),
);

?>

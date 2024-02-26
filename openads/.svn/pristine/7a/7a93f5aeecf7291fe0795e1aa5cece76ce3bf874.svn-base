<?php
/**
 * LISTING - Retours de messages
 *
 * Le listing 'Retours de messages' permet d'afficher la même liste de
 * dossiers que le widget 'Retours de messages'. Ce script permet de
 * définir les paramètres génériques du listing qui se trouvent dans la
 * définition du widget obj/om_widget.class.php et a pour objectif d'être
 * inclus par les scripts de définition des listings spécifiques à chaque
 * filtre : instructeur, division, aucun.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
include "../gen/sql/pgsql/dossier_message.inc.php";

/**
 *
 */
switch ($obj) {
    case 'messages_mes_retours':
        $filtre = 'instructeur_ou_instructeur_secondaire';
        $contexte = 'standard';
        break;
    case 'messages_retours_ma_division':
        $filtre = 'division';
        $contexte = 'standard';
        break;
    case 'messages_tous_retours':
        $filtre = 'aucun';
        $contexte = 'standard';
        break;
    case 'messages_contentieux_mes_retours':
        $filtre = 'instructeur_ou_instructeur_secondaire';
        $contexte = 'contentieux';
        break;
    case 'messages_contentieux_retours_ma_division':
        $filtre = 'division';
        $contexte = 'contentieux';
        break;
    case 'messages_contentieux_tous_retours':
        $filtre = 'aucun';
        $contexte = 'contentieux';
        break;
}
// Filtre selon le filtre passé en paramètre dans l'url
// Permet de garder la cohérence entre le nombre de résultat affiché sur le
// widget et le nombre de résultats dans le listing
$filtreContexte = $this->get_submitted_get_value('filtre');
if (! empty($filtreContexte)) {
    $filtre = $filtreContexte;
}

//
$params = array(
    "filtre" => $filtre,
    "contexte" => $contexte,
    "dossier_cloture" => isset($_GET['dossier_cloture']) ? $_GET['dossier_cloture'] : "",
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
include "../sql/pgsql/app_om_tab_common_select.inc.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_messages_retours($params);

/**
 *
 */
//
$tab_description = $conf["message_help"];

//
$tab_title = _("message");

//
$displayed_fields_begin = array(
    'dossier_message.dossier_message as "'._("dossier_message").'"',
    $select__dossier_libelle__column_as,
    'dossier_message.type as "'._("type").'"',
    'dossier_message.emetteur as "'._("emetteur").'"',
    'dossier_message.destinataire as "'._("destinataire").'"',
    'to_char(dossier_message.date_emission ,\'DD/MM/YYYY\') as "'._("date_emission").'"',
    'to_char(dossier_message.date_emission ,\'HH24:MI:SS\') as "'._("heure_emission").'"',
);
$displayed_field_instructeur = array(
    'instructeur.nom as "'._("instructeur").'"',
    'instructeur_secondaire.nom as "'.__("instructeur secondaire").'"'
);
// Dans le contexte contentieux, affiche les deux instructeurs
if ($contexte === 'contentieux') {
    //
    $displayed_field_instructeur = array(
        'CONCAT_WS(\' / \', instructeur.nom, instructeur_secondaire.nom) as "'._("juriste / technicien").'"',
    );
}
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
// FILTRE
$sqlFilter = $om_widget->get_query_filter(
    $conf["query_ct_from"].' WHERE '.$conf["query_ct_where_common"],
    $filtre
);
// Pour les messages en plus du filtre ont souhaite récupérer tous les messages
// à destination de la commune pour les collectivité mono
if ($conf['arguments']['filtre'] != 'aucun') {
    if ($this->isCollectiviteMono($_SESSION['collectivite']) === true) {
        // Modifie la condition du filtre pour récupérer les messages voulus (filtre
        // instructeur, instructeur_secondaire ou division) ainsi que les messages de
        // à destination de la commune.
        // Le filtre récupéré a un 'AND' devant la condition pour éviter une erreur de
        // base de donnée on le supprime pour ne récupérer que la condition et pouvoir
        // l'associer à la condition sur le destinataire
        $sqlFilter['WHERE'] = sprintf(
            ' AND (%s %s dossier_message.destinataire = \'commune\')',
            str_replace(' AND ', '', $sqlFilter['WHERE']),
            ! empty($sqlFilter['WHERE']) ? 'OR' : ''
        );
    } else {
        // Modifie la condition du filtre pour récupérer les messages voulus (filtre
        // instructeur, instructeur_secondaire ou division) qui sont à destination de
        // l'instructeur
        $sqlFilter['WHERE'] = sprintf(
            ' %s AND dossier_message.destinataire = \'instructeur\'',
            $sqlFilter['WHERE']
        );
    }
}
// FROM
$table = sprintf(
    '%s
    %s',
    $conf["query_ct_from"],
    $sqlFilter['FROM']
);

// WHERE
$selection = sprintf(
    "WHERE 
        %s
        %s",
    $conf["query_ct_where_common"],
    $sqlFilter['WHERE']
);
//
$tri = " ORDER BY dossier.enjeu_erp DESC, dossier.enjeu_urba DESC, dossier_message.date_emission ASC ";
//
if ($contexte === 'contentieux') {
    //
    $tri = " ORDER BY dossier_message.date_emission ASC ";
}

//
$tab_actions['corner']['ajouter'] = null;

/**
 * Options - ADVSEARCH
 */
//
$advsearch_fields_begin = array(
    //
    'dossier' => array(
        'table' => 'dossier_message',
        'colonne' => 'dossier',
        'type' => 'text',
        'libelle' => _('Dossier'),
        'taille' => '',
        'max' => '',
    ),
    //
    'type' => array(
        'table' => 'dossier_message',
        'colonne' => 'type',
        'type' => 'select',
        'libelle' => _('Type message'),
    ),
    //
    'emetteur' => array(
        'colonne' => 'emetteur',
        'table' => 'dossier_message',
        'libelle' => _('Emetteur'),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),
    //
    'date_emission' => array(
        'colonne' => 'date_emission',
        'table' => 'dossier_message',
        'libelle' => _('Date d\'emission'),
        'type' => 'date',
        'where' => 'intervaldate',
        'taille' => '',
    ),
);
//
$advsearch_field_instructeur = array(
    //
    'instructeur' => array(
        'colonne' => 'nom',
        'table' => 'instructeur',
        'libelle' => _('Juriste/Technicien'),
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
// Dans le contexte contentieux, affiche les deux instructeurs
if ($contexte === 'contentieux') {
    //
    $advsearch_field_instructeur = array(
        'instructeur' => array(
            'table' => 'dossier',
            'colonne' => 'instructeur',
            'type' => 'select',
            'libelle' => _('Juriste'),
            'subtype' => 'sqlselect',
            'sql' => "SELECT instructeur.instructeur, instructeur.nom
                FROM ".DB_PREFIXE."instructeur 
                INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
                WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
                    AND LOWER(instructeur_qualite.code) = LOWER('juri')
                ORDER BY nom",
        ),
        //
        'instructeur_2' => array(
            'table' => 'dossier',
            'colonne' => 'instructeur_2',
            'type' => 'select',
            'libelle' => _('Technicien'),
            'subtype' => 'sqlselect',
            'sql' => "SELECT instructeur.instructeur, instructeur.nom
                FROM ".DB_PREFIXE."instructeur 
                INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
                WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
                    AND LOWER(instructeur_qualite.code) = LOWER('tech')
                ORDER BY nom",
        ),
    );
}
//
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
    'enjeu_erp' => array(
        'colonne' => 'enjeu_erp',
        'table' => 'dossier',
        'libelle' => _('Dossier enjeu ERP'),
        "subtype" => "manualselect",
        'type' => 'select',
        "args" => array(
            array("", "true", "false", ),
            array(_("Tous"), _("Oui"), _("Non"), ),
        ),
    ),
    //
    'enjeu_urba' => array(
        'colonne' => 'enjeu_urba',
        'table' => 'dossier',
        'libelle' => _('Dossier enjeu URBA'),
        'type' => 'select',
        "subtype" => "manualselect",
        "args" => array(
            array("", "true", "false", ),
            array(_("Tous"), _("Oui"), _("Non"), ),
        ),
    ),
);
?>

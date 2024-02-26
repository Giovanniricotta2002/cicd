<?php
/**
 * LISTING - Suivi des tâches Plat'AU
 *
 * Le listing "Suivi des tâche Plat'AU" permet d'afficher les dossiers pour lesquels il y a une ou plusieurs tâches qui répond aux 
 * critères paramétrés 
 *
 *
 * @package openads
 * @version SVN : $Id: suivi_tache_platau.inc.php 5208 2015-09-23 21:32:51Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

$tab_title = __("Transferts");

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récupérer le configuration de la requête du widget.
if (isset($_GET['widget_recherche_id'])) {
    $params = unserialize($_SESSION['widget_recherche_id'][$_GET['widget_recherche_id']]);
}
/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_suivi_tache($params);

/**
 * Configuration du listing
 */

$transfert_lib = "";
if (isset($conf['arguments']['categorie_tache'])) {
    if($conf['arguments']['categorie_tache'] == PORTAL) {
        $transfert_lib = __("IDE'AU");
    }
    if($conf['arguments']['categorie_tache'] == PLATAU) {
        $transfert_lib = __("Plat'AU");
    }
}

// Titre de la page
$ent = __("Suivi des Transferts ").$transfert_lib;
//
$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();

$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&retour_widget=suivi_tache&widget_recherche_id='.$_GET['widget_recherche_id'].'&amp;action=3&amp;idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
);
$tab_actions['content'] = $tab_actions['left']['consulter'];

$champRecherche = array(
    $select__dossier_libelle__column_as,
    'task.type as "'.__("type").'"',
    'task.state as "'.__("state").'"',
);

/**
 * Composition de la requête
 */
$sqlFiltre = $om_widget->get_query_filter(
    sprintf(
        "%s
        WHERE 
            %s
        ",
        $conf["query_ct_from"],
        $conf["query_ct_where"]
    ),
    $conf['arguments']['filtre']
);
// SELECT

// /!\ La colonne "type" du listing contient une infobulle qui est insérée directement en javascript
// Faire attention si une colonne doit être ajoutée

$champAffiche = $conf["query_ct_select_champaffiche"];
// FROM
$table =
    $conf["query_ct_from"].
    $sqlFiltre['FROM'];
// WHERE
$selection = sprintf(
    "WHERE 
        %s
        %s",
    $conf["query_ct_where"],
    $sqlFiltre['WHERE']
);
// ORDER BY
$tri = sprintf("
    ORDER BY %s
    ",
    $conf["query_ct_orderby"]
);

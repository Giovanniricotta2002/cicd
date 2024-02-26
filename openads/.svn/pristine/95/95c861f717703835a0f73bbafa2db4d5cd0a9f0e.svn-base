<?php
/**
 * LISTING - Dossiers avec un evenement incomplet ou majoration en attente d'un retour RAR
 *
 * Le listing 'Dossiers evenement incomplet majoration' permet d'afficher les même
 * dossiers que le widget 'Dossiers evenement incomplet majoration' sans la limite de 10
 * enregistrements. Aucune entrée de menu ne permet d'accéder à ce listing, c'est un lien
 * depuis le widget qui nous permet d'arriver sur ce listing.
 *
 * @package openads
 * @version
 */

//
include('../sql/pgsql/dossier_instruction.inc.php');

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récuérer le configuration de la requête du widget.
$params = array(
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : ""),
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_dossiers_evenement_incomplet_majoration($params);
//
$filtre = $conf["arguments"]["filtre"];

// Titre de la page
$ent = __("instruction")." -> ".__("Dossiers incomplets ou majorés sans date de notification");

$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();

$tab_actions['left']['consulter'] =
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
          'id' => '',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
          'ordre' => 10,);
$tab_actions['content'] = $tab_actions['left']['consulter'];
// Aucun champ pour la recherche simple
$champRecherche = array();
// On cache la recherche simple
$options[] = array(
    "type" => "search",
    "display" => false,
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
        $conf["query_ct_where_common"]
    ),
    $filtre
);
// SELECT
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
    $conf["query_ct_where_common"],
    $sqlFiltre['WHERE']
);
// ORDER BY
$tri = sprintf("
    ORDER BY
        %s
    ",
    $conf["query_ct_orderby"]
);

?>
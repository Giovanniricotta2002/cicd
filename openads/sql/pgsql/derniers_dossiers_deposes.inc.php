<?php
/**
 * LISTING - Derniers dossiers déposés
 *
 * Le listing 'Derniers dossiers déposés' permet d'afficher les dossiers que 
 * le widget 'Derniers dossiers déposés. Aucune 
 * entrée de menu ne permet d'accéder à ce listing, c'est un lien depuis le
 * widget qui nous permet d'arriver sur ce listing.
 *
 * @package openads
 * @version SVN : $Id
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récuérer le configuration de la requête du widget.
$params = array(
    "nombre_de_jours" => (isset($_GET['nombre_de_jours']) ? $_GET['nombre_de_jours'] : ""),
    "codes_datd" => (isset($_GET['codes_datd']) ? $_GET['codes_datd'] : ""),
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : ""),
    "restreindre_msg_non_lus" => (isset($_GET['restreindre_msg_non_lus']) ? $_GET['restreindre_msg_non_lus'] : ""),
    "filtre_depot" => (isset($_GET['filtre_depot']) ? $_GET['filtre_depot'] : ""),
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_derniers_dossiers_deposes($params);
//
$filtre = $conf["arguments"]["filtre"];
$nombre_de_jours = $conf["arguments"]["nombre_de_jours"];
$codes_datd = $conf["arguments"]["codes_datd"];
$filtre_depot = $conf["arguments"]["filtre_depot"];
$restreindre_msg_non_lus = $conf["arguments"]["restreindre_msg_non_lus"];

/**
 * Configuration du listing
 */
// Titre de la page
$ent = _("instruction")." -> "._("Dossiers déposés");
//
$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();
// Le lien de consultation porte vers l'objet dossier_instruction sans
// aucun paramètre car aucun retour sur le listing n'est possible
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
);
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
// SELECT
$champAffiche = $conf["query_ct_select_champaffiche"];
// Récuparation du filtre
$sqlFiltre = $om_widget->get_query_filter(
    sprintf("
        %s
        WHERE 
            %s
            %s 
            %s 
            %s
            %s
        ",
        $conf["query_ct_from"],
        $conf["query_ct_where_common"],
        $conf["query_ct_where_date_filter"],
        $conf["query_ct_where_groupe"],
        $conf["query_ct_where_depot_filter"],
        $conf["query_ct_where_datd_filter"]
    ),
    $filtre
);
// FROM
$table =
    $conf["query_ct_from"].
    $sqlFiltre['FROM'];
// WHERE
$selection = sprintf(" 
    WHERE 
        %s
        %s 
        %s 
        %s
        %s
        %s
    ",   
    $conf["query_ct_where_common"],
    $conf["query_ct_where_date_filter"],
    $conf["query_ct_where_groupe"],
    $conf["query_ct_where_depot_filter"],
    $conf["query_ct_where_datd_filter"],
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

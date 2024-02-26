<?php
/**
 * LISTING - Dossiers en pré-instruction
 *
 * Le listing 'Dossiers en pré-instruction' permet d'afficher les même dossiers
 * que le widget 'Dossiers en pré-instruction' sans la limite de 5
 * enregistrements. Aucune entrée de menu ne permet d'accéder à ce listing,
 * c'est un lien depuis le widget qui nous permet d'arriver sur ce listing.
 *
 * @package openads
 * @version SVN : $Id: dossiers_pre_instruction.inc.php 13137 2022-10-27 20:34:03Z softime $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récuérer le configuration de la requête du widget.
$params = array(
    "codes_datd" => (isset($_GET['codes_datd']) ? $_GET['codes_datd'] : ""),
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : "")
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_dossiers_pre_instruction($params);
$filtre = $conf["arguments"]["filtre"];
$codes_datd = $conf["arguments"]["codes_datd"];
/**
 * Configuration du listing
 */
// Titre de la page
$ent = __("instruction")." -> ".__("Dossiers à qualifier (limite de la notification du délai)");
//
$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();
// Le lien de consultation porte vers l'objet dossier_instruction sans
// aucun paramètre car aucun retour sur le listing n'est possible
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'.__('Consulter').'">'.__('Consulter').'</span>',
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
$sqlFiltre = $om_widget->get_query_filter(
    sprintf(
        "%s
        WHERE
            %s
            %s
        ",
        $conf["query_ct_from"],
        $conf["query_ct_where"],
        $conf["query_ct_where_datd_filter"]
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
        %s
        %s",
    $conf["query_ct_where"],
    $conf["query_ct_where_datd_filter"],
    $sqlFiltre['WHERE']
);
// ORDER BY
$tri = sprintf("
    ORDER BY %s
    ",
    $conf["query_ct_orderby"]
);

// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');

?>

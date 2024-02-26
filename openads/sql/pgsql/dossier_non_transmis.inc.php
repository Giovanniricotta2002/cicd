<?php
/**
 * LISTING - Les dossiers non transmis à Plat'AU
 *
 * Le listing 'Les dossiers non transmis à Plat'AU' permet d'afficher les même dossiers que 
 * le widget 'Les dossiers non transmis à Plat'AU' sans la limite de 5 enregistrements. Aucune 
 * entrée de menu ne permet d'accéder à ce listing, c'est un lien depuis le
 * widget qui nous permet d'arriver sur ce listing.
 *
 * @package openads
 * @version SVN : $Id: dossiers_non_transmis.inc.php 5208 2015-09-23 21:32:51Z fmichon $
 */


include "../sql/pgsql/dossier_instruction.inc.php";

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récuérer le configuration de la requête du widget.
$params = array(
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : ""),
    "date_depot_debut" => (isset($_GET['date_depot_debut']) ? $_GET['date_depot_debut'] : ""),
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$params['affichage'] = 'liste';
$conf = $om_widget->get_config_dossier_non_transmis_platau($params);

// Titre de la page
$ent = __("instruction")." -> ".__("Dossiers non transmis à Plat'AU");
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
$tri = $conf["query_ct_orderby"];

?>
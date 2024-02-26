<?php
/**
 * LISTING - Les contradictoires
 *
 * Le listing 'Les contradictoires' permet d'afficher les même dossiers que 
 * le widget 'Les contradictoires' sans la limite de 5 enregistrements. Aucune 
 * entrée de menu ne permet d'accéder à ce listing, c'est un lien depuis le
 * widget qui nous permet d'arriver sur ce listing.
 *
 * @package openads
 * @version SVN : $Id: dossiers_limites.inc.php 5208 2015-09-23 21:32:51Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

/**
 * Récupération des paramètres GET
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récuérer le configuration de la requête du widget.
$params = array(
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : "")
);

/**
 * Récupération de la configuration de la requête à partir du widget.
 */
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_dossier_contentieux_contradictoire($params);

/**
 * Configuration du listing
 */
// Titre de la page
$ent = _("contentieux")." -> ";
if ($params['filtre'] === 'instructeur') {
    //
    $ent .= _("Mes Contradictoires");
} else {
    //
    $ent .= _("Les Contradictoires");
}
//
$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();
// Le lien de consultation porte vers l'objet dossier_instruction sans
// aucun paramètre car aucun retour sur le listing n'est possible
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=',
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
    $conf["arguments"]["filtre"]
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
    ",
    $conf["query_ct_where"],
    $sqlFiltre['WHERE']
);
// ORDER BY
$tri = sprintf("
    ORDER BY
        %s
    ",
    $conf["query_ct_orderby"]
);

// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');

?>

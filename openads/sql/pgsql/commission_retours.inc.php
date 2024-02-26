<?php
/**
 * Ce script permet de ...
 *
 * @package openfoncier
 * @version SVN : $Id: commission_retours.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../sql/pgsql/dossier_commission.inc.php";

//
$ent = _("instruction")." -> "._("commissions")." -> ";

//
$tab_title = _("commission");


/**
 * Filtres
 */
//
if ($obj === "commission_tous_retours") {
    // Aucun filtre appliqué, tous les retours de commissions non lu
    $filtre = "aucun";
} elseif ($obj === "commission_retours_ma_division") {
    // filtre division appliqué, affiche tous les retours de commission liés
    // à un dossier affecté à la même division que l'utilisateur
    $filtre = "division";
} else {
    // filtre ? appliqué, affiche tous les retours de commission liés
    // à un dossier ayant pour instructeur ou instructeur secondaire
    // l'utilisateur
    $filtre = 'instructeur_ou_instructeur_secondaire';
}
// Filtre selon le filtre passé en paramètre dans l'url
$filtre = ! empty($this->get_submitted_get_value('filtre')) ?
    $this->get_submitted_get_value('filtre') :
    $filtre;
//
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
$conf = $om_widget->get_config_commission_retours($params);
// Ajout d'une jointure sur l'instructeur secondaire pour permettre la recherche
// simple par instructeur secondaire
$conf["query_ct_from"] .= sprintf(
    'LEFT JOIN %1$sinstructeur as instructeur_secondaire
        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
    LEFT JOIN %1$som_utilisateur as utilisateur_2
        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur',
    DB_PREFIXE
);
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
$tab_actions['corner']['ajouter']=NULL;

// FROM
$table = $conf["query_ct_from"].$sqlFiltre['FROM'];
// WHERE
$selection = sprintf(
    "WHERE 
        %s
        %s
    ",
    $conf["query_ct_where_common"],
    $sqlFiltre['WHERE']
);

?>
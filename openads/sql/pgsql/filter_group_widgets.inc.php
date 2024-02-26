<?php
/*
 * Ce script permet de d'ajouter aux clauses where des listing ($$query_ct_select) les
 * notions de groupes et de confidentialité.
 * Ce fichier est inclus dans les méthodes suivantes du fichier om_widget.class.php :
 *      - execute_recherche_dossier
 *      - get_config_dossiers_limites
 *      - get_config_dossier_contentieux_recours
 *      - get_config_dossier_contentieux_infraction
 *      - get_config_messages_retours
 *      - get_config_dossiers_evenement_incomplet_majoration
 *      - get_config_dossier_contentieux_contradictoire
 *      - get_config_dossier_contentieux_ait
 *      - get_config_dossier_contentieux_inaffectes
 *      - get_config_dossier_contentieux_alerte_visite
 *      - get_config_dossier_contentieux_alerte_parquet
 *      - get_config_dossier_contentieux_clotures
 *      - get_config_dossier_contentieux_audience
 *      - get_config_derniers_dossiers_deposes
 *      - get_config_dossiers_pre_instruction
 *
 * /!\ Il est peut être inclus mais pas nécessairement utilisé donc à vérifier au cas où !
 *
 * @package openfoncier
 * @version SVN : $Id: filter_group_widgets.inc.php 6565 2017-04-21 16:14:15Z softime $
 */

// Exclusion des sous-dossiers des listings des widgets
$query_ct_where_groupe .= ' AND dossier_instruction_type.sous_dossier IS NOT TRUE';

// Tableau temporaire contenant les clauses pour chaque groupe
$group_clause = array();
foreach ($_SESSION["groupe"] as $key => $value) {
    $group_clause[$key] = "(groupe.code = '".$key."'";
    if($value["confidentiel"] !== true) {
        $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
    }
    $group_clause[$key] .= ")";
}
// Mise en chaîne des clauses
$conditions = implode(" OR ", $group_clause);
if ($conditions !== "") {
    $query_ct_where_groupe .= " AND (".$conditions.")";
}


// Jointures manquantes
if (preg_match("/".DB_PREFIXE."dossier_instruction_type(?!_)/i", $query_ct_from) === 0) {
    $query_ct_from .= "
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
        ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type";
}
if (preg_match("/".DB_PREFIXE."dossier_autorisation(?!_)/i", $query_ct_from) === 0) {
    $query_ct_from .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation
        ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation";
}
if (preg_match("/".DB_PREFIXE."dossier_autorisation_type_detaille(?!_)/i", $query_ct_from) === 0) {
    $query_ct_from .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille";
}
if (preg_match("/".DB_PREFIXE."dossier_autorisation_type(?!_)/i", $query_ct_from) === 0) {
    $query_ct_from .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type";
}
if (preg_match("/".DB_PREFIXE."groupe(?!_)/i", $query_ct_from) === 0) {
    $query_ct_from .= "
    LEFT JOIN ".DB_PREFIXE."groupe
        ON dossier_autorisation_type.groupe = groupe.groupe";
}

?>

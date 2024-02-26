<?php
/*
 * Ce script permet de d'ajouter aux clauses where des listing ($selection) les
 * notions de groupes et de confidentialité.
 * 
 * @package openfoncier
 * @version SVN : $Id: filter_group.inc.php 6565 2017-04-21 16:14:15Z softime $
 */


// Tableau temporaire contenant les clauses pour chaque groupe
$group_clause = array();
foreach ($_SESSION["groupe"] as $key => $value) {
    $group_clause[$key] = "(groupe.code = '".$key."'";
    if($value["confidentiel"] !== true) {
        $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
    }
    $group_clause[$key] .= ")";
}
// Ajout du cas ou le code du groupe est null
$group_clause['EMPTY'] = '(groupe.code IS NULL AND dossier_autorisation_type.confidentiel IS NOT TRUE)';
// Mise en chaîne des clauses
$conditions = implode(" OR ", $group_clause);
if ($conditions !== "") {
    // On ajout le WHERE si il n'est pas présent
    if (stripos($selection, "WHERE") === false) {
        $selection .= "WHERE ";
    } else {
        $selection .= " AND ";
    }

    $selection .= "(".$conditions.")";
}


// Jointures manquantes
if (preg_match("/".DB_PREFIXE."dossier_autorisation(?!_)/i", $table) === 0) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation
        ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation";
}
if (preg_match("/".DB_PREFIXE."dossier_autorisation_type_detaille(?!_)/i", $table) === 0) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille";
}
if (preg_match("/".DB_PREFIXE."dossier_autorisation_type(?!_)/i", $table) === 0) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type";
}
if (preg_match("/".DB_PREFIXE."groupe(?!_)/i", $table) === 0) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."groupe
        ON dossier_autorisation_type.groupe = groupe.groupe";
}

?>

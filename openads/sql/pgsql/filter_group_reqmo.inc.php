<?php
/*
 * Ce script permet de récupérer les notions de groupes et de confidentialité à
 * utiliser dans les requêtes.
 *
 * @package openfoncier
 * @version SVN : $Id: filter_group_reqmo.inc.php 6565 2017-04-21 16:14:15Z softime $
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

// Mise en chaîne des clauses
$selection = " AND ";
$conditions = implode(" OR ", $group_clause);
if ($conditions !== "") {
    //
    $selection .= "(".$conditions.")";
}

// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = ' AND dossier_instruction_type.sous_dossier IS NOT TRUE ';
?>

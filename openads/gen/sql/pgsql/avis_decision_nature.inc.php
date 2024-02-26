<?php
//$Id$ 
//gen openMairie le 12/01/2021 13:14

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("avis_decision_nature");
$om_validite = true;
if(!isset($premier)) $premier='';
if(!isset($tricolsf)) $tricolsf='';
if(!isset($premiersf)) $premiersf='';
if(!isset($selection)) $selection='';
if(!isset($retourformulaire)) $retourformulaire='';
if (!isset($idxformulaire)) {
    $idxformulaire = '';
}
if (!isset($tricol)) {
    $tricol = '';
}
if (!isset($valide)) {
    $valide = '';
}
// FROM 
$table = DB_PREFIXE."avis_decision_nature";
// SELECT 
$champAffiche = array(
    'avis_decision_nature.avis_decision_nature as "'.__("avis_decision_nature").'"',
    'avis_decision_nature.code as "'.__("code").'"',
    'avis_decision_nature.libelle as "'.__("libelle").'"',
    'to_char(avis_decision_nature.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(avis_decision_nature.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'avis_decision_nature.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'avis_decision_nature.avis_decision_nature as "'.__("avis_decision_nature").'"',
    'avis_decision_nature.code as "'.__("code").'"',
    'avis_decision_nature.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY avis_decision_nature.libelle ASC NULLS LAST";
$edition="avis_decision_nature";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((avis_decision_nature.om_validite_debut IS NULL AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE)) OR (avis_decision_nature.om_validite_debut <= CURRENT_DATE AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((avis_decision_nature.om_validite_debut IS NULL AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE)) OR (avis_decision_nature.om_validite_debut <= CURRENT_DATE AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE)))";
// Gestion OMValidité - Suppression du filtre si paramètre
if (isset($_GET["valide"]) and $_GET["valide"] == "false") {
    if (!isset($where_om_validite)
        or (isset($where_om_validite) and $where_om_validite == "")) {
        if (trim($selection) != "") {
            $selection = "";
        }
    } else {
        $selection = trim(str_replace($where_om_validite, "", $selection));
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'avis_decision',
);


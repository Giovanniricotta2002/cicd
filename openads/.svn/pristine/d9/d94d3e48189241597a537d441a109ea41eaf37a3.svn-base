<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("phase");
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
$table = DB_PREFIXE."phase";
// SELECT 
$champAffiche = array(
    'phase.phase as "'.__("phase").'"',
    'phase.code as "'.__("code").'"',
    'to_char(phase.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(phase.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'phase.phase as "'.__("phase").'"',
    'phase.code as "'.__("code").'"',
    );
$tri="ORDER BY phase.code ASC NULLS LAST";
$edition="phase";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((phase.om_validite_debut IS NULL AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE)) OR (phase.om_validite_debut <= CURRENT_DATE AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((phase.om_validite_debut IS NULL AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE)) OR (phase.om_validite_debut <= CURRENT_DATE AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE)))";
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
    'evenement',
);


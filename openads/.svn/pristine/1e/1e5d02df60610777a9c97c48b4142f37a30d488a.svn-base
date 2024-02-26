<?php
//$Id$ 
//gen openMairie le 15/09/2020 13:20

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("region");
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
$table = DB_PREFIXE."region";
// SELECT 
$champAffiche = array(
    'region.region as "'.__("region").'"',
    'region.reg as "'.__("reg").'"',
    'region.cheflieu as "'.__("cheflieu").'"',
    'region.tncc as "'.__("tncc").'"',
    'region.ncc as "'.__("ncc").'"',
    'region.nccenr as "'.__("nccenr").'"',
    'region.libelle as "'.__("libelle").'"',
    'to_char(region.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(region.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'region.region as "'.__("region").'"',
    'region.reg as "'.__("reg").'"',
    'region.cheflieu as "'.__("cheflieu").'"',
    'region.tncc as "'.__("tncc").'"',
    'region.ncc as "'.__("ncc").'"',
    'region.nccenr as "'.__("nccenr").'"',
    'region.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY region.libelle ASC NULLS LAST";
$edition="region";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((region.om_validite_debut IS NULL AND (region.om_validite_fin IS NULL OR region.om_validite_fin > CURRENT_DATE)) OR (region.om_validite_debut <= CURRENT_DATE AND (region.om_validite_fin IS NULL OR region.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((region.om_validite_debut IS NULL AND (region.om_validite_fin IS NULL OR region.om_validite_fin > CURRENT_DATE)) OR (region.om_validite_debut <= CURRENT_DATE AND (region.om_validite_fin IS NULL OR region.om_validite_fin > CURRENT_DATE)))";
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


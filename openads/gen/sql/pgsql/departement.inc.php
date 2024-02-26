<?php
//$Id$ 
//gen openMairie le 15/09/2020 13:20

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("departement");
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
$table = DB_PREFIXE."departement";
// SELECT 
$champAffiche = array(
    'departement.departement as "'.__("departement").'"',
    'departement.dep as "'.__("dep").'"',
    'departement.reg as "'.__("reg").'"',
    'departement.cheflieu as "'.__("cheflieu").'"',
    'departement.tncc as "'.__("tncc").'"',
    'departement.ncc as "'.__("ncc").'"',
    'departement.nccenr as "'.__("nccenr").'"',
    'departement.libelle as "'.__("libelle").'"',
    'to_char(departement.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(departement.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'departement.departement as "'.__("departement").'"',
    'departement.dep as "'.__("dep").'"',
    'departement.reg as "'.__("reg").'"',
    'departement.cheflieu as "'.__("cheflieu").'"',
    'departement.tncc as "'.__("tncc").'"',
    'departement.ncc as "'.__("ncc").'"',
    'departement.nccenr as "'.__("nccenr").'"',
    'departement.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY departement.libelle ASC NULLS LAST";
$edition="departement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((departement.om_validite_debut IS NULL AND (departement.om_validite_fin IS NULL OR departement.om_validite_fin > CURRENT_DATE)) OR (departement.om_validite_debut <= CURRENT_DATE AND (departement.om_validite_fin IS NULL OR departement.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((departement.om_validite_debut IS NULL AND (departement.om_validite_fin IS NULL OR departement.om_validite_fin > CURRENT_DATE)) OR (departement.om_validite_debut <= CURRENT_DATE AND (departement.om_validite_fin IS NULL OR departement.om_validite_fin > CURRENT_DATE)))";
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


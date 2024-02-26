<?php
//$Id$ 
//gen openMairie le 26/04/2021 12:59

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("avis_consultation");
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
$table = DB_PREFIXE."avis_consultation";
// SELECT 
$champAffiche = array(
    'avis_consultation.avis_consultation as "'.__("avis_consultation").'"',
    'avis_consultation.libelle as "'.__("libelle").'"',
    'avis_consultation.abrege as "'.__("abrege").'"',
    'to_char(avis_consultation.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(avis_consultation.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'avis_consultation.code as "'.__("code").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'avis_consultation.avis_consultation as "'.__("avis_consultation").'"',
    'avis_consultation.libelle as "'.__("libelle").'"',
    'avis_consultation.abrege as "'.__("abrege").'"',
    'avis_consultation.code as "'.__("code").'"',
    );
$tri="ORDER BY avis_consultation.libelle ASC NULLS LAST";
$edition="avis_consultation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((avis_consultation.om_validite_debut IS NULL AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE)) OR (avis_consultation.om_validite_debut <= CURRENT_DATE AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((avis_consultation.om_validite_debut IS NULL AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE)) OR (avis_consultation.om_validite_debut <= CURRENT_DATE AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE)))";
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
    'consultation',
);


<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("commune");
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
$table = DB_PREFIXE."commune";
// SELECT 
$champAffiche = array(
    'commune.commune as "'.__("commune").'"',
    'commune.typecom as "'.__("typecom").'"',
    'commune.com as "'.__("com").'"',
    'commune.reg as "'.__("reg").'"',
    'commune.dep as "'.__("dep").'"',
    'commune.arr as "'.__("arr").'"',
    'commune.tncc as "'.__("tncc").'"',
    'commune.ncc as "'.__("ncc").'"',
    'commune.nccenr as "'.__("nccenr").'"',
    'commune.libelle as "'.__("libelle").'"',
    'commune.can as "'.__("can").'"',
    'commune.comparent as "'.__("comparent").'"',
    'to_char(commune.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(commune.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'commune.commune as "'.__("commune").'"',
    'commune.typecom as "'.__("typecom").'"',
    'commune.com as "'.__("com").'"',
    'commune.reg as "'.__("reg").'"',
    'commune.dep as "'.__("dep").'"',
    'commune.arr as "'.__("arr").'"',
    'commune.tncc as "'.__("tncc").'"',
    'commune.ncc as "'.__("ncc").'"',
    'commune.nccenr as "'.__("nccenr").'"',
    'commune.libelle as "'.__("libelle").'"',
    'commune.can as "'.__("can").'"',
    'commune.comparent as "'.__("comparent").'"',
    );
$tri="ORDER BY commune.libelle ASC NULLS LAST";
$edition="commune";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((commune.om_validite_debut IS NULL AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)) OR (commune.om_validite_debut <= CURRENT_DATE AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((commune.om_validite_debut IS NULL AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)) OR (commune.om_validite_debut <= CURRENT_DATE AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)))";
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
    'demande',
    'dossier',
    'dossier_autorisation',
    'lien_habilitation_tiers_consulte_commune',
);


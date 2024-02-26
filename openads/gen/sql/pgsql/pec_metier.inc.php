<?php
//$Id$ 
//gen openMairie le 05/01/2021 11:06

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("pec_metier");
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
$table = DB_PREFIXE."pec_metier";
// SELECT 
$champAffiche = array(
    'pec_metier.pec_metier as "'.__("pec_metier").'"',
    'pec_metier.code as "'.__("code").'"',
    'pec_metier.libelle as "'.__("libelle").'"',
    'to_char(pec_metier.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(pec_metier.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'pec_metier.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'pec_metier.pec_metier as "'.__("pec_metier").'"',
    'pec_metier.code as "'.__("code").'"',
    'pec_metier.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY pec_metier.libelle ASC NULLS LAST";
$edition="pec_metier";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((pec_metier.om_validite_debut IS NULL AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)) OR (pec_metier.om_validite_debut <= CURRENT_DATE AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((pec_metier.om_validite_debut IS NULL AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)) OR (pec_metier.om_validite_debut <= CURRENT_DATE AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)))";
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
    'dossier',
    'evenement',
    'instruction',
);


<?php
//$Id$ 
//gen openMairie le 10/02/2022 17:20

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("signataire_habilitation");
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
$table = DB_PREFIXE."signataire_habilitation";
// SELECT 
$champAffiche = array(
    'signataire_habilitation.signataire_habilitation as "'.__("signataire_habilitation").'"',
    'signataire_habilitation.libelle as "'.__("libelle").'"',
    'signataire_habilitation.code as "'.__("code").'"',
    'signataire_habilitation.description as "'.__("description").'"',
    'to_char(signataire_habilitation.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(signataire_habilitation.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'signataire_habilitation.signataire_habilitation as "'.__("signataire_habilitation").'"',
    'signataire_habilitation.libelle as "'.__("libelle").'"',
    'signataire_habilitation.code as "'.__("code").'"',
    'signataire_habilitation.description as "'.__("description").'"',
    );
$tri="ORDER BY signataire_habilitation.libelle ASC NULLS LAST";
$edition="signataire_habilitation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((signataire_habilitation.om_validite_debut IS NULL AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE)) OR (signataire_habilitation.om_validite_debut <= CURRENT_DATE AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((signataire_habilitation.om_validite_debut IS NULL AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE)) OR (signataire_habilitation.om_validite_debut <= CURRENT_DATE AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE)))";
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
    'signataire_arrete',
);


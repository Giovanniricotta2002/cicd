<?php
//$Id$ 
//gen openMairie le 27/07/2021 12:19

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("document_numerise_nature");
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
$table = DB_PREFIXE."document_numerise_nature";
// SELECT 
$champAffiche = array(
    'document_numerise_nature.document_numerise_nature as "'.__("document_numerise_nature").'"',
    'document_numerise_nature.code as "'.__("code").'"',
    'document_numerise_nature.libelle as "'.__("libelle").'"',
    'to_char(document_numerise_nature.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(document_numerise_nature.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'document_numerise_nature.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'document_numerise_nature.document_numerise_nature as "'.__("document_numerise_nature").'"',
    'document_numerise_nature.code as "'.__("code").'"',
    'document_numerise_nature.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY document_numerise_nature.libelle ASC NULLS LAST";
$edition="document_numerise_nature";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((document_numerise_nature.om_validite_debut IS NULL AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE)) OR (document_numerise_nature.om_validite_debut <= CURRENT_DATE AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((document_numerise_nature.om_validite_debut IS NULL AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE)) OR (document_numerise_nature.om_validite_debut <= CURRENT_DATE AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE)))";
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
    'document_numerise',
);


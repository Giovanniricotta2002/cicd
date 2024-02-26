<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("division");
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
$table = DB_PREFIXE."division
    LEFT JOIN ".DB_PREFIXE."direction 
        ON division.direction=direction.direction ";
// SELECT 
$champAffiche = array(
    'division.division as "'.__("division").'"',
    'division.code as "'.__("code").'"',
    'division.libelle as "'.__("libelle").'"',
    'division.chef as "'.__("chef").'"',
    'direction.libelle as "'.__("direction").'"',
    'to_char(division.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(division.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'division.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'division.division as "'.__("division").'"',
    'division.code as "'.__("code").'"',
    'division.libelle as "'.__("libelle").'"',
    'division.chef as "'.__("chef").'"',
    'direction.libelle as "'.__("direction").'"',
    );
$tri="ORDER BY division.libelle ASC NULLS LAST";
$edition="division";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "direction" => array("direction", ),
);
// Filtre listing sous formulaire - direction
if (in_array($retourformulaire, $foreign_keys_extended["direction"])) {
    $selection = " WHERE (division.direction = ".intval($idxformulaire).")  AND ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)))";
}
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
    'instructeur',
);


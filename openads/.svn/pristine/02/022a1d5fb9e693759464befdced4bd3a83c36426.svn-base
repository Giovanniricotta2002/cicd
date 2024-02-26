<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("direction");
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
$table = DB_PREFIXE."direction
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON direction.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'direction.direction as "'.__("direction").'"',
    'direction.code as "'.__("code").'"',
    'direction.libelle as "'.__("libelle").'"',
    'direction.chef as "'.__("chef").'"',
    'to_char(direction.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(direction.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'direction.description as "'.__("description").'"',
    'direction.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'direction.direction as "'.__("direction").'"',
    'direction.code as "'.__("code").'"',
    'direction.libelle as "'.__("libelle").'"',
    'direction.chef as "'.__("chef").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY direction.libelle ASC NULLS LAST";
$edition="direction";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (direction.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (direction.om_collectivite = ".intval($idxformulaire).")  AND ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (direction.om_collectivite = '".$_SESSION["collectivite"]."') AND (direction.om_collectivite = ".intval($idxformulaire).")  AND ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)))";
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
    'division',
);


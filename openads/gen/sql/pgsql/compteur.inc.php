<?php
//$Id$ 
//gen openMairie le 20/10/2022 18:07

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("compteur");
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
$table = DB_PREFIXE."compteur
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON compteur.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'compteur.compteur as "'.__("compteur").'"',
    'compteur.code as "'.__("code").'"',
    'compteur.description as "'.__("description").'"',
    'compteur.unite as "'.__("unite").'"',
    'compteur.quantite as "'.__("quantite").'"',
    'compteur.quota as "'.__("quota").'"',
    'compteur.alerte as "'.__("alerte").'"',
    'compteur.date_modification as "'.__("date_modification").'"',
    'to_char(compteur.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(compteur.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'compteur.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'compteur.compteur as "'.__("compteur").'"',
    'compteur.code as "'.__("code").'"',
    'compteur.description as "'.__("description").'"',
    'compteur.unite as "'.__("unite").'"',
    'compteur.quantite as "'.__("quantite").'"',
    'compteur.quota as "'.__("quota").'"',
    'compteur.alerte as "'.__("alerte").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY compteur.code ASC NULLS LAST";
$edition="compteur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (compteur.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (compteur.om_collectivite = ".intval($idxformulaire).")  AND ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (compteur.om_collectivite = '".$_SESSION["collectivite"]."') AND (compteur.om_collectivite = ".intval($idxformulaire).")  AND ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((compteur.om_validite_debut IS NULL AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)) OR (compteur.om_validite_debut <= CURRENT_DATE AND (compteur.om_validite_fin IS NULL OR compteur.om_validite_fin > CURRENT_DATE)))";
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


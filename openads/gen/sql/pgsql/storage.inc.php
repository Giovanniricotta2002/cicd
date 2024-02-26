<?php
//$Id: storage.inc.php 10573 2021-10-14 12:43:35Z softime $ 
//gen openMairie le 30/09/2021 16:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("storage");
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
$table = DB_PREFIXE."storage
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON storage.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'storage.storage as "'.__("storage").'"',
    'to_char(storage.creation_date ,\'DD/MM/YYYY\') as "'.__("creation_date").'"',
    'storage.creation_time as "'.__("creation_time").'"',
    'storage.uid as "'.__("uid").'"',
    'storage.filename as "'.__("filename").'"',
    'storage.size as "'.__("size").'"',
    'storage.mimetype as "'.__("mimetype").'"',
    'storage.type as "'.__("type").'"',
    "case storage.uid_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("uid_dossier_final")."\"",
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'storage.info as "'.__("info").'"',
    'storage.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'storage.storage as "'.__("storage").'"',
    'storage.uid as "'.__("uid").'"',
    'storage.filename as "'.__("filename").'"',
    'storage.size as "'.__("size").'"',
    'storage.mimetype as "'.__("mimetype").'"',
    'storage.type as "'.__("type").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY storage.creation_date ASC NULLS LAST";
$edition="storage";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (storage.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (storage.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (storage.om_collectivite = '".$_SESSION["collectivite"]."') AND (storage.om_collectivite = ".intval($idxformulaire).") ";
    }
}


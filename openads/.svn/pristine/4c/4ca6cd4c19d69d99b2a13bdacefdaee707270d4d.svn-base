<?php
//$Id$ 
//gen openMairie le 26/11/2019 18:30

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("num_dossier");
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
$table = DB_PREFIXE."num_dossier
    LEFT JOIN ".DB_PREFIXE."num_bordereau 
        ON num_dossier.num_bordereau=num_bordereau.num_bordereau 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON num_dossier.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'num_dossier.num_dossier as "'.__("num_dossier").'"',
    'num_dossier.ref as "'.__("ref").'"',
    'num_dossier.code as "'.__("code").'"',
    'num_dossier.petition as "'.__("petition").'"',
    'num_dossier.total_pages as "'.__("total_pages").'"',
    'num_dossier.pa3a4 as "'.__("pa3a4").'"',
    'num_dossier.pa0 as "'.__("pa0").'"',
    'to_char(num_dossier.date_depot ,\'DD/MM/YYYY\') as "'.__("date_depot").'"',
    'num_bordereau.libelle as "'.__("num_bordereau").'"',
    'to_char(num_dossier.datenum ,\'DD/MM/YYYY\') as "'.__("datenum").'"',
    'num_dossier.num_commande as "'.__("num_commande").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'num_dossier.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'num_dossier.num_dossier as "'.__("num_dossier").'"',
    'num_dossier.ref as "'.__("ref").'"',
    'num_dossier.code as "'.__("code").'"',
    'num_dossier.petition as "'.__("petition").'"',
    'num_dossier.total_pages as "'.__("total_pages").'"',
    'num_dossier.pa3a4 as "'.__("pa3a4").'"',
    'num_dossier.pa0 as "'.__("pa0").'"',
    'num_bordereau.libelle as "'.__("num_bordereau").'"',
    'num_dossier.num_commande as "'.__("num_commande").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY num_dossier.ref ASC NULLS LAST";
$edition="num_dossier";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (num_dossier.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "num_bordereau" => array("num_bordereau", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - num_bordereau
if (in_array($retourformulaire, $foreign_keys_extended["num_bordereau"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (num_dossier.num_bordereau = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (num_dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (num_dossier.num_bordereau = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (num_dossier.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (num_dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (num_dossier.om_collectivite = ".intval($idxformulaire).") ";
    }
}


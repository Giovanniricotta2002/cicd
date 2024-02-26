<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_sig_contrainte_om_collectivite");
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
$table = DB_PREFIXE."lien_sig_contrainte_om_collectivite
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON lien_sig_contrainte_om_collectivite.om_collectivite=om_collectivite.om_collectivite 
    LEFT JOIN ".DB_PREFIXE."sig_contrainte 
        ON lien_sig_contrainte_om_collectivite.sig_contrainte=sig_contrainte.sig_contrainte ";
// SELECT 
$champAffiche = array(
    'lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite as "'.__("lien_sig_contrainte_om_collectivite").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'lien_sig_contrainte_om_collectivite.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite as "'.__("lien_sig_contrainte_om_collectivite").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY sig_contrainte.libelle ASC NULLS LAST";
$edition="lien_sig_contrainte_om_collectivite";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (lien_sig_contrainte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
    "sig_contrainte" => array("sig_contrainte", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_sig_contrainte_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_sig_contrainte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_sig_contrainte_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - sig_contrainte
if (in_array($retourformulaire, $foreign_keys_extended["sig_contrainte"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_sig_contrainte_om_collectivite.sig_contrainte = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_sig_contrainte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_sig_contrainte_om_collectivite.sig_contrainte = ".intval($idxformulaire).") ";
    }
}


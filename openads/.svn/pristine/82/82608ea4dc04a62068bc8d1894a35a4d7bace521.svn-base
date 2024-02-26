<?php
//$Id$ 
//gen openMairie le 25/02/2022 15:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_categorie_tiers_consulte_om_collectivite");
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
$table = DB_PREFIXE."lien_categorie_tiers_consulte_om_collectivite
    LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte 
        ON lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte=categorie_tiers_consulte.categorie_tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON lien_categorie_tiers_consulte_om_collectivite.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite as "'.__("lien_categorie_tiers_consulte_om_collectivite").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'lien_categorie_tiers_consulte_om_collectivite.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite as "'.__("lien_categorie_tiers_consulte_om_collectivite").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY categorie_tiers_consulte.libelle ASC NULLS LAST";
$edition="lien_categorie_tiers_consulte_om_collectivite";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - categorie_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["categorie_tiers_consulte"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    }
}


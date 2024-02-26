<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("bible");
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
$table = DB_PREFIXE."bible
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type 
        ON bible.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type 
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON bible.evenement=evenement.evenement 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON bible.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'bible.bible as "'.__("bible").'"',
    'bible.libelle as "'.__("libelle").'"',
    'evenement.libelle as "'.__("evenement").'"',
    'bible.complement as "'.__("complement").'"',
    'bible.automatique as "'.__("automatique").'"',
    'dossier_autorisation_type.libelle as "'.__("dossier_autorisation_type").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'bible.contenu as "'.__("contenu").'"',
    'bible.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'bible.bible as "'.__("bible").'"',
    'bible.libelle as "'.__("libelle").'"',
    'evenement.libelle as "'.__("evenement").'"',
    'bible.complement as "'.__("complement").'"',
    'bible.automatique as "'.__("automatique").'"',
    'dossier_autorisation_type.libelle as "'.__("dossier_autorisation_type").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY bible.libelle ASC NULLS LAST";
$edition="bible";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (bible.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_autorisation_type" => array("dossier_autorisation_type", ),
    "evenement" => array("evenement", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - dossier_autorisation_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (bible.dossier_autorisation_type = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (bible.om_collectivite = '".$_SESSION["collectivite"]."') AND (bible.dossier_autorisation_type = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (bible.evenement = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (bible.om_collectivite = '".$_SESSION["collectivite"]."') AND (bible.evenement = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (bible.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (bible.om_collectivite = '".$_SESSION["collectivite"]."') AND (bible.om_collectivite = ".intval($idxformulaire).") ";
    }
}


<?php
//$Id$ 
//gen openMairie le 25/02/2022 15:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_motif_consultation_om_collectivite");
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
$table = DB_PREFIXE."lien_motif_consultation_om_collectivite
    LEFT JOIN ".DB_PREFIXE."motif_consultation 
        ON lien_motif_consultation_om_collectivite.motif_consultation=motif_consultation.motif_consultation 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON lien_motif_consultation_om_collectivite.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite as "'.__("lien_motif_consultation_om_collectivite").'"',
    'motif_consultation.libelle as "'.__("motif_consultation").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'lien_motif_consultation_om_collectivite.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite as "'.__("lien_motif_consultation_om_collectivite").'"',
    'motif_consultation.libelle as "'.__("motif_consultation").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY motif_consultation.libelle ASC NULLS LAST";
$edition="lien_motif_consultation_om_collectivite";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (lien_motif_consultation_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "motif_consultation" => array("motif_consultation", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - motif_consultation
if (in_array($retourformulaire, $foreign_keys_extended["motif_consultation"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_motif_consultation_om_collectivite.motif_consultation = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_motif_consultation_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_motif_consultation_om_collectivite.motif_consultation = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (lien_motif_consultation_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (lien_motif_consultation_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') AND (lien_motif_consultation_om_collectivite.om_collectivite = ".intval($idxformulaire).") ";
    }
}


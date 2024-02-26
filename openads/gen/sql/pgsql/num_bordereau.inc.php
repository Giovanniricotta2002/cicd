<?php
//$Id$ 
//gen openMairie le 26/11/2019 18:30

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("num_bordereau");
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
$table = DB_PREFIXE."num_bordereau
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON num_bordereau.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'num_bordereau.num_bordereau as "'.__("num_bordereau").'"',
    'num_bordereau.libelle as "'.__("libelle").'"',
    'to_char(num_bordereau.envoi ,\'DD/MM/YYYY\') as "'.__("envoi").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'num_bordereau.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'num_bordereau.num_bordereau as "'.__("num_bordereau").'"',
    'num_bordereau.libelle as "'.__("libelle").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY num_bordereau.libelle ASC NULLS LAST";
$edition="num_bordereau";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (num_bordereau.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (num_bordereau.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (num_bordereau.om_collectivite = '".$_SESSION["collectivite"]."') AND (num_bordereau.om_collectivite = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'num_dossier',
);


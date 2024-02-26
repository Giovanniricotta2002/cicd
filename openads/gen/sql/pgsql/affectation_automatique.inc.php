<?php
//$Id$ 
//gen openMairie le 15/09/2020 17:28

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("affectation_automatique");
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
$table = DB_PREFIXE."affectation_automatique
    LEFT JOIN ".DB_PREFIXE."arrondissement 
        ON affectation_automatique.arrondissement=arrondissement.arrondissement 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON affectation_automatique.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON affectation_automatique.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."instructeur as instructeur3 
        ON affectation_automatique.instructeur=instructeur3.instructeur 
    LEFT JOIN ".DB_PREFIXE."instructeur as instructeur4 
        ON affectation_automatique.instructeur_2=instructeur4.instructeur 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON affectation_automatique.om_collectivite=om_collectivite.om_collectivite 
    LEFT JOIN ".DB_PREFIXE."quartier 
        ON affectation_automatique.quartier=quartier.quartier ";
// SELECT 
$champAffiche = array(
    'affectation_automatique.affectation_automatique as "'.__("affectation_automatique").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'quartier.libelle as "'.__("quartier").'"',
    'affectation_automatique.section as "'.__("section").'"',
    'instructeur3.nom as "'.__("instructeur").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'instructeur4.nom as "'.__("instructeur_2").'"',
    'affectation_automatique.communes as "'.__("communes").'"',
    'affectation_automatique.affectation_manuelle as "'.__("affectation_manuelle").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'affectation_automatique.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'affectation_automatique.affectation_automatique as "'.__("affectation_automatique").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'quartier.libelle as "'.__("quartier").'"',
    'affectation_automatique.section as "'.__("section").'"',
    'instructeur3.nom as "'.__("instructeur").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'instructeur4.nom as "'.__("instructeur_2").'"',
    'affectation_automatique.communes as "'.__("communes").'"',
    'affectation_automatique.affectation_manuelle as "'.__("affectation_manuelle").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY arrondissement.libelle ASC NULLS LAST";
$edition="affectation_automatique";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "arrondissement" => array("arrondissement", ),
    "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "instructeur" => array("instructeur", ),
    "om_collectivite" => array("om_collectivite", ),
    "quartier" => array("quartier", ),
);
// Filtre listing sous formulaire - arrondissement
if (in_array($retourformulaire, $foreign_keys_extended["arrondissement"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.arrondissement = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.arrondissement = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier_autorisation_type_detaille
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type_detaille"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.dossier_instruction_type = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.dossier_instruction_type = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - instructeur
if (in_array($retourformulaire, $foreign_keys_extended["instructeur"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.instructeur = ".intval($idxformulaire)." OR affectation_automatique.instructeur_2 = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.instructeur = ".intval($idxformulaire)." OR affectation_automatique.instructeur_2 = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.om_collectivite = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - quartier
if (in_array($retourformulaire, $foreign_keys_extended["quartier"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (affectation_automatique.quartier = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (affectation_automatique.om_collectivite = '".$_SESSION["collectivite"]."') AND (affectation_automatique.quartier = ".intval($idxformulaire).") ";
    }
}


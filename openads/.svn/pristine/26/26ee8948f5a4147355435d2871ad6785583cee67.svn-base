<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("transition");
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
$table = DB_PREFIXE."transition
    LEFT JOIN ".DB_PREFIXE."etat 
        ON transition.etat=etat.etat 
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON transition.evenement=evenement.evenement ";
// SELECT 
$champAffiche = array(
    'transition.transition as "'.__("transition").'"',
    'etat.libelle as "'.__("etat").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'transition.transition as "'.__("transition").'"',
    'etat.libelle as "'.__("etat").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
$tri="ORDER BY etat.libelle ASC NULLS LAST";
$edition="transition";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "etat" => array("etat", ),
    "evenement" => array("evenement", ),
);
// Filtre listing sous formulaire - etat
if (in_array($retourformulaire, $foreign_keys_extended["etat"])) {
    $selection = " WHERE (transition.etat = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (transition.evenement = ".intval($idxformulaire).") ";
}


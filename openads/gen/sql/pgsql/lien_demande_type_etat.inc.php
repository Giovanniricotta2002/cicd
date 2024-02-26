<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_demande_type_etat");
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
$table = DB_PREFIXE."lien_demande_type_etat
    LEFT JOIN ".DB_PREFIXE."demande_type 
        ON lien_demande_type_etat.demande_type=demande_type.demande_type 
    LEFT JOIN ".DB_PREFIXE."etat 
        ON lien_demande_type_etat.etat=etat.etat ";
// SELECT 
$champAffiche = array(
    'lien_demande_type_etat.lien_demande_type_etat as "'.__("lien_demande_type_etat").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'etat.libelle as "'.__("etat").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_demande_type_etat.lien_demande_type_etat as "'.__("lien_demande_type_etat").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'etat.libelle as "'.__("etat").'"',
    );
$tri="ORDER BY demande_type.libelle ASC NULLS LAST";
$edition="lien_demande_type_etat";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demande_type" => array("demande_type", ),
    "etat" => array("etat", ),
);
// Filtre listing sous formulaire - demande_type
if (in_array($retourformulaire, $foreign_keys_extended["demande_type"])) {
    $selection = " WHERE (lien_demande_type_etat.demande_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - etat
if (in_array($retourformulaire, $foreign_keys_extended["etat"])) {
    $selection = " WHERE (lien_demande_type_etat.etat = '".$f->db->escapeSimple($idxformulaire)."') ";
}


<?php
//$Id$ 
//gen openMairie le 25/02/2022 15:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_habilitation_tiers_consulte_specialite_tiers_consulte");
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
$table = DB_PREFIXE."lien_habilitation_tiers_consulte_specialite_tiers_consulte
    LEFT JOIN ".DB_PREFIXE."habilitation_tiers_consulte 
        ON lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte=habilitation_tiers_consulte.habilitation_tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."specialite_tiers_consulte 
        ON lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte=specialite_tiers_consulte.specialite_tiers_consulte ";
// SELECT 
$champAffiche = array(
    'lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte as "'.__("lien_habilitation_tiers_consulte_specialite_tiers_consulte").'"',
    'habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'specialite_tiers_consulte.libelle as "'.__("specialite_tiers_consulte").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte as "'.__("lien_habilitation_tiers_consulte_specialite_tiers_consulte").'"',
    'habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'specialite_tiers_consulte.libelle as "'.__("specialite_tiers_consulte").'"',
    );
$tri="ORDER BY habilitation_tiers_consulte.type_habilitation_tiers_consulte ASC NULLS LAST";
$edition="lien_habilitation_tiers_consulte_specialite_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "habilitation_tiers_consulte" => array("habilitation_tiers_consulte", ),
    "specialite_tiers_consulte" => array("specialite_tiers_consulte", ),
);
// Filtre listing sous formulaire - habilitation_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["habilitation_tiers_consulte"])) {
    $selection = " WHERE (lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - specialite_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["specialite_tiers_consulte"])) {
    $selection = " WHERE (lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte = ".intval($idxformulaire).") ";
}


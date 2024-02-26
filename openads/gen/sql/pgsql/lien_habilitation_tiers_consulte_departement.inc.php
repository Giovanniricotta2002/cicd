<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_habilitation_tiers_consulte_departement");
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
$table = DB_PREFIXE."lien_habilitation_tiers_consulte_departement
    LEFT JOIN ".DB_PREFIXE."departement 
        ON lien_habilitation_tiers_consulte_departement.departement=departement.departement 
    LEFT JOIN ".DB_PREFIXE."habilitation_tiers_consulte 
        ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte=habilitation_tiers_consulte.habilitation_tiers_consulte ";
// SELECT 
$champAffiche = array(
    'lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement as "'.__("lien_habilitation_tiers_consulte_departement").'"',
    'habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'departement.libelle as "'.__("departement").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement as "'.__("lien_habilitation_tiers_consulte_departement").'"',
    'habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'departement.libelle as "'.__("departement").'"',
    );
$tri="ORDER BY habilitation_tiers_consulte.type_habilitation_tiers_consulte ASC NULLS LAST";
$edition="lien_habilitation_tiers_consulte_departement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "departement" => array("departement", ),
    "habilitation_tiers_consulte" => array("habilitation_tiers_consulte", ),
);
// Filtre listing sous formulaire - departement
if (in_array($retourformulaire, $foreign_keys_extended["departement"])) {
    $selection = " WHERE (lien_habilitation_tiers_consulte_departement.departement = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - habilitation_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["habilitation_tiers_consulte"])) {
    $selection = " WHERE (lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = ".intval($idxformulaire).") ";
}


<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("quartier");
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
$table = DB_PREFIXE."quartier
    LEFT JOIN ".DB_PREFIXE."arrondissement 
        ON quartier.arrondissement=arrondissement.arrondissement ";
// SELECT 
$champAffiche = array(
    'quartier.quartier as "'.__("quartier").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'quartier.code_impots as "'.__("code_impots").'"',
    'quartier.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'quartier.quartier as "'.__("quartier").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'quartier.code_impots as "'.__("code_impots").'"',
    'quartier.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY quartier.libelle ASC NULLS LAST";
$edition="quartier";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "arrondissement" => array("arrondissement", ),
);
// Filtre listing sous formulaire - arrondissement
if (in_array($retourformulaire, $foreign_keys_extended["arrondissement"])) {
    $selection = " WHERE (quartier.arrondissement = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'affectation_automatique',
    'dossier',
);


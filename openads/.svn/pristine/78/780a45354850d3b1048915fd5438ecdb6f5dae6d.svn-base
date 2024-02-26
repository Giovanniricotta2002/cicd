<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("demande_nature");
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
$table = DB_PREFIXE."demande_nature";
// SELECT 
$champAffiche = array(
    'demande_nature.demande_nature as "'.__("demande_nature").'"',
    'demande_nature.code as "'.__("code").'"',
    'demande_nature.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    'demande_nature.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'demande_nature.demande_nature as "'.__("demande_nature").'"',
    'demande_nature.code as "'.__("code").'"',
    'demande_nature.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY demande_nature.libelle ASC NULLS LAST";
$edition="demande_nature";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'demande_type',
);


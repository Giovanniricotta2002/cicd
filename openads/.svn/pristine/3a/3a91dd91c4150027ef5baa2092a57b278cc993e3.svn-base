<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("arrondissement");
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
$table = DB_PREFIXE."arrondissement";
// SELECT 
$champAffiche = array(
    'arrondissement.arrondissement as "'.__("arrondissement").'"',
    'arrondissement.libelle as "'.__("libelle").'"',
    'arrondissement.code_postal as "'.__("code_postal").'"',
    'arrondissement.code_impots as "'.__("code_impots").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'arrondissement.arrondissement as "'.__("arrondissement").'"',
    'arrondissement.libelle as "'.__("libelle").'"',
    'arrondissement.code_postal as "'.__("code_postal").'"',
    'arrondissement.code_impots as "'.__("code_impots").'"',
    );
$tri="ORDER BY arrondissement.libelle ASC NULLS LAST";
$edition="arrondissement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'affectation_automatique',
    'demande',
    'dossier_autorisation',
    'quartier',
);


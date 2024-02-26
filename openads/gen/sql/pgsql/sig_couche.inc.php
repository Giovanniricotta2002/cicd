<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("sig_couche");
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
$table = DB_PREFIXE."sig_couche";
// SELECT 
$champAffiche = array(
    'sig_couche.sig_couche as "'.__("sig_couche").'"',
    'sig_couche.libelle as "'.__("libelle").'"',
    'sig_couche.id_couche as "'.__("id_couche").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'sig_couche.sig_couche as "'.__("sig_couche").'"',
    'sig_couche.libelle as "'.__("libelle").'"',
    'sig_couche.id_couche as "'.__("id_couche").'"',
    );
$tri="ORDER BY sig_couche.libelle ASC NULLS LAST";
$edition="sig_couche";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'sig_attribut',
    'sig_contrainte',
);


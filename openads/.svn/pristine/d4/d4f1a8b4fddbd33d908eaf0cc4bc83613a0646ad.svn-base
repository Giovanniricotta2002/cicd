<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("sig_sousgroupe");
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
$table = DB_PREFIXE."sig_sousgroupe";
// SELECT 
$champAffiche = array(
    'sig_sousgroupe.sig_sousgroupe as "'.__("sig_sousgroupe").'"',
    'sig_sousgroupe.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'sig_sousgroupe.sig_sousgroupe as "'.__("sig_sousgroupe").'"',
    'sig_sousgroupe.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY sig_sousgroupe.libelle ASC NULLS LAST";
$edition="sig_sousgroupe";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'sig_contrainte',
);


<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("sig_groupe");
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
$table = DB_PREFIXE."sig_groupe";
// SELECT 
$champAffiche = array(
    'sig_groupe.sig_groupe as "'.__("sig_groupe").'"',
    'sig_groupe.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'sig_groupe.sig_groupe as "'.__("sig_groupe").'"',
    'sig_groupe.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY sig_groupe.libelle ASC NULLS LAST";
$edition="sig_groupe";
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


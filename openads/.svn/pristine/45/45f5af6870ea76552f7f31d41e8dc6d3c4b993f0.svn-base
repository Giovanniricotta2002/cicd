<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("genre");
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
$table = DB_PREFIXE."genre";
// SELECT 
$champAffiche = array(
    'genre.genre as "'.__("genre").'"',
    'genre.code as "'.__("code").'"',
    'genre.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    'genre.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'genre.genre as "'.__("genre").'"',
    'genre.code as "'.__("code").'"',
    'genre.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY genre.libelle ASC NULLS LAST";
$edition="genre";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'groupe',
);


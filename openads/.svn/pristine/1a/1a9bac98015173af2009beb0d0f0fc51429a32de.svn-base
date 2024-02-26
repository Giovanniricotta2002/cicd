<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("autorite_competente");
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
$table = DB_PREFIXE."autorite_competente";
// SELECT 
$champAffiche = array(
    'autorite_competente.autorite_competente as "'.__("autorite_competente").'"',
    'autorite_competente.code as "'.__("code").'"',
    'autorite_competente.libelle as "'.__("libelle").'"',
    'autorite_competente.autorite_competente_sitadel as "'.__("autorite_competente_sitadel").'"',
    );
//
$champNonAffiche = array(
    'autorite_competente.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'autorite_competente.autorite_competente as "'.__("autorite_competente").'"',
    'autorite_competente.code as "'.__("code").'"',
    'autorite_competente.libelle as "'.__("libelle").'"',
    'autorite_competente.autorite_competente_sitadel as "'.__("autorite_competente_sitadel").'"',
    );
$tri="ORDER BY autorite_competente.libelle ASC NULLS LAST";
$edition="autorite_competente";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'dossier',
    'evenement',
    'instruction',
);


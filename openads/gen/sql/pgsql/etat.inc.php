<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("etat");
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
$table = DB_PREFIXE."etat";
// SELECT 
$champAffiche = array(
    'etat.etat as "'.__("etat").'"',
    'etat.libelle as "'.__("libelle").'"',
    'etat.statut as "'.__("statut").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'etat.etat as "'.__("etat").'"',
    'etat.libelle as "'.__("libelle").'"',
    'etat.statut as "'.__("statut").'"',
    );
$tri="ORDER BY etat.libelle ASC NULLS LAST";
$edition="etat";
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
    'lien_demande_type_etat',
    'transition',
);


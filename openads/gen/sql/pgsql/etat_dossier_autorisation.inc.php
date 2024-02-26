<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("etat_dossier_autorisation");
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
$table = DB_PREFIXE."etat_dossier_autorisation";
// SELECT 
$champAffiche = array(
    'etat_dossier_autorisation.etat_dossier_autorisation as "'.__("etat_dossier_autorisation").'"',
    'etat_dossier_autorisation.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'etat_dossier_autorisation.etat_dossier_autorisation as "'.__("etat_dossier_autorisation").'"',
    'etat_dossier_autorisation.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY etat_dossier_autorisation.libelle ASC NULLS LAST";
$edition="etat_dossier_autorisation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'dossier_autorisation',
);


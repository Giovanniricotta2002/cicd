<?php
//$Id$ 
//gen openMairie le 23/11/2021 19:04

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_id_interne_uid_externe");
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
$table = DB_PREFIXE."lien_id_interne_uid_externe";
// SELECT 
$champAffiche = array(
    'lien_id_interne_uid_externe.lien_id_interne_uid_externe as "'.__("lien_id_interne_uid_externe").'"',
    'lien_id_interne_uid_externe.object as "'.__("object").'"',
    'lien_id_interne_uid_externe.object_id as "'.__("object_id").'"',
    'lien_id_interne_uid_externe.external_uid as "'.__("external_uid").'"',
    'lien_id_interne_uid_externe.dossier as "'.__("dossier").'"',
    'lien_id_interne_uid_externe.category as "'.__("category").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_id_interne_uid_externe.lien_id_interne_uid_externe as "'.__("lien_id_interne_uid_externe").'"',
    'lien_id_interne_uid_externe.object as "'.__("object").'"',
    'lien_id_interne_uid_externe.object_id as "'.__("object_id").'"',
    'lien_id_interne_uid_externe.external_uid as "'.__("external_uid").'"',
    'lien_id_interne_uid_externe.dossier as "'.__("dossier").'"',
    'lien_id_interne_uid_externe.category as "'.__("category").'"',
    );
$tri="ORDER BY lien_id_interne_uid_externe.object ASC NULLS LAST";
$edition="lien_id_interne_uid_externe";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";


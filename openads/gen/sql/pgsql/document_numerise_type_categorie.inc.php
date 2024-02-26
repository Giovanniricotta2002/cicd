<?php
//$Id$ 
//gen openMairie le 07/01/2022 14:14

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("document_numerise_type_categorie");
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
$table = DB_PREFIXE."document_numerise_type_categorie";
// SELECT 
$champAffiche = array(
    'document_numerise_type_categorie.document_numerise_type_categorie as "'.__("document_numerise_type_categorie").'"',
    'document_numerise_type_categorie.libelle as "'.__("libelle").'"',
    'document_numerise_type_categorie.code as "'.__("code").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'document_numerise_type_categorie.document_numerise_type_categorie as "'.__("document_numerise_type_categorie").'"',
    'document_numerise_type_categorie.libelle as "'.__("libelle").'"',
    'document_numerise_type_categorie.code as "'.__("code").'"',
    );
$tri="ORDER BY document_numerise_type_categorie.libelle ASC NULLS LAST";
$edition="document_numerise_type_categorie";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'document_numerise_type',
);


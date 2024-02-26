<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("instructeur_qualite");
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
$table = DB_PREFIXE."instructeur_qualite";
// SELECT 
$champAffiche = array(
    'instructeur_qualite.instructeur_qualite as "'.__("instructeur_qualite").'"',
    'instructeur_qualite.code as "'.__("code").'"',
    'instructeur_qualite.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    'instructeur_qualite.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'instructeur_qualite.instructeur_qualite as "'.__("instructeur_qualite").'"',
    'instructeur_qualite.code as "'.__("code").'"',
    'instructeur_qualite.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY instructeur_qualite.libelle ASC NULLS LAST";
$edition="instructeur_qualite";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'instructeur',
    'lien_document_numerise_type_instructeur_qualite',
);


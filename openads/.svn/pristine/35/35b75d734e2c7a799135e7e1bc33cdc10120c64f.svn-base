<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("administration")." -> ".__("om_widget");
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
$table = DB_PREFIXE."om_widget";
// SELECT 
$champAffiche = array(
    'om_widget.om_widget as "'.__("om_widget").'"',
    'om_widget.libelle as "'.__("libelle").'"',
    'om_widget.lien as "'.__("lien").'"',
    'om_widget.type as "'.__("type").'"',
    'om_widget.script as "'.__("script").'"',
    );
//
$champNonAffiche = array(
    'om_widget.texte as "'.__("texte").'"',
    'om_widget.arguments as "'.__("arguments").'"',
    );
//
$champRecherche = array(
    'om_widget.om_widget as "'.__("om_widget").'"',
    'om_widget.libelle as "'.__("libelle").'"',
    'om_widget.lien as "'.__("lien").'"',
    'om_widget.type as "'.__("type").'"',
    'om_widget.script as "'.__("script").'"',
    );
$tri="ORDER BY om_widget.libelle ASC NULLS LAST";
$edition="om_widget";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'om_dashboard',
);


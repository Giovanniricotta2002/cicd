<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_service_service_categorie");
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
$table = DB_PREFIXE."lien_service_service_categorie
    LEFT JOIN ".DB_PREFIXE."service 
        ON lien_service_service_categorie.service=service.service 
    LEFT JOIN ".DB_PREFIXE."service_categorie 
        ON lien_service_service_categorie.service_categorie=service_categorie.service_categorie ";
// SELECT 
$champAffiche = array(
    'lien_service_service_categorie.lien_service_service_categorie as "'.__("lien_service_service_categorie").'"',
    'service_categorie.libelle as "'.__("service_categorie").'"',
    'service.libelle as "'.__("service").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_service_service_categorie.lien_service_service_categorie as "'.__("lien_service_service_categorie").'"',
    'service_categorie.libelle as "'.__("service_categorie").'"',
    'service.libelle as "'.__("service").'"',
    );
$tri="ORDER BY service_categorie.libelle ASC NULLS LAST";
$edition="lien_service_service_categorie";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "service" => array("service", ),
    "service_categorie" => array("service_categorie", ),
);
// Filtre listing sous formulaire - service
if (in_array($retourformulaire, $foreign_keys_extended["service"])) {
    $selection = " WHERE (lien_service_service_categorie.service = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - service_categorie
if (in_array($retourformulaire, $foreign_keys_extended["service_categorie"])) {
    $selection = " WHERE (lien_service_service_categorie.service_categorie = ".intval($idxformulaire).") ";
}


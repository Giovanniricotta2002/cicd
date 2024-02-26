<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_service_om_utilisateur");
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
$table = DB_PREFIXE."lien_service_om_utilisateur
    LEFT JOIN ".DB_PREFIXE."om_utilisateur 
        ON lien_service_om_utilisateur.om_utilisateur=om_utilisateur.om_utilisateur 
    LEFT JOIN ".DB_PREFIXE."service 
        ON lien_service_om_utilisateur.service=service.service ";
// SELECT 
$champAffiche = array(
    'lien_service_om_utilisateur.lien_service_om_utilisateur as "'.__("lien_service_om_utilisateur").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'service.libelle as "'.__("service").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_service_om_utilisateur.lien_service_om_utilisateur as "'.__("lien_service_om_utilisateur").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'service.libelle as "'.__("service").'"',
    );
$tri="ORDER BY om_utilisateur.nom ASC NULLS LAST";
$edition="lien_service_om_utilisateur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_utilisateur" => array("om_utilisateur", ),
    "service" => array("service", ),
);
// Filtre listing sous formulaire - om_utilisateur
if (in_array($retourformulaire, $foreign_keys_extended["om_utilisateur"])) {
    $selection = " WHERE (lien_service_om_utilisateur.om_utilisateur = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - service
if (in_array($retourformulaire, $foreign_keys_extended["service"])) {
    $selection = " WHERE (lien_service_om_utilisateur.service = ".intval($idxformulaire).") ";
}


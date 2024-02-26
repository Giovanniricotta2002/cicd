<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_document_numerise_type_instructeur_qualite");
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
$table = DB_PREFIXE."lien_document_numerise_type_instructeur_qualite
    LEFT JOIN ".DB_PREFIXE."document_numerise_type 
        ON lien_document_numerise_type_instructeur_qualite.document_numerise_type=document_numerise_type.document_numerise_type 
    LEFT JOIN ".DB_PREFIXE."instructeur_qualite 
        ON lien_document_numerise_type_instructeur_qualite.instructeur_qualite=instructeur_qualite.instructeur_qualite ";
// SELECT 
$champAffiche = array(
    'lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite as "'.__("lien_document_numerise_type_instructeur_qualite").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    'instructeur_qualite.libelle as "'.__("instructeur_qualite").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite as "'.__("lien_document_numerise_type_instructeur_qualite").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    'instructeur_qualite.libelle as "'.__("instructeur_qualite").'"',
    );
$tri="ORDER BY document_numerise_type.libelle ASC NULLS LAST";
$edition="lien_document_numerise_type_instructeur_qualite";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "document_numerise_type" => array("document_numerise_type", ),
    "instructeur_qualite" => array("instructeur_qualite", ),
);
// Filtre listing sous formulaire - document_numerise_type
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise_type"])) {
    $selection = " WHERE (lien_document_numerise_type_instructeur_qualite.document_numerise_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - instructeur_qualite
if (in_array($retourformulaire, $foreign_keys_extended["instructeur_qualite"])) {
    $selection = " WHERE (lien_document_numerise_type_instructeur_qualite.instructeur_qualite = ".intval($idxformulaire).") ";
}


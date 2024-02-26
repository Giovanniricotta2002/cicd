<?php
//$Id$ 
//gen openMairie le 28/03/2023 10:06

$DEBUG=0;
$serie=15;
$ent = __("paramétrage")." -> ".__("geolocalisation")." -> ".__("contraintes de référence")." -> ".__("Événements Suggérés");
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
$table = DB_PREFIXE."lien_sig_contrainte_evenement
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON lien_sig_contrainte_evenement.evenement=evenement.evenement 
    LEFT JOIN ".DB_PREFIXE."sig_contrainte 
        ON lien_sig_contrainte_evenement.sig_contrainte=sig_contrainte.sig_contrainte ";
// SELECT 
$champAffiche = array(
    'lien_sig_contrainte_evenement.lien_sig_contrainte_evenement as "'.__("lien_sig_contrainte_evenement").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_sig_contrainte_evenement.lien_sig_contrainte_evenement as "'.__("lien_sig_contrainte_evenement").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
$tri="ORDER BY sig_contrainte.libelle ASC NULLS LAST";
$edition="lien_sig_contrainte_evenement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "evenement" => array("evenement", ),
    "sig_contrainte" => array("sig_contrainte", ),
);
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (lien_sig_contrainte_evenement.evenement = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - sig_contrainte
if (in_array($retourformulaire, $foreign_keys_extended["sig_contrainte"])) {
    $selection = " WHERE (lien_sig_contrainte_evenement.sig_contrainte = ".intval($idxformulaire).") ";
}


<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_donnees_techniques_moyen_retenu_juge");
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
$table = DB_PREFIXE."lien_donnees_techniques_moyen_retenu_juge
    LEFT JOIN ".DB_PREFIXE."donnees_techniques 
        ON lien_donnees_techniques_moyen_retenu_juge.donnees_techniques=donnees_techniques.donnees_techniques 
    LEFT JOIN ".DB_PREFIXE."moyen_retenu_juge 
        ON lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge=moyen_retenu_juge.moyen_retenu_juge ";
// SELECT 
$champAffiche = array(
    'lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge as "'.__("lien_donnees_techniques_moyen_retenu_juge").'"',
    'donnees_techniques.dossier_instruction as "'.__("donnees_techniques").'"',
    'moyen_retenu_juge.libelle as "'.__("moyen_retenu_juge").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge as "'.__("lien_donnees_techniques_moyen_retenu_juge").'"',
    'donnees_techniques.dossier_instruction as "'.__("donnees_techniques").'"',
    'moyen_retenu_juge.libelle as "'.__("moyen_retenu_juge").'"',
    );
$tri="ORDER BY donnees_techniques.dossier_instruction ASC NULLS LAST";
$edition="lien_donnees_techniques_moyen_retenu_juge";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "donnees_techniques" => array("donnees_techniques", ),
    "moyen_retenu_juge" => array("moyen_retenu_juge", ),
);
// Filtre listing sous formulaire - donnees_techniques
if (in_array($retourformulaire, $foreign_keys_extended["donnees_techniques"])) {
    $selection = " WHERE (lien_donnees_techniques_moyen_retenu_juge.donnees_techniques = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - moyen_retenu_juge
if (in_array($retourformulaire, $foreign_keys_extended["moyen_retenu_juge"])) {
    $selection = " WHERE (lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge = ".intval($idxformulaire).") ";
}


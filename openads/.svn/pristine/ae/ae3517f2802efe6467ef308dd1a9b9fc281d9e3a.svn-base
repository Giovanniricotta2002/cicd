<?php
//$Id$ 
//gen openMairie le 24/02/2022 17:55

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_om_utilisateur_tiers_consulte");
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
$table = DB_PREFIXE."lien_om_utilisateur_tiers_consulte
    LEFT JOIN ".DB_PREFIXE."om_utilisateur 
        ON lien_om_utilisateur_tiers_consulte.om_utilisateur=om_utilisateur.om_utilisateur 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte 
        ON lien_om_utilisateur_tiers_consulte.tiers_consulte=tiers_consulte.tiers_consulte ";
// SELECT 
$champAffiche = array(
    'lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte as "'.__("lien_om_utilisateur_tiers_consulte").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte as "'.__("lien_om_utilisateur_tiers_consulte").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    );
$tri="ORDER BY om_utilisateur.nom ASC NULLS LAST";
$edition="lien_om_utilisateur_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_utilisateur" => array("om_utilisateur", ),
    "tiers_consulte" => array("tiers_consulte", ),
);
// Filtre listing sous formulaire - om_utilisateur
if (in_array($retourformulaire, $foreign_keys_extended["om_utilisateur"])) {
    $selection = " WHERE (lien_om_utilisateur_tiers_consulte.om_utilisateur = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["tiers_consulte"])) {
    $selection = " WHERE (lien_om_utilisateur_tiers_consulte.tiers_consulte = ".intval($idxformulaire).") ";
}


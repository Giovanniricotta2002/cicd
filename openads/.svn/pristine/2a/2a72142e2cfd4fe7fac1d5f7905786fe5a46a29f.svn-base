<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_demande_demandeur");
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
$table = DB_PREFIXE."lien_demande_demandeur
    LEFT JOIN ".DB_PREFIXE."demande 
        ON lien_demande_demandeur.demande=demande.demande 
    LEFT JOIN ".DB_PREFIXE."demandeur 
        ON lien_demande_demandeur.demandeur=demandeur.demandeur ";
// SELECT 
$champAffiche = array(
    'lien_demande_demandeur.lien_demande_demandeur as "'.__("lien_demande_demandeur").'"',
    "case lien_demande_demandeur.petitionnaire_principal when 't' then 'Oui' else 'Non' end as \"".__("petitionnaire_principal")."\"",
    'demande.dossier_autorisation_type_detaille as "'.__("demande").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_demande_demandeur.lien_demande_demandeur as "'.__("lien_demande_demandeur").'"',
    'demande.dossier_autorisation_type_detaille as "'.__("demande").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
$tri="ORDER BY lien_demande_demandeur.petitionnaire_principal ASC NULLS LAST";
$edition="lien_demande_demandeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demande" => array("demande", ),
    "demandeur" => array("demandeur", ),
);
// Filtre listing sous formulaire - demande
if (in_array($retourformulaire, $foreign_keys_extended["demande"])) {
    $selection = " WHERE (lien_demande_demandeur.demande = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - demandeur
if (in_array($retourformulaire, $foreign_keys_extended["demandeur"])) {
    $selection = " WHERE (lien_demande_demandeur.demandeur = ".intval($idxformulaire).") ";
}


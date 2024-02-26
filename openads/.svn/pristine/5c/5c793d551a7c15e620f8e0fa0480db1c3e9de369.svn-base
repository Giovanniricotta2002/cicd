<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_lot_demandeur");
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
$table = DB_PREFIXE."lien_lot_demandeur
    LEFT JOIN ".DB_PREFIXE."demandeur 
        ON lien_lot_demandeur.demandeur=demandeur.demandeur 
    LEFT JOIN ".DB_PREFIXE."lot 
        ON lien_lot_demandeur.lot=lot.lot ";
// SELECT 
$champAffiche = array(
    'lien_lot_demandeur.lien_lot_demandeur as "'.__("lien_lot_demandeur").'"',
    'lot.libelle as "'.__("lot").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    "case lien_lot_demandeur.petitionnaire_principal when 't' then 'Oui' else 'Non' end as \"".__("petitionnaire_principal")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_lot_demandeur.lien_lot_demandeur as "'.__("lien_lot_demandeur").'"',
    'lot.libelle as "'.__("lot").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
$tri="ORDER BY lot.libelle ASC NULLS LAST";
$edition="lien_lot_demandeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demandeur" => array("demandeur", ),
    "lot" => array("lot", ),
);
// Filtre listing sous formulaire - demandeur
if (in_array($retourformulaire, $foreign_keys_extended["demandeur"])) {
    $selection = " WHERE (lien_lot_demandeur.demandeur = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - lot
if (in_array($retourformulaire, $foreign_keys_extended["lot"])) {
    $selection = " WHERE (lien_lot_demandeur.lot = ".intval($idxformulaire).") ";
}


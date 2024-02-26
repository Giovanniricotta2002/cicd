<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lot");
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
$table = DB_PREFIXE."lot
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON lot.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON lot.dossier_autorisation=dossier_autorisation.dossier_autorisation ";
// SELECT 
$champAffiche = array(
    'lot.lot as "'.__("lot").'"',
    'lot.libelle as "'.__("libelle").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier.annee as "'.__("dossier").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lot.lot as "'.__("lot").'"',
    'lot.libelle as "'.__("libelle").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier.annee as "'.__("dossier").'"',
    );
$tri="ORDER BY lot.libelle ASC NULLS LAST";
$edition="lot";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "dossier_autorisation" => array("dossier_autorisation", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (lot.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation"])) {
    $selection = " WHERE (lot.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'donnees_techniques',
    'lien_lot_demandeur',
);


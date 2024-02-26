<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_autorisation_parcelle");
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
$table = DB_PREFIXE."dossier_autorisation_parcelle
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON dossier_autorisation_parcelle.dossier_autorisation=dossier_autorisation.dossier_autorisation ";
// SELECT 
$champAffiche = array(
    'dossier_autorisation_parcelle.dossier_autorisation_parcelle as "'.__("dossier_autorisation_parcelle").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier_autorisation_parcelle.parcelle as "'.__("parcelle").'"',
    'dossier_autorisation_parcelle.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'dossier_autorisation_parcelle.dossier_autorisation_parcelle as "'.__("dossier_autorisation_parcelle").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier_autorisation_parcelle.parcelle as "'.__("parcelle").'"',
    'dossier_autorisation_parcelle.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY dossier_autorisation_parcelle.libelle ASC NULLS LAST";
$edition="dossier_autorisation_parcelle";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_autorisation" => array("dossier_autorisation", ),
);
// Filtre listing sous formulaire - dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation"])) {
    $selection = " WHERE (dossier_autorisation_parcelle.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
}


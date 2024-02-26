<?php
//$Id$ 
//gen openMairie le 15/11/2018 16:09

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("demande_type");
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
$table = DB_PREFIXE."demande_type
    LEFT JOIN ".DB_PREFIXE."demande_nature 
        ON demande_type.demande_nature=demande_nature.demande_nature 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON demande_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON demande_type.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON demande_type.evenement=evenement.evenement 
    LEFT JOIN ".DB_PREFIXE."groupe 
        ON demande_type.groupe=groupe.groupe ";
// SELECT 
$champAffiche = array(
    'demande_type.demande_type as "'.__("demande_type").'"',
    'demande_type.code as "'.__("code").'"',
    'demande_type.libelle as "'.__("libelle").'"',
    'demande_nature.libelle as "'.__("demande_nature").'"',
    'groupe.libelle as "'.__("groupe").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'demande_type.contraintes as "'.__("contraintes").'"',
    "case demande_type.qualification when 't' then 'Oui' else 'Non' end as \"".__("qualification")."\"",
    'evenement.libelle as "'.__("evenement").'"',
    "case demande_type.regeneration_cle_citoyen when 't' then 'Oui' else 'Non' end as \"".__("regeneration_cle_citoyen")."\"",
    );
//
$champNonAffiche = array(
    'demande_type.description as "'.__("description").'"',
    'demande_type.document_obligatoire as "'.__("document_obligatoire").'"',
    );
//
$champRecherche = array(
    'demande_type.demande_type as "'.__("demande_type").'"',
    'demande_type.code as "'.__("code").'"',
    'demande_type.libelle as "'.__("libelle").'"',
    'demande_nature.libelle as "'.__("demande_nature").'"',
    'groupe.libelle as "'.__("groupe").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'demande_type.contraintes as "'.__("contraintes").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
$tri="ORDER BY demande_type.libelle ASC NULLS LAST";
$edition="demande_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demande_nature" => array("demande_nature", ),
    "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "evenement" => array("evenement", ),
    "groupe" => array("groupe", ),
);
// Filtre listing sous formulaire - demande_nature
if (in_array($retourformulaire, $foreign_keys_extended["demande_nature"])) {
    $selection = " WHERE (demande_type.demande_nature = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_autorisation_type_detaille
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type_detaille"])) {
    $selection = " WHERE (demande_type.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (demande_type.dossier_instruction_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (demande_type.evenement = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - groupe
if (in_array($retourformulaire, $foreign_keys_extended["groupe"])) {
    $selection = " WHERE (demande_type.groupe = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'demande',
    'lien_demande_type_dossier_instruction_type',
    'lien_demande_type_etat',
);


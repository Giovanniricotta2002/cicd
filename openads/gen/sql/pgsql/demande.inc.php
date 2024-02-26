<?php
//$Id$ 
//gen openMairie le 14/09/2022 11:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("demande");
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
$table = DB_PREFIXE."demande
    LEFT JOIN ".DB_PREFIXE."arrondissement 
        ON demande.arrondissement=arrondissement.arrondissement 
    LEFT JOIN ".DB_PREFIXE."dossier as dossier1 
        ON demande.autorisation_contestee=dossier1.dossier 
    LEFT JOIN ".DB_PREFIXE."commune 
        ON demande.commune=commune.commune 
    LEFT JOIN ".DB_PREFIXE."demande_type 
        ON demande.demande_type=demande_type.demande_type 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON demande.dossier_autorisation=dossier_autorisation.dossier_autorisation 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON demande.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN ".DB_PREFIXE."dossier as dossier6 
        ON demande.dossier_instruction=dossier6.dossier 
    LEFT JOIN ".DB_PREFIXE."instruction 
        ON demande.instruction_recepisse=instruction.instruction 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON demande.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'demande.demande as "'.__("demande").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'dossier6.annee as "'.__("dossier_instruction").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'to_char(demande.date_demande ,\'DD/MM/YYYY\') as "'.__("date_demande").'"',
    'demande.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'demande.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'demande.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'demande.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'demande.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'demande.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'demande.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'demande.terrain_superficie as "'.__("terrain_superficie").'"',
    'instruction.destinataire as "'.__("instruction_recepisse").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'dossier1.annee as "'.__("autorisation_contestee").'"',
    "case demande.depot_electronique when 't' then 'Oui' else 'Non' end as \"".__("depot_electronique")."\"",
    "case demande.parcelle_temporaire when 't' then 'Oui' else 'Non' end as \"".__("parcelle_temporaire")."\"",
    'commune.libelle as "'.__("commune").'"',
    'demande.source_depot as "'.__("source_depot").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'demande.terrain_references_cadastrales as "'.__("terrain_references_cadastrales").'"',
    'demande.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'demande.demande as "'.__("demande").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'dossier6.annee as "'.__("dossier_instruction").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'demande.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'demande.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'demande.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'demande.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'demande.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'demande.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'demande.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'demande.terrain_superficie as "'.__("terrain_superficie").'"',
    'instruction.destinataire as "'.__("instruction_recepisse").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'dossier1.annee as "'.__("autorisation_contestee").'"',
    'commune.libelle as "'.__("commune").'"',
    'demande.source_depot as "'.__("source_depot").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY dossier_autorisation_type_detaille.libelle ASC NULLS LAST";
$edition="demande";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "arrondissement" => array("arrondissement", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "commune" => array("commune", ),
    "demande_type" => array("demande_type", ),
    "dossier_autorisation" => array("dossier_autorisation", ),
    "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
    "instruction" => array("instruction", "instruction_modale", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - arrondissement
if (in_array($retourformulaire, $foreign_keys_extended["arrondissement"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.arrondissement = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.arrondissement = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.autorisation_contestee = '".$f->db->escapeSimple($idxformulaire)."' OR demande.dossier_instruction = '".$f->db->escapeSimple($idxformulaire)."') ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.autorisation_contestee = '".$f->db->escapeSimple($idxformulaire)."' OR demande.dossier_instruction = '".$f->db->escapeSimple($idxformulaire)."') ";
    }
}
// Filtre listing sous formulaire - commune
if (in_array($retourformulaire, $foreign_keys_extended["commune"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.commune = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.commune = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - demande_type
if (in_array($retourformulaire, $foreign_keys_extended["demande_type"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.demande_type = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.demande_type = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
    }
}
// Filtre listing sous formulaire - dossier_autorisation_type_detaille
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type_detaille"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - instruction
if (in_array($retourformulaire, $foreign_keys_extended["instruction"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.instruction_recepisse = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.instruction_recepisse = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demande.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demande.om_collectivite = '".$_SESSION["collectivite"]."') AND (demande.om_collectivite = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'lien_demande_demandeur',
);


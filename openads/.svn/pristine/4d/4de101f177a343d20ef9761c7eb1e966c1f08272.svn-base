<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("document_numerise");
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
$table = DB_PREFIXE."document_numerise
    LEFT JOIN ".DB_PREFIXE."document_numerise_nature 
        ON document_numerise.document_numerise_nature=document_numerise_nature.document_numerise_nature 
    LEFT JOIN ".DB_PREFIXE."document_numerise_type 
        ON document_numerise.document_numerise_type=document_numerise_type.document_numerise_type 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON document_numerise.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'document_numerise.document_numerise as "'.__("document_numerise").'"',
    'document_numerise.uid as "'.__("uid").'"',
    'dossier.annee as "'.__("dossier").'"',
    'document_numerise.nom_fichier as "'.__("nom_fichier").'"',
    'to_char(document_numerise.date_creation ,\'DD/MM/YYYY\') as "'.__("date_creation").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    "case document_numerise.uid_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("uid_dossier_final")."\"",
    'document_numerise_nature.libelle as "'.__("document_numerise_nature").'"',
    'document_numerise.uid_thumbnail as "'.__("uid_thumbnail").'"',
    'document_numerise.description_type as "'.__("description_type").'"',
    "case document_numerise.document_travail when 't' then 'Oui' else 'Non' end as \"".__("document_travail")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'document_numerise.document_numerise as "'.__("document_numerise").'"',
    'document_numerise.uid as "'.__("uid").'"',
    'dossier.annee as "'.__("dossier").'"',
    'document_numerise.nom_fichier as "'.__("nom_fichier").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    'document_numerise_nature.libelle as "'.__("document_numerise_nature").'"',
    'document_numerise.uid_thumbnail as "'.__("uid_thumbnail").'"',
    'document_numerise.description_type as "'.__("description_type").'"',
    );
$tri="ORDER BY document_numerise.uid ASC NULLS LAST";
$edition="document_numerise";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "document_numerise_nature" => array("document_numerise_nature", ),
    "document_numerise_type" => array("document_numerise_type", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - document_numerise_nature
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise_nature"])) {
    $selection = " WHERE (document_numerise.document_numerise_nature = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - document_numerise_type
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise_type"])) {
    $selection = " WHERE (document_numerise.document_numerise_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (document_numerise.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'instruction',
);


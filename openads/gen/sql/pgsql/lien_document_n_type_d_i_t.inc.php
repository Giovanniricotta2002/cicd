<?php
//$Id$ 
//gen openMairie le 15/07/2021 10:24

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_document_n_type_d_i_t");
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
$table = DB_PREFIXE."lien_document_n_type_d_i_t
    LEFT JOIN ".DB_PREFIXE."document_numerise_type 
        ON lien_document_n_type_d_i_t.document_numerise_type=document_numerise_type.document_numerise_type 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_document_n_type_d_i_t.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type ";
// SELECT 
$champAffiche = array(
    'lien_document_n_type_d_i_t.lien_document_n_type_d_i_t as "'.__("lien_document_n_type_d_i_t").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'lien_document_n_type_d_i_t.code as "'.__("code").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_document_n_type_d_i_t.lien_document_n_type_d_i_t as "'.__("lien_document_n_type_d_i_t").'"',
    'document_numerise_type.libelle as "'.__("document_numerise_type").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'lien_document_n_type_d_i_t.code as "'.__("code").'"',
    );
$tri="ORDER BY document_numerise_type.libelle ASC NULLS LAST";
$edition="lien_document_n_type_d_i_t";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "document_numerise_type" => array("document_numerise_type", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
);
// Filtre listing sous formulaire - document_numerise_type
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise_type"])) {
    $selection = " WHERE (lien_document_n_type_d_i_t.document_numerise_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_document_n_type_d_i_t.dossier_instruction_type = ".intval($idxformulaire).") ";
}


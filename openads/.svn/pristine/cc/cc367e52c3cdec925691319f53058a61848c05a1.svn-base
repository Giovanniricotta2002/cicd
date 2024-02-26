<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_geolocalisation");
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
$table = DB_PREFIXE."dossier_geolocalisation
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_geolocalisation.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'dossier_geolocalisation.dossier_geolocalisation as "'.__("dossier_geolocalisation").'"',
    'dossier.annee as "'.__("dossier").'"',
    'dossier_geolocalisation.date_verif_parcelle as "'.__("date_verif_parcelle").'"',
    "case dossier_geolocalisation.etat_verif_parcelle when 't' then 'Oui' else 'Non' end as \"".__("etat_verif_parcelle")."\"",
    'dossier_geolocalisation.date_calcul_emprise as "'.__("date_calcul_emprise").'"',
    "case dossier_geolocalisation.etat_calcul_emprise when 't' then 'Oui' else 'Non' end as \"".__("etat_calcul_emprise")."\"",
    'dossier_geolocalisation.date_dessin_emprise as "'.__("date_dessin_emprise").'"',
    "case dossier_geolocalisation.etat_dessin_emprise when 't' then 'Oui' else 'Non' end as \"".__("etat_dessin_emprise")."\"",
    'dossier_geolocalisation.date_calcul_centroide as "'.__("date_calcul_centroide").'"',
    "case dossier_geolocalisation.etat_calcul_centroide when 't' then 'Oui' else 'Non' end as \"".__("etat_calcul_centroide")."\"",
    'dossier_geolocalisation.date_recup_contrainte as "'.__("date_recup_contrainte").'"',
    "case dossier_geolocalisation.etat_recup_contrainte when 't' then 'Oui' else 'Non' end as \"".__("etat_recup_contrainte")."\"",
    );
//
$champNonAffiche = array(
    'dossier_geolocalisation.message_verif_parcelle as "'.__("message_verif_parcelle").'"',
    'dossier_geolocalisation.message_calcul_emprise as "'.__("message_calcul_emprise").'"',
    'dossier_geolocalisation.message_dessin_emprise as "'.__("message_dessin_emprise").'"',
    'dossier_geolocalisation.message_calcul_centroide as "'.__("message_calcul_centroide").'"',
    'dossier_geolocalisation.message_recup_contrainte as "'.__("message_recup_contrainte").'"',
    'dossier_geolocalisation.terrain_references_cadastrales_archive as "'.__("terrain_references_cadastrales_archive").'"',
    );
//
$champRecherche = array(
    'dossier_geolocalisation.dossier_geolocalisation as "'.__("dossier_geolocalisation").'"',
    'dossier.annee as "'.__("dossier").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="dossier_geolocalisation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (dossier_geolocalisation.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}


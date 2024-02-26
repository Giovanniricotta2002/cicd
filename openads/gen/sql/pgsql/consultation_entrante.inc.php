<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("consultation_entrante");
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
$table = DB_PREFIXE."consultation_entrante
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON consultation_entrante.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'consultation_entrante.consultation_entrante as "'.__("consultation_entrante").'"',
    'consultation_entrante.delai_reponse as "'.__("delai_reponse").'"',
    'to_char(consultation_entrante.date_consultation ,\'DD/MM/YYYY\') as "'.__("date_consultation").'"',
    'to_char(consultation_entrante.date_emission ,\'DD/MM/YYYY\') as "'.__("date_emission").'"',
    'consultation_entrante.service_consultant_id as "'.__("service_consultant_id").'"',
    'consultation_entrante.service_consultant_libelle as "'.__("service_consultant_libelle").'"',
    'consultation_entrante.service_consultant_insee as "'.__("service_consultant_insee").'"',
    'consultation_entrante.service_consultant_mail as "'.__("service_consultant_mail").'"',
    'consultation_entrante.service_consultant_type as "'.__("service_consultant_type").'"',
    'consultation_entrante.service_consultant__siren as "'.__("service_consultant__siren").'"',
    'consultation_entrante.etat_consultation as "'.__("etat_consultation").'"',
    'consultation_entrante.type_consultation as "'.__("type_consultation").'"',
    'dossier.annee as "'.__("dossier").'"',
    'consultation_entrante.type_delai as "'.__("type_delai").'"',
    'consultation_entrante.objet_consultation as "'.__("objet_consultation").'"',
    'to_char(consultation_entrante.date_production_notification ,\'DD/MM/YYYY\') as "'.__("date_production_notification").'"',
    'to_char(consultation_entrante.date_premiere_consultation ,\'DD/MM/YYYY\') as "'.__("date_premiere_consultation").'"',
    );
//
$champNonAffiche = array(
    'consultation_entrante.texte_fondement_reglementaire as "'.__("texte_fondement_reglementaire").'"',
    'consultation_entrante.texte_objet_consultation as "'.__("texte_objet_consultation").'"',
    );
//
$champRecherche = array(
    'consultation_entrante.consultation_entrante as "'.__("consultation_entrante").'"',
    'consultation_entrante.delai_reponse as "'.__("delai_reponse").'"',
    'consultation_entrante.service_consultant_id as "'.__("service_consultant_id").'"',
    'consultation_entrante.service_consultant_libelle as "'.__("service_consultant_libelle").'"',
    'consultation_entrante.service_consultant_insee as "'.__("service_consultant_insee").'"',
    'consultation_entrante.service_consultant_mail as "'.__("service_consultant_mail").'"',
    'consultation_entrante.service_consultant_type as "'.__("service_consultant_type").'"',
    'consultation_entrante.service_consultant__siren as "'.__("service_consultant__siren").'"',
    'consultation_entrante.etat_consultation as "'.__("etat_consultation").'"',
    'consultation_entrante.type_consultation as "'.__("type_consultation").'"',
    'dossier.annee as "'.__("dossier").'"',
    'consultation_entrante.type_delai as "'.__("type_delai").'"',
    'consultation_entrante.objet_consultation as "'.__("objet_consultation").'"',
    );
$tri="ORDER BY consultation_entrante.delai_reponse ASC NULLS LAST";
$edition="consultation_entrante";
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
    $selection = " WHERE (consultation_entrante.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}


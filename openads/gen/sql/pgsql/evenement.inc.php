<?php
//$Id$ 
//gen openMairie le 07/03/2023 15:07

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("evenement");
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
$table = DB_PREFIXE."evenement
    LEFT JOIN ".DB_PREFIXE."action 
        ON evenement.action=action.action 
    LEFT JOIN ".DB_PREFIXE."autorite_competente 
        ON evenement.autorite_competente=autorite_competente.autorite_competente 
    LEFT JOIN ".DB_PREFIXE."avis_decision 
        ON evenement.avis_decision=avis_decision.avis_decision 
    LEFT JOIN ".DB_PREFIXE."etat 
        ON evenement.etat=etat.etat 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement4 
        ON evenement.evenement_retour_ar=evenement4.evenement 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement5 
        ON evenement.evenement_retour_signature=evenement5.evenement 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement6 
        ON evenement.evenement_suivant_tacite=evenement6.evenement 
    LEFT JOIN ".DB_PREFIXE."pec_metier 
        ON evenement.pec_metier=pec_metier.pec_metier 
    LEFT JOIN ".DB_PREFIXE."phase 
        ON evenement.phase=phase.phase ";
// SELECT 
$champAffiche = array(
    'evenement.evenement as "'.__("evenement").'"',
    'evenement.libelle as "'.__("libelle").'"',
    'action.libelle as "'.__("action").'"',
    'etat.libelle as "'.__("etat").'"',
    'evenement.delai as "'.__("delai").'"',
    'evenement.accord_tacite as "'.__("accord_tacite").'"',
    'evenement.delai_notification as "'.__("delai_notification").'"',
    'evenement.lettretype as "'.__("lettretype").'"',
    'evenement.consultation as "'.__("consultation").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'evenement.restriction as "'.__("restriction").'"',
    'evenement.type as "'.__("type").'"',
    'evenement4.libelle as "'.__("evenement_retour_ar").'"',
    'evenement6.libelle as "'.__("evenement_suivant_tacite").'"',
    'evenement5.libelle as "'.__("evenement_retour_signature").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    "case evenement.retour when 't' then 'Oui' else 'Non' end as \"".__("retour")."\"",
    "case evenement.non_verrouillable when 't' then 'Oui' else 'Non' end as \"".__("non_verrouillable")."\"",
    'phase.code as "'.__("phase").'"',
    "case evenement.finaliser_automatiquement when 't' then 'Oui' else 'Non' end as \"".__("finaliser_automatiquement")."\"",
    'pec_metier.libelle as "'.__("pec_metier").'"',
    "case evenement.commentaire when 't' then 'Oui' else 'Non' end as \"".__("commentaire")."\"",
    "case evenement.non_modifiable when 't' then 'Oui' else 'Non' end as \"".__("non_modifiable")."\"",
    "case evenement.non_supprimable when 't' then 'Oui' else 'Non' end as \"".__("non_supprimable")."\"",
    'evenement.notification as "'.__("notification").'"',
    "case evenement.envoi_cl_platau when 't' then 'Oui' else 'Non' end as \"".__("envoi_cl_platau")."\"",
    "case evenement.signataire_obligatoire when 't' then 'Oui' else 'Non' end as \"".__("signataire_obligatoire")."\"",
    "case evenement.notification_service when 't' then 'Oui' else 'Non' end as \"".__("notification_service")."\"",
    'evenement.notification_tiers as "'.__("notification_tiers").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'evenement.evenement as "'.__("evenement").'"',
    'evenement.libelle as "'.__("libelle").'"',
    'action.libelle as "'.__("action").'"',
    'etat.libelle as "'.__("etat").'"',
    'evenement.delai as "'.__("delai").'"',
    'evenement.accord_tacite as "'.__("accord_tacite").'"',
    'evenement.delai_notification as "'.__("delai_notification").'"',
    'evenement.lettretype as "'.__("lettretype").'"',
    'evenement.consultation as "'.__("consultation").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'evenement.restriction as "'.__("restriction").'"',
    'evenement.type as "'.__("type").'"',
    'evenement4.libelle as "'.__("evenement_retour_ar").'"',
    'evenement6.libelle as "'.__("evenement_suivant_tacite").'"',
    'evenement5.libelle as "'.__("evenement_retour_signature").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    'phase.code as "'.__("phase").'"',
    'pec_metier.libelle as "'.__("pec_metier").'"',
    'evenement.notification as "'.__("notification").'"',
    'evenement.notification_tiers as "'.__("notification_tiers").'"',
    );
$tri="ORDER BY evenement.libelle ASC NULLS LAST";
$edition="evenement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "action" => array("action", ),
    "autorite_competente" => array("autorite_competente", ),
    "avis_decision" => array("avis_decision", ),
    "etat" => array("etat", ),
    "evenement" => array("evenement", ),
    "pec_metier" => array("pec_metier", ),
    "phase" => array("phase", ),
);
// Filtre listing sous formulaire - action
if (in_array($retourformulaire, $foreign_keys_extended["action"])) {
    $selection = " WHERE (evenement.action = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - autorite_competente
if (in_array($retourformulaire, $foreign_keys_extended["autorite_competente"])) {
    $selection = " WHERE (evenement.autorite_competente = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - avis_decision
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision"])) {
    $selection = " WHERE (evenement.avis_decision = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - etat
if (in_array($retourformulaire, $foreign_keys_extended["etat"])) {
    $selection = " WHERE (evenement.etat = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (evenement.evenement_retour_ar = ".intval($idxformulaire)." OR evenement.evenement_retour_signature = ".intval($idxformulaire)." OR evenement.evenement_suivant_tacite = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - pec_metier
if (in_array($retourformulaire, $foreign_keys_extended["pec_metier"])) {
    $selection = " WHERE (evenement.pec_metier = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - phase
if (in_array($retourformulaire, $foreign_keys_extended["phase"])) {
    $selection = " WHERE (evenement.phase = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'bible',
    'demande_type',
    'dossier',
    'evenement',
    'evenement_type_habilitation_tiers_consulte',
    'instruction',
    'lien_dossier_instruction_type_evenement',
    'lien_sig_contrainte_evenement',
    'transition',
);


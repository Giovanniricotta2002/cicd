<?php
//$Id$ 
//gen openMairie le 06/09/2022 16:16

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("instruction_notification");
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
$table = DB_PREFIXE."instruction_notification
    LEFT JOIN ".DB_PREFIXE."instruction 
        ON instruction_notification.instruction=instruction.instruction ";
// SELECT 
$champAffiche = array(
    'instruction_notification.instruction_notification as "'.__("instruction_notification").'"',
    'instruction.destinataire as "'.__("instruction").'"',
    "case instruction_notification.automatique when 't' then 'Oui' else 'Non' end as \"".__("automatique")."\"",
    'instruction_notification.emetteur as "'.__("emetteur").'"',
    'instruction_notification.date_envoi as "'.__("date_envoi").'"',
    'instruction_notification.destinataire as "'.__("destinataire").'"',
    'instruction_notification.date_premier_acces as "'.__("date_premier_acces").'"',
    'instruction_notification.statut as "'.__("statut").'"',
    'instruction_notification.commentaire as "'.__("commentaire").'"',
    'instruction_notification.courriel as "'.__("courriel").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'instruction_notification.instruction_notification as "'.__("instruction_notification").'"',
    'instruction.destinataire as "'.__("instruction").'"',
    'instruction_notification.emetteur as "'.__("emetteur").'"',
    'instruction_notification.destinataire as "'.__("destinataire").'"',
    'instruction_notification.statut as "'.__("statut").'"',
    'instruction_notification.commentaire as "'.__("commentaire").'"',
    'instruction_notification.courriel as "'.__("courriel").'"',
    );
$tri="ORDER BY instruction.destinataire ASC NULLS LAST";
$edition="instruction_notification";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "instruction" => array("instruction", "instruction_modale", ),
);
// Filtre listing sous formulaire - instruction
if (in_array($retourformulaire, $foreign_keys_extended["instruction"])) {
    $selection = " WHERE (instruction_notification.instruction = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'instruction_notification_document',
);


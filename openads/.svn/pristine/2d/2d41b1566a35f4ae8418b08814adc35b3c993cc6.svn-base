<?php
//$Id$ 
//gen openMairie le 21/02/2022 17:12

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("instruction_notification_document");
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
$table = DB_PREFIXE."instruction_notification_document
    LEFT JOIN ".DB_PREFIXE."instruction_notification 
        ON instruction_notification_document.instruction_notification=instruction_notification.instruction_notification ";
// SELECT 
$champAffiche = array(
    'instruction_notification_document.instruction_notification_document as "'.__("instruction_notification_document").'"',
    'instruction_notification.instruction as "'.__("instruction_notification").'"',
    'instruction_notification_document.instruction as "'.__("instruction").'"',
    "case instruction_notification_document.annexe when 't' then 'Oui' else 'Non' end as \"".__("annexe")."\"",
    'instruction_notification_document.document_id as "'.__("document_id").'"',
    'instruction_notification_document.document_type as "'.__("document_type").'"',
    );
//
$champNonAffiche = array(
    'instruction_notification_document.cle as "'.__("cle").'"',
    );
//
$champRecherche = array(
    'instruction_notification_document.instruction_notification_document as "'.__("instruction_notification_document").'"',
    'instruction_notification.instruction as "'.__("instruction_notification").'"',
    'instruction_notification_document.instruction as "'.__("instruction").'"',
    'instruction_notification_document.document_id as "'.__("document_id").'"',
    'instruction_notification_document.document_type as "'.__("document_type").'"',
    );
$tri="ORDER BY instruction_notification.instruction ASC NULLS LAST";
$edition="instruction_notification_document";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "instruction_notification" => array("instruction_notification", ),
);
// Filtre listing sous formulaire - instruction_notification
if (in_array($retourformulaire, $foreign_keys_extended["instruction_notification"])) {
    $selection = " WHERE (instruction_notification_document.instruction_notification = ".intval($idxformulaire).") ";
}


<?php
//$Id$ 
//gen openMairie le 23/06/2022 12:32

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("task");
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
$table = DB_PREFIXE."task";
// SELECT 
$champAffiche = array(
    'task.task as "'.__("task").'"',
    'task.type as "'.__("type").'"',
    'task.state as "'.__("state").'"',
    'task.object_id as "'.__("object_id").'"',
    'task.dossier as "'.__("dossier").'"',
    'task.stream as "'.__("stream").'"',
    'task.category as "'.__("category").'"',
    'to_char(task.creation_date ,\'DD/MM/YYYY\') as "'.__("creation_date").'"',
    'task.creation_time as "'.__("creation_time").'"',
    'to_char(task.last_modification_date ,\'DD/MM/YYYY\') as "'.__("last_modification_date").'"',
    'task.last_modification_time as "'.__("last_modification_time").'"',
    );
//
$champNonAffiche = array(
    'task.timestamp_log as "'.__("timestamp_log").'"',
    'task.json_payload as "'.__("json_payload").'"',
    'task.comment as "'.__("comment").'"',
    );
//
$champRecherche = array(
    'task.task as "'.__("task").'"',
    'task.type as "'.__("type").'"',
    'task.state as "'.__("state").'"',
    'task.object_id as "'.__("object_id").'"',
    'task.dossier as "'.__("dossier").'"',
    'task.stream as "'.__("stream").'"',
    'task.category as "'.__("category").'"',
    );
$tri="ORDER BY task.type ASC NULLS LAST";
$edition="task";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";


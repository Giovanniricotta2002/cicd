<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("regle");
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
$table = DB_PREFIXE."regle";
// SELECT 
$champAffiche = array(
    'regle.regle as "'.__("regle").'"',
    'regle.sens as "'.__("sens").'"',
    'regle.ordre as "'.__("ordre").'"',
    'regle.controle as "'.__("controle").'"',
    'regle.id as "'.__("id").'"',
    'regle.champ as "'.__("champ").'"',
    'regle.operateur as "'.__("operateur").'"',
    'regle.valeur as "'.__("valeur").'"',
    'regle.message as "'.__("message").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'regle.regle as "'.__("regle").'"',
    'regle.sens as "'.__("sens").'"',
    'regle.ordre as "'.__("ordre").'"',
    'regle.controle as "'.__("controle").'"',
    'regle.id as "'.__("id").'"',
    'regle.champ as "'.__("champ").'"',
    'regle.operateur as "'.__("operateur").'"',
    'regle.valeur as "'.__("valeur").'"',
    'regle.message as "'.__("message").'"',
    );
$tri="ORDER BY regle.sens ASC NULLS LAST";
$edition="regle";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";


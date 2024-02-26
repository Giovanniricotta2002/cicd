<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_donnees_techniques_moyen_souleve");
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
$table = DB_PREFIXE."lien_donnees_techniques_moyen_souleve
    LEFT JOIN ".DB_PREFIXE."donnees_techniques 
        ON lien_donnees_techniques_moyen_souleve.donnees_techniques=donnees_techniques.donnees_techniques 
    LEFT JOIN ".DB_PREFIXE."moyen_souleve 
        ON lien_donnees_techniques_moyen_souleve.moyen_souleve=moyen_souleve.moyen_souleve ";
// SELECT 
$champAffiche = array(
    'lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve as "'.__("lien_donnees_techniques_moyen_souleve").'"',
    'donnees_techniques.dossier_instruction as "'.__("donnees_techniques").'"',
    'moyen_souleve.libelle as "'.__("moyen_souleve").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve as "'.__("lien_donnees_techniques_moyen_souleve").'"',
    'donnees_techniques.dossier_instruction as "'.__("donnees_techniques").'"',
    'moyen_souleve.libelle as "'.__("moyen_souleve").'"',
    );
$tri="ORDER BY donnees_techniques.dossier_instruction ASC NULLS LAST";
$edition="lien_donnees_techniques_moyen_souleve";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "donnees_techniques" => array("donnees_techniques", ),
    "moyen_souleve" => array("moyen_souleve", ),
);
// Filtre listing sous formulaire - donnees_techniques
if (in_array($retourformulaire, $foreign_keys_extended["donnees_techniques"])) {
    $selection = " WHERE (lien_donnees_techniques_moyen_souleve.donnees_techniques = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - moyen_souleve
if (in_array($retourformulaire, $foreign_keys_extended["moyen_souleve"])) {
    $selection = " WHERE (lien_donnees_techniques_moyen_souleve.moyen_souleve = ".intval($idxformulaire).") ";
}


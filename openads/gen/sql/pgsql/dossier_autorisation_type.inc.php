<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_autorisation_type");
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
$table = DB_PREFIXE."dossier_autorisation_type
    LEFT JOIN ".DB_PREFIXE."groupe 
        ON dossier_autorisation_type.groupe=groupe.groupe ";
// SELECT 
$champAffiche = array(
    'dossier_autorisation_type.dossier_autorisation_type as "'.__("dossier_autorisation_type").'"',
    'dossier_autorisation_type.code as "'.__("code").'"',
    'dossier_autorisation_type.libelle as "'.__("libelle").'"',
    "case dossier_autorisation_type.confidentiel when 't' then 'Oui' else 'Non' end as \"".__("confidentiel")."\"",
    'groupe.libelle as "'.__("groupe").'"',
    'dossier_autorisation_type.affichage_form as "'.__("affichage_form").'"',
    "case dossier_autorisation_type.cacher_da when 't' then 'Oui' else 'Non' end as \"".__("cacher_da")."\"",
    );
//
$champNonAffiche = array(
    'dossier_autorisation_type.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'dossier_autorisation_type.dossier_autorisation_type as "'.__("dossier_autorisation_type").'"',
    'dossier_autorisation_type.code as "'.__("code").'"',
    'dossier_autorisation_type.libelle as "'.__("libelle").'"',
    'groupe.libelle as "'.__("groupe").'"',
    'dossier_autorisation_type.affichage_form as "'.__("affichage_form").'"',
    );
$tri="ORDER BY dossier_autorisation_type.libelle ASC NULLS LAST";
$edition="dossier_autorisation_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "groupe" => array("groupe", ),
);
// Filtre listing sous formulaire - groupe
if (in_array($retourformulaire, $foreign_keys_extended["groupe"])) {
    $selection = " WHERE (dossier_autorisation_type.groupe = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'bible',
    'dossier_autorisation_type_detaille',
);


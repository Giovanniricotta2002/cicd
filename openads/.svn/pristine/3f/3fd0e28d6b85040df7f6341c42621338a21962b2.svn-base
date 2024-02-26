<?php
//$Id$ 
//gen openMairie le 24/05/2023 13:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_autorisation_type_detaille");
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
$table = DB_PREFIXE."dossier_autorisation_type_detaille
    LEFT JOIN ".DB_PREFIXE."cerfa as cerfa0 
        ON dossier_autorisation_type_detaille.cerfa=cerfa0.cerfa 
    LEFT JOIN ".DB_PREFIXE."cerfa as cerfa1 
        ON dossier_autorisation_type_detaille.cerfa_lot=cerfa1.cerfa 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type 
        ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type ";
// SELECT 
$champAffiche = array(
    'dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as "'.__("dossier_autorisation_type_detaille").'"',
    'dossier_autorisation_type_detaille.code as "'.__("code").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("libelle").'"',
    'dossier_autorisation_type.libelle as "'.__("dossier_autorisation_type").'"',
    'cerfa0.libelle as "'.__("cerfa").'"',
    'cerfa1.libelle as "'.__("cerfa_lot").'"',
    'dossier_autorisation_type_detaille.duree_validite_parametrage as "'.__("duree_validite_parametrage").'"',
    "case dossier_autorisation_type_detaille.dossier_platau when 't' then 'Oui' else 'Non' end as \"".__("dossier_platau")."\"",
    'dossier_autorisation_type_detaille.couleur as "'.__("couleur").'"',
    "case dossier_autorisation_type_detaille.secret_instruction when 't' then 'Oui' else 'Non' end as \"".__("secret_instruction")."\"",
    );
//
$champNonAffiche = array(
    'dossier_autorisation_type_detaille.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as "'.__("dossier_autorisation_type_detaille").'"',
    'dossier_autorisation_type_detaille.code as "'.__("code").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("libelle").'"',
    'dossier_autorisation_type.libelle as "'.__("dossier_autorisation_type").'"',
    'cerfa0.libelle as "'.__("cerfa").'"',
    'cerfa1.libelle as "'.__("cerfa_lot").'"',
    'dossier_autorisation_type_detaille.duree_validite_parametrage as "'.__("duree_validite_parametrage").'"',
    'dossier_autorisation_type_detaille.couleur as "'.__("couleur").'"',
    );
$tri="ORDER BY dossier_autorisation_type_detaille.libelle ASC NULLS LAST";
$edition="dossier_autorisation_type_detaille";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "cerfa" => array("cerfa", ),
    "dossier_autorisation_type" => array("dossier_autorisation_type", ),
);
// Filtre listing sous formulaire - cerfa
if (in_array($retourformulaire, $foreign_keys_extended["cerfa"])) {
    $selection = " WHERE (dossier_autorisation_type_detaille.cerfa = ".intval($idxformulaire)." OR dossier_autorisation_type_detaille.cerfa_lot = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_autorisation_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type"])) {
    $selection = " WHERE (dossier_autorisation_type_detaille.dossier_autorisation_type = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'affectation_automatique',
    'demande',
    'demande_type',
    'dossier_autorisation',
    'dossier_instruction_type',
);


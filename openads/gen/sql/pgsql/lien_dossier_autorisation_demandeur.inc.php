<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_autorisation_demandeur");
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
$table = DB_PREFIXE."lien_dossier_autorisation_demandeur
    LEFT JOIN ".DB_PREFIXE."demandeur 
        ON lien_dossier_autorisation_demandeur.demandeur=demandeur.demandeur 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON lien_dossier_autorisation_demandeur.dossier_autorisation=dossier_autorisation.dossier_autorisation ";
// SELECT 
$champAffiche = array(
    'lien_dossier_autorisation_demandeur.lien_dossier_autorisation_demandeur as "'.__("lien_dossier_autorisation_demandeur").'"',
    "case lien_dossier_autorisation_demandeur.petitionnaire_principal when 't' then 'Oui' else 'Non' end as \"".__("petitionnaire_principal")."\"",
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_autorisation_demandeur.lien_dossier_autorisation_demandeur as "'.__("lien_dossier_autorisation_demandeur").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
$tri="ORDER BY lien_dossier_autorisation_demandeur.petitionnaire_principal ASC NULLS LAST";
$edition="lien_dossier_autorisation_demandeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demandeur" => array("demandeur", ),
    "dossier_autorisation" => array("dossier_autorisation", ),
);
// Filtre listing sous formulaire - demandeur
if (in_array($retourformulaire, $foreign_keys_extended["demandeur"])) {
    $selection = " WHERE (lien_dossier_autorisation_demandeur.demandeur = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation"])) {
    $selection = " WHERE (lien_dossier_autorisation_demandeur.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
}


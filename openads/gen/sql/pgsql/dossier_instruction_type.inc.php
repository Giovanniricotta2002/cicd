<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_instruction_type");
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
$table = DB_PREFIXE."dossier_instruction_type
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille ";
// SELECT 
$champAffiche = array(
    'dossier_instruction_type.dossier_instruction_type as "'.__("dossier_instruction_type").'"',
    'dossier_instruction_type.code as "'.__("code").'"',
    'dossier_instruction_type.libelle as "'.__("libelle").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    "case dossier_instruction_type.suffixe when 't' then 'Oui' else 'Non' end as \"".__("suffixe")."\"",
    'dossier_instruction_type.mouvement_sitadel as "'.__("mouvement_sitadel").'"',
    "case dossier_instruction_type.maj_da_localisation when 't' then 'Oui' else 'Non' end as \"".__("maj_da_localisation")."\"",
    "case dossier_instruction_type.maj_da_lot when 't' then 'Oui' else 'Non' end as \"".__("maj_da_lot")."\"",
    "case dossier_instruction_type.maj_da_demandeur when 't' then 'Oui' else 'Non' end as \"".__("maj_da_demandeur")."\"",
    "case dossier_instruction_type.maj_da_etat when 't' then 'Oui' else 'Non' end as \"".__("maj_da_etat")."\"",
    "case dossier_instruction_type.maj_da_date_init when 't' then 'Oui' else 'Non' end as \"".__("maj_da_date_init")."\"",
    "case dossier_instruction_type.maj_da_date_validite when 't' then 'Oui' else 'Non' end as \"".__("maj_da_date_validite")."\"",
    "case dossier_instruction_type.maj_da_date_doc when 't' then 'Oui' else 'Non' end as \"".__("maj_da_date_doc")."\"",
    "case dossier_instruction_type.maj_da_date_daact when 't' then 'Oui' else 'Non' end as \"".__("maj_da_date_daact")."\"",
    "case dossier_instruction_type.maj_da_dt when 't' then 'Oui' else 'Non' end as \"".__("maj_da_dt")."\"",
    "case dossier_instruction_type.sous_dossier when 't' then 'Oui' else 'Non' end as \"".__("sous_dossier")."\"",
    );
//
$champNonAffiche = array(
    'dossier_instruction_type.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'dossier_instruction_type.dossier_instruction_type as "'.__("dossier_instruction_type").'"',
    'dossier_instruction_type.code as "'.__("code").'"',
    'dossier_instruction_type.libelle as "'.__("libelle").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'dossier_instruction_type.mouvement_sitadel as "'.__("mouvement_sitadel").'"',
    );
$tri="ORDER BY dossier_instruction_type.libelle ASC NULLS LAST";
$edition="dossier_instruction_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
);
// Filtre listing sous formulaire - dossier_autorisation_type_detaille
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type_detaille"])) {
    $selection = " WHERE (dossier_instruction_type.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'affectation_automatique',
    'demande_type',
    'dossier',
    'lien_demande_type_dossier_instruction_type',
    'lien_dit_nature_travaux',
    'lien_document_n_type_d_i_t',
    'lien_dossier_instruction_type_categorie_tiers',
    'lien_dossier_instruction_type_evenement',
    'lien_sig_contrainte_dossier_instruction_type',
    'lien_type_di_type_di',
);


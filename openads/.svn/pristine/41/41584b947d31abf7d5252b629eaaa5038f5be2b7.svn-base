<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_operateur");
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
$table = DB_PREFIXE."dossier_operateur
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_operateur.dossier_instruction=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte as tiers_consulte1 
        ON dossier_operateur.operateur_designe=tiers_consulte1.tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte as tiers_consulte2 
        ON dossier_operateur.operateur_detecte_inrap=tiers_consulte2.tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte as tiers_consulte3 
        ON dossier_operateur.operateur_personne_publique=tiers_consulte3.tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte as tiers_consulte4 
        ON dossier_operateur.operateur_selectionne=tiers_consulte4.tiers_consulte ";
// SELECT 
$champAffiche = array(
    'dossier_operateur.dossier_operateur as "'.__("dossier_operateur").'"',
    "case dossier_operateur.operateur_designation_initialisee when 't' then 'Oui' else 'Non' end as \"".__("operateur_designation_initialisee")."\"",
    'tiers_consulte2.libelle as "'.__("operateur_detecte_inrap").'"',
    'dossier_operateur.operateur_collterr_type_agrement as "'.__("operateur_collterr_type_agrement").'"',
    'dossier_operateur.operateur_amenagement_pers_publique as "'.__("operateur_amenagement_pers_publique").'"',
    'dossier_operateur.operateur_pers_publique_amenageur as "'.__("operateur_pers_publique_amenageur").'"',
    'dossier_operateur.operateur_collterr_kpark_avis as "'.__("operateur_collterr_kpark_avis").'"',
    'tiers_consulte4.libelle as "'.__("operateur_selectionne").'"',
    'tiers_consulte3.libelle as "'.__("operateur_personne_publique").'"',
    'dossier_operateur.operateur_personne_publique_avis as "'.__("operateur_personne_publique_avis").'"',
    'dossier_operateur.operateur_kpark_libelle as "'.__("operateur_kpark_libelle").'"',
    'dossier_operateur.operateur_kpark_type_operateur as "'.__("operateur_kpark_type_operateur").'"',
    'dossier_operateur.operateur_kpark_evenement as "'.__("operateur_kpark_evenement").'"',
    'tiers_consulte1.libelle as "'.__("operateur_designe").'"',
    "case dossier_operateur.operateur_valide when 't' then 'Oui' else 'Non' end as \"".__("operateur_valide")."\"",
    'dossier.annee as "'.__("dossier_instruction").'"',
    );
//
$champNonAffiche = array(
    'dossier_operateur.operateur_detecte_collterr as "'.__("operateur_detecte_collterr").'"',
    'dossier_operateur.operateur_designe_historique as "'.__("operateur_designe_historique").'"',
    );
//
$champRecherche = array(
    'dossier_operateur.dossier_operateur as "'.__("dossier_operateur").'"',
    'tiers_consulte2.libelle as "'.__("operateur_detecte_inrap").'"',
    'dossier_operateur.operateur_collterr_type_agrement as "'.__("operateur_collterr_type_agrement").'"',
    'dossier_operateur.operateur_amenagement_pers_publique as "'.__("operateur_amenagement_pers_publique").'"',
    'dossier_operateur.operateur_pers_publique_amenageur as "'.__("operateur_pers_publique_amenageur").'"',
    'dossier_operateur.operateur_collterr_kpark_avis as "'.__("operateur_collterr_kpark_avis").'"',
    'tiers_consulte4.libelle as "'.__("operateur_selectionne").'"',
    'tiers_consulte3.libelle as "'.__("operateur_personne_publique").'"',
    'dossier_operateur.operateur_personne_publique_avis as "'.__("operateur_personne_publique_avis").'"',
    'dossier_operateur.operateur_kpark_libelle as "'.__("operateur_kpark_libelle").'"',
    'dossier_operateur.operateur_kpark_type_operateur as "'.__("operateur_kpark_type_operateur").'"',
    'dossier_operateur.operateur_kpark_evenement as "'.__("operateur_kpark_evenement").'"',
    'tiers_consulte1.libelle as "'.__("operateur_designe").'"',
    'dossier.annee as "'.__("dossier_instruction").'"',
    );
$tri="ORDER BY dossier_operateur.operateur_designation_initialisee ASC NULLS LAST";
$edition="dossier_operateur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "tiers_consulte" => array("tiers_consulte", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (dossier_operateur.dossier_instruction = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["tiers_consulte"])) {
    $selection = " WHERE (dossier_operateur.operateur_designe = ".intval($idxformulaire)." OR dossier_operateur.operateur_detecte_inrap = ".intval($idxformulaire)." OR dossier_operateur.operateur_personne_publique = ".intval($idxformulaire)." OR dossier_operateur.operateur_selectionne = ".intval($idxformulaire).") ";
}


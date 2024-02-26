<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("taxe_amenagement");
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
$table = DB_PREFIXE."taxe_amenagement
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON taxe_amenagement.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'taxe_amenagement.taxe_amenagement as "'.__("taxe_amenagement").'"',
    "case taxe_amenagement.en_ile_de_france when 't' then 'Oui' else 'Non' end as \"".__("en_ile_de_france")."\"",
    'taxe_amenagement.val_forf_surf_cstr as "'.__("val_forf_surf_cstr").'"',
    'taxe_amenagement.val_forf_empl_tente_carav_rml as "'.__("val_forf_empl_tente_carav_rml").'"',
    'taxe_amenagement.val_forf_empl_hll as "'.__("val_forf_empl_hll").'"',
    'taxe_amenagement.val_forf_surf_piscine as "'.__("val_forf_surf_piscine").'"',
    'taxe_amenagement.val_forf_nb_eolienne as "'.__("val_forf_nb_eolienne").'"',
    'taxe_amenagement.val_forf_surf_pann_photo as "'.__("val_forf_surf_pann_photo").'"',
    'taxe_amenagement.val_forf_nb_parking_ext as "'.__("val_forf_nb_parking_ext").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'taxe_amenagement.om_collectivite as "'.__("om_collectivite").'"',
    'taxe_amenagement.tx_depart as "'.__("tx_depart").'"',
    'taxe_amenagement.tx_reg as "'.__("tx_reg").'"',
    'taxe_amenagement.tx_comm_secteur_1 as "'.__("tx_comm_secteur_1").'"',
    'taxe_amenagement.tx_comm_secteur_2 as "'.__("tx_comm_secteur_2").'"',
    'taxe_amenagement.tx_comm_secteur_3 as "'.__("tx_comm_secteur_3").'"',
    'taxe_amenagement.tx_comm_secteur_4 as "'.__("tx_comm_secteur_4").'"',
    'taxe_amenagement.tx_comm_secteur_5 as "'.__("tx_comm_secteur_5").'"',
    'taxe_amenagement.tx_comm_secteur_6 as "'.__("tx_comm_secteur_6").'"',
    'taxe_amenagement.tx_comm_secteur_7 as "'.__("tx_comm_secteur_7").'"',
    'taxe_amenagement.tx_comm_secteur_8 as "'.__("tx_comm_secteur_8").'"',
    'taxe_amenagement.tx_comm_secteur_9 as "'.__("tx_comm_secteur_9").'"',
    'taxe_amenagement.tx_comm_secteur_10 as "'.__("tx_comm_secteur_10").'"',
    'taxe_amenagement.tx_comm_secteur_11 as "'.__("tx_comm_secteur_11").'"',
    'taxe_amenagement.tx_comm_secteur_12 as "'.__("tx_comm_secteur_12").'"',
    'taxe_amenagement.tx_comm_secteur_13 as "'.__("tx_comm_secteur_13").'"',
    'taxe_amenagement.tx_comm_secteur_14 as "'.__("tx_comm_secteur_14").'"',
    'taxe_amenagement.tx_comm_secteur_15 as "'.__("tx_comm_secteur_15").'"',
    'taxe_amenagement.tx_comm_secteur_16 as "'.__("tx_comm_secteur_16").'"',
    'taxe_amenagement.tx_comm_secteur_17 as "'.__("tx_comm_secteur_17").'"',
    'taxe_amenagement.tx_comm_secteur_18 as "'.__("tx_comm_secteur_18").'"',
    'taxe_amenagement.tx_comm_secteur_19 as "'.__("tx_comm_secteur_19").'"',
    'taxe_amenagement.tx_comm_secteur_20 as "'.__("tx_comm_secteur_20").'"',
    'taxe_amenagement.tx_exo_facul_1_reg as "'.__("tx_exo_facul_1_reg").'"',
    'taxe_amenagement.tx_exo_facul_2_reg as "'.__("tx_exo_facul_2_reg").'"',
    'taxe_amenagement.tx_exo_facul_3_reg as "'.__("tx_exo_facul_3_reg").'"',
    'taxe_amenagement.tx_exo_facul_4_reg as "'.__("tx_exo_facul_4_reg").'"',
    'taxe_amenagement.tx_exo_facul_5_reg as "'.__("tx_exo_facul_5_reg").'"',
    'taxe_amenagement.tx_exo_facul_6_reg as "'.__("tx_exo_facul_6_reg").'"',
    'taxe_amenagement.tx_exo_facul_7_reg as "'.__("tx_exo_facul_7_reg").'"',
    'taxe_amenagement.tx_exo_facul_8_reg as "'.__("tx_exo_facul_8_reg").'"',
    'taxe_amenagement.tx_exo_facul_9_reg as "'.__("tx_exo_facul_9_reg").'"',
    'taxe_amenagement.tx_exo_facul_1_depart as "'.__("tx_exo_facul_1_depart").'"',
    'taxe_amenagement.tx_exo_facul_2_depart as "'.__("tx_exo_facul_2_depart").'"',
    'taxe_amenagement.tx_exo_facul_3_depart as "'.__("tx_exo_facul_3_depart").'"',
    'taxe_amenagement.tx_exo_facul_4_depart as "'.__("tx_exo_facul_4_depart").'"',
    'taxe_amenagement.tx_exo_facul_5_depart as "'.__("tx_exo_facul_5_depart").'"',
    'taxe_amenagement.tx_exo_facul_6_depart as "'.__("tx_exo_facul_6_depart").'"',
    'taxe_amenagement.tx_exo_facul_7_depart as "'.__("tx_exo_facul_7_depart").'"',
    'taxe_amenagement.tx_exo_facul_8_depart as "'.__("tx_exo_facul_8_depart").'"',
    'taxe_amenagement.tx_exo_facul_9_depart as "'.__("tx_exo_facul_9_depart").'"',
    'taxe_amenagement.tx_exo_facul_1_comm as "'.__("tx_exo_facul_1_comm").'"',
    'taxe_amenagement.tx_exo_facul_2_comm as "'.__("tx_exo_facul_2_comm").'"',
    'taxe_amenagement.tx_exo_facul_3_comm as "'.__("tx_exo_facul_3_comm").'"',
    'taxe_amenagement.tx_exo_facul_4_comm as "'.__("tx_exo_facul_4_comm").'"',
    'taxe_amenagement.tx_exo_facul_5_comm as "'.__("tx_exo_facul_5_comm").'"',
    'taxe_amenagement.tx_exo_facul_6_comm as "'.__("tx_exo_facul_6_comm").'"',
    'taxe_amenagement.tx_exo_facul_7_comm as "'.__("tx_exo_facul_7_comm").'"',
    'taxe_amenagement.tx_exo_facul_8_comm as "'.__("tx_exo_facul_8_comm").'"',
    'taxe_amenagement.tx_exo_facul_9_comm as "'.__("tx_exo_facul_9_comm").'"',
    'taxe_amenagement.tx_rap as "'.__("tx_rap").'"',
    );
//
$champRecherche = array(
    'taxe_amenagement.taxe_amenagement as "'.__("taxe_amenagement").'"',
    'taxe_amenagement.val_forf_surf_cstr as "'.__("val_forf_surf_cstr").'"',
    'taxe_amenagement.val_forf_empl_tente_carav_rml as "'.__("val_forf_empl_tente_carav_rml").'"',
    'taxe_amenagement.val_forf_empl_hll as "'.__("val_forf_empl_hll").'"',
    'taxe_amenagement.val_forf_surf_piscine as "'.__("val_forf_surf_piscine").'"',
    'taxe_amenagement.val_forf_nb_eolienne as "'.__("val_forf_nb_eolienne").'"',
    'taxe_amenagement.val_forf_surf_pann_photo as "'.__("val_forf_surf_pann_photo").'"',
    'taxe_amenagement.val_forf_nb_parking_ext as "'.__("val_forf_nb_parking_ext").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY om_collectivite.libelle ASC NULLS LAST";
$edition="taxe_amenagement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (taxe_amenagement.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (taxe_amenagement.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (taxe_amenagement.om_collectivite = '".$_SESSION["collectivite"]."') AND (taxe_amenagement.om_collectivite = ".intval($idxformulaire).") ";
    }
}


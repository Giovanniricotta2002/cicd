<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier");
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
$table = DB_PREFIXE."dossier
    LEFT JOIN ".DB_PREFIXE."dossier as dossier0 
        ON dossier.autorisation_contestee=dossier0.dossier 
    LEFT JOIN ".DB_PREFIXE."autorite_competente 
        ON dossier.autorite_competente=autorite_competente.autorite_competente 
    LEFT JOIN ".DB_PREFIXE."avis_decision 
        ON dossier.avis_decision=avis_decision.avis_decision 
    LEFT JOIN ".DB_PREFIXE."commune 
        ON dossier.commune=commune.commune 
    LEFT JOIN ".DB_PREFIXE."division 
        ON dossier.division=division.division 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."dossier as dossier7 
        ON dossier.dossier_parent=dossier7.dossier 
    LEFT JOIN ".DB_PREFIXE."etat as etat8 
        ON dossier.etat=etat8.etat 
    LEFT JOIN ".DB_PREFIXE."etat as etat9 
        ON dossier.etat_pendant_incompletude=etat9.etat 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement10 
        ON dossier.evenement_suivant_tacite=evenement10.evenement 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement11 
        ON dossier.evenement_suivant_tacite_incompletude=evenement11.evenement 
    LEFT JOIN ".DB_PREFIXE."instructeur as instructeur12 
        ON dossier.instructeur=instructeur12.instructeur 
    LEFT JOIN ".DB_PREFIXE."instructeur as instructeur13 
        ON dossier.instructeur_2=instructeur13.instructeur 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON dossier.om_collectivite=om_collectivite.om_collectivite 
    LEFT JOIN ".DB_PREFIXE."pec_metier 
        ON dossier.pec_metier=pec_metier.pec_metier 
    LEFT JOIN ".DB_PREFIXE."quartier 
        ON dossier.quartier=quartier.quartier ";
// SELECT 
$champAffiche = array(
    'dossier.dossier as "'.__("dossier").'"',
    'dossier.annee as "'.__("annee").'"',
    'etat8.libelle as "'.__("etat").'"',
    'instructeur12.nom as "'.__("instructeur").'"',
    'to_char(dossier.date_demande ,\'DD/MM/YYYY\') as "'.__("date_demande").'"',
    'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'.__("date_depot").'"',
    'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'.__("date_complet").'"',
    'to_char(dossier.date_rejet ,\'DD/MM/YYYY\') as "'.__("date_rejet").'"',
    'to_char(dossier.date_notification_delai ,\'DD/MM/YYYY\') as "'.__("date_notification_delai").'"',
    'dossier.delai as "'.__("delai").'"',
    'to_char(dossier.date_limite ,\'DD/MM/YYYY\') as "'.__("date_limite").'"',
    'dossier.accord_tacite as "'.__("accord_tacite").'"',
    'to_char(dossier.date_decision ,\'DD/MM/YYYY\') as "'.__("date_decision").'"',
    'to_char(dossier.date_validite ,\'DD/MM/YYYY\') as "'.__("date_validite").'"',
    'to_char(dossier.date_chantier ,\'DD/MM/YYYY\') as "'.__("date_chantier").'"',
    'to_char(dossier.date_achevement ,\'DD/MM/YYYY\') as "'.__("date_achevement").'"',
    'to_char(dossier.date_conformite ,\'DD/MM/YYYY\') as "'.__("date_conformite").'"',
    "case dossier.erp when 't' then 'Oui' else 'Non' end as \"".__("erp")."\"",
    'avis_decision.libelle as "'.__("avis_decision").'"',
    "case dossier.enjeu_erp when 't' then 'Oui' else 'Non' end as \"".__("enjeu_erp")."\"",
    "case dossier.enjeu_urba when 't' then 'Oui' else 'Non' end as \"".__("enjeu_urba")."\"",
    'division.libelle as "'.__("division").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    "case dossier.a_qualifier when 't' then 'Oui' else 'Non' end as \"".__("a_qualifier")."\"",
    'dossier.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'dossier.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'dossier.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'dossier.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'dossier.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'dossier.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'dossier.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'dossier.terrain_superficie as "'.__("terrain_superficie").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'to_char(dossier.date_dernier_depot ,\'DD/MM/YYYY\') as "'.__("date_dernier_depot").'"',
    'dossier.version as "'.__("version").'"',
    "case dossier.incompletude when 't' then 'Oui' else 'Non' end as \"".__("incompletude")."\"",
    'evenement10.libelle as "'.__("evenement_suivant_tacite").'"',
    'evenement11.libelle as "'.__("evenement_suivant_tacite_incompletude").'"',
    'etat9.libelle as "'.__("etat_pendant_incompletude").'"',
    'to_char(dossier.date_limite_incompletude ,\'DD/MM/YYYY\') as "'.__("date_limite_incompletude").'"',
    'dossier.delai_incompletude as "'.__("delai_incompletude").'"',
    'dossier.dossier_libelle as "'.__("dossier_libelle").'"',
    'dossier.numero_versement_archive as "'.__("numero_versement_archive").'"',
    'dossier.duree_validite as "'.__("duree_validite").'"',
    'quartier.libelle as "'.__("quartier").'"',
    "case dossier.incomplet_notifie when 't' then 'Oui' else 'Non' end as \"".__("incomplet_notifie")."\"",
    'dossier.tax_secteur as "'.__("tax_secteur").'"',
    'dossier.tax_mtn_part_commu as "'.__("tax_mtn_part_commu").'"',
    'dossier.tax_mtn_part_depart as "'.__("tax_mtn_part_depart").'"',
    'dossier.tax_mtn_part_reg as "'.__("tax_mtn_part_reg").'"',
    'dossier.tax_mtn_total as "'.__("tax_mtn_total").'"',
    "case dossier.interface_referentiel_erp when 't' then 'Oui' else 'Non' end as \"".__("interface_referentiel_erp")."\"",
    'dossier0.annee as "'.__("autorisation_contestee").'"',
    'to_char(dossier.date_cloture_instruction ,\'DD/MM/YYYY\') as "'.__("date_cloture_instruction").'"',
    'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'.__("date_premiere_visite").'"',
    'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'.__("date_derniere_visite").'"',
    'to_char(dossier.date_contradictoire ,\'DD/MM/YYYY\') as "'.__("date_contradictoire").'"',
    'to_char(dossier.date_retour_contradictoire ,\'DD/MM/YYYY\') as "'.__("date_retour_contradictoire").'"',
    'to_char(dossier.date_ait ,\'DD/MM/YYYY\') as "'.__("date_ait").'"',
    'to_char(dossier.date_transmission_parquet ,\'DD/MM/YYYY\') as "'.__("date_transmission_parquet").'"',
    'instructeur13.nom as "'.__("instructeur_2").'"',
    'dossier.tax_mtn_rap as "'.__("tax_mtn_rap").'"',
    'dossier.tax_mtn_part_commu_sans_exo as "'.__("tax_mtn_part_commu_sans_exo").'"',
    'dossier.tax_mtn_part_depart_sans_exo as "'.__("tax_mtn_part_depart_sans_exo").'"',
    'dossier.tax_mtn_part_reg_sans_exo as "'.__("tax_mtn_part_reg_sans_exo").'"',
    'dossier.tax_mtn_total_sans_exo as "'.__("tax_mtn_total_sans_exo").'"',
    'dossier.tax_mtn_rap_sans_exo as "'.__("tax_mtn_rap_sans_exo").'"',
    'to_char(dossier.date_modification ,\'DD/MM/YYYY\') as "'.__("date_modification").'"',
    'dossier.hash_sitadel as "'.__("hash_sitadel").'"',
    "case dossier.depot_electronique when 't' then 'Oui' else 'Non' end as \"".__("depot_electronique")."\"",
    "case dossier.parcelle_temporaire when 't' then 'Oui' else 'Non' end as \"".__("parcelle_temporaire")."\"",
    'to_char(dossier.date_affichage ,\'DD/MM/YYYY\') as "'.__("date_affichage").'"',
    'dossier.version_clos as "'.__("version_clos").'"',
    'commune.libelle as "'.__("commune").'"',
    'to_char(dossier.date_depot_mairie ,\'DD/MM/YYYY\') as "'.__("date_depot_mairie").'"',
    'dossier.numerotation_type as "'.__("numerotation_type").'"',
    'dossier.numerotation_dep as "'.__("numerotation_dep").'"',
    'dossier.numerotation_com as "'.__("numerotation_com").'"',
    'dossier.numerotation_division as "'.__("numerotation_division").'"',
    'dossier.numerotation_num as "'.__("numerotation_num").'"',
    'dossier.numerotation_suffixe as "'.__("numerotation_suffixe").'"',
    'dossier.numerotation_num_suffixe as "'.__("numerotation_num_suffixe").'"',
    'dossier.numerotation_entite as "'.__("numerotation_entite").'"',
    'dossier.numerotation_num_entite as "'.__("numerotation_num_entite").'"',
    'pec_metier.libelle as "'.__("pec_metier").'"',
    'dossier7.annee as "'.__("dossier_parent").'"',
    'dossier.terrain_superficie_calculee as "'.__("terrain_superficie_calculee").'"',
    'dossier.geoloc_latitude as "'.__("geoloc_latitude").'"',
    'dossier.geoloc_longitude as "'.__("geoloc_longitude").'"',
    'dossier.geoloc_rayon as "'.__("geoloc_rayon").'"',
    'dossier.geom as "'.__("geom").'"',
    'dossier.geom1 as "'.__("geom1").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'dossier.description as "'.__("description").'"',
    'dossier.terrain_references_cadastrales as "'.__("terrain_references_cadastrales").'"',
    'dossier.om_collectivite as "'.__("om_collectivite").'"',
    'dossier.log_instructions as "'.__("log_instructions").'"',
    'dossier.initial_dt as "'.__("initial_dt").'"',
    'dossier.adresse_normalisee as "'.__("adresse_normalisee").'"',
    'dossier.adresse_normalisee_json as "'.__("adresse_normalisee_json").'"',
    'dossier.etat_transmission_platau as "'.__("etat_transmission_platau").'"',
    );
//
$champRecherche = array(
    'dossier.dossier as "'.__("dossier").'"',
    'dossier.annee as "'.__("annee").'"',
    'etat8.libelle as "'.__("etat").'"',
    'instructeur12.nom as "'.__("instructeur").'"',
    'dossier.delai as "'.__("delai").'"',
    'dossier.accord_tacite as "'.__("accord_tacite").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'division.libelle as "'.__("division").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    'dossier.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'dossier.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'dossier.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'dossier.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'dossier.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'dossier.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'dossier.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'dossier.terrain_superficie as "'.__("terrain_superficie").'"',
    'dossier_autorisation.dossier_autorisation_type_detaille as "'.__("dossier_autorisation").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'dossier.version as "'.__("version").'"',
    'evenement10.libelle as "'.__("evenement_suivant_tacite").'"',
    'evenement11.libelle as "'.__("evenement_suivant_tacite_incompletude").'"',
    'etat9.libelle as "'.__("etat_pendant_incompletude").'"',
    'dossier.delai_incompletude as "'.__("delai_incompletude").'"',
    'dossier.dossier_libelle as "'.__("dossier_libelle").'"',
    'dossier.numero_versement_archive as "'.__("numero_versement_archive").'"',
    'dossier.duree_validite as "'.__("duree_validite").'"',
    'quartier.libelle as "'.__("quartier").'"',
    'dossier.tax_secteur as "'.__("tax_secteur").'"',
    'dossier.tax_mtn_part_commu as "'.__("tax_mtn_part_commu").'"',
    'dossier.tax_mtn_part_depart as "'.__("tax_mtn_part_depart").'"',
    'dossier.tax_mtn_part_reg as "'.__("tax_mtn_part_reg").'"',
    'dossier.tax_mtn_total as "'.__("tax_mtn_total").'"',
    'dossier0.annee as "'.__("autorisation_contestee").'"',
    'instructeur13.nom as "'.__("instructeur_2").'"',
    'dossier.tax_mtn_rap as "'.__("tax_mtn_rap").'"',
    'dossier.tax_mtn_part_commu_sans_exo as "'.__("tax_mtn_part_commu_sans_exo").'"',
    'dossier.tax_mtn_part_depart_sans_exo as "'.__("tax_mtn_part_depart_sans_exo").'"',
    'dossier.tax_mtn_part_reg_sans_exo as "'.__("tax_mtn_part_reg_sans_exo").'"',
    'dossier.tax_mtn_total_sans_exo as "'.__("tax_mtn_total_sans_exo").'"',
    'dossier.tax_mtn_rap_sans_exo as "'.__("tax_mtn_rap_sans_exo").'"',
    'dossier.hash_sitadel as "'.__("hash_sitadel").'"',
    'dossier.version_clos as "'.__("version_clos").'"',
    'commune.libelle as "'.__("commune").'"',
    'dossier.numerotation_type as "'.__("numerotation_type").'"',
    'dossier.numerotation_dep as "'.__("numerotation_dep").'"',
    'dossier.numerotation_com as "'.__("numerotation_com").'"',
    'dossier.numerotation_division as "'.__("numerotation_division").'"',
    'dossier.numerotation_num as "'.__("numerotation_num").'"',
    'dossier.numerotation_suffixe as "'.__("numerotation_suffixe").'"',
    'dossier.numerotation_num_suffixe as "'.__("numerotation_num_suffixe").'"',
    'dossier.numerotation_entite as "'.__("numerotation_entite").'"',
    'dossier.numerotation_num_entite as "'.__("numerotation_num_entite").'"',
    'pec_metier.libelle as "'.__("pec_metier").'"',
    'dossier7.annee as "'.__("dossier_parent").'"',
    'dossier.terrain_superficie_calculee as "'.__("terrain_superficie_calculee").'"',
    'dossier.geoloc_latitude as "'.__("geoloc_latitude").'"',
    'dossier.geoloc_longitude as "'.__("geoloc_longitude").'"',
    'dossier.geoloc_rayon as "'.__("geoloc_rayon").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="dossier";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "autorite_competente" => array("autorite_competente", ),
    "avis_decision" => array("avis_decision", ),
    "commune" => array("commune", ),
    "division" => array("division", ),
    "dossier_autorisation" => array("dossier_autorisation", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "etat" => array("etat", ),
    "evenement" => array("evenement", ),
    "instructeur" => array("instructeur", ),
    "om_collectivite" => array("om_collectivite", ),
    "pec_metier" => array("pec_metier", ),
    "quartier" => array("quartier", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.autorisation_contestee = '".$f->db->escapeSimple($idxformulaire)."' OR dossier.dossier_parent = '".$f->db->escapeSimple($idxformulaire)."') ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.autorisation_contestee = '".$f->db->escapeSimple($idxformulaire)."' OR dossier.dossier_parent = '".$f->db->escapeSimple($idxformulaire)."') ";
    }
}
// Filtre listing sous formulaire - autorite_competente
if (in_array($retourformulaire, $foreign_keys_extended["autorite_competente"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.autorite_competente = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.autorite_competente = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - avis_decision
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.avis_decision = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.avis_decision = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - commune
if (in_array($retourformulaire, $foreign_keys_extended["commune"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.commune = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.commune = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - division
if (in_array($retourformulaire, $foreign_keys_extended["division"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.division = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.division = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.dossier_autorisation = '".$f->db->escapeSimple($idxformulaire)."') ";
    }
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.dossier_instruction_type = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.dossier_instruction_type = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - etat
if (in_array($retourformulaire, $foreign_keys_extended["etat"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.etat = '".$f->db->escapeSimple($idxformulaire)."' OR dossier.etat_pendant_incompletude = '".$f->db->escapeSimple($idxformulaire)."') ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.etat = '".$f->db->escapeSimple($idxformulaire)."' OR dossier.etat_pendant_incompletude = '".$f->db->escapeSimple($idxformulaire)."') ";
    }
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.evenement_suivant_tacite = ".intval($idxformulaire)." OR dossier.evenement_suivant_tacite_incompletude = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.evenement_suivant_tacite = ".intval($idxformulaire)." OR dossier.evenement_suivant_tacite_incompletude = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - instructeur
if (in_array($retourformulaire, $foreign_keys_extended["instructeur"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.instructeur = ".intval($idxformulaire)." OR dossier.instructeur_2 = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.instructeur = ".intval($idxformulaire)." OR dossier.instructeur_2 = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.om_collectivite = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - pec_metier
if (in_array($retourformulaire, $foreign_keys_extended["pec_metier"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.pec_metier = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.pec_metier = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - quartier
if (in_array($retourformulaire, $foreign_keys_extended["quartier"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier.quartier = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier.quartier = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'blocnote',
    'consultation',
    'consultation_entrante',
    'demande',
    'document_numerise',
    'donnees_techniques',
    'dossier',
    'dossier_commission',
    'dossier_contrainte',
    'dossier_geolocalisation',
    'dossier_message',
    'dossier_operateur',
    'dossier_parcelle',
    'instruction',
    'lien_dossier_demandeur',
    'lien_dossier_dossier',
    'lien_dossier_nature_travaux',
    'lien_dossier_tiers',
    'lot',
    'rapport_instruction',
);


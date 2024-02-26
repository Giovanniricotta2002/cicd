<?php
//$Id$ 
//gen openMairie le 22/10/2020 12:41

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_autorisation");
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
$table = DB_PREFIXE."dossier_autorisation
    LEFT JOIN ".DB_PREFIXE."arrondissement 
        ON dossier_autorisation.arrondissement=arrondissement.arrondissement 
    LEFT JOIN ".DB_PREFIXE."avis_decision 
        ON dossier_autorisation.avis_decision=avis_decision.avis_decision 
    LEFT JOIN ".DB_PREFIXE."commune 
        ON dossier_autorisation.commune=commune.commune 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN ".DB_PREFIXE."etat_dossier_autorisation as etat_dossier_autorisation4 
        ON dossier_autorisation.etat_dernier_dossier_instruction_accepte=etat_dossier_autorisation4.etat_dossier_autorisation 
    LEFT JOIN ".DB_PREFIXE."etat_dossier_autorisation as etat_dossier_autorisation5 
        ON dossier_autorisation.etat_dossier_autorisation=etat_dossier_autorisation5.etat_dossier_autorisation 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON dossier_autorisation.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'dossier_autorisation.dossier_autorisation as "'.__("dossier_autorisation").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'dossier_autorisation.exercice as "'.__("exercice").'"',
    'dossier_autorisation.insee as "'.__("insee").'"',
    'dossier_autorisation.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'dossier_autorisation.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'dossier_autorisation.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'dossier_autorisation.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'dossier_autorisation.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'dossier_autorisation.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'dossier_autorisation.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'dossier_autorisation.terrain_superficie as "'.__("terrain_superficie").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'to_char(dossier_autorisation.depot_initial ,\'DD/MM/YYYY\') as "'.__("depot_initial").'"',
    'dossier_autorisation.erp_numero_batiment as "'.__("erp_numero_batiment").'"',
    "case dossier_autorisation.erp_ouvert when 't' then 'Oui' else 'Non' end as \"".__("erp_ouvert")."\"",
    'to_char(dossier_autorisation.erp_date_ouverture ,\'DD/MM/YYYY\') as "'.__("erp_date_ouverture").'"',
    "case dossier_autorisation.erp_arrete_decision when 't' then 'Oui' else 'Non' end as \"".__("erp_arrete_decision")."\"",
    'to_char(dossier_autorisation.erp_date_arrete_decision ,\'DD/MM/YYYY\') as "'.__("erp_date_arrete_decision").'"',
    'dossier_autorisation.numero_version as "'.__("numero_version").'"',
    'etat_dossier_autorisation5.libelle as "'.__("etat_dossier_autorisation").'"',
    'to_char(dossier_autorisation.date_depot ,\'DD/MM/YYYY\') as "'.__("date_depot").'"',
    'to_char(dossier_autorisation.date_decision ,\'DD/MM/YYYY\') as "'.__("date_decision").'"',
    'to_char(dossier_autorisation.date_validite ,\'DD/MM/YYYY\') as "'.__("date_validite").'"',
    'to_char(dossier_autorisation.date_chantier ,\'DD/MM/YYYY\') as "'.__("date_chantier").'"',
    'to_char(dossier_autorisation.date_achevement ,\'DD/MM/YYYY\') as "'.__("date_achevement").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'etat_dossier_autorisation4.libelle as "'.__("etat_dernier_dossier_instruction_accepte").'"',
    'dossier_autorisation.dossier_autorisation_libelle as "'.__("dossier_autorisation_libelle").'"',
    'dossier_autorisation.cle_acces_citoyen as "'.__("cle_acces_citoyen").'"',
    'dossier_autorisation.numero_version_clos as "'.__("numero_version_clos").'"',
    'commune.libelle as "'.__("commune").'"',
    'dossier_autorisation.numerotation_type as "'.__("numerotation_type").'"',
    'dossier_autorisation.numerotation_dep as "'.__("numerotation_dep").'"',
    'dossier_autorisation.numerotation_com as "'.__("numerotation_com").'"',
    'dossier_autorisation.numerotation_division as "'.__("numerotation_division").'"',
    'dossier_autorisation.numerotation_num as "'.__("numerotation_num").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'dossier_autorisation.terrain_references_cadastrales as "'.__("terrain_references_cadastrales").'"',
    'dossier_autorisation.om_collectivite as "'.__("om_collectivite").'"',
    'dossier_autorisation.adresse_normalisee as "'.__("adresse_normalisee").'"',
    'dossier_autorisation.adresse_normalisee_json as "'.__("adresse_normalisee_json").'"',
    );
//
$champRecherche = array(
    'dossier_autorisation.dossier_autorisation as "'.__("dossier_autorisation").'"',
    'dossier_autorisation_type_detaille.libelle as "'.__("dossier_autorisation_type_detaille").'"',
    'dossier_autorisation.exercice as "'.__("exercice").'"',
    'dossier_autorisation.insee as "'.__("insee").'"',
    'dossier_autorisation.terrain_adresse_voie_numero as "'.__("terrain_adresse_voie_numero").'"',
    'dossier_autorisation.terrain_adresse_voie as "'.__("terrain_adresse_voie").'"',
    'dossier_autorisation.terrain_adresse_lieu_dit as "'.__("terrain_adresse_lieu_dit").'"',
    'dossier_autorisation.terrain_adresse_localite as "'.__("terrain_adresse_localite").'"',
    'dossier_autorisation.terrain_adresse_code_postal as "'.__("terrain_adresse_code_postal").'"',
    'dossier_autorisation.terrain_adresse_bp as "'.__("terrain_adresse_bp").'"',
    'dossier_autorisation.terrain_adresse_cedex as "'.__("terrain_adresse_cedex").'"',
    'dossier_autorisation.terrain_superficie as "'.__("terrain_superficie").'"',
    'arrondissement.libelle as "'.__("arrondissement").'"',
    'dossier_autorisation.erp_numero_batiment as "'.__("erp_numero_batiment").'"',
    'dossier_autorisation.numero_version as "'.__("numero_version").'"',
    'etat_dossier_autorisation5.libelle as "'.__("etat_dossier_autorisation").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'etat_dossier_autorisation4.libelle as "'.__("etat_dernier_dossier_instruction_accepte").'"',
    'dossier_autorisation.dossier_autorisation_libelle as "'.__("dossier_autorisation_libelle").'"',
    'dossier_autorisation.cle_acces_citoyen as "'.__("cle_acces_citoyen").'"',
    'dossier_autorisation.numero_version_clos as "'.__("numero_version_clos").'"',
    'commune.libelle as "'.__("commune").'"',
    'dossier_autorisation.numerotation_type as "'.__("numerotation_type").'"',
    'dossier_autorisation.numerotation_dep as "'.__("numerotation_dep").'"',
    'dossier_autorisation.numerotation_com as "'.__("numerotation_com").'"',
    'dossier_autorisation.numerotation_division as "'.__("numerotation_division").'"',
    'dossier_autorisation.numerotation_num as "'.__("numerotation_num").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY dossier_autorisation_type_detaille.libelle ASC NULLS LAST";
$edition="dossier_autorisation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "arrondissement" => array("arrondissement", ),
    "avis_decision" => array("avis_decision", ),
    "commune" => array("commune", ),
    "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
    "etat_dossier_autorisation" => array("etat_dossier_autorisation", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - arrondissement
if (in_array($retourformulaire, $foreign_keys_extended["arrondissement"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.arrondissement = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.arrondissement = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - avis_decision
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.avis_decision = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.avis_decision = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - commune
if (in_array($retourformulaire, $foreign_keys_extended["commune"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.commune = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.commune = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - dossier_autorisation_type_detaille
if (in_array($retourformulaire, $foreign_keys_extended["dossier_autorisation_type_detaille"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.dossier_autorisation_type_detaille = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - etat_dossier_autorisation
if (in_array($retourformulaire, $foreign_keys_extended["etat_dossier_autorisation"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.etat_dernier_dossier_instruction_accepte = ".intval($idxformulaire)." OR dossier_autorisation.etat_dossier_autorisation = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.etat_dernier_dossier_instruction_accepte = ".intval($idxformulaire)." OR dossier_autorisation.etat_dossier_autorisation = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (dossier_autorisation.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (dossier_autorisation.om_collectivite = '".$_SESSION["collectivite"]."') AND (dossier_autorisation.om_collectivite = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'demande',
    'donnees_techniques',
    'dossier',
    'dossier_autorisation_parcelle',
    'lien_dossier_autorisation_demandeur',
    'lot',
);


<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("habilitation_tiers_consulte");
$om_validite = true;
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
$table = DB_PREFIXE."habilitation_tiers_consulte
    LEFT JOIN ".DB_PREFIXE."tiers_consulte 
        ON habilitation_tiers_consulte.tiers_consulte=tiers_consulte.tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."type_habilitation_tiers_consulte 
        ON habilitation_tiers_consulte.type_habilitation_tiers_consulte=type_habilitation_tiers_consulte.type_habilitation_tiers_consulte ";
// SELECT 
$champAffiche = array(
    'habilitation_tiers_consulte.habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
    'to_char(habilitation_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(habilitation_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    );
//
$champNonAffiche = array(
    'habilitation_tiers_consulte.texte_agrement as "'.__("texte_agrement").'"',
    'habilitation_tiers_consulte.division_territoriales as "'.__("division_territoriales").'"',
    );
//
$champRecherche = array(
    'habilitation_tiers_consulte.habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    );
$tri="ORDER BY type_habilitation_tiers_consulte.libelle ASC NULLS LAST";
$edition="habilitation_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "tiers_consulte" => array("tiers_consulte", ),
    "type_habilitation_tiers_consulte" => array("type_habilitation_tiers_consulte", ),
);
// Filtre listing sous formulaire - tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["tiers_consulte"])) {
    $selection = " WHERE (habilitation_tiers_consulte.tiers_consulte = ".intval($idxformulaire).")  AND ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - type_habilitation_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["type_habilitation_tiers_consulte"])) {
    $selection = " WHERE (habilitation_tiers_consulte.type_habilitation_tiers_consulte = ".intval($idxformulaire).")  AND ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
}
// Gestion OMValidité - Suppression du filtre si paramètre
if (isset($_GET["valide"]) and $_GET["valide"] == "false") {
    if (!isset($where_om_validite)
        or (isset($where_om_validite) and $where_om_validite == "")) {
        if (trim($selection) != "") {
            $selection = "";
        }
    } else {
        $selection = trim(str_replace($where_om_validite, "", $selection));
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'lien_habilitation_tiers_consulte_commune',
    'lien_habilitation_tiers_consulte_departement',
    'lien_habilitation_tiers_consulte_specialite_tiers_consulte',
);


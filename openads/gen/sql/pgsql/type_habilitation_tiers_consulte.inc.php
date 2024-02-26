<?php
//$Id$ 
//gen openMairie le 17/10/2022 11:48

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("type_habilitation_tiers_consulte");
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
$table = DB_PREFIXE."type_habilitation_tiers_consulte";
// SELECT 
$champAffiche = array(
    'type_habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("type_habilitation_tiers_consulte").'"',
    'type_habilitation_tiers_consulte.code as "'.__("code").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("libelle").'"',
    'to_char(type_habilitation_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(type_habilitation_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'type_habilitation_tiers_consulte.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'type_habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("type_habilitation_tiers_consulte").'"',
    'type_habilitation_tiers_consulte.code as "'.__("code").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY type_habilitation_tiers_consulte.libelle ASC NULLS LAST";
$edition="type_habilitation_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((type_habilitation_tiers_consulte.om_validite_debut IS NULL AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((type_habilitation_tiers_consulte.om_validite_debut IS NULL AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
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
    'evenement_type_habilitation_tiers_consulte',
    'habilitation_tiers_consulte',
);


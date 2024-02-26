<?php
//$Id$ 
//gen openMairie le 25/02/2022 15:50

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("specialite_tiers_consulte");
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
$table = DB_PREFIXE."specialite_tiers_consulte";
// SELECT 
$champAffiche = array(
    'specialite_tiers_consulte.specialite_tiers_consulte as "'.__("specialite_tiers_consulte").'"',
    'specialite_tiers_consulte.code as "'.__("code").'"',
    'specialite_tiers_consulte.libelle as "'.__("libelle").'"',
    'to_char(specialite_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(specialite_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'specialite_tiers_consulte.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'specialite_tiers_consulte.specialite_tiers_consulte as "'.__("specialite_tiers_consulte").'"',
    'specialite_tiers_consulte.code as "'.__("code").'"',
    'specialite_tiers_consulte.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY specialite_tiers_consulte.libelle ASC NULLS LAST";
$edition="specialite_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((specialite_tiers_consulte.om_validite_debut IS NULL AND (specialite_tiers_consulte.om_validite_fin IS NULL OR specialite_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (specialite_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (specialite_tiers_consulte.om_validite_fin IS NULL OR specialite_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((specialite_tiers_consulte.om_validite_debut IS NULL AND (specialite_tiers_consulte.om_validite_fin IS NULL OR specialite_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (specialite_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (specialite_tiers_consulte.om_validite_fin IS NULL OR specialite_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
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
    'lien_habilitation_tiers_consulte_specialite_tiers_consulte',
);


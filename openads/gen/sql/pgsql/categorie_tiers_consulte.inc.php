<?php
//$Id$ 
//gen openMairie le 23/01/2023 14:57

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("categorie_tiers_consulte");
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
$table = DB_PREFIXE."categorie_tiers_consulte";
// SELECT 
$champAffiche = array(
    'categorie_tiers_consulte.categorie_tiers_consulte as "'.__("categorie_tiers_consulte").'"',
    'categorie_tiers_consulte.code as "'.__("code").'"',
    'categorie_tiers_consulte.libelle as "'.__("libelle").'"',
    'to_char(categorie_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(categorie_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'categorie_tiers_consulte.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'categorie_tiers_consulte.categorie_tiers_consulte as "'.__("categorie_tiers_consulte").'"',
    'categorie_tiers_consulte.code as "'.__("code").'"',
    'categorie_tiers_consulte.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY categorie_tiers_consulte.libelle ASC NULLS LAST";
$edition="categorie_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((categorie_tiers_consulte.om_validite_debut IS NULL AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((categorie_tiers_consulte.om_validite_debut IS NULL AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)))";
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
    'consultation',
    'lien_categorie_tiers_consulte_om_collectivite',
    'lien_dossier_instruction_type_categorie_tiers',
    'tiers_consulte',
);


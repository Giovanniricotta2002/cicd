<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:19

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("famille_travaux");
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
$table = DB_PREFIXE."famille_travaux";
// SELECT 
$champAffiche = array(
    'famille_travaux.famille_travaux as "'.__("famille_travaux").'"',
    'famille_travaux.libelle as "'.__("libelle").'"',
    'famille_travaux.code as "'.__("code").'"',
    'to_char(famille_travaux.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(famille_travaux.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'famille_travaux.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'famille_travaux.famille_travaux as "'.__("famille_travaux").'"',
    'famille_travaux.libelle as "'.__("libelle").'"',
    'famille_travaux.code as "'.__("code").'"',
    );
$tri="ORDER BY famille_travaux.libelle ASC NULLS LAST";
$edition="famille_travaux";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((famille_travaux.om_validite_debut IS NULL AND (famille_travaux.om_validite_fin IS NULL OR famille_travaux.om_validite_fin > CURRENT_DATE)) OR (famille_travaux.om_validite_debut <= CURRENT_DATE AND (famille_travaux.om_validite_fin IS NULL OR famille_travaux.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((famille_travaux.om_validite_debut IS NULL AND (famille_travaux.om_validite_fin IS NULL OR famille_travaux.om_validite_fin > CURRENT_DATE)) OR (famille_travaux.om_validite_debut <= CURRENT_DATE AND (famille_travaux.om_validite_fin IS NULL OR famille_travaux.om_validite_fin > CURRENT_DATE)))";
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
    'nature_travaux',
);


<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("moyen_retenu_juge");
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
$table = DB_PREFIXE."moyen_retenu_juge";
// SELECT 
$champAffiche = array(
    'moyen_retenu_juge.moyen_retenu_juge as "'.__("moyen_retenu_juge").'"',
    'moyen_retenu_juge.code as "'.__("code").'"',
    'moyen_retenu_juge.libelle as "'.__("libelle").'"',
    'to_char(moyen_retenu_juge.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(moyen_retenu_juge.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'moyen_retenu_juge.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'moyen_retenu_juge.moyen_retenu_juge as "'.__("moyen_retenu_juge").'"',
    'moyen_retenu_juge.code as "'.__("code").'"',
    'moyen_retenu_juge.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY moyen_retenu_juge.libelle ASC NULLS LAST";
$edition="moyen_retenu_juge";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((moyen_retenu_juge.om_validite_debut IS NULL AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)) OR (moyen_retenu_juge.om_validite_debut <= CURRENT_DATE AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((moyen_retenu_juge.om_validite_debut IS NULL AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)) OR (moyen_retenu_juge.om_validite_debut <= CURRENT_DATE AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)))";
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
    'lien_donnees_techniques_moyen_retenu_juge',
);


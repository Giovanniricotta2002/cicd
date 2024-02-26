<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("administration")." -> ".__("om_profil");
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
$table = DB_PREFIXE."om_profil";
// SELECT 
$champAffiche = array(
    'om_profil.om_profil as "'.__("om_profil").'"',
    'om_profil.libelle as "'.__("libelle").'"',
    'om_profil.hierarchie as "'.__("hierarchie").'"',
    'to_char(om_profil.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(om_profil.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'om_profil.om_profil as "'.__("om_profil").'"',
    'om_profil.libelle as "'.__("libelle").'"',
    'om_profil.hierarchie as "'.__("hierarchie").'"',
    );
$tri="ORDER BY om_profil.libelle ASC NULLS LAST";
$edition="om_profil";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((om_profil.om_validite_debut IS NULL AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE)) OR (om_profil.om_validite_debut <= CURRENT_DATE AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((om_profil.om_validite_debut IS NULL AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE)) OR (om_profil.om_validite_debut <= CURRENT_DATE AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE)))";
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
    'lien_om_profil_groupe',
    'om_dashboard',
    'om_droit',
    'om_utilisateur',
);


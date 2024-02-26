<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("objet_recours");
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
$table = DB_PREFIXE."objet_recours";
// SELECT 
$champAffiche = array(
    'objet_recours.objet_recours as "'.__("objet_recours").'"',
    'objet_recours.code as "'.__("code").'"',
    'objet_recours.libelle as "'.__("libelle").'"',
    'to_char(objet_recours.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(objet_recours.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'objet_recours.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'objet_recours.objet_recours as "'.__("objet_recours").'"',
    'objet_recours.code as "'.__("code").'"',
    'objet_recours.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY objet_recours.libelle ASC NULLS LAST";
$edition="objet_recours";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((objet_recours.om_validite_debut IS NULL AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)) OR (objet_recours.om_validite_debut <= CURRENT_DATE AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((objet_recours.om_validite_debut IS NULL AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)) OR (objet_recours.om_validite_debut <= CURRENT_DATE AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)))";
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
    'donnees_techniques',
);


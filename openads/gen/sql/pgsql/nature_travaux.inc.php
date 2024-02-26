<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("nature_travaux");
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
$table = DB_PREFIXE."nature_travaux
    LEFT JOIN ".DB_PREFIXE."famille_travaux 
        ON nature_travaux.famille_travaux=famille_travaux.famille_travaux ";
// SELECT 
$champAffiche = array(
    'nature_travaux.nature_travaux as "'.__("nature_travaux").'"',
    'nature_travaux.libelle as "'.__("libelle").'"',
    'nature_travaux.code as "'.__("code").'"',
    'famille_travaux.libelle as "'.__("famille_travaux").'"',
    'to_char(nature_travaux.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(nature_travaux.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'nature_travaux.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'nature_travaux.nature_travaux as "'.__("nature_travaux").'"',
    'nature_travaux.libelle as "'.__("libelle").'"',
    'nature_travaux.code as "'.__("code").'"',
    'famille_travaux.libelle as "'.__("famille_travaux").'"',
    );
$tri="ORDER BY nature_travaux.libelle ASC NULLS LAST";
$edition="nature_travaux";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((nature_travaux.om_validite_debut IS NULL AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)) OR (nature_travaux.om_validite_debut <= CURRENT_DATE AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((nature_travaux.om_validite_debut IS NULL AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)) OR (nature_travaux.om_validite_debut <= CURRENT_DATE AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "famille_travaux" => array("famille_travaux", ),
);
// Filtre listing sous formulaire - famille_travaux
if (in_array($retourformulaire, $foreign_keys_extended["famille_travaux"])) {
    $selection = " WHERE (nature_travaux.famille_travaux = ".intval($idxformulaire).")  AND ((nature_travaux.om_validite_debut IS NULL AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)) OR (nature_travaux.om_validite_debut <= CURRENT_DATE AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((nature_travaux.om_validite_debut IS NULL AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)) OR (nature_travaux.om_validite_debut <= CURRENT_DATE AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)))";
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
    'lien_dit_nature_travaux',
    'lien_dossier_nature_travaux',
);


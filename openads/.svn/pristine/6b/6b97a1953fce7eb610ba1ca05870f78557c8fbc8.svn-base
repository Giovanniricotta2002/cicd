<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("contrainte");
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
$table = DB_PREFIXE."contrainte
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON contrainte.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'contrainte.contrainte as "'.__("contrainte").'"',
    'contrainte.numero as "'.__("numero").'"',
    'contrainte.nature as "'.__("nature").'"',
    'contrainte.groupe as "'.__("groupe").'"',
    'contrainte.sousgroupe as "'.__("sousgroupe").'"',
    'contrainte.libelle as "'.__("libelle").'"',
    'contrainte.no_ordre as "'.__("no_ordre").'"',
    "case contrainte.reference when 't' then 'Oui' else 'Non' end as \"".__("reference")."\"",
    "case contrainte.service_consulte when 't' then 'Oui' else 'Non' end as \"".__("service_consulte")."\"",
    'to_char(contrainte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(contrainte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'contrainte.texte as "'.__("texte").'"',
    'contrainte.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'contrainte.contrainte as "'.__("contrainte").'"',
    'contrainte.numero as "'.__("numero").'"',
    'contrainte.nature as "'.__("nature").'"',
    'contrainte.groupe as "'.__("groupe").'"',
    'contrainte.sousgroupe as "'.__("sousgroupe").'"',
    'contrainte.libelle as "'.__("libelle").'"',
    'contrainte.no_ordre as "'.__("no_ordre").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY contrainte.libelle ASC NULLS LAST";
$edition="contrainte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (contrainte.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (contrainte.om_collectivite = ".intval($idxformulaire).")  AND ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (contrainte.om_collectivite = '".$_SESSION["collectivite"]."') AND (contrainte.om_collectivite = ".intval($idxformulaire).")  AND ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)))";
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
    'dossier_contrainte',
);


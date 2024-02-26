<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("instructeur");
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
$table = DB_PREFIXE."instructeur
    LEFT JOIN ".DB_PREFIXE."division 
        ON instructeur.division=division.division 
    LEFT JOIN ".DB_PREFIXE."instructeur_qualite 
        ON instructeur.instructeur_qualite=instructeur_qualite.instructeur_qualite 
    LEFT JOIN ".DB_PREFIXE."om_utilisateur 
        ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur ";
// SELECT 
$champAffiche = array(
    'instructeur.instructeur as "'.__("instructeur").'"',
    'instructeur.nom as "'.__("nom").'"',
    'instructeur.telephone as "'.__("telephone").'"',
    'division.libelle as "'.__("division").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'to_char(instructeur.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(instructeur.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'instructeur_qualite.libelle as "'.__("instructeur_qualite").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'instructeur.instructeur as "'.__("instructeur").'"',
    'instructeur.nom as "'.__("nom").'"',
    'instructeur.telephone as "'.__("telephone").'"',
    'division.libelle as "'.__("division").'"',
    'om_utilisateur.nom as "'.__("om_utilisateur").'"',
    'instructeur_qualite.libelle as "'.__("instructeur_qualite").'"',
    );
$tri="ORDER BY instructeur.nom ASC NULLS LAST";
$edition="instructeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "division" => array("division", ),
    "instructeur_qualite" => array("instructeur_qualite", ),
    "om_utilisateur" => array("om_utilisateur", ),
);
// Filtre listing sous formulaire - division
if (in_array($retourformulaire, $foreign_keys_extended["division"])) {
    $selection = " WHERE (instructeur.division = ".intval($idxformulaire).")  AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - instructeur_qualite
if (in_array($retourformulaire, $foreign_keys_extended["instructeur_qualite"])) {
    $selection = " WHERE (instructeur.instructeur_qualite = ".intval($idxformulaire).")  AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - om_utilisateur
if (in_array($retourformulaire, $foreign_keys_extended["om_utilisateur"])) {
    $selection = " WHERE (instructeur.om_utilisateur = ".intval($idxformulaire).")  AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))";
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
    'affectation_automatique',
    'dossier',
);


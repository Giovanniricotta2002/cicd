<?php
//$Id$ 
//gen openMairie le 21/02/2022 16:51

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("service");
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
$table = DB_PREFIXE."service
    LEFT JOIN ".DB_PREFIXE."om_etat 
        ON service.edition=om_etat.om_etat 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON service.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'service.service as "'.__("service").'"',
    'service.abrege as "'.__("abrege").'"',
    'service.libelle as "'.__("libelle").'"',
    'service.adresse as "'.__("adresse").'"',
    'service.adresse2 as "'.__("adresse2").'"',
    'service.cp as "'.__("cp").'"',
    'service.ville as "'.__("ville").'"',
    'service.delai as "'.__("delai").'"',
    "case service.consultation_papier when 't' then 'Oui' else 'Non' end as \"".__("consultation_papier")."\"",
    "case service.notification_email when 't' then 'Oui' else 'Non' end as \"".__("notification_email")."\"",
    'to_char(service.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(service.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'service.type_consultation as "'.__("type_consultation").'"',
    'om_etat.libelle as "'.__("edition").'"',
    'service.delai_type as "'.__("delai_type").'"',
    'service.service_type as "'.__("service_type").'"',
    "case service.generate_edition when 't' then 'Oui' else 'Non' end as \"".__("generate_edition")."\"",
    'service.uid_platau_acteur as "'.__("uid_platau_acteur").'"',
    "case service.accepte_notification_email when 't' then 'Oui' else 'Non' end as \"".__("accepte_notification_email")."\"",
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'service.email as "'.__("email").'"',
    'service.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'service.service as "'.__("service").'"',
    'service.abrege as "'.__("abrege").'"',
    'service.libelle as "'.__("libelle").'"',
    'service.adresse as "'.__("adresse").'"',
    'service.adresse2 as "'.__("adresse2").'"',
    'service.cp as "'.__("cp").'"',
    'service.ville as "'.__("ville").'"',
    'service.delai as "'.__("delai").'"',
    'service.type_consultation as "'.__("type_consultation").'"',
    'om_etat.libelle as "'.__("edition").'"',
    'service.delai_type as "'.__("delai_type").'"',
    'service.service_type as "'.__("service_type").'"',
    'service.uid_platau_acteur as "'.__("uid_platau_acteur").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY service.libelle ASC NULLS LAST";
$edition="service";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (service.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_etat" => array("om_etat", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_etat
if (in_array($retourformulaire, $foreign_keys_extended["om_etat"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (service.edition = ".intval($idxformulaire).")  AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (service.om_collectivite = '".$_SESSION["collectivite"]."') AND (service.edition = ".intval($idxformulaire).")  AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (service.om_collectivite = ".intval($idxformulaire).")  AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (service.om_collectivite = '".$_SESSION["collectivite"]."') AND (service.om_collectivite = ".intval($idxformulaire).")  AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)))";
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
    'consultation',
    'lien_service_om_utilisateur',
    'lien_service_service_categorie',
);


<?php
//$Id$ 
//gen openMairie le 18/03/2022 19:10

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("motif_consultation");
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
$table = DB_PREFIXE."motif_consultation
    LEFT JOIN ".DB_PREFIXE."om_etat 
        ON motif_consultation.om_etat=om_etat.om_etat ";
// SELECT 
$champAffiche = array(
    'motif_consultation.motif_consultation as "'.__("motif_consultation").'"',
    'motif_consultation.code as "'.__("code").'"',
    'motif_consultation.libelle as "'.__("libelle").'"',
    "case motif_consultation.notification_email when 't' then 'Oui' else 'Non' end as \"".__("notification_email")."\"",
    'motif_consultation.delai_type as "'.__("delai_type").'"',
    'motif_consultation.delai as "'.__("delai").'"',
    "case motif_consultation.consultation_papier when 't' then 'Oui' else 'Non' end as \"".__("consultation_papier")."\"",
    'to_char(motif_consultation.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(motif_consultation.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'motif_consultation.type_consultation as "'.__("type_consultation").'"',
    'om_etat.libelle as "'.__("om_etat").'"',
    'motif_consultation.service_type as "'.__("service_type").'"',
    "case motif_consultation.generate_edition when 't' then 'Oui' else 'Non' end as \"".__("generate_edition")."\"",
    );
//
$champNonAffiche = array(
    'motif_consultation.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'motif_consultation.motif_consultation as "'.__("motif_consultation").'"',
    'motif_consultation.code as "'.__("code").'"',
    'motif_consultation.libelle as "'.__("libelle").'"',
    'motif_consultation.delai_type as "'.__("delai_type").'"',
    'motif_consultation.delai as "'.__("delai").'"',
    'motif_consultation.type_consultation as "'.__("type_consultation").'"',
    'om_etat.libelle as "'.__("om_etat").'"',
    'motif_consultation.service_type as "'.__("service_type").'"',
    );
$tri="ORDER BY motif_consultation.libelle ASC NULLS LAST";
$edition="motif_consultation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_etat" => array("om_etat", ),
);
// Filtre listing sous formulaire - om_etat
if (in_array($retourformulaire, $foreign_keys_extended["om_etat"])) {
    $selection = " WHERE (motif_consultation.om_etat = ".intval($idxformulaire).")  AND ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)))";
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
    'lien_motif_consultation_om_collectivite',
);


<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("commission_type");
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
$table = DB_PREFIXE."commission_type
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON commission_type.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'commission_type.commission_type as "'.__("commission_type").'"',
    'commission_type.code as "'.__("code").'"',
    'commission_type.libelle as "'.__("libelle").'"',
    'commission_type.lieu_adresse_ligne1 as "'.__("lieu_adresse_ligne1").'"',
    'commission_type.lieu_adresse_ligne2 as "'.__("lieu_adresse_ligne2").'"',
    'commission_type.lieu_salle as "'.__("lieu_salle").'"',
    'to_char(commission_type.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(commission_type.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'commission_type.listes_de_diffusion as "'.__("listes_de_diffusion").'"',
    'commission_type.participants as "'.__("participants").'"',
    'commission_type.corps_du_courriel as "'.__("corps_du_courriel").'"',
    'commission_type.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'commission_type.commission_type as "'.__("commission_type").'"',
    'commission_type.code as "'.__("code").'"',
    'commission_type.libelle as "'.__("libelle").'"',
    'commission_type.lieu_adresse_ligne1 as "'.__("lieu_adresse_ligne1").'"',
    'commission_type.lieu_adresse_ligne2 as "'.__("lieu_adresse_ligne2").'"',
    'commission_type.lieu_salle as "'.__("lieu_salle").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY commission_type.libelle ASC NULLS LAST";
$edition="commission_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (commission_type.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (commission_type.om_collectivite = ".intval($idxformulaire).")  AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (commission_type.om_collectivite = '".$_SESSION["collectivite"]."') AND (commission_type.om_collectivite = ".intval($idxformulaire).")  AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)))";
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
    'commission',
    'dossier_commission',
);


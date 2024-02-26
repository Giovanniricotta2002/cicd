<?php
//$Id$ 
//gen openMairie le 14/03/2022 16:43

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("signataire_arrete");
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
$table = DB_PREFIXE."signataire_arrete
    LEFT JOIN ".DB_PREFIXE."civilite 
        ON signataire_arrete.civilite=civilite.civilite 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON signataire_arrete.om_collectivite=om_collectivite.om_collectivite 
    LEFT JOIN ".DB_PREFIXE."signataire_habilitation 
        ON signataire_arrete.signataire_habilitation=signataire_habilitation.signataire_habilitation ";
// SELECT 
$champAffiche = array(
    'signataire_arrete.signataire_arrete as "'.__("signataire_arrete").'"',
    'civilite.libelle as "'.__("civilite").'"',
    'signataire_arrete.nom as "'.__("nom").'"',
    'signataire_arrete.prenom as "'.__("prenom").'"',
    'signataire_arrete.qualite as "'.__("qualite").'"',
    "case signataire_arrete.defaut when 't' then 'Oui' else 'Non' end as \"".__("defaut")."\"",
    'to_char(signataire_arrete.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(signataire_arrete.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'signataire_arrete.email as "'.__("email").'"',
    'signataire_arrete.description as "'.__("description").'"',
    'signataire_habilitation.libelle as "'.__("signataire_habilitation").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'signataire_arrete.signature as "'.__("signature").'"',
    'signataire_arrete.om_collectivite as "'.__("om_collectivite").'"',
    'signataire_arrete.parametre_parapheur as "'.__("parametre_parapheur").'"',
    'signataire_arrete.agrement as "'.__("agrement").'"',
    'signataire_arrete.visa as "'.__("visa").'"',
    'signataire_arrete.visa_2 as "'.__("visa_2").'"',
    'signataire_arrete.visa_3 as "'.__("visa_3").'"',
    'signataire_arrete.visa_4 as "'.__("visa_4").'"',
    );
//
$champRecherche = array(
    'signataire_arrete.signataire_arrete as "'.__("signataire_arrete").'"',
    'civilite.libelle as "'.__("civilite").'"',
    'signataire_arrete.nom as "'.__("nom").'"',
    'signataire_arrete.prenom as "'.__("prenom").'"',
    'signataire_arrete.qualite as "'.__("qualite").'"',
    'signataire_arrete.email as "'.__("email").'"',
    'signataire_arrete.description as "'.__("description").'"',
    'signataire_habilitation.libelle as "'.__("signataire_habilitation").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY civilite.libelle ASC NULLS LAST";
$edition="signataire_arrete";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = " WHERE ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
} else {
    // Filtre MONO
    $selection = " WHERE (signataire_arrete.om_collectivite = '".$_SESSION["collectivite"]."')  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "civilite" => array("civilite", ),
    "om_collectivite" => array("om_collectivite", ),
    "signataire_habilitation" => array("signataire_habilitation", ),
);
// Filtre listing sous formulaire - civilite
if (in_array($retourformulaire, $foreign_keys_extended["civilite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (signataire_arrete.civilite = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (signataire_arrete.om_collectivite = '".$_SESSION["collectivite"]."') AND (signataire_arrete.civilite = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (signataire_arrete.om_collectivite = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (signataire_arrete.om_collectivite = '".$_SESSION["collectivite"]."') AND (signataire_arrete.om_collectivite = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
}
// Filtre listing sous formulaire - signataire_habilitation
if (in_array($retourformulaire, $foreign_keys_extended["signataire_habilitation"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (signataire_arrete.signataire_habilitation = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    } else {
        // Filtre MONO
        $selection = " WHERE (signataire_arrete.om_collectivite = '".$_SESSION["collectivite"]."') AND (signataire_arrete.signataire_habilitation = ".intval($idxformulaire).")  AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
    }
$where_om_validite = " AND ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)))";
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
    'instruction',
);


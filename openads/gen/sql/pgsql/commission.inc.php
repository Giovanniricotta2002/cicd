<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("commission");
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
$table = DB_PREFIXE."commission
    LEFT JOIN ".DB_PREFIXE."commission_type 
        ON commission.commission_type=commission_type.commission_type 
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON commission.om_collectivite=om_collectivite.om_collectivite ";
// SELECT 
$champAffiche = array(
    'commission.commission as "'.__("commission").'"',
    'commission.code as "'.__("code").'"',
    'commission_type.libelle as "'.__("commission_type").'"',
    'commission.libelle as "'.__("libelle").'"',
    'to_char(commission.date_commission ,\'DD/MM/YYYY\') as "'.__("date_commission").'"',
    'commission.heure_commission as "'.__("heure_commission").'"',
    'commission.lieu_adresse_ligne1 as "'.__("lieu_adresse_ligne1").'"',
    'commission.lieu_adresse_ligne2 as "'.__("lieu_adresse_ligne2").'"',
    'commission.lieu_salle as "'.__("lieu_salle").'"',
    'commission.om_fichier_commission_ordre_jour as "'.__("om_fichier_commission_ordre_jour").'"',
    "case commission.om_final_commission_ordre_jour when 't' then 'Oui' else 'Non' end as \"".__("om_final_commission_ordre_jour")."\"",
    'commission.om_fichier_commission_compte_rendu as "'.__("om_fichier_commission_compte_rendu").'"',
    "case commission.om_final_commission_compte_rendu when 't' then 'Oui' else 'Non' end as \"".__("om_final_commission_compte_rendu")."\"",
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'commission.listes_de_diffusion as "'.__("listes_de_diffusion").'"',
    'commission.participants as "'.__("participants").'"',
    'commission.om_collectivite as "'.__("om_collectivite").'"',
    );
//
$champRecherche = array(
    'commission.commission as "'.__("commission").'"',
    'commission.code as "'.__("code").'"',
    'commission_type.libelle as "'.__("commission_type").'"',
    'commission.libelle as "'.__("libelle").'"',
    'commission.heure_commission as "'.__("heure_commission").'"',
    'commission.lieu_adresse_ligne1 as "'.__("lieu_adresse_ligne1").'"',
    'commission.lieu_adresse_ligne2 as "'.__("lieu_adresse_ligne2").'"',
    'commission.lieu_salle as "'.__("lieu_salle").'"',
    'commission.om_fichier_commission_ordre_jour as "'.__("om_fichier_commission_ordre_jour").'"',
    'commission.om_fichier_commission_compte_rendu as "'.__("om_fichier_commission_compte_rendu").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY commission.libelle ASC NULLS LAST";
$edition="commission";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (commission.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "commission_type" => array("commission_type", ),
    "om_collectivite" => array("om_collectivite", ),
);
// Filtre listing sous formulaire - commission_type
if (in_array($retourformulaire, $foreign_keys_extended["commission_type"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (commission.commission_type = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (commission.om_collectivite = '".$_SESSION["collectivite"]."') AND (commission.commission_type = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (commission.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (commission.om_collectivite = '".$_SESSION["collectivite"]."') AND (commission.om_collectivite = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'dossier_commission',
);


<?php
//$Id$ 
//gen openMairie le 23/01/2023 14:57

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("tiers_consulte");
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
$table = DB_PREFIXE."tiers_consulte
    LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte 
        ON tiers_consulte.categorie_tiers_consulte=categorie_tiers_consulte.categorie_tiers_consulte ";
// SELECT 
$champAffiche = array(
    'tiers_consulte.tiers_consulte as "'.__("tiers_consulte").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    'tiers_consulte.abrege as "'.__("abrege").'"',
    'tiers_consulte.libelle as "'.__("libelle").'"',
    'tiers_consulte.adresse as "'.__("adresse").'"',
    'tiers_consulte.complement as "'.__("complement").'"',
    'tiers_consulte.cp as "'.__("cp").'"',
    'tiers_consulte.ville as "'.__("ville").'"',
    "case tiers_consulte.accepte_notification_email when 't' then 'Oui' else 'Non' end as \"".__("accepte_notification_email")."\"",
    'tiers_consulte.uid_platau_acteur as "'.__("uid_platau_acteur").'"',
    );
//
$champNonAffiche = array(
    'tiers_consulte.liste_diffusion as "'.__("liste_diffusion").'"',
    );
//
$champRecherche = array(
    'tiers_consulte.tiers_consulte as "'.__("tiers_consulte").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    'tiers_consulte.abrege as "'.__("abrege").'"',
    'tiers_consulte.libelle as "'.__("libelle").'"',
    'tiers_consulte.adresse as "'.__("adresse").'"',
    'tiers_consulte.complement as "'.__("complement").'"',
    'tiers_consulte.cp as "'.__("cp").'"',
    'tiers_consulte.ville as "'.__("ville").'"',
    'tiers_consulte.uid_platau_acteur as "'.__("uid_platau_acteur").'"',
    );
$tri="ORDER BY tiers_consulte.libelle ASC NULLS LAST";
$edition="tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
);
// Filtre listing sous formulaire - categorie_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["categorie_tiers_consulte"])) {
    $selection = " WHERE (tiers_consulte.categorie_tiers_consulte = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'consultation',
    'dossier_operateur',
    'habilitation_tiers_consulte',
    'lien_dossier_tiers',
    'lien_om_utilisateur_tiers_consulte',
);


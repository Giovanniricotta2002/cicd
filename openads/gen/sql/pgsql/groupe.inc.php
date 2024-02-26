<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("groupe");
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
$table = DB_PREFIXE."groupe
    LEFT JOIN ".DB_PREFIXE."genre 
        ON groupe.genre=genre.genre ";
// SELECT 
$champAffiche = array(
    'groupe.groupe as "'.__("groupe").'"',
    'groupe.code as "'.__("code").'"',
    'groupe.libelle as "'.__("libelle").'"',
    'genre.libelle as "'.__("genre").'"',
    );
//
$champNonAffiche = array(
    'groupe.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'groupe.groupe as "'.__("groupe").'"',
    'groupe.code as "'.__("code").'"',
    'groupe.libelle as "'.__("libelle").'"',
    'genre.libelle as "'.__("genre").'"',
    );
$tri="ORDER BY groupe.libelle ASC NULLS LAST";
$edition="groupe";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "genre" => array("genre", ),
);
// Filtre listing sous formulaire - genre
if (in_array($retourformulaire, $foreign_keys_extended["genre"])) {
    $selection = " WHERE (groupe.genre = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'demande_type',
    'dossier_autorisation_type',
    'lien_om_profil_groupe',
    'lien_om_utilisateur_groupe',
);


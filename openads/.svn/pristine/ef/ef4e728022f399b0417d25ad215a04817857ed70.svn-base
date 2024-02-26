<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_om_profil_groupe");
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
$table = DB_PREFIXE."lien_om_profil_groupe
    LEFT JOIN ".DB_PREFIXE."groupe 
        ON lien_om_profil_groupe.groupe=groupe.groupe 
    LEFT JOIN ".DB_PREFIXE."om_profil 
        ON lien_om_profil_groupe.om_profil=om_profil.om_profil ";
// SELECT 
$champAffiche = array(
    'lien_om_profil_groupe.lien_om_profil_groupe as "'.__("lien_om_profil_groupe").'"',
    'om_profil.libelle as "'.__("om_profil").'"',
    'groupe.libelle as "'.__("groupe").'"',
    "case lien_om_profil_groupe.confidentiel when 't' then 'Oui' else 'Non' end as \"".__("confidentiel")."\"",
    "case lien_om_profil_groupe.enregistrement_demande when 't' then 'Oui' else 'Non' end as \"".__("enregistrement_demande")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_om_profil_groupe.lien_om_profil_groupe as "'.__("lien_om_profil_groupe").'"',
    'om_profil.libelle as "'.__("om_profil").'"',
    'groupe.libelle as "'.__("groupe").'"',
    );
$tri="ORDER BY om_profil.libelle ASC NULLS LAST";
$edition="lien_om_profil_groupe";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "groupe" => array("groupe", ),
    "om_profil" => array("om_profil", ),
);
// Filtre listing sous formulaire - groupe
if (in_array($retourformulaire, $foreign_keys_extended["groupe"])) {
    $selection = " WHERE (lien_om_profil_groupe.groupe = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - om_profil
if (in_array($retourformulaire, $foreign_keys_extended["om_profil"])) {
    $selection = " WHERE (lien_om_profil_groupe.om_profil = ".intval($idxformulaire).") ";
}


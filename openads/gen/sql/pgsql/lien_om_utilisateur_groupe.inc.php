<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_om_utilisateur_groupe");
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
$table = DB_PREFIXE."lien_om_utilisateur_groupe
    LEFT JOIN ".DB_PREFIXE."groupe 
        ON lien_om_utilisateur_groupe.groupe=groupe.groupe ";
// SELECT 
$champAffiche = array(
    'lien_om_utilisateur_groupe.lien_om_utilisateur_groupe as "'.__("lien_om_utilisateur_groupe").'"',
    'lien_om_utilisateur_groupe.login as "'.__("login").'"',
    'groupe.libelle as "'.__("groupe").'"',
    "case lien_om_utilisateur_groupe.confidentiel when 't' then 'Oui' else 'Non' end as \"".__("confidentiel")."\"",
    "case lien_om_utilisateur_groupe.enregistrement_demande when 't' then 'Oui' else 'Non' end as \"".__("enregistrement_demande")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_om_utilisateur_groupe.lien_om_utilisateur_groupe as "'.__("lien_om_utilisateur_groupe").'"',
    'lien_om_utilisateur_groupe.login as "'.__("login").'"',
    'groupe.libelle as "'.__("groupe").'"',
    );
$tri="ORDER BY lien_om_utilisateur_groupe.login ASC NULLS LAST";
$edition="lien_om_utilisateur_groupe";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "groupe" => array("groupe", ),
);
// Filtre listing sous formulaire - groupe
if (in_array($retourformulaire, $foreign_keys_extended["groupe"])) {
    $selection = " WHERE (lien_om_utilisateur_groupe.groupe = ".intval($idxformulaire).") ";
}


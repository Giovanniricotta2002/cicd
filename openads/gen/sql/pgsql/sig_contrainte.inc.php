<?php
//$Id$ 
//gen openMairie le 07/03/2023 15:07

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("sig_contrainte");
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
$table = DB_PREFIXE."sig_contrainte
    LEFT JOIN ".DB_PREFIXE."sig_groupe 
        ON sig_contrainte.groupe=sig_groupe.sig_groupe 
    LEFT JOIN ".DB_PREFIXE."sig_couche 
        ON sig_contrainte.sig_couche=sig_couche.sig_couche 
    LEFT JOIN ".DB_PREFIXE."sig_sousgroupe 
        ON sig_contrainte.sousgroupe=sig_sousgroupe.sig_sousgroupe ";
// SELECT 
$champAffiche = array(
    'sig_contrainte.sig_contrainte as "'.__("sig_contrainte").'"',
    'sig_contrainte.nature as "'.__("nature").'"',
    'sig_groupe.libelle as "'.__("groupe").'"',
    'sig_sousgroupe.libelle as "'.__("sousgroupe").'"',
    'sig_contrainte.libelle as "'.__("libelle").'"',
    'sig_contrainte.no_ordre as "'.__("no_ordre").'"',
    "case sig_contrainte.service_consulte when 't' then 'Oui' else 'Non' end as \"".__("service_consulte")."\"",
    'sig_couche.libelle as "'.__("sig_couche").'"',
    );
//
$champNonAffiche = array(
    'sig_contrainte.texte as "'.__("texte").'"',
    'sig_contrainte.texte_genere as "'.__("texte_genere").'"',
    );
//
$champRecherche = array(
    'sig_contrainte.sig_contrainte as "'.__("sig_contrainte").'"',
    'sig_contrainte.nature as "'.__("nature").'"',
    'sig_groupe.libelle as "'.__("groupe").'"',
    'sig_sousgroupe.libelle as "'.__("sousgroupe").'"',
    'sig_contrainte.libelle as "'.__("libelle").'"',
    'sig_contrainte.no_ordre as "'.__("no_ordre").'"',
    'sig_couche.libelle as "'.__("sig_couche").'"',
    );
$tri="ORDER BY sig_contrainte.libelle ASC NULLS LAST";
$edition="sig_contrainte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "sig_groupe" => array("sig_groupe", ),
    "sig_couche" => array("sig_couche", ),
    "sig_sousgroupe" => array("sig_sousgroupe", ),
);
// Filtre listing sous formulaire - sig_groupe
if (in_array($retourformulaire, $foreign_keys_extended["sig_groupe"])) {
    $selection = " WHERE (sig_contrainte.groupe = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - sig_couche
if (in_array($retourformulaire, $foreign_keys_extended["sig_couche"])) {
    $selection = " WHERE (sig_contrainte.sig_couche = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - sig_sousgroupe
if (in_array($retourformulaire, $foreign_keys_extended["sig_sousgroupe"])) {
    $selection = " WHERE (sig_contrainte.sousgroupe = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'lien_sig_contrainte_dossier_instruction_type',
    'lien_sig_contrainte_evenement',
    'lien_sig_contrainte_om_collectivite',
    'lien_sig_contrainte_sig_attribut',
);


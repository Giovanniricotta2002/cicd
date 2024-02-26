<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("sig_attribut");
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
$table = DB_PREFIXE."sig_attribut
    LEFT JOIN ".DB_PREFIXE."sig_couche 
        ON sig_attribut.sig_couche=sig_couche.sig_couche ";
// SELECT 
$champAffiche = array(
    'sig_attribut.sig_attribut as "'.__("sig_attribut").'"',
    'sig_couche.libelle as "'.__("sig_couche").'"',
    'sig_attribut.libelle as "'.__("libelle").'"',
    'sig_attribut.identifiant as "'.__("identifiant").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'sig_attribut.sig_attribut as "'.__("sig_attribut").'"',
    'sig_couche.libelle as "'.__("sig_couche").'"',
    'sig_attribut.libelle as "'.__("libelle").'"',
    'sig_attribut.identifiant as "'.__("identifiant").'"',
    );
$tri="ORDER BY sig_attribut.libelle ASC NULLS LAST";
$edition="sig_attribut";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "sig_couche" => array("sig_couche", ),
);
// Filtre listing sous formulaire - sig_couche
if (in_array($retourformulaire, $foreign_keys_extended["sig_couche"])) {
    $selection = " WHERE (sig_attribut.sig_couche = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'lien_sig_contrainte_sig_attribut',
);


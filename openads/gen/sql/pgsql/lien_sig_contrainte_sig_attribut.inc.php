<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_sig_contrainte_sig_attribut");
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
$table = DB_PREFIXE."lien_sig_contrainte_sig_attribut
    LEFT JOIN ".DB_PREFIXE."sig_attribut 
        ON lien_sig_contrainte_sig_attribut.sig_attribut=sig_attribut.sig_attribut 
    LEFT JOIN ".DB_PREFIXE."sig_contrainte 
        ON lien_sig_contrainte_sig_attribut.sig_contrainte=sig_contrainte.sig_contrainte ";
// SELECT 
$champAffiche = array(
    'lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut as "'.__("lien_sig_contrainte_sig_attribut").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'sig_attribut.libelle as "'.__("sig_attribut").'"',
    'lien_sig_contrainte_sig_attribut.valeur as "'.__("valeur").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut as "'.__("lien_sig_contrainte_sig_attribut").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'sig_attribut.libelle as "'.__("sig_attribut").'"',
    'lien_sig_contrainte_sig_attribut.valeur as "'.__("valeur").'"',
    );
$tri="ORDER BY sig_contrainte.libelle ASC NULLS LAST";
$edition="lien_sig_contrainte_sig_attribut";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "sig_attribut" => array("sig_attribut", ),
    "sig_contrainte" => array("sig_contrainte", ),
);
// Filtre listing sous formulaire - sig_attribut
if (in_array($retourformulaire, $foreign_keys_extended["sig_attribut"])) {
    $selection = " WHERE (lien_sig_contrainte_sig_attribut.sig_attribut = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - sig_contrainte
if (in_array($retourformulaire, $foreign_keys_extended["sig_contrainte"])) {
    $selection = " WHERE (lien_sig_contrainte_sig_attribut.sig_contrainte = ".intval($idxformulaire).") ";
}


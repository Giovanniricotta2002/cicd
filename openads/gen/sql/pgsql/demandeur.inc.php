<?php
//$Id$ 
//gen openMairie le 23/08/2023 11:44

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("demandeur");
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
$table = DB_PREFIXE."demandeur
    LEFT JOIN ".DB_PREFIXE."om_collectivite 
        ON demandeur.om_collectivite=om_collectivite.om_collectivite 
    LEFT JOIN ".DB_PREFIXE."civilite as civilite1 
        ON demandeur.particulier_civilite=civilite1.civilite 
    LEFT JOIN ".DB_PREFIXE."civilite as civilite2 
        ON demandeur.personne_morale_civilite=civilite2.civilite ";
// SELECT 
$champAffiche = array(
    'demandeur.demandeur as "'.__("demandeur").'"',
    'demandeur.type_demandeur as "'.__("type_demandeur").'"',
    'demandeur.qualite as "'.__("qualite").'"',
    'demandeur.particulier_nom as "'.__("particulier_nom").'"',
    'demandeur.particulier_prenom as "'.__("particulier_prenom").'"',
    'to_char(demandeur.particulier_date_naissance ,\'DD/MM/YYYY\') as "'.__("particulier_date_naissance").'"',
    'demandeur.particulier_commune_naissance as "'.__("particulier_commune_naissance").'"',
    'demandeur.particulier_departement_naissance as "'.__("particulier_departement_naissance").'"',
    'demandeur.personne_morale_denomination as "'.__("personne_morale_denomination").'"',
    'demandeur.personne_morale_raison_sociale as "'.__("personne_morale_raison_sociale").'"',
    'demandeur.personne_morale_siret as "'.__("personne_morale_siret").'"',
    'demandeur.personne_morale_categorie_juridique as "'.__("personne_morale_categorie_juridique").'"',
    'demandeur.personne_morale_nom as "'.__("personne_morale_nom").'"',
    'demandeur.personne_morale_prenom as "'.__("personne_morale_prenom").'"',
    'demandeur.numero as "'.__("numero").'"',
    'demandeur.voie as "'.__("voie").'"',
    'demandeur.complement as "'.__("complement").'"',
    'demandeur.lieu_dit as "'.__("lieu_dit").'"',
    'demandeur.localite as "'.__("localite").'"',
    'demandeur.code_postal as "'.__("code_postal").'"',
    'demandeur.bp as "'.__("bp").'"',
    'demandeur.cedex as "'.__("cedex").'"',
    'demandeur.pays as "'.__("pays").'"',
    'demandeur.division_territoriale as "'.__("division_territoriale").'"',
    'demandeur.telephone_fixe as "'.__("telephone_fixe").'"',
    'demandeur.telephone_mobile as "'.__("telephone_mobile").'"',
    'demandeur.indicatif as "'.__("indicatif").'"',
    'demandeur.courriel as "'.__("courriel").'"',
    "case demandeur.notification when 't' then 'Oui' else 'Non' end as \"".__("notification")."\"",
    "case demandeur.frequent when 't' then 'Oui' else 'Non' end as \"".__("frequent")."\"",
    'civilite1.libelle as "'.__("particulier_civilite").'"',
    'civilite2.libelle as "'.__("personne_morale_civilite").'"',
    'demandeur.fax as "'.__("fax").'"',
    'demandeur.particulier_pays_naissance as "'.__("particulier_pays_naissance").'"',
    'demandeur.num_inscription as "'.__("num_inscription").'"',
    'demandeur.nom_cabinet as "'.__("nom_cabinet").'"',
    'demandeur.conseil_regional as "'.__("conseil_regional").'"',
    'to_char(demandeur.date_obt_diplo_spec ,\'DD/MM/YYYY\') as "'.__("date_obt_diplo_spec").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champNonAffiche = array(
    'demandeur.om_collectivite as "'.__("om_collectivite").'"',
    'demandeur.titre_obt_diplo_spec as "'.__("titre_obt_diplo_spec").'"',
    'demandeur.lieu_obt_diplo_spec as "'.__("lieu_obt_diplo_spec").'"',
    );
//
$champRecherche = array(
    'demandeur.demandeur as "'.__("demandeur").'"',
    'demandeur.type_demandeur as "'.__("type_demandeur").'"',
    'demandeur.qualite as "'.__("qualite").'"',
    'demandeur.particulier_nom as "'.__("particulier_nom").'"',
    'demandeur.particulier_prenom as "'.__("particulier_prenom").'"',
    'demandeur.particulier_commune_naissance as "'.__("particulier_commune_naissance").'"',
    'demandeur.particulier_departement_naissance as "'.__("particulier_departement_naissance").'"',
    'demandeur.personne_morale_denomination as "'.__("personne_morale_denomination").'"',
    'demandeur.personne_morale_raison_sociale as "'.__("personne_morale_raison_sociale").'"',
    'demandeur.personne_morale_siret as "'.__("personne_morale_siret").'"',
    'demandeur.personne_morale_categorie_juridique as "'.__("personne_morale_categorie_juridique").'"',
    'demandeur.personne_morale_nom as "'.__("personne_morale_nom").'"',
    'demandeur.personne_morale_prenom as "'.__("personne_morale_prenom").'"',
    'demandeur.numero as "'.__("numero").'"',
    'demandeur.voie as "'.__("voie").'"',
    'demandeur.complement as "'.__("complement").'"',
    'demandeur.lieu_dit as "'.__("lieu_dit").'"',
    'demandeur.localite as "'.__("localite").'"',
    'demandeur.code_postal as "'.__("code_postal").'"',
    'demandeur.bp as "'.__("bp").'"',
    'demandeur.cedex as "'.__("cedex").'"',
    'demandeur.pays as "'.__("pays").'"',
    'demandeur.division_territoriale as "'.__("division_territoriale").'"',
    'demandeur.telephone_fixe as "'.__("telephone_fixe").'"',
    'demandeur.telephone_mobile as "'.__("telephone_mobile").'"',
    'demandeur.indicatif as "'.__("indicatif").'"',
    'demandeur.courriel as "'.__("courriel").'"',
    'civilite1.libelle as "'.__("particulier_civilite").'"',
    'civilite2.libelle as "'.__("personne_morale_civilite").'"',
    'demandeur.fax as "'.__("fax").'"',
    'demandeur.particulier_pays_naissance as "'.__("particulier_pays_naissance").'"',
    'demandeur.num_inscription as "'.__("num_inscription").'"',
    'demandeur.nom_cabinet as "'.__("nom_cabinet").'"',
    'demandeur.conseil_regional as "'.__("conseil_regional").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
$tri="ORDER BY demandeur.type_demandeur ASC NULLS LAST";
$edition="demandeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection = "";
} else {
    // Filtre MONO
    $selection = " WHERE (demandeur.om_collectivite = '".$_SESSION["collectivite"]."') ";
}
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "om_collectivite" => array("om_collectivite", ),
    "civilite" => array("civilite", ),
);
// Filtre listing sous formulaire - om_collectivite
if (in_array($retourformulaire, $foreign_keys_extended["om_collectivite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demandeur.om_collectivite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demandeur.om_collectivite = '".$_SESSION["collectivite"]."') AND (demandeur.om_collectivite = ".intval($idxformulaire).") ";
    }
}
// Filtre listing sous formulaire - civilite
if (in_array($retourformulaire, $foreign_keys_extended["civilite"])) {
    if ($_SESSION["niveau"] == "2") {
        // Filtre MULTI
        $selection = " WHERE (demandeur.particulier_civilite = ".intval($idxformulaire)." OR demandeur.personne_morale_civilite = ".intval($idxformulaire).") ";
    } else {
        // Filtre MONO
        $selection = " WHERE (demandeur.om_collectivite = '".$_SESSION["collectivite"]."') AND (demandeur.particulier_civilite = ".intval($idxformulaire)." OR demandeur.personne_morale_civilite = ".intval($idxformulaire).") ";
    }
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'lien_demande_demandeur',
    'lien_dossier_autorisation_demandeur',
    'lien_dossier_demandeur',
    'lien_lot_demandeur',
);


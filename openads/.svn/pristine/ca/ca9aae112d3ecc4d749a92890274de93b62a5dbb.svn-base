<?php
//$Id$ 
//gen openMairie le 13/07/2021 11:59

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("document_numerise_type");
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
$table = DB_PREFIXE."document_numerise_type
    LEFT JOIN ".DB_PREFIXE."document_numerise_type_categorie 
        ON document_numerise_type.document_numerise_type_categorie=document_numerise_type_categorie.document_numerise_type_categorie ";
// SELECT 
$champAffiche = array(
    'document_numerise_type.document_numerise_type as "'.__("document_numerise_type").'"',
    'document_numerise_type.code as "'.__("code").'"',
    'document_numerise_type.libelle as "'.__("libelle").'"',
    'document_numerise_type_categorie.libelle as "'.__("document_numerise_type_categorie").'"',
    'to_char(document_numerise_type.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(document_numerise_type.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    );
//
$champNonAffiche = array(
    'document_numerise_type.aff_service_consulte as "'.__("aff_service_consulte").'"',
    'document_numerise_type.aff_da as "'.__("aff_da").'"',
    'document_numerise_type.synchro_metadonnee as "'.__("synchro_metadonnee").'"',
    'document_numerise_type.description as "'.__("description").'"',
    );
//
$champRecherche = array(
    'document_numerise_type.document_numerise_type as "'.__("document_numerise_type").'"',
    'document_numerise_type.code as "'.__("code").'"',
    'document_numerise_type.libelle as "'.__("libelle").'"',
    'document_numerise_type_categorie.libelle as "'.__("document_numerise_type_categorie").'"',
    );
$tri="ORDER BY document_numerise_type.libelle ASC NULLS LAST";
$edition="document_numerise_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = " WHERE ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " WHERE ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)))";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "document_numerise_type_categorie" => array("document_numerise_type_categorie", ),
);
// Filtre listing sous formulaire - document_numerise_type_categorie
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise_type_categorie"])) {
    $selection = " WHERE (document_numerise_type.document_numerise_type_categorie = ".intval($idxformulaire).")  AND ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)))";
$where_om_validite = " AND ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)))";
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
    'document_numerise',
    'lien_document_n_type_d_i_t',
    'lien_document_numerise_type_instructeur_qualite',
);


<?php
//$Id$ 
//gen openMairie le 17/08/2023 19:55

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("architecte");
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
$table = DB_PREFIXE."architecte";
// SELECT 
$champAffiche = array(
    'architecte.architecte as "'.__("architecte").'"',
    'architecte.nom as "'.__("nom").'"',
    'architecte.prenom as "'.__("prenom").'"',
    'architecte.adresse1 as "'.__("adresse1").'"',
    'architecte.adresse2 as "'.__("adresse2").'"',
    'architecte.cp as "'.__("cp").'"',
    'architecte.ville as "'.__("ville").'"',
    'architecte.pays as "'.__("pays").'"',
    'architecte.inscription as "'.__("inscription").'"',
    'architecte.telephone as "'.__("telephone").'"',
    'architecte.fax as "'.__("fax").'"',
    'architecte.email as "'.__("email").'"',
    "case architecte.frequent when 't' then 'Oui' else 'Non' end as \"".__("frequent")."\"",
    'architecte.nom_cabinet as "'.__("nom_cabinet").'"',
    'architecte.conseil_regional as "'.__("conseil_regional").'"',
    'architecte.lieu_dit as "'.__("lieu_dit").'"',
    'architecte.boite_postale as "'.__("boite_postale").'"',
    'architecte.cedex as "'.__("cedex").'"',
    'to_char(architecte.date_obt_diplo_spec ,\'DD/MM/YYYY\') as "'.__("date_obt_diplo_spec").'"',
    );
//
$champNonAffiche = array(
    'architecte.note as "'.__("note").'"',
    'architecte.titre_obt_diplo_spec as "'.__("titre_obt_diplo_spec").'"',
    'architecte.lieu_obt_diplo_spec as "'.__("lieu_obt_diplo_spec").'"',
    );
//
$champRecherche = array(
    'architecte.architecte as "'.__("architecte").'"',
    'architecte.nom as "'.__("nom").'"',
    'architecte.prenom as "'.__("prenom").'"',
    'architecte.adresse1 as "'.__("adresse1").'"',
    'architecte.adresse2 as "'.__("adresse2").'"',
    'architecte.cp as "'.__("cp").'"',
    'architecte.ville as "'.__("ville").'"',
    'architecte.pays as "'.__("pays").'"',
    'architecte.inscription as "'.__("inscription").'"',
    'architecte.telephone as "'.__("telephone").'"',
    'architecte.fax as "'.__("fax").'"',
    'architecte.email as "'.__("email").'"',
    'architecte.nom_cabinet as "'.__("nom_cabinet").'"',
    'architecte.conseil_regional as "'.__("conseil_regional").'"',
    'architecte.lieu_dit as "'.__("lieu_dit").'"',
    'architecte.boite_postale as "'.__("boite_postale").'"',
    'architecte.cedex as "'.__("cedex").'"',
    );
$tri="ORDER BY architecte.nom ASC NULLS LAST";
$edition="architecte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'donnees_techniques',
);


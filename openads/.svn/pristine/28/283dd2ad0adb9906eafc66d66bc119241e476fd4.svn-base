<?php
/**
 *
 * @package openfoncier
 * @version SVN : $Id: petitionnaire_frequent.inc.php 5575 2015-12-08 19:25:17Z stimezouaght $
 */

//
include "../sql/pgsql/petitionnaire.inc.php";

//
$ent = _("guichet unique")." -> "._("nouvelle demande")." -> "._("petitionnaire frequent");

// SELECT 
$champAffiche = array(
    'demandeur.demandeur as "'._("id").'"',
    $case_demandeur.' as "'._("nom").'"',
    $case_adresse.' as "'._("adresse").'"',
    'demandeur.qualite as "'._("qualite").'"',
);
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \""._("collectivite")."\"");
}

//
$selection .= " AND demandeur.frequent='t' ";

// Si utilisateur niveau filtre des pétitionnaires fréquents
// soit multi soit mono mais de collectivité identique
if ($_SESSION["niveau"] == "1") {
    // Filtre MONO
    $selection .= " AND (demandeur.om_collectivite = ".$_SESSION["collectivite"]."
        OR om_collectivite.niveau = '2')";
}

//
$champRecherche = $champAffiche;
?>

<?php
/**
 * Ce script a pour objet de récupérer la liste des pétitionnaires
 * correspondants aux critères de recherche
 *
 * @package openfoncier
 * @version SVN : $Id: afficher_synthese_demandeur.view.php 4418 2015-02-24 17:30:28Z tbenita $
 */

require_once "../obj/utils.class.php";

$f = new utils("nohtml");
$f->isAccredited(array("demande","demande_modifier","demande_ajouter"), "OR");
$f->disableLog();

// Donnees
$iddemandeur = "";
if ($f->get_submitted_get_value('iddemandeur') != null) {
    $iddemandeur = $f->get_submitted_get_value('iddemandeur');
}
$type = "";
if ($f->get_submitted_get_value('type') != null) {
    $type = $f->get_submitted_get_value('type');
}
$obj = str_replace('_principal', '', $type);
$demandeur = $f->get_inst__om_dbform(array(
    "obj" => $obj,
    "idx" => $iddemandeur,
));
$demandeur -> afficherSynthese($type, true);
$demandeur -> __destruct();

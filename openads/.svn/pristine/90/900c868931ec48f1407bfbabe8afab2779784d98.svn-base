<?php
/**
 * Ce script a pour objet de recuperer la liste des demandeurs
 * du dossier d'autorisation passé en paramètre
 *
 * @package openfoncier
 * @version SVN : $Id: getDemandeurList.php 4418 2015-02-24 17:30:28Z tbenita $
 */

require_once "../obj/utils.class.php";
$f = new utils("nohtml");
$f->isAccredited(array("demande","demande_modifier","demande_ajouter"), "OR");
$f->disableLog();

$id_dossier_autorisation =($f->get_submitted_get_value("dossier_autorisation") != null) ? $f->get_submitted_get_value("dossier_autorisation") : "";
$contraintes = ($f->get_submitted_get_value("contraintes") != null) ? $f->get_submitted_get_value("contraintes") : "";

if($id_dossier_autorisation != "") {
    $dossier_autorisation = $f->get_inst__om_dbform(array(
        "obj" => "dossier_autorisation",
        "idx" => $id_dossier_autorisation,
    ));
    $demande = $f->get_inst__om_dbform(array(
        "obj" => "demande",
        "idx" => "]",
    ));
    $dossier_autorisation -> listeDemandeur("dossier_autorisation", $id_dossier_autorisation);
    $demande->setValIdDemandeur($dossier_autorisation->getValIdDemandeur());
    $demande->display_form_specific_content(0, $contraintes);
}

?>

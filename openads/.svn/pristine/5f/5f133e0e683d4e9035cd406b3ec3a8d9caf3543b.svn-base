<?php
/**
 * Ce script a pour objet de récupérer la liste des pétitionnaires
 * correspondants aux critères de recherche
 *
 * @package openfoncier
 * @version SVN : $Id: afficher_synthese_obj.view.php 4752 2015-05-13 08:00:03Z nhaye $
 */
require_once "../obj/utils.class.php";
//
$f = new utils("nohtml");
$f->disableLog();
//Données
$idx = ($f->get_submitted_get_value('idx') != null ? $f->get_submitted_get_value('idx') : "]" );
$obj = ($f->get_submitted_get_value('obj') != null ? $f->get_submitted_get_value('obj') : "" );
//
$f->isAccredited(array($obj,$obj."consulter",), "OR");
//
// Affichage des données
$obj = $f->get_inst__om_dbform(array(
    "obj" => $obj,
    "idx" => $idx,
));
if($idx == ']') {
    $obj->setParameter("maj", 0);
}
$obj->afficherSynthese();


$obj->__destruct();

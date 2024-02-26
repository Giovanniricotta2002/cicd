<?php
/*
* WIDGET DASHBOARD - widget_compteur_signatures.
*
* Ce script permet d'interfacer le widget 'Compteur Signatures'.
*
* @package openads
* @version SVN : $Id:
*/

require_once "../obj/utils.class.php";
if (empty($f)) {
    $f = new utils(null, "compteur_signatures", _("Widget - Compteur Signatures"));
}

// instanciation d'un widget vide (uniquement pour accéder à la méthode de la classe)
$empty_widget = $f->get_inst__om_dbform(array(
    'obj' => 'om_widget',
    'idx' => 0,
));

$empty_widget->view_widget_compteur_signatures($content);

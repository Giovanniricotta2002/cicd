<?php
/**
 * WIDGET DASHBOARD - widget_controle_donnee.
 *
 * Ce script permet d'interfacer le widget 'Les dossiers non transmis à Plat'AU'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_controle_donnee", _("Widget - Les dossiers non transmis à Plat'AU"));
}

/**
 *
 */
//
$om_widget = $f->get_inst__om_dbform(array(
    "obj" => "om_widget",
    "idx" => 0,
));
//
if (!isset($content)) {
    $content = null;
}
//
$om_widget->view_widget_dossier_non_transmis_platau($content);

?>

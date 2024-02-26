<?php
/**
 * WIDGET DASHBOARD - widget_derniers_dossiers_deposes.
 *
 * Ce script permet d'interfacer le widget 'Les derniers dossiers déposés'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (isset($f) === false) {
    $f = new utils(null, "widget_derniers_dossiers_deposes", _("Widget - Derniers dossiers déposés"));
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
if (isset($content) === false) {
    $content = null;
}

$om_widget->view_widget_derniers_dossiers_deposes($content);

?>

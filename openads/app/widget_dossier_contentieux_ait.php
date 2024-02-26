<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_ait.
 *
 * Ce script permet d'interfacer le widget 'Mes AIT'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_contentieux_ait", _("Widget - Mes AIT"));
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
$om_widget->view_widget_dossier_contentieux_ait($content);

?>

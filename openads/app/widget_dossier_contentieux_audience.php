<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_audiance.
 *
 * Ce script permet d'interfacer le widget 'Les audiances'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_contentieux_audiance", _("Widget - Les audiences"));
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
$om_widget->view_widget_dossier_contentieux_audience($content);

?>

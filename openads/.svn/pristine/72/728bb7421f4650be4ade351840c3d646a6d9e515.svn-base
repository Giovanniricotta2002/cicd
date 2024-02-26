<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_infraction.
 *
 * Ce script permet d'interfacer le widget 'Retours de consultation'.
 *
 * @package openads
 * @version SVN : $Id: widget_dossier_contentieux_infraction.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_contentieux_infraction", _("Widget - Dossier d'Infractions"));
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
$om_widget->view_widget_dossier_contentieux_infraction($content);

?>

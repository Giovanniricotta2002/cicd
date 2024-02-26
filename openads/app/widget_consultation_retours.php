<?php
/**
 * WIDGET DASHBOARD - widget_consultation_retours.
 *
 * Ce script permet d'interfacer le widget 'Retours de consultation'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_consultation_retours", _("Widget - Retours de consultation"));
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
$om_widget->view_widget_consultation_retours($content);

?>

<?php
/**
 * WIDGET DASHBOARD - widget_messages_retours.
 *
 * Ce script permet d'interfacer le widget 'Retours de messages'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_messages_retours", _("Widget - Retours de messages"));
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
$om_widget->view_widget_messages_retours($content);

?>

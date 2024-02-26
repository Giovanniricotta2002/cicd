<?php
/**
 * WIDGET DASHBOARD - widget_dossiers_pre_instruction.
 *
 * Ce script permet d'interfacer le widget 'Dossiers en pré-instruction'.
 *
 * @package openads
 * @version SVN : $Id: widget_dossiers_pre_instruction.php 8989 2019-10-31 15:09:51Z softime $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossiers_pre_instruction", _("Widget - Dossiers en pré-instruction"));
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
$om_widget->view_widget_dossiers_pre_instruction($content);

?>
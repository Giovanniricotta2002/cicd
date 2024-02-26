<?php
/**
 * WIDGET DASHBOARD - widget_dossiers_limites.
 *
 * Ce script permet d'interfacer le widget 'Dossiers limites'.
 *
 * @package openads
 * @version SVN : $Id: widget_dossiers_limites.php 5208 2015-09-23 21:32:51Z fmichon $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossiers_limites", _("Widget - Dossiers limites"));
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
$om_widget->view_widget_dossiers_limites($content);

?>

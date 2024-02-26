<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_clotures.
 *
 * Ce script permet d'interfacer le widget 'Mes clôtures'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_contentieux_clotures", _("Widget - Mes clôtures"));
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
$om_widget->view_widget_dossier_contentieux_clotures($content);

?>

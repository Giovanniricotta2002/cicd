<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_inaffectes.
 *
 * Ce script permet d'interfacer le widget 'Les infractions non affectées'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_contentieux_inaffectes", _("Widget - Les infractions non affectées"));
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
$om_widget->view_widget_dossier_contentieux_inaffectes($content);

?>

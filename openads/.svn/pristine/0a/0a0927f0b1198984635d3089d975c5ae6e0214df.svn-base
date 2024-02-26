<?php
/**
 * WIDGET DASHBOARD - widget_recherche_dossier.
 *
 * Ce script permet d'interfacer le widget 'Recherche dossier'.
 *
 * @package openads
 * @version SVN : $Id: widget_recherche_dossier.php 5187 2015-09-23 10:38:54Z fmichon $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_recherche_dossier", _("Widget - Recherche dossier"));
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
$om_widget->view_widget_recherche_dossier($content);

?>

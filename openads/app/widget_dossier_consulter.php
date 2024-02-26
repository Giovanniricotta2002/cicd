<?php
/**
 * WIDGET DASHBOARD - widget_dossier_consulter.
 *
 * Ce script permet d'afficher les X derniers dossiers consultés dans un Widget.
 *
 * @package openads
 * @version SVN : $Id: widget_dossier_consulter.php 7768 2018-04-16 15:23:37Z apasquini $
 */

require_once "../obj/utils.class.php";
if (isset($f) === false) {
    $f = new utils(null, "widget_dossier_consulter", _("Widget - Derniers dossiers consultés"));
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
if (isset($content) === false) {
    $content = null;
}

$om_widget->view_widget_dossier_consulter($content);

?>

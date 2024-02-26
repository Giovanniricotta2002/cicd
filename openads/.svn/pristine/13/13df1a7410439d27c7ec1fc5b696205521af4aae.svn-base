<?php
/**
 * WIDGET DASHBOARD - widget_recherche_dossier_par_type.
 *
 * Ce script permet d'interfacer le widget 'Recherche accès direct par type'.
 *
 * @package openads
 * @version SVN : $Id: widget_recherche_dossier_par_type.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_recherche_dossier_par_type", _("Widget - Recherche dossier par type"));
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
$om_widget->view_widget_recherche_dossier_par_type($content);

?>

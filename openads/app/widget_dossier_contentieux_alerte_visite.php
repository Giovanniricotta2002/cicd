<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_alerte_visite.
 *
 * Ce script permet d'interfacer le widget 'Alerte Visite'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_dossier_mes_contradictoires", _("Widget - Mes contradictoires"));
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
$om_widget->view_widget_dossier_contentieux_alerte_visite($content);

?>

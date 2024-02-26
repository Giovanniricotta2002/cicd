<?php
/**
 * WIDGET DASHBOARD - widget_dossier_contentieux_alerte_parquet.
 *
 * Ce script permet d'interfacer le widget 'Alerte Parquet'.
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
$om_widget->view_widget_dossier_contentieux_alerte_parquet($content);

?>

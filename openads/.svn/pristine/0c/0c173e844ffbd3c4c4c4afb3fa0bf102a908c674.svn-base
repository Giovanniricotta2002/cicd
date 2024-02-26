<?php
/**
 * WIDGET DASHBOARD - widget_dossier_evenement_incomplet_majoration.
 *
 * Ce script permet d'interfacer le widget 'Dossiers avec événement incomplet ou majoration.
 * 
 * @package openfoncier
 * @version SVN : $Id: widget_dossiers_evenement_incomplet_majoration.php 5203 2015-09-23 16:49:36Z fmichon $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "dossier_evenement_incomplet_majoration", 
    _("Widget - Dossier Evenement Incomplet Et Majoration"));
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
$om_widget->view_widget_dossiers_evenement_incomplet_majoration($content);


?>

<?php
/**
 * WIDGET DASHBOARD - widget_nouvelle_demande_nouveau_dossier.
 *
 * Ce script permet d'interfacer le widget 'Nouvelle demande (nouveau dossier)'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_nouvelle_demande_nouveau_dossier", _("Widget - Nouvelle demande (nouveau dossier)"));
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
$om_widget->view_widget_nouvelle_demande_nouveau_dossier($content);

?>

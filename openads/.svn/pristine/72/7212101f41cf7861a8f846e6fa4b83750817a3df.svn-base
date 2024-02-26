<?php
/**
 * WIDGET DASHBOARD - widget_suivi_tache_platau.
 *
 * Ce script permet d'interfacer le widget "Suivi des tâches Plat'AU".
 *
 * @package openads
 * @version SVN : $Id: widget_suivi_tache_platau.php 5187 2015-09-23 10:38:54Z fmichon $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "widget_suivi_tache_platau", _("Widget - Suivi des Transferts"));
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
$om_widget->view_widget_suivi_tache($content);


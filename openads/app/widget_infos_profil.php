<?php
/**
 * WIDGET DASHBOARD - widget_infos_profil.
 *
 * Ce script permet d'interfacer le widget 'Infos profil'.
 *
 * @package openads
 * @version SVN : $Id: widget_infos_profil.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, "infos_profil", _("Widget - Infos Profil"));
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
$om_widget->view_widget_infos_profil($content);


?>

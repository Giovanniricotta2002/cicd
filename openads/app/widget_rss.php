<?php
/**
 * WIDGET DASHBOARD - widget_rss.
 *
 * Ce script permet d'afficher des flux rss.
 *
 * @package openads
 * @version SVN : $Id: widget_rss.php 7996 2018-07-20 17:12:33Z softime $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
	$f = new utils(null, "widget_rss", _("Widget - Flux RSS"));
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

//

$om_widget->display_widget_rss($content, $id);

?>
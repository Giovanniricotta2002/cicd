<?php
/**
 * Ce script permet d'interfacer l'application.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
$flag = filter_input(INPUT_GET, 'module');
if (in_array($flag, array("login", "logout", )) === false) {
    $flag = "nohtml";
}
$f = new utils($flag);
$f->view_main();


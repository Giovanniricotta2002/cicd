<?php
/**
 * Ce script redirige vers la page de login de l'application.
 *
 * @package openads
 * @version SVN : $Id: index.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
$came_from = "";
if (isset($_GET['came_from'])) {
    $came_from = $_GET['came_from'];
}

//
header("Location: app/index.php?module=login&came_from=".urlencode($came_from));


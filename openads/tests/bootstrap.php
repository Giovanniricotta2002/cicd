<?php
/**
 * PHPUnit Bootstrap.
 *
 * @package openads
 * @version SVN : $Id$
 */

/**
 * Pour simuler correctement l'environnement, nous définissons les variables
 * définies normalement par apache. Elles sont définies ici pour la fonction
 * get_base_url() présente dans le script obj/utils.class.php.
 */
$_SERVER["HTTP_HOST"] = "localhost";
$_SERVER["SERVER_PORT"] = "80";
$_SERVER["PHP_SELF"] = "/openads/app/index.php?module=login&came_from=";

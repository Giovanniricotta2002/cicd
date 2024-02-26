<?php
/**
 * 
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_sousetat.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include PATH_OPENMAIRIE."sql/pgsql/om_sousetat.inc.php";
$ent = _("administration")." -> "._("options avancees")." -> "._("om_sousetat");

/**
 * Options
 */
if ($_SESSION['niveau'] == '2') {
    $selection = "";
} else {
    $selection = " where (".$obj.".om_collectivite='".$_SESSION['collectivite']."' or niveau='2')";
}

?>

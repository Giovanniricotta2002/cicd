<?php
/**
 *
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_logo.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include PATH_OPENMAIRIE."sql/pgsql/om_logo.inc.php";
$ent = _("parametrage dossiers")." -> "._("editions")." -> "._("om_logo");

/**
 * Options
 */
if ($_SESSION['niveau'] == '2') {
    $selection = "";
} else {
    $selection = " where (".$obj.".om_collectivite='".$_SESSION['collectivite']."' or niveau='2')";
}

?>

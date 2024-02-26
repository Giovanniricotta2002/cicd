<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: demande_nature.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/demande_nature.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("demandes")." -> "._("nature");

//
$champAffiche[0] = "demande_nature.demande_nature as \""._("id")."\"";
$champRecherche[0] = "demande_nature.demande_nature as \""._("id")."\"";

?>

<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: bible.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../gen/sql/pgsql/bible.inc.php";

//
$ent = _("parametrage")." -> "._("workflows")." -> "._("bible");

//
$champAffiche[0] = "bible.bible as \""._("id")."\"";
$champRecherche[0] = "bible.bible as \""._("id")."\"";

?>

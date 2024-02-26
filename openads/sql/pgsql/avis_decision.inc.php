<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: avis_decision.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/avis_decision.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("workflows")." -> "._("avis_decision");

//
$champAffiche[0] = "avis_decision.avis_decision as \""._("id")."\"";
$champRecherche[0] = "avis_decision.avis_decision as \""._("id")."\"";

//
$sousformulaire = array(
    'evenement',
);

?>

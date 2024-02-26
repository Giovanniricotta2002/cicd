<?php
/**
 * $Id$ 
 */

include('../gen/sql/pgsql/groupe.inc.php');
$ent = _("parametrage")." -> "._("organisation")." -> "._("groupe");

// Gestion sousformulaire
$sousformulaire = array(
    'demande_type',
    'dossier_autorisation_type',
);
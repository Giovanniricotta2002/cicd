<?php
/**
 * Surcharge de la classe instruction afin d'afficher une entrée menu pour 
 * le suivi des bordereaux.
 * 
 * @package openfoncier
 * @version SVN : $Id$
 */

require_once "../sql/pgsql/instruction.inc.php";

// Fil d'ariane
$ent = _("suivi")." -> "._("suivi des pieces")." -> "._("bordereaux");

//
$sousformulaire = array();

//
$tab_title = _("imprimer un bordereau d'envoi");

?>

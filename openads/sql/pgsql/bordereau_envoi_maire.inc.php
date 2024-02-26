<?php
/**
 * Surcharge de la classe instruction afin d'afficher une entrée menu pour 
 * l'envoi de bordereau au maire.
 * 
 * @package openfoncier
 * @version SVN : $Id$
 */

require_once "../sql/pgsql/instruction.inc.php";

// Fil d'ariane
$ent = _("suivi")." -> "._("suivi des pieces")." -> "._("bordereau d'envoi au maire");

//
$sousformulaire = array();

//
$tab_title = _("imprimer le bordereau d'envoi au maire");

?>

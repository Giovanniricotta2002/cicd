<?php
/**
 * @package openads
 * @version SVN : $Id: dossier_instruction_tous_clotures.inc.php 5220 2015-09-24 17:50:06Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

//
$champAffiche = array_merge($champAffiche_debut_commun, array(
    'avis_decision.libelle as "'._("avis_decision").'"',
    $instructeur_nom,
), $champAffiche_fin_commun);

//
$selection .= "
AND dossier.division = ".$_SESSION['division']."
AND dossier.etat IN (select etat from ".DB_PREFIXE."etat where etat.statut='cloture' )
";

/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection .= "";
} else {
    // Filtre MONO
    $selection .= " AND (dossier.om_collectivite = '".$_SESSION["collectivite"]."') ";
}


?>

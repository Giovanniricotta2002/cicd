<?php
/**
 * @package openads
 * @version SVN : $Id: dossier_instruction_tous_encours.inc.php 5220 2015-09-24 17:50:06Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

//
$champAffiche = array_merge($champAffiche_debut_commun, array(
    $instructeur_nom,
), $champAffiche_fin_commun);

//
$selection .= "
AND dossier.division = ".$_SESSION['division']."
AND dossier.etat IN (select etat from ".DB_PREFIXE."etat where etat.statut='encours')
";


// Tri par défaut sur la date limite,
// prenant en compte la date limite de complétude :
$tri = 
    "ORDER BY 
        CASE WHEN incompletude is true AND incomplet_notifie is true
            THEN dossier.date_limite_incompletude
            ELSE dossier.date_limite
        END
    ASC NULLS LAST"
;

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

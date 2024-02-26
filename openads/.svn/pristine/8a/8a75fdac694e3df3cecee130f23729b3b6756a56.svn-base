<?php
/**
 * @package openads
 * @version SVN : $Id: dossier_instruction_mes_clotures.inc.php 5220 2015-09-24 17:50:06Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

//
$champAffiche = array_merge($champAffiche_debut_commun, array(
    'avis_decision.libelle as "'._("avis_decision").'"',
), $champAffiche_fin_commun);

//
$selection .= sprintf('
    AND (om_utilisateur.login = \'%2$s\'
        OR utilisateur_2.login = \'%2$s\')
    AND dossier.etat IN (
        SELECT
            etat
        FROM
            %1$setat
        WHERE
            etat.statut = \'cloture\'
    )',
    DB_PREFIXE,
    $_SESSION["login"]
);

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

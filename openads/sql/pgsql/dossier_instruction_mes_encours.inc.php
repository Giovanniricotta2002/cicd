<?php
/**
 * @package openads
 * @version SVN : $Id: dossier_instruction_mes_encours.inc.php 5220 2015-09-24 17:50:06Z fmichon $
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

//
$champAffiche = array_merge($champAffiche_debut_commun, array(
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
            etat.statut = \'encours\'
    )',
    DB_PREFIXE,
    $_SESSION["login"]
);

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

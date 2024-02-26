<?php
//$Id: instructeur.inc.php 4651 2015-04-26 09:15:48Z tbenita $ 
//gen openMairie le 17/10/2012 17:46

include('../gen/sql/pgsql/instructeur.inc.php');
$ent = _("parametrage")." -> "._("organisation")." -> "._("instructeur");

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'affectation_automatique',
);

// Filtre la liste des instructeurs pour n'afficher que ceux de la même collectivité que l'utilisateur.
// Si l'utilisateur appartiens à la collectivité de niveau 2 alors le filtre n'est pas appliqué.
// Le filtre ne s'applique que si la liste n'est pas un sous-formulaire.
if (isset($_SESSION["niveau"]) && $_SESSION["niveau"] != "2") {
    // Vérifie si on est dans le contexte d'un sous-formulaire et si c'est le cas le filtre par
    // colllectivité n'est pas appliqué
    $list_of_contexte = array_filter($foreign_keys_extended, function($elem) use($retourformulaire) {
        return in_array($retourformulaire, $elem);
    });
    if (empty($list_of_contexte)) {
        $table .= sprintf(
            'LEFT JOIN %sdirection
                ON direction.direction = division.direction',
            DB_PREFIXE
        );
        $selection .= sprintf(
            'AND direction.om_collectivite = %d',
            $_SESSION["collectivite"]
        );
    }
}

?>

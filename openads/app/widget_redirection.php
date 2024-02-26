<?php
/**
 * WIDGET DASHBOARD - widget_redirection.
 *
 * Ce script permet de rediriger vers le listing des demandes d'avis en cours.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(null, null, _("Tableau de bord"));
}

// Contrôle sur une permission qui ne sera pas donnée à l'administrateur afin
// que la redirection ne s'enclenche pas lors de la composition des tableaux de
// bord
if ($f->isAccredited("widget_redirection") === true) {
    //
    echo '<script>redirection("'.OM_ROUTE_TAB.'&obj=demande_avis_encours", 0)</script>';
}

?>

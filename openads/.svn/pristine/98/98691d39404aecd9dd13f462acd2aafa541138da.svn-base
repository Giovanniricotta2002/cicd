<?php
/**
 * WIDGET DASHBOARD - widget_dossiers_evenement_retour_finalise.
 * 
 * Dossiers d'instructions dont on peut modifier la décision.
 *
 * L'objet de ce widget est de permettre de visualiser les 
 * dossiers d'instruction dont le dernier événement d'instruction est de type
 * "retour", est finalisé et qu'aucune autre date n'a été renseignée.
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

//
require_once "../obj/utils.class.php";

// Si utils n'est pas instancié
if (!isset($f)) {
    // Instanciation de la classe utils
    $f = new utils(null);
}
/**
 *
 */
//

if ($f->isAccredited(array("dossier_instruction", "dossier_instruction_consulter"), "OR")) {

    $di = $f->get_inst__om_dbform(array(
        "obj" => "dossier_instruction",
        "idx" => "]",
    ));

    //
    $empty = $di->view_widget_dossiers_evenement_retour_finalise();

    //
    if(!$empty) {
        $footer = OM_ROUTE_TAB."&obj=dossier_instruction&amp;decision=true";
        $footer_title = _("Voir les dossiers auxquels on peut proposer une autre decision");
    }

} else {

    //
    $widget_is_empty = true;

}

?>

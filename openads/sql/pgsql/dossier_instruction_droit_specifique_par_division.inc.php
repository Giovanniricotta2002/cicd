<?php
/**
 * Gestion particulière de l'affichage du listing dans le contexte d'un dossier
 * d'instruction. Ce script permet de supprimer les actions disponibles dans
 * le tableau pour l'utilisateur qui se trouverait sur un dossier 
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_instruction_droit_specifique_par_division.inc.php 5290 2015-10-07 16:14:11Z nhaye $
 */

// Dans le contexte du dossier d'instruction si l'instructeur ne se trouve pas
// dans la bonne division alors on n'a pas accès à l'action ajouter
if ($retourformulaire == 'dossier' || $this->contexte_dossier_instruction()) {
    // Si l'utilisateur est un instructeur et qu'il n'est pas de la bonne
    // division il n'a pas le droit d'ajouter un nouvel évément d'instruction
    // alors on enlève l'action
    if (isset($f) && $f->isUserCanAddObj($idxformulaire, $_GET["obj"]) === false) {

        // suppression des actions d'ajout
        $tab_actions['corner'] = array();
    }
    
    // Si l'utilisateur est un instructeur et que le dossier est clôturé, il n'a pas 
    //le droit d'ajouter un nouvel évément d'instruction alors on enlève l'action
    if (isset($f) && $f->isUserInstructeur() && 
        $f->getStatutDossier($idxformulaire) == "cloture" && $obj != "instruction"
        && !$f->isAccredited($_GET["obj"]."_ajouter_bypass")) {
        $tab_actions['corner'] = array();
    }
}

?>

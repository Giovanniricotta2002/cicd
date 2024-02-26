<?php
/**
 * DBFORM - 'phase' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'phase'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/phase.class.php";

class phase extends phase_gen {

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        $this->set_om_validite_debut_today($form, $maj, $validation);
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->set_om_validite_debut_today($form, $maj, $validation);
    }

    /**
     * SETTER_FORM - set_om_validite_debut_today (setVal).
     *
     * @return void
     */
    private function set_om_validite_debut_today(&$form, $maj, $validation) {
        if ($validation == 0 && $maj == 0) {
            $form->setVal("om_validite_debut", date("d/m/Y"));
        }
    }

    /**
     * Permet de modifier le fil d'Ariane.
     * 
     * @param string $ent Fil d'Ariane.
     *
     * @return string
     */
    public function getFormTitle($ent) {

        // Fil d'ariane par défaut
        $ent = _("parametrage")." -> "._("Gestion des dossiers")." -> "._("phase");

        // Si différent de l'ajout
        if($this->getParameter("maj") != 0) {

            // Affiche la clé primaire
            $ent .= " -> ".$this->getVal("phase");

            // Affiche le libellé de la phase
            $ent .= " ".mb_strtoupper($this->getVal("code"), 'UTF-8');
        }

        // Change le fil d'Ariane
        return $ent;
    }

}



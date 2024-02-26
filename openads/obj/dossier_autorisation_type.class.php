<?php
/**
 * DBFORM - 'dossier_autorisation_type' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: dossier_autorisation_type.class.php 5839 2016-01-29 08:50:12Z fmichon $
 */

require_once "../gen/obj/dossier_autorisation_type.class.php";

class dossier_autorisation_type extends dossier_autorisation_type_gen {

    /**
     * Permet de définir le type des champs.
     *
     * @param object  &$form Instance de formulaire.
     * @param integer $maj   Mode du formulaire.
     *
     * @return void
     */
    public function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("affichage_form", "select");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("affichage_form", "select");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("affichage_form", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("affichage_form", "selectstatic");
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // Contenu du select affichage_form
        $contenu = array();
        $contenu[0] = array('ADS', 'CTX RE', 'CTX IN', 'DPC', 'CONSULTATION ENTRANTE', );
        $contenu[1] = array('ADS', 'CTX RE', 'CTX IN', 'DPC', 'CONSULTATION ENTRANTE', );
        $form->setSelect('affichage_form', $contenu);
    }

}



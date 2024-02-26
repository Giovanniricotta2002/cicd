<?php
/**
 * DBFORM - 'paysagiste' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id$
 */
require_once("../obj/demandeur.class.php");


/**
 * Les paysagistes héritent des demandeurs.
 */
class paysagiste extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "paysagiste";

    /**
     * Cache les champs de notification, fréquent et type_demandeur.
     *
     * @param formulaire $form Instance de la classe om_formulaire.
     * @param integer    $maj  Identifiant de l'action.
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        $form->setType('type_demandeur', 'hidden');
        $form->setType('notification', 'hidden');
        $form->setType('frequent', 'hidden');
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        if ($maj == 0) {
            $form->setVal("type_demandeur", "paysagiste");
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $form->setVal("type_demandeur", "paysagiste");
    }
}

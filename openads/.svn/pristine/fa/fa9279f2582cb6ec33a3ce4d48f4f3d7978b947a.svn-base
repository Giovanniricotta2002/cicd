<?php
/**
 * DBFORM - 'plaignant' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id: plaignant.class.php 6565 2017-04-21 16:14:15Z softime $
 */
require_once("../obj/demandeur.class.php");


/**
 * Les plaignants héritent des demandeurs.
 */
class plaignant extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "plaignant";

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
        //
        if ($maj == 0) {
            $form->setVal("type_demandeur", "plaignant");
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
        $form->setVal("type_demandeur", "plaignant");
    }
}

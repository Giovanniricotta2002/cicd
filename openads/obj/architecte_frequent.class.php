<?php
/**
 * DBFORM - 'architecte_frequent' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'architecte_frequent'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/architecte.class.php";

class architecte_frequent extends architecte {

    /**
     *
     */
    protected $_absolute_class_name = "architecte_frequent";

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        $form->setVal("frequent", true);
    }
}



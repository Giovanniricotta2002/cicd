<?php
/**
 * DBFORM - 'autorite_competente' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'autorite_competente'.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
require_once "../gen/obj/autorite_competente.class.php";

class autorite_competente extends autorite_competente_gen {

    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        if($maj < 2) { //ajouter et modifier
            $form->setType("autorite_competente_sitadel", "select");
        }
        if($maj == 3) {
            $form->setType("autorite_competente_sitadel", "selectstatic");
        }

    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // autorite_competente_sitadel
        $contenu=array();
        $contenu[0]=array('1','2','3');
        $contenu[1]=array(
            _("1 - au nom de la commune"),
            _("2 - au nom de l'etat"),
            _("3 - au nom de l'EPCI"));
        $form->setSelect("autorite_competente_sitadel", $contenu);
    }

}



<?php
/**
 * DBFORM - 'servitude_surfacique' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'servitude_surfacique'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/servitude_surfacique.class.php";

class servitude_surfacique extends servitude_surfacique_gen {

    function setvalF($val){
        parent::setvalF($val);   
        // enlever les valeurs a ne pas saisir
        unset ($this->valF['geom']);
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        if ($maj < 2) { //ajouter et modifier
            $form->setType('geom', 'hidden');
        }
    }

}



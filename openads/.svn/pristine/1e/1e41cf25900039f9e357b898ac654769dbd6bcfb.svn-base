<?php
/**
 * DBFORM - 'servitude_ligne' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'servitude_ligne'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/servitude_ligne.class.php";

class servitude_ligne extends servitude_ligne_gen {

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



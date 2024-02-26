<?php
/**
 * DBFORM - 'parcelle_lot' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'parcelle_lot'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/parcelle_lot.class.php";

class parcelle_lot extends parcelle_lot_gen {

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

    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);
        // mise en majuscule
        $form->setOnchange("lotissement","this.value=this.value.toUpperCase()");
    }

}



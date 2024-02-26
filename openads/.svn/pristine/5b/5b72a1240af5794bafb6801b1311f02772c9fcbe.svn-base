<?php
/**
 * DBFORM - 'parcelle' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'parcelle'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/parcelle.class.php";

class parcelle extends parcelle_gen {

    function setvalF($val){
        parent::setvalF($val);   
        // enlever les valeurs a ne pas saisir
        unset ($this->valF['geom']);
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        if ($maj < 2) { //ajouter et modifier
            $form->setType('geom', 'hidden');
            $form->setType('section', 'hidden');
            $form->setType('commune', 'hidden');
        }
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        /*Vérifie qu'une parcelle a bien été écrite*/
        if  (!preg_match('/^[0-9]{3} [A-Z]{1,3} [0-9]{1,5}$/', $val['parcelle']) && !preg_match('/^[0-9]{3}[A-Z]{1,3}[0-9]{1,5}$/', $val['parcelle'])){ 
            $this->correct=false;
            $this->addToMessage("<br>"._("format parcelle incorrect CCC LL CCC ou CCCLLCCC"));
        }
    }

}



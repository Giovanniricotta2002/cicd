<?php
/**
 * DBFORM - 'pos' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'pos'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/pos.class.php";

class pos extends pos_gen {

    function setvalF($val){
        parent::setvalF($val);   
        // enlever les valeurs a ne pas saisir
        unset ($this->valF['geom']);
    }

}



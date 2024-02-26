<?php
/**
 * DBFORM - 'bordereau_envoi_maire' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'bordereau_envoi_maire'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/instruction.class.php";

/**
 * Surcharge de la classe instruction afin d'afficher une entrée menu pour 
 * éditer des bordereaux d'envoi au maire.
 */
class bordereau_envoi_maire extends instruction {

    /**
     *
     */
    protected $_absolute_class_name = "bordereau_envoi_maire";

}



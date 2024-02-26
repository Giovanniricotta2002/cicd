<?php
/**
 * OM_COLLECTIVITE - Surcharge du core
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once PATH_OPENMAIRIE."obj/om_collectivite.class.php";

class om_collectivite extends om_collectivite_core {

    /**
     * Permet de modifier le fil d'Ariane depuis l'objet pour un formulaire
     * @param string    $ent    Fil d'Ariane récupéréré
     * @return                  Fil d'Ariane
     */
    function getFormTitle($ent) {
        $out = parent::getFormTitle($ent);
        //
        if ($this->f->is_option_renommer_collectivite_enabled() === true) {
            $out = str_ireplace(array(__('om_collectivite'), __('collectivite')), __('service'), $out);
        }
        //
        return $out;
    }

    /**
     * Permet de modifier le fil d'Ariane depuis l'objet pour un sous-formulaire
     * @param string    $ent Fil d'Ariane récupéréré
     * @return                  Fil d'Ariane
     */
    function getSubFormTitle($ent) {
        $out = parent::getSubFormTitle($ent);
        //
        if ($this->f->is_option_renommer_collectivite_enabled() === true) {
            $out = str_ireplace(array(__('om_collectivite'), __('collectivite')), __('service'), $out);
        }
        //
        return $out;
    }

}

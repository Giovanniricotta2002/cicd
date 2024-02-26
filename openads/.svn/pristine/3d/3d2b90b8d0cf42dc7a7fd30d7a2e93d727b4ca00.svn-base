<?php
/**
 * DBFORM - 'dossier_autorisation_type_detaille' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: dossier_autorisation_type_detaille.class.php 5839 2016-01-29 08:50:12Z fmichon $
 */

require_once "../gen/obj/dossier_autorisation_type_detaille.class.php";

class dossier_autorisation_type_detaille extends dossier_autorisation_type_detaille_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 004 - get_affichage_form
        //
        $this->class_actions[4] = array(
            "identifier" => "get_affichage_form",
            "view" => "get_affichage_form",
            "permission_suffix" => "aff_form",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, (dossier_autorisation_type.code ||' ('||dossier_autorisation_type.libelle||')') as lib FROM ".DB_PREFIXE."dossier_autorisation_type ORDER BY lib";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_by_id() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, (dossier_autorisation_type.code ||' ('||dossier_autorisation_type.libelle||')') as lib FROM ".DB_PREFIXE."dossier_autorisation_type WHERE dossier_autorisation_type = <idx>";
    }

    /**
     * AJAX - get_affichage_form
     * 
     * @return json
     */
    function get_affichage_form() {
        $this->f->disableLog();
        $tda = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation_type",
            "idx" => $this->getVal('dossier_autorisation_type'),
        ));
        echo json_encode($tda->getVal('affichage_form'));
        return true;
    }

    /**
     * [setType description]
     * @param [type] &$form [description]
     * @param [type] $maj   [description]
     */
    function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);
        // type
        if ($maj == 0){ // ajout
            $form->setType('couleur', 'color');
        } // fin ajout
        if ($maj == 1){ // modifier
            $form->setType('couleur', 'color');
        } // fin modifier
    }

    /**
     * (Surcharge)
     * Affichage des noms des champs dans les formulaires.
     */
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);
        $form->setLib('secret_instruction', __("Restreindre l’accès aux pièces sur le DA si le DI n’est pas clôturé (secret de l’instruction)"));
    }
}

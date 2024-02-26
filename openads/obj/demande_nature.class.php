<?php
/**
 * DBFORM - 'demande_nature' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'demande_nature'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/demande_nature.class.php";

class demande_nature extends demande_nature_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 011 - json_data
        //
        $this->class_actions[11] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );

    }

    /**
     * VIEW - view_json_data.
     *
     * Affiche un tableau JSON représentant toutes les données de 
     * l'enregistrement courant.
     *
     * @return void
     */
    function view_json_data() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // La désactivation des logs est obligatoire pour une vue JSON.
        $this->f->disableLog();
        //
        $data = array();
        foreach ($this->champs as $key => $value) {
            $data[$value] = $this->getVal($value);
        }
        //
        echo json_encode($data);
    }

}



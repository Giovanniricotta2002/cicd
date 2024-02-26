<?php
/**
 * DBFORM - 'commission_type' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'commission_type'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/commission_type.class.php";

class commission_type extends commission_type_gen {

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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_only_mono() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite.niveau = '1' ORDER BY om_collectivite.libelle ASC";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        $crud = $this->get_action_crud($maj);
        // Le but ici est de brider aux collectivités mono en cas d'ajout par collectivité multi.
        if ($crud == 'create' || $maj == 0 || $_SESSION["niveau"] == 2) {
            // om_collectivite
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "om_collectivite",
                $this->get_var_sql_forminc__sql("om_collectivite_only_mono"),
                $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
                false
            );
        }
    }

}



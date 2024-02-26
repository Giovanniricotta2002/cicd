<?php
/**
 * DBFORM - 'dossier_contentieux' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/dossier_instruction.class.php";

//
class dossier_contentieux extends dossier_instruction {

    /**
     *
     */
    protected $_absolute_class_name = "dossier_contentieux";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 100 - donnees_techniques
        // Affiche dans un overlay les données techniques
        $this->class_actions[100] = array(
            "identifier" => "donnees_techniques",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Données techniques"),
                "order" => 100,
                "class" => "rediger-16",
            ),
            "view" => "view_donnees_techniques",
            "permission_suffix" => "donnees_techniques_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_donnees_techniques",
            ),
        );

        // ACTION - 110 - rapport_instruction
        // Désactivation de l'action ouvrant l'overlay de rapport d'instruction
        $this->class_actions[110] = null;


        // ACTION - 130 - view_edition
        // Désactivation de l'action permettant d'éditer le récapitulatif du dossier
        $this->class_actions[130] = null;
    }

    /**
     * VIEW - view_donnees_techniques.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_donnees_techniques() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->display_overlay(
            $this->getVal($this->clePrimaire),
            "donnees_techniques_contexte_ctx",
            "donnees_techniques"
        );
    }

}



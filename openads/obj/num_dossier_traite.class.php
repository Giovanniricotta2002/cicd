<?php
/**
 *
 * @package openADSNumerisation
 */

require_once PATH_OPENMAIRIE."../obj/num_dossier.class.php";

class num_dossier_traite extends num_dossier {
    protected $_absolute_class_name = "num_dossier_traite";

    function init_class_actions() {
        parent::init_class_actions();

        // Action - 002 - supprimer
        $this->class_actions[2] = array();

        // Action - 003 - consulter
        $this->class_actions[3] = array();

        // ACTION - 004 - copier
        $this->class_actions[4] = array();
    }

    /* surcharge */
    function setType(&$form, $maj) {
        // héritage 
        parent::setType($form, $maj);
        
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            // on ne peut pas modifier le bordereau ou la date de numérisation

            // on peut modifier les informations sur les pages
            $form->setType("total_pages", "text");
            $form->setType("pa3a4", "text");
            $form->setType("pa0", "text");
        }

    }
    
}// fin classe


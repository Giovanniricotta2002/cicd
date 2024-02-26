<?php
/**
 * DBFORM - 'blocnote' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'blocnote'.
 *
 * @package openads
 * @version SVN : $Id: blocnote.class.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../gen/obj/blocnote.class.php";

class blocnote extends blocnote_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();
        
        // ACTION - 000 - ajouter
        // 
        $this->class_actions[0]["condition"] = array("is_ajoutable", "can_user_access_dossier_contexte_ajout");
        
        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_modifiable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_supprimable", "can_user_access_dossier_contexte_modification");
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        if ($validation == 0) {
            if ($maj == 0) {
                $form->setVal("dossier", $idxformulaire);
            }
        }
    }

    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib($this->clePrimaire, _("id"));
    }

    function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);
        //
        if ($maj < 2) {
            $form->setType('categorie', 'select');
            $form->setType('dossier', 'hiddenstatic');
        }else{
             $form->setType('blocnote', 'hiddenstatic');
             $form->setType('destination', 'hiddenstatic');
             $form->setType('dossier', 'hiddenstatic');
        }
        
        // 
        if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            $form->setType('dossier', 'hidden');
        }
    }


    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        //parent::setSelect($form, $maj);
        $contenu=array();
        $contenu[0]=array(
            _('reprise'),
            _('suivi projet'),
            _('contentieux'),
            _('divers'),
            );
        $contenu[1]=array(
            _('reprise'),
            _('suivi projet'),
            _('contentieux'),
            _('divers'),
            );
        $form->setSelect("categorie",$contenu);
    }

    /**
     * CONDITION - is_ajoutable.
     *
     * Condition pour pouvoir ajouter
     *
     * @return boolean
     */
    function is_ajoutable() {
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "ajouter")){
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * CONDITION - is_modifiable.
     *
     * Condition pour afficher le bouton modifier
     *
     * @return boolean
     */
    function is_modifiable() {
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "modifier")){
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * CONDITION - is_supprimable.
     *
     * Condition pour afficher le bouton supprimer
     * @return boolean
     */
    function is_supprimable() {
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "supprimer")){
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * Conditions pour afficher les boutons modifier et supprimer
     *
     * @return boolean
     */
    function is_ajoutable_or_modifiable_or_supprimable() {
        // Tester si le dossier est cloturé ,
        // et si l'instructeur est de la même division
        if ($this->is_instructeur_from_division_dossier() === true and
            $this->is_dossier_instruction_not_closed() === true){
            return true;
        }

        return false;
    }

    /*
     * CONDITION - can_user_access_dossier_contexte_ajout
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'instruction passé dans le
     * formulaire d'ajout.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_ajout() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if ($id_dossier !== "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié à la commission instanciée.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {

        $id_dossier = $this->getVal('dossier');
        //
        if ($id_dossier !== "" && $id_dossier !== null) {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

}



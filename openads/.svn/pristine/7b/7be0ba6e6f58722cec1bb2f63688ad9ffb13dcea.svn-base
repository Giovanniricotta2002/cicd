<?php
/**
 * DBFORM - 'architecte_lc' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id$
 */
require_once("../obj/demandeur.class.php");


/**
 * Les architecte_lcs héritent des demandeurs.
 */
class architecte_lc extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "architecte_lc";

    /**
     * Cache les champs de notification, fréquent et type_demandeur.
     *
     * @param formulaire $form Instance de la classe om_formulaire.
     * @param integer    $maj  Identifiant de l'action.
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        $crud = $this->get_action_crud($maj);

        $form->setType('type_demandeur', 'hidden');
        $form->setType('notification', 'hidden');
        $form->setType('frequent', 'hidden');

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("num_inscription", "text");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }
        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("num_inscription", "text");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }
        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("num_inscription", "hiddenstatic");
            $form->setType("nom_cabinet", "hiddenstatic");
            $form->setType("conseil_regional", "hiddenstatic");
            $form->setType("titre_obt_diplo_spec", "hiddenstatic");
            $form->setType("date_obt_diplo_spec", "hiddenstatic");
            $form->setType("lieu_obt_diplo_spec", "hiddenstatic");
        }
        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("num_inscription", "static");
            $form->setType("nom_cabinet", "static");
            $form->setType("conseil_regional", "static");
            $form->setType("titre_obt_diplo_spec", "textareastatic");
            $form->setType("date_obt_diplo_spec", "datestatic");
            $form->setType("lieu_obt_diplo_spec", "textareastatic");
        }
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        if ($maj == 0) {
            $form->setVal("type_demandeur", "architecte_lc");
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $form->setVal("type_demandeur", "architecte_lc");
    }
}

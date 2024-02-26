<?php
/**
 * DBFORM - 'lien_om_utilisateur_groupe' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/lien_om_utilisateur_groupe.class.php";

class lien_om_utilisateur_groupe extends lien_om_utilisateur_groupe_gen {

    var $foreign_keys_extended = array(
        "groupe" => array("groupe", ),
        "om_utilisateur" => array("om_utilisateur", ),
    );

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($validation == 0) {
            if ($this->is_in_context_of_foreign_key('om_utilisateur', $this->getParameter("retourformulaire")) === true) {
                //
                $inst_om_utilisateur = $this->f->get_inst__om_dbform(array(
                    "obj" => "om_utilisateur",
                    "idx" => $idxformulaire,
                ));
                $form->setVal('login', $inst_om_utilisateur->getVal("login"));
            }
        }
        $this->set_form_default_values($form, $maj, $validation);
    }

    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        $form->setType("login", "hiddenstatic");
    }
}



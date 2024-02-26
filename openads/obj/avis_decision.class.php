<?php
/**
 * DBFORM - 'avis_decision' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'avis_decision'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/avis_decision.class.php";

class avis_decision extends avis_decision_gen {

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "avis_decision",
            "libelle",
            "typeavis",
            "sitadel",
            "sitadel_motif",
            "tacite",
            "avis_decision_type",
            "avis_decision_nature",
            "prescription",
        );
    }

    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        $form->setLib('avis_decision', _("id"));
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        if ($maj < 2) {
            $form->setType('typeavis', 'select');
            $form->setType('sitadel', 'select');
            $form->setType('sitadel_motif', 'select');
        }
        if ($maj == 3) {
            $form->setType('typeavis', 'selectstatic');
            $form->setType('sitadel', 'selectstatic');
            $form->setType('sitadel_motif', 'selectstatic');
        }

        //
        if ($this->f->is_option_mode_service_consulte_enabled() === false) {
            $form->setType('prescription', 'hidden');
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // typeavis
        $contenu=array();
        $contenu[0]=array(
            '',
            'A',
            'D',
            'F',
            );
        $contenu[1]=array(
            _('sans'),
            _('annulation'),
            _('defavorable'),
            _('favorable'),
            );
        $form->setSelect("typeavis",$contenu);
        // sitadel
        $contenu=array();
        $contenu[0]=array(
            '',
            '5',
            '8',
            '4',
            '2',
            '7',
            '6',
            '3',
            '1',
            );
        $contenu[1]=array(
            _('sans'),
            _('accord avec prescription'),
            _('annulation'),
            _('octroi'),
            _('octroi tacite'),
            _('sursis a statuer'),
            _('refus'),
            _('refus tacite'),
            _('rejet tacite'),
            );
        $form->setSelect("sitadel",$contenu);
        // sitadel_ motif annulation
        $contenu=array();
        $contenu[0]=array(
            '',
            '2',
            '1',
            );
        $contenu[1]=array(
            _('sans'),
            _('annulation par une juridiction administrative'),
            _('retrait a la demande du petitionnaire'),
            );
        $form->setSelect("sitadel_motif",$contenu);
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

}



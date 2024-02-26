<?php
/**
 * DBFORM - 'regle' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'regle'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/regle.class.php";

class regle extends regle_gen {

    function setType(&$form,$maj) {
        if ($maj < 2) { //ajouter et modifier
            $form->setType('sens', 'select');
            $form->setType('ordre', 'select');
            $form->setType('controle', 'hiddenstatic');
            $form->setType('libelle', 'hiddenstatic');
            $form->setType('id', 'hiddenstatic');
            $form->setType('champ', 'select');
            $form->setType('operateur', 'select');;
            if ($maj==1){ //modifier
               $form->setType('regle', 'hiddenstatic');
            }else
               $form->setType('regle', 'hidden');
        }else{ // supprimer
             $form->setType('regle', 'hiddenstatic');
             $form->setType('id', 'hiddenstatic');
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // parent::setSelect($form, $maj);
        //
        $contenu=array();
        $contenu[0]=array('plus','moins');
        $contenu[1]=array(_('plus'), _('moins'));
        $form->setSelect("sens",$contenu);
        //
        $contenu=array();
        $contenu[0]=array('terrain_surface',
                          'lot',
                          'date_notification_delai',
                          'date_rejet');
        $contenu[1]=array(_('terrain_surface'),
                          _('lot'),
                          _('date_notification_delai'),
                          _('date_rejet')
                          );
        $form->setSelect("champ",$contenu);
        //
        $contenu=array();
        $contenu[0]=array('1','2','3','4','5','6','7','8','9');
        $contenu[1]=array('1 '._('regle'),
                          '2 '._('regle'),
                          '3 '._('regle'),
                          '4 '._('regle'),
                          '5 '._('regle'),
                          '6 '._('regle'),
                          '7 '._('regle'),
                          '8 '._('regle'),
                          '9 '._('regle'),);
        $form->setSelect("ordre",$contenu);
        //
        $contenu=array();
        $contenu[0]=array('==','!=','>','<','<=','>=');
        $contenu[1]=array(_('egal'),_('different'),'>','<','<=','>=');
        $form->setSelect("operateur",$contenu);
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        if ($validation == 0) {
            if ($maj == 0) {
                $form->setVal("id", $idxformulaire);
                $form->setVal("controle", $retourformulaire);
            }
        }
    }
}



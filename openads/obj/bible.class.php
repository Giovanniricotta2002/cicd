<?php
/**
 * DBFORM - 'bible' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'bible'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/bible.class.php";

class bible extends bible_gen {

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        // En modes "ajouter" et "modifier"
        if ($maj ==  0 || $maj == 1) {
            $form->setType('complement', 'select');
            $form->setType('automatique', 'select');
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // complement
        $contenu=array();
        $contenu[0]=array('', '1','2','3','4','5','6','7','8','9','10','11');
        $contenu[1]=array(_('tous'),
                          _('complement').' 1',
                          _('complement').' 2',
                          _('complement').' 3',
                          _('complement').' 4',
                          _('complement').' 5',
                          _('complement').' 6',
                          _('complement').' 7',
                          _('complement').' 8',
                          _('complement').' 9',
                          _('complement').' 10',
                          _('complement').' 11',
                           );
        $form->setSelect("complement",$contenu);
        // automatique
        $contenu=array();
        $contenu[0]=array('Non','Oui');
        $contenu[1]=array(_('Non'),_('Oui'));
        $form->setSelect("automatique",$contenu);
    }

}



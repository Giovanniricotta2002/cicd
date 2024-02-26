<?php
/**
 * DBFORM - 'service' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'service'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/service.class.php";

class service extends service_gen {

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "service",
            "abrege",
            "libelle",
            "adresse",
            "adresse2",
            "cp",
            "ville",
            "email",
            "notification_email",
            "delai_type",
            "delai",
            "consultation_papier",
            "om_validite_debut",
            "om_validite_fin",
            "om_collectivite",
            "type_consultation",
            "edition",
            "service_type",
            "generate_edition",
            "uid_platau_acteur",
            "accepte_notification_email",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_edition() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat WHERE id LIKE 'consultation_%' ORDER BY om_etat.libelle ASC";
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        if ($maj < 2) {
            $form->setType('type_consultation', 'select');
            $form->setType('edition', 'select');
            $form->setType('delai_type', 'select');
            $form->setType('service_type', 'select');
        }
        if ($maj == 2 || $maj == 3) {
            $form->setType('service_type', 'selectstatic');
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

        $contenu=array();

        $contenu[0]=array(
          'avec_avis_attendu',
          'pour_conformite',
          'pour_information',
          );

        $contenu[1]=array(
          _('Avec avis attendu'),
          _('Pour conformite'),
          _('Pour information'),
          
          );
        $form->setSelect("type_consultation",$contenu);

        //
        $contenu = array();
        $contenu[0] = array('mois','jour');
        $contenu[1] = array(_('mois'), _('jour'));
        $form->setSelect("delai_type", $contenu);

        // service_type
        $contenu = array();
        $contenu[0] = array(PLATAU, 'openads', );
        $contenu[1] = array(__("Plat'AU"), __('openADS'), );
        $form->setSelect("service_type", $contenu);
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($maj > 1) {
            //Traitement des données pour l'affichage du select
            $temp = $this->val[array_search('type_consultation', array_keys($form->val))];
            if (strcmp($temp, 'pour_information') == 0) {
                $temp = _('Pour information');
            } elseif (strcmp($temp, 'avec_avis_attendu') == 0) {
                $temp = _('Avec avis attendu');
            } elseif (strcmp($temp, 'pour_conformite') == 0) {
                $temp = _('Pour conformite');
            }
            $form->setVal('type_consultation', $temp);
        }
    }
    
    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        $form->setLib("edition", __("type d'edition de la consultation"));
        $form->setLib("email", __("liste de diffusion"));
        $form->setLib("accepte_notification_email", __("peut recevoir une notification d'instruction"));
    }

    /**
     * SURCHARGE
     *
     * Configuration du formulaire (VIEW formulaire et VIEW sousformulaire).
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     *
     * @return void
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);

        $form->setTaille("uid_platau_acteur", 11);
    }

    /**
     * SURCHARGE
     *
     * Configuration du formulaire (VIEW formulaire et VIEW sousformulaire).
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     *
     * @return void
     */
    function setMax(&$form, $maj) {
        parent::setMax($form, $maj);

        $form->setMax("uid_platau_acteur", 11);
    }

    // XXX WIP
    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

}



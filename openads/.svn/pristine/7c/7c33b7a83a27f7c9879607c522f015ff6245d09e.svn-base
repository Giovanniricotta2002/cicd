<?php
/**
 * DBFORM - 'demande_avis_encours' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'demande_avis_encours'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/demande_avis.class.php";

class demande_avis_encours extends demande_avis {

    /**
     *
     */
    protected $_absolute_class_name = "demande_avis_encours";

    // Cette classe n'a pas vocation a modifier le champ code_barres seule
    // clé unique du modèle de données 'consultation', pour éviter de modifier
    // une données que nous n'avons pas besoin de modifier dans ce contexte
    // nous supprimons la contrainte
    var $unique_key = array(
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 091 - rendre_avis
        // Pour qu'un service rende l'avis
        $this->class_actions[91] = array(
            "identifier" => "rendre_avis",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Rendre un avis"),
                "order" => 40,
                "class" => "edit-16",
            ),
            "view" => "formulaire",
            "method" => "modifier",
            "permission_suffix" => "modifier",
            "condition" => array("is_consultation_retour_avis_service"),
            "button" => _("Modifier"),
        );

        // ACTION - 120 - marquer
        // 
        $this->class_actions[120] = array(
            "identifier" => "marquer",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer le dossier"),
                "order" => 80,
                "class" => "marque-16",
            ),
            "method" => "marquer",
            "permission_suffix" => "marquer",
            "condition" => array("is_markable"),
        );

        // ACTION - 130 - démarquer
        // 
        $this->class_actions[130] = array(
            "identifier" => "demarquer",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Dé-marquer le dossier"),
                "order" => 80,
                "class" => "demarque-16",
            ),
            "method" => "demarquer",
            "permission_suffix" => "demarquer",
            "condition" => array("is_unmarkable"),
        );
    }

    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        if($this->getParameter("maj") == 3) {
            // Cache le fieldset avis rendu
            $form->setType('fichier', 'hidden');
            $form->setType('avis_consultation', 'hidden');
            $form->setType("motivation", "hidden");
            $form->setType("date_retour", "hiddendate");
        }
        // On cache la visibilité de la consultation car ça n'a rien a faire ici
        $form->setType('visible', 'hidden');

        // Mode - retour d'avis
        // Modification layout : écran de retour d'avis permettant
        // uniquement la saisie des trois champs : avis, motivation et fichier
        if ($maj == 91) {
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
            $form->setType("consultation", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("avis_consultation", $this->getParameter("retourformulaire"))) {
                $form->setType("avis_consultation", "selecthiddenstatic");
            } else {
                $form->setType("avis_consultation", "select");
            }
            $form->setType("motivation", "textarea");
            $form->setType('fichier', 'upload2');

            // On cache alors tous les champs que nous ne voulons pas voir
            $form->setType('dossier_libelle', 'hidden');
            $form->setType('service', 'hidden');
            $form->setType('date_envoi', 'hiddendate');
            $form->setType('date_retour', 'hiddendate');
            $form->setType('date_reception', 'hiddendate');
            $form->setType('date_limite', 'hiddendate');
            $form->setType('lu', 'hidden');
            $form->setType('visible', 'hidden');
        }

        // On définit le type des champs pour les actions direct
        // utilisant la vue formulaire
        if ($maj == 120  || $maj == 130) {
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
        }
    }

    /**
     *
     * @return void
     */
    function setValF($val = array()) {
        if ($this->getParameter("maj") == 91) {
            if (!is_numeric($val['consultation'])) {
                $this->valF['consultation'] = ""; // -> requis
            } else {
                $this->valF['consultation'] = $val['consultation'];
            }
            if (!is_numeric($val['avis_consultation'])) {
                $this->valF['avis_consultation'] = null;
            } else {
                $this->valF['avis_consultation'] = $val['avis_consultation'];
            }
            $this->valF['motivation'] = $val['motivation'];
            if ($val['fichier'] == "") {
                $this->valF['fichier'] = null;
            } else {
                $this->valF['fichier'] = $val['fichier'];
            }
            if ($val['date_retour'] != "") {
                $this->valF['date_retour'] = $this->dateDB($val['date_retour']);
            } else {
                $this->valF['date_retour'] = null;
            }
            // Si un retour d'avis est modifie on passe "lu" a false
            if ($this->getVal("avis_consultation") != $val["avis_consultation"]
                || $this->getVal("date_retour") != $val["date_retour"]
                || $this->getVal("motivation") != $val["motivation"]
                || $this->getVal("fichier") != $val["fichier"]) {
                $this->valF["lu"] = false;
            }
            return;
        }
        parent::setValF($val);
    }

    function is_markable() {
        if ($this->getVal("marque") == 'f') {
            return true;
        }
        return false;
    }

    function is_unmarkable() {
        return !$this->is_markable();
    }

    function marquer($val = array(), &$dnu1 = null, $dnu2 = null) {
        return $this->manage_marque(true);
    }

    function demarquer($val = array(), &$dnu1 = null, $dnu2 = null) {
        return $this->manage_marque(false);
    }

    function manage_marque($bool) {
        // Begin
        $this->begin_treatment(__METHOD__);
        // Mise à jour
        $val = array("marque"=>$bool);
        $ret = $this->f->db->autoExecute(
            DB_PREFIXE."consultation",
            $val,
            DB_AUTOQUERY_UPDATE,
            "consultation = ".$this->getVal('consultation'));
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."consultation\", ".print_r($val, true).", DB_AUTOQUERY_UPDATE, \"consultation = ".$this->getVal('consultation')."\")",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($ret, true) !== false) {
            $this->erreur_db($ret->getDebugInfo(), $ret->getMessage(), 'consultation');
            $this->correct = false;
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }
        $state = ($bool) ? _("marqué") : _("dé-marqué");
        $this->addToMessage(_("Dossier").' '.$state.' '._("avec succès."));
        $this->correct = true;
        return $this->end_treatment(__METHOD__, true);
    }


    /**
     * CONDITION - Défini si l'utilisateur est de service interne.
     *
     * @return boolean true si correspond false sinon
     */
    public function is_consultation_retour_avis_service() {

        return $this->f->isAccredited("consultation_retour_avis_service");
    }


   /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        $maj = $this->getParameter('maj');
        //
        if ($maj == 91) {
            //
            return false;
        }
        //
        return true;
    }


}



<?php
/**
 * DBFORM - 'evenement' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'evenement'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/evenement.class.php";

class evenement extends evenement_gen {

    /**
    * Liaison NaN
    *
    * Tableau contenant les objets qui représente les liaisons.
    */
    var $liaisons_nan = array(
            "evenement_type_habilitation_tiers_consulte" => array(
            "table_l" => "evenement_type_habilitation_tiers_consulte",
            "table_f" => "type_habilitation_tiers_consulte",
            "field" => "type_habilitation_tiers_consulte",
        )
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    public function init_class_actions() {

        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // Modifie la condition d'affichage du bouton ajouter
        $this->class_actions[0]["condition"] = "is_addable_editable_and_deletable";

        // ACTION - 001 - modifier
        // Modifie la condition et le libellé du bouton modifier
        $this->class_actions[1]["condition"] = "is_addable_editable_and_deletable";

        // ACTION - 002 - supprimer
        // Modifie la condition et le libellé du bouton supprimer
        $this->class_actions[2]["condition"] = "is_addable_editable_and_deletable";
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "evenement.evenement",
            "evenement.libelle",
            "evenement.type",
            "evenement.commentaire",
            "evenement.non_verrouillable",
            "evenement.non_modifiable",
            "evenement.non_supprimable",
            "evenement.signataire_obligatoire",
            "evenement.notification",
            "evenement.notification_service",
            "evenement.notification_tiers",
            "array_to_string(array_agg(distinct(type_habilitation_tiers_consulte) ORDER BY type_habilitation_tiers_consulte), ';') as type_habilitation_tiers_consulte",
            "evenement.envoi_cl_platau",
            "evenement.retour",
            "array_to_string(array_agg(distinct(transition.etat) ORDER BY transition.etat), ';') as etats_depuis_lequel_l_evenement_est_disponible",
            "array_to_string(array_agg(distinct(dossier_instruction_type) ORDER BY dossier_instruction_type), ';') as dossier_instruction_type",
            "evenement.restriction",
            "evenement.action",
            "evenement.etat",
            "evenement.delai",
            "evenement.accord_tacite",
            "evenement.delai_notification",
            "evenement.avis_decision",
            "evenement.autorite_competente",
            "evenement.pec_metier",
            "evenement.lettretype",
            "evenement.consultation",
            "evenement.phase",
            "evenement.finaliser_automatiquement",
            "evenement.evenement_suivant_tacite",
            "evenement.evenement_retour_ar",
            "evenement.evenement_retour_signature",
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$s evenement_type_habilitation_tiers_consulte
                    ON evenement.evenement = evenement_type_habilitation_tiers_consulte.evenement
                LEFT JOIN %1$slien_dossier_instruction_type_evenement 
                    ON lien_dossier_instruction_type_evenement.evenement=evenement.evenement
                LEFT JOIN %1$stransition 
                    ON transition.evenement=evenement.evenement',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
    *
    * @return string
    */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte() {
        return sprintf(
            'SELECT
                type_habilitation_tiers_consulte.type_habilitation_tiers_consulte,
                type_habilitation_tiers_consulte.libelle
            FROM
                %stype_habilitation_tiers_consulte
            WHERE
                (
                    (
                        type_habilitation_tiers_consulte.om_validite_debut IS NULL
                        AND (
                            type_habilitation_tiers_consulte.om_validite_fin IS NULL
                            OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE
                        )
                    )
                    OR (
                        type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE
                        AND (
                            type_habilitation_tiers_consulte.om_validite_fin IS NULL
                            OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE
                        )
                    )
                )
            ORDER BY
                type_habilitation_tiers_consulte.libelle ASC',
                DB_PREFIXE
        );
    }

    /**
    *
    * @return string
    */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte_by_id() {
        return sprintf(
            'SELECT
                type_habilitation_tiers_consulte.type_habilitation_tiers_consulte,
                type_habilitation_tiers_consulte.libelle
            FROM
                %stype_habilitation_tiers_consulte
            WHERE
                type_habilitation_tiers_consulte IN (<idx>)',
            DB_PREFIXE
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY evenement.evenement, evenement.libelle ";
    }

    /**
     * CONDITION - is_addable_editable_and_deletable.
     *
     * Condition pour l'affichage de l'action d'ajout, de modification et de
     * suppression.
     *
     * @return boolean
     */
    public function is_addable_editable_and_deletable() {

        // Si evenement est ouvert en sous-formulaire
        if ($this->getParameter("retourformulaire") !== null) {

            //
            return false;
        }

        //
        return true;
    }


    function setType(&$form, $maj) {
        $optionNotif = $this->f->is_option_enabled('option_module_acteur');
        $form->setType('type_habilitation_tiers_consulte','hidden');
        //
        parent::setType($form, $maj);
        // MODE AJOUTER et MODE MODIFIER
        if ($maj == 0 || $maj == 1) {
            //
            $form->setType('accord_tacite', 'select');
            $form->setType('delai_notification', 'select');
            $form->setType('delai', 'select');
            $form->setType('lettretype', 'select');
            $form->setType('consultation', 'checkbox');
            $form->setType('dossier_instruction_type','select_multiple');
            $form->setType('type','select');
            $form->setType('etats_depuis_lequel_l_evenement_est_disponible','select_multiple');
            $form->setType('notification','select');
            $form->setType('notification_tiers','select');
            if ($optionNotif === true) {
                $form->setType('type_habilitation_tiers_consulte','select_multiple');
            }
        }
        // MODE SUPPRIMER et MODE CONSULTER
        if ($maj == 2 || $maj == 3) {
            //
            $form->setType('dossier_instruction_type','select_multiple_static');
            $form->setType('etats_depuis_lequel_l_evenement_est_disponible','select_multiple_static');
            $form->setType('notification','selecthiddenstatic');
            if ($optionNotif === true) {
                $form->setType('type_habilitation_tiers_consulte','select_multiple_static');
            }
            $form->setType('notification_tiers','selectstatic');
        }

        // Mode modifier
        if ($maj == 1) {
            // Champ non modifiable pour éviter un déréglement du paramètrage
            // des événements
            $form->setType('retour', 'checkboxhiddenstatic');
        }

        // Cache les champs en fonction de la valeur de 'retour'
        if ($this->getVal("retour") == 't') {

            // Cache les champs "evenement_retour_ar" et 
            // "evenement_retour_signature"
            $form->setType('evenement_retour_ar', 'hidden');
            $form->setType('evenement_retour_signature', 'hidden');

            // En mode Ajouter et Modifier
            if ($maj < 2) {
                $form->setType('restriction', 'hiddenstatic');
                $form->setType('delai', 'hiddenstatic');
                $form->setType('accord_tacite', 'hiddenstatic');
                $form->setType('delai_notification', 'hiddenstatic');
                $form->setType('avis_decision', 'hiddenstatic');
            }
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT 
  dossier_instruction_type.dossier_instruction_type, 
  CONCAT(dossier_autorisation_type_detaille.code,' - ',dossier_instruction_type.code,' - ',dossier_instruction_type.libelle) as lib
FROM ".DB_PREFIXE."dossier_instruction_type 
  LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
ORDER BY dossier_autorisation_type_detaille.code";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT 
  dossier_instruction_type.dossier_instruction_type, 
  CONCAT(dossier_autorisation_type_detaille.code,' - ',dossier_instruction_type.code,' - ',dossier_instruction_type.libelle) as lib
FROM ".DB_PREFIXE."dossier_instruction_type 
  LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
WHERE dossier_instruction_type IN (<idx>) 
ORDER BY dossier_autorisation_type_detaille.code";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etats_depuis_lequel_l_evenement_est_disponible() {
        return "SELECT etat.etat, etat.libelle as lib FROM ".DB_PREFIXE."etat ORDER BY lib";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etats_depuis_lequel_l_evenement_est_disponible_by_id() {
        return "SELECT etat.etat, etat.libelle as lib FROM ".DB_PREFIXE."etat WHERE etat.etat IN (<idx>) ORDER BY lib";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_ar() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement.retour = 't' ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_signature() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement.retour = 't' ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement.retour = 'f' ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_lettretype() {
        return sprintf(
            'SELECT
                id,
                (id||\' \'||libelle) AS lib
            FROM
                %1$som_lettretype
            ORDER BY
                lib',
            DB_PREFIXE
        );
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        //
        if ($maj < 2) {
            // lettretype
            $contenu = array();
            $qres = $this->f->get_all_results_from_db_query(
                $this->get_var_sql_forminc__sql("om_lettretype"),
                array(
                    'origin' => __METHOD__
                )
            );

            $contenu[0][0]='';
            $contenu[1][0]=_('choisir')."&nbsp;"._('lettretype');
            $k = 1;
            foreach($qres['result'] as $row) {
                $contenu[0][$k] = $row['id'];
                $contenu[1][$k] = $row['lib'];
                $k++;
            }
            $form->setSelect('lettretype', $contenu);
        }
        // accord_tacite
        $contenu=array();
        $contenu[0]=array('Non','Oui');
        $contenu[1]=array(_('Non'), _('Oui'));
        $form->setSelect("accord_tacite",$contenu);
        // delai_notification
        $contenu=array();
        $contenu[0]=array('0','1');
        $contenu[1]=array('sans','1 '._("mois"));
        $form->setSelect("delai_notification",$contenu);
        // delai
        $contenu=array();
        $contenu[0]=array('0','1','2','3','4','5','6','7','8','9','10','11','12','18','24');
        $contenu[1]=array('sans',
                          '1 '._("mois"),
                          '2 '._("mois"),
                          '3 '._("mois"),
                          '4 '._("mois"),
                          '5 '._("mois"),
                          '6 '._("mois"),
                          '7 '._("mois"),
                          '8 '._("mois"),
                          '9 '._("mois"),
                          '10 '._("mois"),
                          '11 '._("mois"),
                          '12 '._("mois"),
                          '18 '._("mois"),
                          '24 '._("mois")
                          );
        $form->setSelect("delai",$contenu);

        // choix possible de notification_tiers
        $contenu = array(
            0 => array(
                '',
                'notification_manuelle'
            ),
            1 => array(
                __("Aucune"),
                __("Notification manuelle")
            )
        );
        // Si l'option de notificaton automatique des tiers est active ajout d'un choix sup
        if ($this->f->is_option_enabled('option_module_acteur') === true) {
            $contenu[0][] = 'notification_automatique';
            $contenu[1][] = __("Notification automatique");
        }
        $form->setSelect("notification_tiers", $contenu);

        // type de l'événement
        $contenu=array();
        $contenu[0]=array(
            '',
            'arrete',
            'incompletude',
            'majoration_delai',
            'retour',
            'changement_decision',
            'affichage',
            'ait',
            'annul_contradictoire'
            );
        $contenu[1]=array(
            _('choisir type'),
            _('arrete'),
            _('incompletude'),
            _('majoration_delai'),
            _('retour de pieces'),
            _('changement de decision'),
            _('affichage'),
            _('arrêté interruptif des travaux'),
            _('annulation de contradictoire'),
            );
        $form->setSelect("type",$contenu);
        // dossier_instruction_type
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "dossier_instruction_type",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false,
            true
        );
        // etats_depuis_lequel_l_evenement_est_disponible
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "etats_depuis_lequel_l_evenement_est_disponible",
            $this->get_var_sql_forminc__sql("etats_depuis_lequel_l_evenement_est_disponible"),
            $this->get_var_sql_forminc__sql("etats_depuis_lequel_l_evenement_est_disponible_by_id"),
            false,
            true
        );
        // evenement_retour_ar
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "evenement_retour_ar",
            $this->get_var_sql_forminc__sql("evenement_retour_ar"),
            $this->get_var_sql_forminc__sql("evenement_retour_ar_by_id"),
            false,
            false,
            __("l'événement lors de la notification du pétitionnaire")
        );


        // Initialisation du selecteur multiple type_habilitation_tiers_consulte
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "type_habilitation_tiers_consulte",
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte"),
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte_by_id"),
            false,
            true
        );
    
        // notification
        $contenu = array();
        $contenu[0] = array(
            '',
            'notification_automatique',
            'notification_manuelle',
            'notification_auto_signature_requise',
            'notification_manuelle_signature_requise',
            'notification_manuelle_annexe',
            'notification_manuelle_annexe_signature_requise'
        );
        $contenu[1] = array(
            __('Pas de notification'),
            __('Notification automatique'),
            __('Notification manuelle'),
            __('Notification automatique avec signature requise'),
            __('Notification manuelle avec signature requise'),
            __('Notification manuelle avec annexe'),
            __('Notification manuelle avec annexe et avec signature requise')
        );
        $form->setSelect('notification', $contenu);
    }

    function setTaille(&$form, $maj) {
        //
        parent::setTaille($form, $maj);
        //
        $form->setTaille("dossier_instruction_type", 10);
        $form->setTaille("etats_depuis_lequel_l_evenement_est_disponible", 10);
    }

    function setMax(&$form, $maj) {
        //
        parent::setMax($form, $maj);
        //
        $form->setMax("dossier_instruction_type", 5);
        $form->setMax("etats_depuis_lequel_l_evenement_est_disponible", 5);
    }

    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib("dossier_instruction_type", _("type(s) de DI concerne(s)"));
        $form->setLib("etats_depuis_lequel_l_evenement_est_disponible", _("etat(s) source(s)"));
        $form->setLib('notification_service', __('Notification des services'));
        $form->setLib('notification_tiers', __('Notification des tiers'));
        $form->setLib("type_habilitation_tiers_consulte", __("type(s) d'habilitation des tiers consultés à notifier"));
        // Change le libellé de retour pour pas qu'il soit confondus avec le
        // bouton
        $form->setLib("retour", _("retour_evenement"));
        // En ajout et en modification 
        if ($maj < 2) {
            $form->setLib("retour", _("retour_evenement (parametrage non modifiable)"));
        }

        // Message d'aide à l'utilisateur concernant les événements liés
        $message_help = _("Les champs suivants seront copies vers l'evenement choisi :");
        $champs_copy = _('delai') . ", " . _('accord_tacite') . ", " . _('delai_notification') . ", " . _('avis_decision') . ", " . _('restriction');
        $form->setLib("evenement_retour_ar", __('Événement lors de la notification du correspondant') . "<br> (" . $message_help . " " . $champs_copy . ")");
        $form->setLib("evenement_retour_signature", _('evenement_retour_signature') . "<br> (" . $message_help . " " . $champs_copy . ")");

        $form->setLib("commentaire", __("Commentaire"));
        $form->setLib("non_modifiable", __("Non modifiable"));
        $form->setLib("non_supprimable", __("Non supprimable"));
        $form->setLib("signataire_obligatoire", __("Signataire obligatoire"));
    }

    function setLayout(&$form, $maj) {
        //
        parent::setLayout($form, $maj);
        //
        $form->setFieldset("evenement", "D", _("Evenement"));
        $form->setFieldset("retour", "F");
        //
        $form->setFieldset("etats_depuis_lequel_l_evenement_est_disponible", "D", _("Filtre de selection"));
            $form->setBloc("etats_depuis_lequel_l_evenement_est_disponible", "D", _("Filtres pour la possibilite de selection a l'ajout d'un evenement d'instruction"));
            $form->setBloc("dossier_instruction_type", "F");
            $form->setBloc("restriction", "DF", _("Filtre supplementaire a l'enregistrement de l'evenement d'instruction"));
        $form->setFieldset("restriction", "F");
        //
        $form->setFieldset("action", "D", _("Action"));
            $form->setBloc("action", "DF");
            $form->setBloc("etat", "D", _("Parametres de l'action"));
            $form->setBloc("pec_metier", "F");
        $form->setFieldset("pec_metier", "F");
        //
        $form->setFieldset("lettretype", "D", _("Edition"));
        $form->setFieldset("finaliser_automatiquement", "F");
        //
        $form->setFieldset("evenement_suivant_tacite", "D", _("Evenements lies"), "evenements_lies");
        $form->setFieldset("evenement_retour_signature", "F");
    }

    function set_form_specificity(&$form, $maj) {
        parent::set_form_specificity($form, $maj);
        // Pour les notification non automatique ajoute une classe permettant de masquer le champs
        // type_habilitation_tiers_consulte.
        if ($this->getParameter("validation") > 0) {
            $postvar = $this->getParameter("postvar");
            $notification_tiers = isset($postvar['notification_tiers']) ? $postvar['notification_tiers'] : null;
        } elseif (isset($this->val['notification_tiers'])) {
            $notification_tiers = $this->val['notification_tiers'];
        } else {
            $notification_tiers = $this->getVal('notification_tiers');
        }
        if (empty($notification_tiers) || $notification_tiers !== 'notification_automatique') {
            $form->classes_specifiques['type_habilitation_tiers_consulte'] = 'ui-tabs-hide';
        }
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - ...
     * - Ajoute autant de lien_dossier_instruction_type_evenement que de dossier_instruction_type
     * - ...
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);

        /**
         * LIEN ETAT
         */
        // Récupération des données du select multiple
        $etats_depuis_lequel_l_evenement_est_disponible = $this->getEvenementLinks(
            'etats_depuis_lequel_l_evenement_est_disponible',
            'transition',
            'etat'
        );
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($etats_depuis_lequel_l_evenement_est_disponible)
            && count($etats_depuis_lequel_l_evenement_est_disponible) > 0) {
            // Initialisation
            $nb_liens_etat = 0;
            // Boucle sur la liste des états sélectionnés
            foreach ($etats_depuis_lequel_l_evenement_est_disponible as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //
                    $data = array(
                        'evenement' => $this->valF['evenement'],
                        'etat' => $value
                    );
                    // On ajoute l'enregistrement
                    $this->addEvenementLinks($data, 'transition');
                    // On compte le nombre d'éléments ajoutés
                    $nb_liens_etat++;
                }
            }
            // Message de confirmation
            if ($nb_liens_etat > 0) {
                if ($nb_liens_etat == 1) {
                    $this->addToMessage(_("Creation de ").$nb_liens_etat._(" nouvelle liaison realisee avec succes."));
                } else {
                    $this->addToMessage(_("Creation de ").$nb_liens_etat._(" nouvelles liaisons realisees avec succes."));
                }
            }
        }

        /**
         * LIEN DI TYPE
         */
        // Récupère les données du select multiple
        $dossier_instruction_type = $this->getEvenementLinks(
            'dossier_instruction_type',
            'lien_dossier_instruction_type_evenement',
            'dossier_instruction_type'
        );
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($dossier_instruction_type) && count($dossier_instruction_type) > 0) {
            $nb_tr = 0;
            // Va créer autant de lien_dossier_instruction_type_evenement
            // que de dossier_instruction_type choisis
            foreach ($dossier_instruction_type as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //Données
                    $data = array(
                        'evenement' => $this->valF['evenement'],
                        'dossier_instruction_type' => $value
                    );
                    // Ajoute un nouveau lien_dossier_instruction_type_evenement
                    $this->addEvenementLinks($data, 'lien_dossier_instruction_type_evenement');
                    $nb_tr++;
                }
            }
            // Message de confirmation de création de(s) lien_dossier_instruction_type_evenement(s).
            if ($nb_tr > 0) {
                if ($nb_tr == 1) {
                    $this->addToMessage(_("Creation de ").$nb_tr._(" nouvelle liaison 
                        realisee avec succes."));
                } else {
                    $this->addToMessage(_("Creation de ").$nb_tr._(" nouvelles liaisions 
                        realisee avec succes."));
                }
            }
        }

        // Liaison NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Si le champ possède une valeur
            if (isset($val[$liaison_nan["field"]]) === true) {
                // Ajout des liaisons table Nan
                $nb_liens = $this->ajouter_liaisons_table_nan(
                    $liaison_nan["table_l"],
                    $liaison_nan["table_f"],
                    $liaison_nan["field"],
                    $val[$liaison_nan["field"]]
                );

                // Message de confirmation
                if ($nb_liens > 0) {
                    if ($nb_liens == 1) {
                        $this->addToMessage(sprintf(
                            __("Création d'une nouvelle liaison réalisee avec succès."))
                        );
                    } else {
                        $this->addToMessage(sprintf(
                            __("Création de %s nouvelles liaisons réalisée avec succès."), 
                            $nb_liens)
                        );
                    }
                }
            }
        }

        // Copie les paramètres vers l'événement lié
        $this->copyParametersToEvenementLink();
    }
        
    /**
     * Récupère les liens de la variable POST ou de la base de données selon le
     * contexte
     * 
     * @param $champ Le champ POST à récupérer
     * @return mixed Les liens
     */
    function getEvenementLinks($champ, $table, $champLie){
            
        $liens = array();

        // Si on est dans le contexte d'un formulaire
        if ( isset($this->form) && !is_null($this)){
            // On récupère les données post
            if ($this->f->get_submitted_post_value($champ) !== null) {
            
                return $this->f->get_submitted_post_value($champ);
            }
        }
        //Si on n'est pas dans le contexte d'un formulaire
        else {

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT 
                        %2$s
                    FROM
                        %1$s%3$s
                    WHERE
                        evenement = %4$d',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($champLie),
                    $this->f->db->escapeSimple($table),
                    intval($this->valF['evenement'])
                ),
                array(
                    'origin' => __METHOD__,
                    'force_result' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($qres['message'], $qres['message'], 'evenement');
            }
            
            foreach($qres['result'] as $row) {
                
                $liens[] = $row[$champLie];
            }
        }
        
        return $liens;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggermodifierapres($id, $dnu1, $val);

        /**
         * LIEN ETAT
         */
        // On récupère les liens selon le contexte : POST ou base de données
        $etats_depuis_lequel_l_evenement_est_disponible = $this->getEvenementLinks(
            'etats_depuis_lequel_l_evenement_est_disponible',
            'transition',
            'etat'
        );

        // Suppression de tous les liens de la table transition (table lien
        // entre etat et evenement)
        $this->deleteEvenementLinks($this->valF['evenement'], 'transition');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($etats_depuis_lequel_l_evenement_est_disponible)
            && count($etats_depuis_lequel_l_evenement_est_disponible) > 0) {
            // Initialisation
            $nb_liens_etat = 0;
            // Boucle sur la liste des états sélectionnés
            foreach ($etats_depuis_lequel_l_evenement_est_disponible as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //
                    $data = array(
                        'evenement' => $this->valF['evenement'],
                        'etat' => $value
                    );
                    // On ajoute l'enregistrement
                    $this->addEvenementLinks($data, 'transition');
                    // On compte le nombre d'éléments ajoutés
                    $nb_liens_etat++;
                }
            }
            // Message de confirmation
            if ($nb_liens_etat > 0) {
                $this->addToMessage(_("Mise a jour des liaisons realisee avec succes."));
            }
        }

        /**
         * LIEN DI TYPE
         */
        // On récupère les liens selon le contexte : POST ou base de données
        $dossier_instruction_type = $this->getEvenementLinks(
            'dossier_instruction_type',
            'lien_dossier_instruction_type_evenement',
            'dossier_instruction_type'
        );
        // Supprime toutes les liaisions liées à l'événement
        $this->deleteEvenementLinks($this->valF['evenement'], 'lien_dossier_instruction_type_evenement');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($dossier_instruction_type) && count($dossier_instruction_type) > 0) {
            $nb_tr = 0;
            // Va créer autant de lien_dossier_instruction_type_evenement que de dossier_instruction_type choisis
            foreach ($dossier_instruction_type as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //Données
                    $data = array(
                        'evenement' => $this->valF['evenement'],
                        'dossier_instruction_type' => $value
                    );
                    //Ajoute un nouveau lien_dossier_instruction_type_evenement
                    $this->addEvenementLinks($data, 'lien_dossier_instruction_type_evenement');
                    $nb_tr++;
                }
            }
            //Message de confirmation de création de(s) lien_dossier_instruction_type_evenement.
            if ($nb_tr > 0) {
                $this->addToMessage(_("Mise a jour des liaisons realisee avec succes."));
            }
        }


        // Liaison NaN
        foreach ($this->liaisons_nan as $liaison_nan) {

            // Liaisons NaN
            foreach ($this->liaisons_nan as $liaison_nan) {
                // Suppression des liaisons table NaN
                $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
            }
            
            // Si le champ possède une valeur
            if (isset($val[$liaison_nan["field"]]) === true) {
                // Ajout des liaisons table Nan
                $nb_liens = $this->ajouter_liaisons_table_nan(
                    $liaison_nan["table_l"],
                    $liaison_nan["table_f"],
                    $liaison_nan["field"],
                    $val[$liaison_nan["field"]]
                );
                // Message de confirmation
                if ($nb_liens > 0) {
                    if ($nb_liens == 1) {
                        $this->addToMessage(sprintf(
                            __("Création d'une nouvelle liaison réalisee avec succès."))
                        );
                    } else {
                        $this->addToMessage(sprintf(
                            __("Création de %s nouvelles liaisons réalisée avec succès."), 
                            $nb_liens)
                        );
                    }
                }
            }
        }
        // Copie les paramètres vers l'événement lié
        $this->copyParametersToEvenementLink();
    }

    /**
     * Ajout d'un lien dans la table passée en paramètre
     * @param $data Les données à ajouter
     * @param $table La table à populer
     */
    function addEvenementLinks($data, $table){
        $linksEvenement = $this->f->get_inst__om_dbform(array(
            "obj" => $table,
            "idx" => "]",
        ));
        
        $linksEvenement->valF = array();
        $val[$table] = NULL;
        //
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $val[$key]=$value;
            }
        }
        //
        $linksEvenement->ajouter($val);
    }

    /**
     * Suppression des liens de la table passé en paramètre
     * @param $id L'identifiant de l'événement
     * @param $table La table à vider
     */
    function deleteEvenementLinks($id, $table){
        
        // Suppression de tous les enregistrements correspondants à l'id de
        // l'événement
        $sql = "DELETE
            FROM ".DB_PREFIXE.$table."
            WHERE evenement = ".$id;
        $res = $this->f->db->query($sql);
        $this->addToLog(
            __METHOD__."(): db->query(\"".$sql."\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), 'evenement');
        } 
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Suppression de tous les liens de la table transition (table lien
        // entre etat et evenement)
        $this->deleteEvenementLinks($this->getVal('evenement'), 'transition');
        //Supprime toutes les lien_dossier_instruction_type_evenement liées à l'evenement
        $this->deleteEvenementLinks($this->getVal('evenement'), 'lien_dossier_instruction_type_evenement');

        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
        }
    }
    
     /**
     * TRIGGER - triggersupprimerapres.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
    }

    /* Surcharge de la fonction cleSecondaire pour qu'elle ne vérifie pas le lien avec 
     * lien_dossier_instruction_type_evenement qui sera supprimé juste après ni avec la table transition*/ 
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {

        // Verification de la cle secondaire : bible
        $this->rechercheTable($dnu1, "bible", "evenement", $id);
        // Verification de la cle secondaire : demande_type
        $this->rechercheTable($dnu1, "demande_type", "evenement", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($dnu1, "evenement", "evenement_retour_ar", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($dnu1, "evenement", "evenement_suivant_tacite", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($dnu1, "instruction", "evenement", $id);
        //// Verification de la cle secondaire : transition
        //$this->rechercheTable($dnu1, "transition", "evenement", $id);
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($maj == 2 && $validation == 1) {
            //Affichage des dossier_instruction_type anciennement liés
            $form->setVal("dossier_instruction_type", $this->val[count($this->val)-1]);
        }
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        //Test qu'une restriction est présente
        if (isset($this->valF['restriction']) && $this->valF['restriction'] != ""){

            $restriction = $this->valF['restriction'];

            // Liste des opérateurs possible
            $operateurs = array(">=", "<=", "+", "-", "&&", "||", "==", "!=");

            // Supprime tous les espaces de la chaîne de caractère
            $restriction = str_replace(' ', '', $restriction);
            
            // Met des espace avant et après les opérateurs puis transforme la 
            // chaine en un tableau 
            $tabRestriction = str_replace($operateurs, " ", $restriction);
            // Tableau des champ
            $tabRestriction = explode(" ", $tabRestriction);
            // Supprime les numériques du tableau
            foreach ($tabRestriction as $key => $value) {
                if (is_numeric($value)) {
                    unset($tabRestriction[$key]);
                }
            }

            // Vérifie les champs utilisés pour la restriction
            $check_field_exist = $this->f->check_field_exist($tabRestriction, 
                'instruction');
            if ($check_field_exist !== true) {

                // Liste des champs en erreur
                $string_error_fields = implode(", ", $check_field_exist);

                // Message d'erreur
                $error_message = _("Le champ %s n'est pas utilisable pour le champ %s");
                if (count($check_field_exist) > 1) {
                    $error_message = _("Les champs %s ne sont pas utilisable pour le champ %s");
                }

                // Affiche l'erreur
                $this->correct=false;
                $this->addToMessage(sprintf($error_message, $string_error_fields, _("restriction")));
            }
        }

        // Identifiant de l'évenement en cours
        $evenement_main = "";
        // Si pas en mode "Ajouter"
        if ($this->getParameter("maj") != 0) {
            $evenement_main = $this->valF['evenement'];
        }

        //
        $error_retour = false;

        // Si le même événement retour est sélectionné pour le retour ar et le
        // retour signature
        if (isset($this->valF['evenement_retour_ar']) 
            && $this->valF['evenement_retour_ar'] != ""
            && isset($this->valF['evenement_retour_signature']) 
            && $this->valF['evenement_retour_signature'] != "") {

            //
            if ($this->valF['evenement_retour_ar'] == $this->valF['evenement_retour_signature']) {

                // Récupère l'événement
                $evenement_retour = $this->valF['evenement_retour_ar'];

                // Récupère le libelle de l'événement
                $evenement_retour_libelle = $this->getEvenementLibelle($evenement_retour);

                // Message d'erreur
                $error_message = _("L'evenement \"%s\" ne peut pas etre utilise en tant qu'evenement d'accuse de reception et evenement de retour de signature.");

                // Le formulaire n'est pas validé
                $this->correct=false;
                $this->addToMessage(sprintf($error_message, $evenement_retour_libelle));
                $error_retour = true;
            }
        }

        // Si l'erreur concernant la double utilisation d'une événement retour 
        // sur le même formulaire n'est pas activé
        if ($error_retour === false) {

            // Vérifie que l'événement "evenement_retour_signature" n'est pas
            // utilisé en evenement retour 
            $this->checkEvenementRetour('evenement_retour_signature', $evenement_main);
            // Vérifie que l'événement n'est pas déjà utilisé en tant que 
            // "evenement_retour_ar"
            $this->checkEvenementRetour('evenement_retour_ar', $evenement_main);
        }

        // Si c'est un événement retour
        if (isset($this->valF['retour']) 
            && $this->valF['retour'] === true) {

            // Supprime les valeurs des champs
            unset($this->valF['evenement_retour_ar']);
            unset($this->valF['evenement_retour_signature']);
        }

        if (isset($this->valF['lettretype']) &&
            $this->valF['lettretype'] != '' &&
            isset($this->valF['non_modifiable']) &&
            $this->valF['non_modifiable'] == 'Oui')
        {
            // Message d'erreur
            $error_message = __("L'evenement ne peut pas avoir une lettre type et être non modifiable");

            // Le formulaire n'est pas validé
            $this->correct=false;
            $this->addToMessage($error_message);
        }
    }

    /**
     * Vérifie que l'événement $champ n'est pas déjà utilisé en événement 
     * 'evenement_retour_ar' et 'evenement_retour_signature'
     * @param  string   $champ          Champ à tester
     * @param  integer  $evenement_main Identifiant de l'événement en cours
     */
    function checkEvenementRetour($champ, $evenement_main) {

        // Si un l'évenement est renseigné
        if (isset($this->valF[$champ]) 
            && $this->valF[$champ] != "") {

            // Récupère l'événement
            $evenement_retour = $this->valF[$champ];

            // Récupère le libelle de l'événement
            $evenement_libelle = $this->getEvenementLibelle($evenement_retour);

            // Si l'événement est utilisé en tant que "evenement_retour_ar"
            if ($this->checkEvenementIsUse($evenement_retour, 'evenement_retour_ar', $evenement_main)) {

                // Message d'erreur
                $error_message = _("L'evenement \"%s\" est deja utilise en tant qu'evenement d'accuse de reception.");

                // Le formulaire n'est pas validé
                $this->correct=false;
                $this->addToMessage(sprintf($error_message, $evenement_libelle));
            }

            // Si l'événement est utilisé en tant que 
            // "evenement_retour_signature"
            if ($this->checkEvenementIsUse($evenement_retour, 'evenement_retour_signature', $evenement_main)) {

                // Message d'erreur
                $error_message = _("L'evenement \"%s\" est deja utilise en tant qu'evenement de retour de signature.");

                // Le formulaire n'est pas validé
                $this->correct=false;
                $this->addToMessage(sprintf($error_message, $evenement_libelle));
            }
        }

    }

    /**
     * Vérifie si l'événement est déjà utilisé dans un autre champ
     * @param  integer $evenement Identifiant de l'événement
     * @return boolean            
     */
    function checkEvenementIsUse($evenement_link, $champ, $evenement_main) {

        // Initialisation du retour de la fonction
        $return = false;

        // Si les paramètres ne sont pas vide
        if ($evenement_link != "" && $champ != "") {

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT 
                        evenement
                    FROM 
                        %1$sevenement
                    WHERE 
                        %2$s = %3$s
                    %4$s',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($champ),
                    $this->f->db->escapeSimple($evenement_link),
                    // Si l'événement principal est déjà créé,
                    // il ne faut pas que l'événement principal soit pris en compte
                    $evenement_main != "" ?
                        sprintf(" AND evenement != %d", intval($evenement_main)) :
                        ''
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            // Si il y a un résultat à la requête
            if ($qres['row_count'] > 0) {

                // Change la valeur de retour
                $return = true;
            }
        }

        // Retourne le résultat de la fonction
        return $return;

    }

    /**
     * Récupère le libellé de l'evénement passé en paramètre
     * @param  integer $evenement Identifiant de l'événement
     * @return string             Libellé de l'événement
     */
    function getEvenementLibelle($evenement) {
        $inst_evenement = $this->f->get_inst__om_dbform(array(
            "obj" => "evenement",
            "idx" => $evenement,
        ));
        return $inst_evenement->getVal("libelle");
    }

    /**
     * Copie les paramétres de l'événement principal vers l'évévenement lié
     */
    function copyParametersToEvenementLink() {
        // Si un évenement retour de signature est renseigné
        if (isset($this->valF['evenement_retour_signature']) 
            && $this->valF['evenement_retour_signature'] != "") {

            // Instanciation de la classe evenement
            $evenement_retour_signature = $this->f->get_inst__om_dbform(array(
                "obj" => "evenement",
                "idx" => $this->valF['evenement_retour_signature'],
            ));
            $evenement_retour_signature->setParameter("maj",1);

            // Valeurs de l'enregistrement
            $value_evenement_retour_signature = array();
            foreach($evenement_retour_signature->champs as $key => $champ) {
                //
                $value_evenement_retour_signature[$champ] = $evenement_retour_signature->val[$key];
            }

            // Valeurs à modifier
            $value_evenement_retour_signature['delai'] = $this->valF['delai'];
            $value_evenement_retour_signature['accord_tacite'] = $this->valF['accord_tacite'];
            $value_evenement_retour_signature['delai_notification'] = $this->valF['delai_notification'];
            $value_evenement_retour_signature['avis_decision'] = $this->valF['avis_decision'];
            $value_evenement_retour_signature['restriction'] = $this->valF['restriction'];

            // Récupère le libelle de l'événement
            $evenement_retour_signature_libelle = $this->getEvenementLibelle($value_evenement_retour_signature['evenement']);

            // Message de validation
            $valid_message = _("Mise a jour de l'evenement lie \"%s\" realisee avec succes.");

            // Modifie l'événement lié pour qu'il ait les mêmes paramètres
            // que l'événement principal
            if ($evenement_retour_signature->modifier($value_evenement_retour_signature)) {
                
                //
                $this->addToMessage(sprintf($valid_message, $evenement_retour_signature_libelle));
            }

        }

        // Si un évenement retour d'accusé de réception est renseigné
        if (isset($this->valF['evenement_retour_ar']) 
            && $this->valF['evenement_retour_ar'] != "") {

            // Instanciation de la classe evenement
            $evenement_retour_ar = $this->f->get_inst__om_dbform(array(
                "obj" => "evenement",
                "idx" => $this->valF['evenement_retour_ar'],
            ));
            $evenement_retour_ar->setParameter("maj",1);

            // Valeurs de l'enregistrment
            $value_evenement_retour_ar = array();
            foreach($evenement_retour_ar->champs as $key => $champ) {
                //
                $value_evenement_retour_ar[$champ] = $evenement_retour_ar->val[$key];
            }

            // Valeurs à modifier
            $value_evenement_retour_ar['delai'] = $this->valF['delai'];
            $value_evenement_retour_ar['accord_tacite'] = $this->valF['accord_tacite'];
            $value_evenement_retour_ar['delai_notification'] = $this->valF['delai_notification'];
            $value_evenement_retour_ar['avis_decision'] = $this->valF['avis_decision'];
            $value_evenement_retour_ar['restriction'] = $this->valF['restriction'];

            // Récupère le libelle de l'événement
            $evenement_retour_ar_libelle = $this->getEvenementLibelle($value_evenement_retour_ar['evenement']);

            // Message de validation
            $valid_message = _("Mise a jour de l'evenement lie \"%s\" realisee avec succes.");
            // Modifie l'événement lié pour qu'il ait les mêmes paramètres
            // que l'événement principal
            if ($evenement_retour_ar->modifier($value_evenement_retour_ar)) {

                //
                $this->addToMessage(sprintf($valid_message, $evenement_retour_ar_libelle));
            }

        }
    }

    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);

        //
        $form->setOnchange('retour','retourOnchangeEvenement(this)');

        // Alterne l'affichage du champs type_habilitation_tiers_consulte selon la valeur de la notification
        $form->setOnchange(
            'notification_tiers',
            'alternate_display(
                this.value === \'notification_automatique\',
                [\'type_habilitation_tiers_consulte\'],
                [\'\']
            )'
        );
    }

    /**
     * Fonction appelée lors de la copie d'un enregistrement
     * @param  array    $valCopy    Liste des valeurs de l'enregistrement
     * @param  string   $objsf      Liste des objets associés
     * @param  mixed    $DEBUG      Type du DEBUG
     * @return array                Liste des valeurs après traitement
     */
    function update_for_copy($valCopy, $objsf, $DEBUG) {

        // Libellé du duplicata
        $libelle = _("Copie de %s du %s");
        $valCopy['libelle'] = sprintf($libelle, $valCopy['libelle'], date('d/m/Y H:i:s'));
        // Tronque le libellé si celui est trop long
        $valCopy['libelle'] = mb_substr($valCopy['libelle'], 0, 70, "UTF8");

        // Message à retourner
        $valCopy['message'] = "";

        // S'il y a un événement retour_ar sur l'événement copié
        if ($valCopy['evenement_retour_ar'] != '') {
            // Copie l'événement retour_ar
            $copie = $this->f->copier($valCopy['evenement_retour_ar'], 'evenement', $objsf);
            $evenement_retour_ar = $copie['evenement_'.$valCopy['evenement_retour_ar']];
            $valCopy['message'] .= $copie['message'];
            $valCopy['message_type'] = $copie['message_type'];
            $valCopy['evenement_retour_ar'] = $evenement_retour_ar;
        }

        // S'il y a un événement evenement_retour_signature sur l'événement copié
        if ($valCopy['evenement_retour_signature'] != '') {
            // Copie l'événement retour_signature
            $copie = $this->f->copier($valCopy['evenement_retour_signature'], 'evenement', $objsf);
            $evenement_retour_signature = $copie['evenement_'.$valCopy['evenement_retour_signature']];
            $valCopy['message'] .= $copie['message'];
            $valCopy['message_type'] = $copie['message_type'];
            $valCopy['evenement_retour_signature'] = $evenement_retour_signature;
        }

        // Retourne les valeurs
        return $valCopy;
    }

    /**
     * Méthode permettant de savoir si un signataire est obligatoire
     * ou pas pour l'évenement.
     *
     * @return boolean 
     */
    public function is_signataire_obligatoire() {
        return $this->get_boolean_from_pgsql_value($this->getVal('signataire_obligatoire'));
    }


    /**
     * Récupère, à l'aide d'une requête, la liste des types d'habilitation notifiable
     * pour l'événement.
     *
     * @return array liste des types d'habilitation notifiable
     */
    public function get_types_habilitation_notifiable() {
        $rst = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    type_habilitation_tiers_consulte
                FROM
                    %1$sevenement_type_habilitation_tiers_consulte
                WHERE
                    evenement = %2$s',
                DB_PREFIXE,
                intval($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // renvoi les valeurs de la colonne des 'type_habilitation_tiers_consulte'
        return array_column($rst['result'], 'type_habilitation_tiers_consulte');
    }
}

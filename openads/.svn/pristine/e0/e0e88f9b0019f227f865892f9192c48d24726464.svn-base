<?php
/**
 * DBFORM - 'demande_nouveau_dossier' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'demande_nouveau_dossier'.
 *
 * @package openads
 * @version SVN : $Id: demande_nouveau_dossier.class.php 5984 2016-02-19 08:41:12Z fmichon $
 */

require_once "../obj/demande.class.php";

/**
 * Définition de la classe 'demande_nouveau_dossier'.
 *
 * Cette classe permet d'interfacer l'ajout de demande concernant un nouveau
 * dossier.
 */
class demande_nouveau_dossier extends demande {

    /**
     *
     */
    protected $_absolute_class_name = "demande_nouveau_dossier";

    /**
     * Surcharge du bouton retour afin de retourner sur le dashboard
     */
    function retour($premier = 0, $recherche = "", $tricol = "") {

        echo "\n<a class=\"retour\" ";
        echo "href=\"".OM_ROUTE_DASHBOARD;
        //
        echo "\"";
        echo ">";
        //
        echo _("Retour");
        //
        echo "</a>\n";

    }

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 140 - Récupération du code du type de DA
        $this->class_actions[140] = array(
            "identifier" => "get_code_type_da",
            "view" => "view_get_code_type_da",
            "permission_suffix" => "ajouter"
        );

        // ACTION - 141 - Récupération du code département et commune de la collectivité
        $this->class_actions[141] = array(
            "identifier" => "get_code_depcom",
            "view" => "view_get_code_depcom",
            "permission_suffix" => "ajouter"
        );

        // ACTION - 142 - Récupération de la prochaine séquence du numéro de dossier
        $this->class_actions[142] = array(
            "identifier" => "get_dossier_seq_currval",
            "view" => "view_get_dossier_seq_currval",
            "permission_suffix" => "ajouter"
        );

        // ACTION - 143 - Récupération de la division depuis l'instructeur
        // affecté automatiquement
        $this->class_actions[143] = array(
            "identifier" => "get_dossier_division",
            "view" => "view_get_dossier_division",
            "permission_suffix" => "ajouter"
        );

        // ACTION - 150 - Récupération de l'affectation automatique
        // affecté automatiquement
        $this->class_actions[150] = array(
            "identifier" => "get_affectation_auto",
            "view" => "view_get_affectation_auto",
            "permission_suffix" => "ajouter"
        );

        $this->class_actions[160] = array(
            "identifier" => "verifier_numerotation_urbanisme",
            "view" => "view_verifier_numerotation_urbanisme",
            "permission_suffix" => "ajouter"
        );

        // ACTION - 170 - Récupération d'un text traduisible
        $this->class_actions[170] = array(
            "identifier" => "get_translatable_text",
            "view" => "view_get_translatable_text",
            "permission_suffix" => "ajouter"
        );
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
        return false;
    }

    /**
     * Concatenation du code département et du code commune
     * obtenus à partir de la collectivité (collectivité par défaut si aucun id fourni).
     * Renvoie un tuple (code_depcom, error_msg).
     */
    function getCodeDepartementCommuneFromCollectivite($collectivite_id)
    {
        $code_depcom = null;
        $error_msg = null;
        if (!empty($collectivite_id)) {
            $collectivite_parameters = $this->f->getCollectivite($collectivite_id);
        }
        else {
            $collectivite_parameters = $this->f->getCollectivite();
        }
        if (!empty($collectivite_parameters)) {
            if (!isset($collectivite_parameters['departement'])) {
                $error_msg = sprintf(__("om_parametre '%s' inexistant"), 'departement');
            }
            else if (!isset($collectivite_parameters['commune'])) {
                $error_msg = sprintf(__("om_parametre '%s' inexistant"), 'commune');
            }
            else {
                $code_departement = strtoupper($collectivite_parameters['departement']);
                $code_commune = $collectivite_parameters['commune'];
                if(!is_numeric($code_departement) && ! in_array($code_departement, array('02A', '02B'))) {
                    $error_msg = sprintf(__("om_parametre '%s' invalide (%s). Doit être numérique ou 02A|02B."),
                                         'departement', $code_departement);
                }
                else if (!is_numeric($code_commune)) {
                    $error_msg = sprintf(__("om_parametre '%s' invalide (%s). Doit être numérique."),
                                         'commune', $code_commune);
                }
                else {
                    $code_depcom = $code_departement . $code_commune;
                }
            }
        }
        else {
            $error_msg = sprintf(__("Aucun om_parametre pour la collectivité '%s'."),
                                 $collectivite_id ? $collectivite_id : 'par défaut');
        }
        if (!empty($error_msg)) {
            $this->f->addToLog(__METHOD__."(): ERROR $error_msg", DEBUG_MODE);
        }
        return array($code_depcom, $error_msg);
    }

    /**
     * Code du Type de DA
     * obtenu à partir de l'id du DAdt.
     * Renvoie un tuple (code_type_da, error_msg).
     */
    function getCodeTypeDA($dadt_id)
    {
        $code_type_da = null;
        $error_msg = null;
        if (!empty($dadt_id)) {
            // instance du DAdt
            // TODO: replace with '$this->f->findObjectById' ?
            $inst_datd = $this->get_inst_common("dossier_autorisation_type_detaille", $dadt_id);
            if (!empty($inst_datd)) {
                // id du type DA
                $type_da = $inst_datd->getVal('dossier_autorisation_type');
                if (!empty($type_da)) {
                    // instance du DA
                    // TODO: replace with '$this->f->findObjectById' ?
                    $inst_da = $this->get_inst_common("dossier_autorisation_type", $type_da);
                    if (!empty($inst_da)) {
                        // code du DA
                        $code_type_da = $inst_da->getVal('code');
                        if (empty($code_type_da)) {
                            $error_msg = sprintf(__("Empty code for type DA '%s'"), $type_da);
                        }
                    }
                    else {
                        $error_msg = sprintf(__("Type DA '%s' not found"), $type_da);
                    }
                }
                else {
                    $error_msg = sprintf(__("Empty type DA for DAdt '%'"), $dadt_id);
                }
            }
            else {
                $error_msg = sprintf(__("Type DAdt '%s' not found"), $dadt_id);
            }
        }
        else {
            $error_msg = __("Empty type DAdt");
        }
        if (!empty($error_msg)) {
            $this->f->addToLog(__METHOD__."(): ERROR $error_msg", DEBUG_MODE);
        }
        return array($code_type_da, $error_msg);
    }

    /**
     * Récupère la valeur courante de la séquence.
     *
     * @return array
     */
    function getNumeroDossierSequenceCurrval($code_type_da, $annee, $departement, $commune) {
        $seq_currval = null;
        $error_msg = null;
        foreach(array('code_type_da', 'annee', 'departement', 'commune') as $varname) {
            if(empty($$varname)) {
                $error_msg = sprintf(__("Argument '%s' vide non permis"), $varname);
                $this->f->addToLog(__METHOD__."(): ERROR $error_msg", DEBUG_MODE);
                return array($seq_currval, $error_msg);
            }
        }
        // obliger d'instancier un DA pour accéder à la méthode 'getMaxDANumeroDossier()'
        $empty_da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => 0,
        ));
        $seq_currval = $empty_da->getMaxDANumeroDossier(
            $code_type_da,
            $annee,
            $departement,
            $commune
        );
        if ($seq_currval === null) {
            $error_msg = sprintf(__("Failed to get current value of sequence '%s'"),
                                    $seq_name);
        }
        if (!empty($error_msg)) {
            $this->f->addToLog(__METHOD__."(): ERROR $error_msg", DEBUG_MODE);
        }
        return array($seq_currval, $error_msg);
    }

    /**
     * VIEW - view_get_code_depcom
     *
     * Vue pour récupérer en json le code du département et le code commune de
     * la collectivité passée dans l'URL.
     *
     * @return void
     */
    function view_get_code_depcom() {
        $this->f->disableLog();
        $response = array();

        // si l'option dossier_commune est activée et qu'on a l'ID de la commune
        $commune_id = $this->f->get_submitted_get_value('commune_id');
        if ($this->f->is_option_dossier_commune_enabled() && !empty($commune_id)) {
            list($code_depcom, $err_msg) = $this->getCodeDepartementCommuneFromCommune(
                intval($commune_id));
        }
        // pas d'option dossier_commune : infos à partir des paramètres de la collectivité
        else {
            $collectivite_id = $this->f->get_submitted_get_value('collectivite_id');
            list($code_depcom, $err_msg) = $this->getCodeDepartementCommuneFromCollectivite(
                $collectivite_id);
        }
        if (!empty($code_depcom) && empty($err_msg)) {
            $response = array('code_depcom' => $code_depcom);
        }
        else if (!empty($err_msg)) {
            $response = array('error' => $err_msg);
        }
        printf(json_encode($response));
    }

    /**
     * VIEW - view_get_code_type_da
     *
     * Vue pour récupérer en json le code du type de dossier d'autorisation du
     * type de DAdt passé dans l'URL.
     *
     * @return void
     */
    function view_get_code_type_da() {
        $this->f->disableLog();
        $response = array();

        // id du type de DAdt
        $dadt = $this->f->get_submitted_get_value('type_dadt');
        list($code_type_da, $err_msg) = $this->getCodeTypeDA($dadt);
        if(!empty($err_msg)) {
            $response = array('error' => $err_msg);
        }
        else {
            $response = array('code_type_da' => $code_type_da,);
        }
        printf(json_encode($response));
    }

    /**
     * VIEW - view_get_dossier_seq_currval
     *
     * Vue pour récupérer la valeur courante de la séquence en json.
     * Le type du DA, l'année de la date de la demande, le code département et
     * le code commune composant la séquence sont passés dans l'URL.
     *
     * @return void
     */
    function view_get_dossier_seq_currval() {
        $this->f->disableLog();
        $response = array();

        // code du type de DA
        $code_type_da = $this->f->get_submitted_get_value('type_da');
        // annee date demande
        $annee = $this->f->get_submitted_get_value('date_demande_annee');
        // code département et commune (concaténés)
        $code_depcom = $this->f->get_submitted_get_value('code_depcom');

        $departement = $code_depcom ? substr($code_depcom, 0, 3) : null;
        $commune = $code_depcom ? substr($code_depcom, 3) : null;

        list($seq_currval, $err_msg) = $this->getNumeroDossierSequenceCurrval(
            $code_type_da, $annee, $departement, $commune);
        if (!empty($err_msg)) {
            $response = array('error' => $err_msg);
        }
        else {
            $response = array('seq_currval' => $seq_currval,);
        }

        printf(json_encode($response));
    }

    /**
     * VIEW - view_get_dossier_division
     *
     * Vue pour récupérer la valeur courante de la séquence en json.
     * Le type du DA, l'année de la date de la demande, le code département et
     * le code commune composant la séquence sont passés dans l'URL.
     *
     * @return void
     */
    function view_get_dossier_division() {
        $this->f->disableLog();
        $response = array();

        // Identifiant de la collectivité
        $om_collectivite = intval($this->f->get_submitted_get_value('om_collectivite'));

        // Identifiant de la commune
        $commune_id = 0;
        if ($this->f->is_option_dossier_commune_enabled()) {
            $commune_id = intval($this->f->get_submitted_get_value('commune'));
        }
        // Type détaillé du dossier d'autorisation
        $datd = intval($this->f->get_submitted_get_value('datd'));

        // Références cadastrales
        $ref_cadas = strval($this->f->get_submitted_get_value('ref_cadas'));

        // Type de demande
        $demande_type = intval($this->f->get_submitted_get_value('demande_type'));

        // Instanciation de la classe dossier_autorisation pour récupérer la
        // division de l'instructeur affecté autoamtiquement
        $empty_da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => 0,
        ));
        $response['code_division'] = $empty_da->get_instructeur_division_for_numero_dossier(
            $datd, $om_collectivite, $commune_id, $ref_cadas, $demande_type);

        printf(json_encode($response));
    }

    /**
     * VIEW - view_get_affectation_auto
     *
     * Vue pour récupérer la valeur courante des affectations automatiques possibles, en json.
     *
     * @return void
     */
    function view_get_affectation_auto() {
        $this->f->disableLog();
        $response = array('affectations_auto' => array());

        // Identifiant de la collectivité
        $om_collectivite = intval($this->f->get_submitted_get_value('om_collectivite'));
        // Identifiant de la commune
        $commune_id = 0;
        if ($this->f->is_option_dossier_commune_enabled()) {
            $commune_id = intval($this->f->get_submitted_get_value('commune'));
        }
        // Type détaillé du dossier d'autorisation
        $datd = intval($this->f->get_submitted_get_value('datd'));
        // Type de demande (ID)
        $demande_type = intval($this->f->get_submitted_get_value('demande_type'));

        // récupère la liste des affectations automatiques qui correspondent
        $aff_auto = $this->f->get_inst__om_dbform(array(
            "obj" => "affectation_automatique",
            "idx" => 0,
        ));
        $response['affectations_auto'] = $aff_auto->get_matching_affectations(
            $om_collectivite, $commune_id, $datd, $demande_type);

        // affiche le tableau en JSON
        printf(json_encode($response));
    }

    /**
     * VIEW - view_get_translatable_text
     *
     * Vue permettant au JavaScript de récupérer un texte traduisible.
     *
     * @return void
     */
    function view_get_translatable_text() {
        $this->f->disableLog();
        $texts = array(
            'commune_change_selection' => __("Les données saisies ne permettent pas de rattacher la demande à la commune sélectionnée."),
        );
        $text_choice = $this->f->get_submitted_get_value('text_choice');

        if ($text_choice !== null
            && array_key_exists($text_choice, $texts) === true) {
            //
            printf($texts[$this->f->get_submitted_get_value('text_choice')]);
        }
    }

    /**
     *
     */
    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);

        if ($maj == 0) {

            if ($this->f->is_option_dossier_saisie_numero_enabled() === true) {
                $form->addOnchange("date_demande", "update_num_dossier_annee($(this));");
                $form->addOnchange("dossier_autorisation_type_detaille",
                    "update_num_dossier_type_da(this); update_num_dossier_division();", 'prepend');
                $form->addOnchange("om_collectivite",
                    "update_num_dossier_code_depcom(this); update_num_dossier_division();");
                if ($this->f->is_option_dossier_commune_enabled()) {
                    $form->addOnchange("commune", "update_num_dossier_code_depcom(this);");
                }
                $form->addOnchange("num_doss_manuel", "toggle_num_dossier_manuel(this);");
                $form->addOnchange("num_doss_division",
                    "check_input_is_alpha_num(this.value.toUpperCase());");

                // mise à jour du numéro de séquence
                $form->setOnchange('num_doss_type_da', 'update_num_dossier_seq();');
                $form->setOnchange('num_doss_code_depcom', 'update_num_dossier_seq();');
                $form->setOnchange('num_doss_annee', 'update_num_dossier_seq();');
            }

            // mise à jour du champ 'affectation_automatique'
            $form->addOnchange("om_collectivite",
                "update_affectation_auto();",
                'prepend');
            $form->setOnchange("dossier_autorisation_type_detaille",
                $form->onchange["dossier_autorisation_type_detaille"]."; ".
                "update_affectation_auto(this, function(_this) { ".
                    "afficheFormDemandeDAtd(500); ".
                "}, 500);");
            $form->setOnchange("demande_type",
                "update_affectation_auto(this, function(_this) { ".
                    "manage_document_checklist(_this); ".
                    "afficheFormDemandeDT(500); ".
                "}, 500);");
            if ($this->f->is_option_dossier_commune_enabled()) {
                $form->addOnchange("commune", "update_affectation_auto();", 'prepend');
            }

            // mise à jour de l'autocomplete de la commune en fonction de la collectivité
            if ($this->f->is_option_dossier_commune_enabled()) {
                $form->addOnchange("om_collectivite", "update_commune_autocomplete();");
                $form->addOnchange("date_demande", "update_commune_autocomplete();");
            }
        }

        if ($maj == 0
            && $this->f->is_option_dossier_saisie_numero_complet_enabled() === true) {
            //
            $form->setOnchange("num_doss_manuel", "toggle_num_dossier_manuel_complet(this);");
            $form->setOnchange("num_doss_complet", "this.value=this.value.toUpperCase(); check_input_is_alpha_num(this); verifier_numerotation_urbanisme(this);");
        }
    }

    function view_verifier_numerotation_urbanisme() {
        $this->f->disableLog();
        $response = array();

        //
        $num_doss_comp = $this->f->get_submitted_get_value('num_doss_complet');
        $datd_id = $this->f->get_submitted_get_value('datd_id');
        $demande_type_id = $this->f->get_submitted_get_value('demande_type_id');

        // Contrôle numérotation respecte format urbanisme
        $num_urba = $this->f->numerotation_urbanisme($num_doss_comp);
        if (empty($num_urba['di']) === true
            || empty($num_urba['da']) === true) {
            //
            $response['info_msg'][] = __("Le numéro saisie ne respecte pas le format imposé par le code de l'urbanisme, les vérifications imposées ne seront donc pas réalisées.");
            printf(json_encode($response));
            return;
        }

        // Contrôle du code du type de DA
        list($code_type_da, $err_msg) = $this->getCodeTypeDA($datd_id);
        if(empty($err_msg) === true) {
            if (strtolower($code_type_da) !== strtolower($num_urba['di']['type'])) {
                $response['info_msg'][] = __("Le code du type de dossier d'autorisation saisie ne correspond pas au type de dossier d'autorisation détaillé sélectionné.");
            }
        }

        // Contrôle du suffixe
        $query = str_replace(
            '<idx>',
            $demande_type_id,
            $this->get_var_sql_forminc__sql("demande_type_details_by_id")
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        $empty_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => 0,
        ));
        foreach ($res['result'] as $value) {
            if ($empty_di->getSuffixe($value['dossier_instruction_type']) === 't'
                && (isset($num_urba['di']['suffixe']) === false
                    || isset($num_urba['di']['num_suffixe']) === false)) {
                //
                $response['info_msg'][] = __("Le numéro saisie doit comporter un suffixe.");
            }
            if ($empty_di->getSuffixe($value['dossier_instruction_type']) === 'f'
                && (isset($num_urba['di']['suffixe']) === true
                    || isset($num_urba['di']['num_suffixe']) === true)) {
                //
                $response['info_msg'][] = __("Le numéro saisie ne doit pas comporter de suffixe.");
            }
            if ($empty_di->getSuffixe($value['dossier_instruction_type']) === 't'
                && isset($num_urba['di']['suffixe']) === true) {
                //
                $code = $empty_di->getCode($value['dossier_instruction_type']);
                if (strtolower($code) !== strtolower($num_urba['di']['suffixe'])) {
                     $response['info_msg'][] = sprintf(
                        __("Le suffixe du numéro saisie doit être %s."),
                        sprintf("<b>%s</b>", strtoupper($code))
                    );
                }
            }
        }

        printf(json_encode($response));
    }

    /**
     *
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Par défaut les champs sont tous cachés
        $form->setType('num_doss_type_da', 'hidden');
        $form->setType('num_doss_code_depcom', 'hidden');
        $form->setType('num_doss_annee', 'hidden');
        $form->setType('num_doss_division', 'hidden');
        $form->setType('num_doss_sequence', 'hidden');
        $form->setType('num_doss_manuel', 'hidden');
        $form->setType('affectation_automatique', 'hidden');
        $form->setType('num_doss_complet', 'hidden');

        //
        if ($maj == 0
            && $this->f->is_option_dossier_saisie_numero_enabled() === true) {
            // Checkbox pour passer en numérotation forcée
            $form->setType('num_doss_manuel', 'checkboxlabelafter');
            // Champs non modifiables avec valeur informative
            $form->setType('num_doss_type_da', 'textreadonlynolabel');
            $form->setType('num_doss_code_depcom', 'textreadonlynolabel');
            $form->setType('num_doss_annee', 'textreadonlynolabel');
            // Champs modifiables pré-saisie
            $form->setType('num_doss_division', 'textnolabel');
            $form->setType('num_doss_sequence', 'textnolabel');
        }

        if ($maj == 0
            && $this->f->is_option_dossier_saisie_numero_complet_enabled() === true) {
            // Checkbox pour passer en numérotation forcée
            $form->setType('num_doss_manuel', 'checkboxlabelafter');
            // Champs modifiables
            $form->setType('num_doss_complet', 'textnolabel');
        }

        if ($this->f->is_option_dossier_commune_enabled() === true) {
            if (($maj == 0 || $maj == 1) &&
                    ! $this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "autocomplete");
            }
        }
        if ($maj == 0) {
            $form->setType('affectation_automatique', 'select');
        }
    }

    /**
     *
     */
    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        //libelle des champs
        
        $form->setLib('num_doss_manuel', __('Saisir le numéro de dossier'));
        $form->setLib('affectation_automatique', __("Affectation manuelle de l'instructeur"));
    }

    /**
     *
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form,$maj);

        $form->setTaille('num_doss_type_da', 3);
        $form->setTaille('num_doss_code_depcom', 6);
        $form->setTaille('num_doss_annee', 2);
        $form->setTaille('num_doss_division', 1);
        $form->setTaille('num_doss_sequence', 4);
        $form->setTaille('num_doss_complet', 15);
    }

    /**
     *
     */
    function setMax(&$form, $maj) {
        parent::setMax($form,$maj);

        $form->setMax('num_doss_type_da', 3);
        $form->setMax('num_doss_code_depcom', 6);
        $form->setMax('num_doss_annee', 2);
        $form->setMax('num_doss_division', 1);
        $form->setMax('num_doss_sequence', 4);
        $form->setMax('num_doss_complet', 255);
    }

    /**
     *
     */
    function verifierAjout($val = array(), &$dnu1 = NULL) {
        $num_doss_sequence = null;

        // Si l'option des communes est activée
        if ($this->f->is_option_dossier_commune_enabled()) {

            // La commune doit être définie
            if (! array_key_exists("commune", $val) || empty($val["commune"])) {
                $this->addToMessage(__("La <b>commune</b> doit être <b>définie</b>."));
                $this->correct = false;
            }
            else {
                // récupération de la date de demande
                $date_demande = 'NOW';
                $d_match = array();
                if (isset($this->valF["date_demande"])
                        && preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/',
                                      $this->valF["date_demande"], $d_match)) {
                    $date_demande = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
                }
                $date_demande = new DateTime($date_demande);

                // La commune doit exister
                $commune = $this->f->findObjectById("commune", $val["commune"]);
                if (empty($commune) === true) {
                    $this->addToMessage(sprintf(__("La <b>commune</b> '%s' <b>n'existe pas</b>."),
                                                $val["commune"]));
                    $this->correct = false;
                }
                // La commune doit être valide à la date de ma demande
                elseif (! $commune->valid($date_demande)) {
                    $this->addToMessage(sprintf(
                        __("La <b>commune</b> '%s' n'est <b>pas valide</b> à la date du '%s'."),
                        $commune->getVal('libelle'), $date_demande->format('d/m/Y')
                    ));
                    $this->correct = false;
                }
            }
        }

        // Si l'option de numérotation forcée est activée et que la saisie est
        // en numérotation forcée
        if ($this->f->is_option_dossier_saisie_numero_enabled() === true
            && isset($val['num_doss_manuel']) === true
            && $val['num_doss_manuel'] === 'Oui') {

            // Vérification de la séquence du numéro de dossier
            if (isset($val['num_doss_sequence']) === false || empty($val['num_doss_sequence']) === true) {
                $this->addToMessage(__("Numéro de dossier : le <b>numéro</b> est obligatoire."));
                $this->correct = false;
            }
            else if (preg_match('/^[0-9]{1,4}$/', $val['num_doss_sequence']) == false) {
                $this->addToMessage(sprintf(
                    __("Numéro de dossier : le <b>numéro</b> %s est invalide."),
                    sprintf("<b>%s</b>", $val['num_doss_sequence'])
                ));
                $this->correct = false;
            }
            else if (isset($this->valF["date_demande"]) === true
                && empty($this->valF["date_demande"]) === false) {
                // Vérifie si un DA avec cette séquence existe déjà
                if($this->f->is_option_om_collectivite_entity_enabled($this->valF['om_collectivite']) === false
                    && $this->existsDAWithNumeroDossierSeq(
                        $this->valF['dossier_autorisation_type_detaille'],
                        $this->valF["date_demande"],
                        $this->valF['om_collectivite'],
                        intval($val['num_doss_sequence']),
                        empty($val["commune"]) === false ? $val["commune"] : null) === true) {
                    //
                    $this->addToMessage(sprintf(
                        __("Numéro de dossier : le <b>numéro</b> %s est déjà atttribué à un autre dossier, veuillez en choisir un autre."),
                        sprintf("<b>%s</b>", $val['num_doss_sequence'])
                    ));
                    $this->correct = false;
                }
                // Cas particulier du dernier numéro de séquence possible (valide)
                else if (intval($val['num_doss_sequence']) == 9999) {
                    $this->addToMessage(sprintf(
                        "%s%s",
                        __("Attention vous avez atteint le dernier numéro de dossier possible pour ce type de dossier d'autorisation de cette collectivité pour l'année sélectionnée."),
                        $this->correct === false ? "" : "<br/>"
                    ));
                }
            }

            // Vérification de la division du numéro de dossier
            if (isset($val['num_doss_division']) === true) {

                // Correction car la division peut-être = 0
                if ($val['num_doss_division'] === null || $val['num_doss_division'] === '') {
                    $this->addToMessage(sprintf(__("Numéro de dossier : le caractère réservé au service instructeur (<b>division</b>) est obligatoire.")));
                    $this->correct = false;
                }
                if (strlen($val['num_doss_division']) > 2 && ctype_alnum($val['num_doss_division']) === false) {
                    $this->addToMessage(sprintf(
                        __("Numéro de dossier : le caractère réservé au service instructeur (<b>division</b>) %s est invalide."),
                        sprintf("<b>%s</b>", $val['num_doss_division'])
                    ));
                    $this->correct = false;
                }
            }
        }

        // Vérification de l'affectation automatique de l'instructeur
        if (isset($val['affectation_automatique']) === true
            && empty($val['affectation_automatique']) === false) {
            //
            if (ctype_digit($val['affectation_automatique']) === false) {
                $this->addToMessage(sprintf(__("Affectation automatique : l'identifiant est invalide (doit être un entier).")));
                $this->correct = false;
            }
            else {
                $aff = $this->f->get_inst__om_dbform(array(
                    "obj" => "affectation_automatique",
                    "idx" => intval($val['affectation_automatique'])
                ));
                if (empty($aff) === true) {
                    $this->addToMessage(sprintf(__("Affectation automatique : non-trouvée (identifiant incorrecte).")));
                    $this->correct = false;
                }
            }
        }
    }

    /**
    * Méthode permettant de définir des valeurs à envoyer en base après
    * validation du formulaire d'ajout.
    *
    * @param array $val tableau des valeurs retournées par le formulaire
    *
    * @return void
    */
    function setValFAjout($val = array()) {

        if ($this->f->is_option_dossier_saisie_numero_enabled() === true) {
            // ajoute les valeurs des champs fictifs à '$this->valF'
            // (la classe générée parente n'appelant pas la méthode parente qui fait ça pour tous les
            // champs, par défaut).
            foreach(array(
                    'num_doss_type_da',
                    'num_doss_code_depcom',
                    'num_doss_annee',
                    'num_doss_division',
                    'num_doss_sequence',
                    'num_doss_manuel'
                    ) as $key) {
                if (isset($val[$key])) {
                    $this->valF[$key] = $val[$key];
                }
            }
        }

        if ($this->f->is_option_dossier_saisie_numero_complet_enabled() === true) {
            // ajoute les valeurs des champs fictifs à '$this->valF'
            // (la classe générée parente n'appelant pas la méthode parente qui fait ça pour tous les
            // champs, par défaut).
            foreach(array(
                    'num_doss_complet',
                    'num_doss_manuel'
                    ) as $key) {
                if (isset($val[$key])) {
                    $this->valF[$key] = $val[$key];
                }
            }
        }

        if (isset($val['affectation_automatique']) === true) {
            $this->valF['affectation_automatique'] = $val['affectation_automatique'];
        }

        parent::setValFAjout($val);
    }

    /**
     * Surcharge pour retirer les champs fictifs
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        if ($this->f->is_option_dossier_saisie_numero_enabled() === true) {
            foreach(array(
                    'num_doss_type_da',
                    'num_doss_code_depcom',
                    'num_doss_annee',
                    'num_doss_division',
                    'num_doss_sequence',
                    'num_doss_manuel'
                    ) as $key) {
                //
                if (isset($this->valF[$key]) === true) {
                    unset($this->valF[$key]);
                }
            }
        }

        if ($this->f->is_option_dossier_saisie_numero_complet_enabled() === true) {
            foreach(array(
                    'num_doss_complet',
                    'num_doss_manuel'
                    ) as $key) {
                //
                if (isset($this->valF[$key]) === true) {
                    unset($this->valF[$key]);
                }
            }
        }

        $ret = parent::triggerajouter($id, $dnu1, $val, $dnu2);

        if (isset($val['affectation_automatique']) === true) {
            unset($val['affectation_automatique']);
        }
        if (isset($this->valF['affectation_automatique']) === true) {
            unset($this->valF['affectation_automatique']);
        }

        return $ret;
    }

    /**
     * Surcharge pour passer le champ commune en autocomplete
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj, $dnu1, $dnu2);

        // commune
        $form->setSelect(
            'commune', $this->get_widget_config__commune__autocomplete()
        );

        // affectation_automatique
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "affectation_automatique",
            $this->get_var_sql_forminc__sql("affectation_automatique"),
            $this->get_var_sql_forminc__sql("affectation_automatique_by_id"),
            false
        );
    }

    /**
     * Renvoie les communes valides pour une collectivité donnée et une date de demande donnée
     *
     */
    function get_widget_config__commune__autocomplete() {

        // récupère l'identifiant de la collectivité sélectionnée
        $collectivite_id = $this->f->get_submitted_get_value('om_collectivite');

        // si identifiant de la collectivite valide
        if (empty($collectivite_id) || ! is_numeric($collectivite_id)) {
            $collectivite_id = null;
        }

        // récupère les paramètres de la collectivité
        $params = $this->f->getCollectivite($collectivite_id);

        // récupère la date de la demande
        $date_demande = $this->f->get_submitted_get_value('date_demande');
        $d_match = array();
        // si elle est valide on la transforme en date anglaise (pour Postgres)
        if (empty($date_demande)
                || ! preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $date_demande, $d_match)) {
            $date_demande = date('Y-m-d');
        }
        // sinon on prend la date du jour (courant)
        else {
            $date_demande = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
        }

        // filtre sur les communes en fonction de la date courante
        $communes_filter = sprintf("
            (
                commune.om_validite_debut IS NULL
                OR commune.om_validite_debut <= TO_DATE('%s', 'YYYY-MM-DD')
            )
            AND (
                commune.om_validite_fin IS NULL
                OR commune.om_validite_fin > TO_DATE('%s', 'YYYY-MM-DD')
            )",
            $this->f->db->escapeSimple($date_demande),
            $this->f->db->escapeSimple($date_demande)
        );

        // si le paramètre 'param_communes' est défini et valide
        if(!empty($params) && isset($params['param_communes']) && preg_match(
                '/^([0-9]{2,3}|[0-9]{5})(,([0-9]{2,3}|[0-9]{5}))*$/',
                $params['param_communes'])) {

            // on ajoute autant de conditions à la clause WHERE de la requête SQL
            // qu'il y a d'élément dans la liste du paramètre
            $communes_filter .= ' AND ( ';
            $communes_filter_tokens = explode(',', $params['param_communes']);
            foreach ($communes_filter_tokens as $communes_filter_token) {

                // champ de la commune à comparer (par défaut: code INSEE commune)
                $commune_filter_field = 'com';

                // département
                if (strlen($communes_filter_token) <= 3) {
                    $commune_filter_field = 'dep';
                }

                // ajoute le filtre à la requête SQL
                $communes_filter .= sprintf(
                    "commune.%s = '%s' OR ", $commune_filter_field, $communes_filter_token);
            }
            $communes_filter = preg_replace('/ OR $/', ')', $communes_filter);
        }

        return array(
            // Surcharge visée pour l'ajout
            "obj" => "commune",
            // Table de l'objet
            "table" => "commune",
            // Critères de recherche
            "criteres" => array(
                "commune.libelle" => __("Libelle"),
                "commune.com" => __("Code commune"),
                "commune.dep" => __("Code département"),
                "commune.reg" => __("Code région")
            ),
            // Filtrage des résultats
            'where' => "($communes_filter)",
            // Colonnes ID et libellé du champ
            // (si plusieurs pour le libellé alors une concaténation est faite)
            "identifiant" => "commune.commune",
            "libelle" => array (
                "commune.com",
                "commune.libelle"
            ),
            "link_selection" => true
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_affectation_automatique() {
        return "
            SELECT
                affectation_automatique.affectation_automatique,
                affectation_automatique.affectation_manuelle
            FROM
                ".DB_PREFIXE."affectation_automatique
            WHERE
                affectation_automatique.affectation_manuelle IS NOT NULL
                AND affectation_automatique.affectation_manuelle != ''
                AND affectation_automatique.instructeur IS NOT NULL
            ORDER BY
                affectation_automatique.affectation_automatique ASC NULLS LAST";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_affectation_automatique_by_id() {
        return "
            SELECT
                affectation_automatique.affectation_automatique,
                affectation_automatique.affectation_manuelle
            FROM
                ".DB_PREFIXE."affectation_automatique
            WHERE
                affectation_automatique.affectation_automatique = <idx>";
    }
}

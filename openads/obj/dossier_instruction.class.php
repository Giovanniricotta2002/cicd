<?php
/**
 * DBFORM - 'dossier_instruction' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'dossier_instruction'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/dossier.class.php";

class dossier_instruction extends dossier {

    /**
     *
     */
    protected $_absolute_class_name = "dossier_instruction";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        //
        parent::init_class_actions();

        // ACTION - 001 - modifier
        //
        $this->class_actions[1]["portlet"]["libelle"] = _("Modifier");
        $this->class_actions[1]["condition"] = array(
            "is_user_from_allowed_collectivite",
            "check_context",
            "is_editable",
        );

        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["portlet"]["libelle"] = _("Supprimer");
        $this->class_actions[2]["condition"] = array(
            "is_option_suppression_dossier_instruction_enabled",
            "is_user_from_allowed_collectivite",
            "check_context",
            "is_deletable",
        );

        // ACTION - 100 - donnees_techniques
        // Affiche dans un overlay les données techniques
        $this->class_actions[100] = array(
            "identifier" => "donnees_techniques",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => __("Données techniques / CERFA"),
                "order" => 100,
                "class" => "rediger-16",
            ),
            "view" => "view_donnees_techniques",
            "permission_suffix" => "donnees_techniques_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );

        // ACTION - 110 - rapport_instruction
        // Affiche dans un overlay le rapport d'instruction
        $this->class_actions[110] = array(
            "identifier" => "rapport_instruction",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Rapport d'instruction"),
                "order" => 110,
                "class" => "rediger-16",
            ),
            "view" => "view_rapport_instruction",
            "permission_suffix" => "rapport_instruction_rediger",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_rapport_instruction",
            ),
        );

        // ACTION - 111 - date_affichage
        // Affiche l'édition contenant la date d'affichage obligatoire
        $this->class_actions[111] = array(
            "identifier" => "date_affichage",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Attestation d'affichage"),
                "order" => 111,
                "class" => "pdf-16",
            ),
            "view" => "view_attestation_date_affichage",
            "permission_suffix" => "acceder_attest_date_affi",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_access_attestation_date_affichage",
            ),
        );

        // ACTION - 112 - recepisse
        // Affiche l'édition
        $this->class_actions[112] = array(
            "identifier" => "recepisse",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Regenerer le recepisse"),
                "order" => 112,
                "class" => "pdf-16",
            ),
            "view" => "formulaire",
            "method" => "regenerate_recepisse",
            "permission_suffix" => "regenerate_recepisse",
            "button" => "valider",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_regenerate_recepisse",
            ),
        );

        // ACTION - 120 - geolocalisation
        // Affiche dans un overlay la géolocalisation
        $this->class_actions[120] = array(
            "identifier" => "geolocalisation",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Geolocalisation"),
                "order" => 120,
                "class" => "rediger-16",
            ),
            "view" => "view_geolocalisation",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 121 - geolocalisation verif parcelles
        // action de l'overlay de géolocalisation verif_parcelle
        $this->class_actions[121] = array(
            "identifier" => "geolocalisation_verif_parcelle",
            "view" => "view_geolocalisation_verif_parcelle",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 122 - geolocalisation calcul_emprise
        // action de l'overlay de géolocalisation calcul_emprise
        $this->class_actions[122] = array(
            "identifier" => "geolocalisation_calcul_emprise",
            "view" => "view_geolocalisation_calcul_emprise",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 123 - geolocalisation dessin_emprise
        // action de l'overlay de géolocalisation dessin_emprise
        $this->class_actions[123] = array(
            "identifier" => "geolocalisation_dessin_emprise",
            "view" => "view_geolocalisation_dessin_emprise",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 124 - geolocalisation calcul_centroide
        // action de l'overlay de géolocalisation calcul_centroide
        $this->class_actions[124] = array(
            "identifier" => "geolocalisation_calcul_centroide",
            "view" => "view_geolocalisation_calcul_centroide",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 125 - geolocalisation recup_contrainte
        // action de l'overlay de géolocalisation recup_contrainte
        $this->class_actions[125] = array(
            "identifier" => "geolocalisation_recup_contrainte",
            "view" => "view_geolocalisation_recup_contrainte",
            "permission_suffix" => "geolocalisation_consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "can_open_geolocalisation",
            ),
        );

        // ACTION - 126 - geocoder
        // Formulaire de géocodage par lot
        $this->class_actions[126] = array(
            "identifier" => "geocoder",
            "view" => "view_geocoder",
            "permission_suffix" => "geocoder",
        );

        // ACTION - 127 - Désignation operateur
        // Affiche dans un overlay le formulaire de désignation d'un opérateur
        $this->class_actions[127] = array(
            "identifier" => "designation_operateur",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => __("Désignation operateur"),
                "order" => 121,
                "class" => "rediger-16",
            ),
            "view" => "view_designation_operateur",
            "permission_suffix" => "dossier_operateur",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
                "is_option_mode_service_consulte_enabled",
                "is_param_operateur_etat_setted",
            ),
        );


        // ACTION - 130 - edition
        // Affiche l'édition
        $this->class_actions[130] = array(
            "identifier" => "edition",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Recapitulatif"),
                "order" => 130,
                "class" => "pdf-16",
            ),
            "view" => "view_edition",
            "permission_suffix" => "consulter",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );
    
        // ACTION - 140 - Redirection vers le SIG
        $this->class_actions[140] = array(
            "identifier" => "localiser",
            "view" => "view_localiser",
            "permission_suffix" => "localiser-sig-externe",
        );

        // ACTION - 150 - Générer la clé accès citoyen
        // Ce bouton est affiché seulement si le DA lié n'a pas de clé associée
        $this->class_actions[150] = array(
            "identifier" => "generate_citizen_access_key",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Generer la cle d'acces au portail citoyen"),
                "class" => "citizen_access_key-16"
            ),
            "method" => "generate_citizen_access_key",
            "permission_suffix" => "generer_cle_acces_citoyen",
            "view" => "formulaire",
            "condition" => array(
                "is_option_citizen_access_portal_enabled",
                "can_generate_citizen_access_key",
                "is_dossier_autorisation_visible",
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );

        // ACTION - 151 - Regénérer la clé accès citoyen
        // Ce bouton est affiché seulement si le DA lié a déjà une clé d'accès
        $this->class_actions[151] = array(
            "identifier" => "regenerate_citizen_access_key",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => _("Regenerer la cle d'acces au portail citoyen"),
                "class" => "citizen_access_key-16"
            ),
            "method" => "regenerate_citizen_access_key",
            "permission_suffix" => "regenerer_cle_acces_citoyen",
            "view" => "formulaire",
            "condition" => array(
                "is_option_citizen_access_portal_enabled",
                "can_regenerate_citizen_access_key",
                "is_dossier_autorisation_visible",
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );

        // ACTION - 160 - normalize_address
        // Ouvre le formulaire de normalisation de l'adresse dans un overlay
        $this->class_actions[160] = array(
            "identifier" => "normalize_address",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => __("Normaliser l'adresse"),
                "order" => 160,
                "class" => "rediger-16",
            ),
            "view" => "view_normalize_address",
            "permission_suffix" => "normalize_address",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );

        // ACTION - 200 - Afficher les logs des événements d'instruction
        // 
        $this->class_actions[200] = array(
            "identifier" => "get_log_di",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => __("journal d'instruction"),
                "order" => 200,
                "class" => "journal-instruction-16",
            ),
            "view" => "formulaire",
            "permission_suffix" => "log_instructions",
            "condition" => array(
                "is_user_from_allowed_collectivite",
                "check_context",
            ),
        );
        
        // ACTION - 210 - Supprimer liaison dossier
        // 
        $this->class_actions[210] = array(
            "identifier" => "supprimer_liaison",
            "permission_suffix" => "supprimer_liaison",
            "method" => "supprimer_liaison",
            "condition" => array(
                "can_user_access_dossier",
                "check_context",
            ),
        );

        // ACTION - 220 - Afficher les informations du di
        // 
        $this->class_actions[220] = array(
            "identifier" => "get_autorisation_contestee",
            "view" => "get_autorisation_contestee",
            "permission_suffix" => "consulter",
        );

        // ACTION - 230 - Récupération de traduction dans un format json
        // 
        $this->class_actions[230] = array(
            "identifier" => "dossier_instruction_trad",
            "view" => "get_dossier_instruction_trad",
            "permission_suffix" => "consulter",
        );

        // ACTION - 599 - Afficher les informations du di
        // 
        $this->class_actions[599] = array(
            "identifier" => "get_division_instructeur",
            "view" => "get_division_instructeur",
            "permission_suffix" => "consulter",
        );
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        // On définit le type des champs pour les actions direct
        // utilisant la vue formulaire
                // Override entete formulaire 
         $form->entete("dossier-instruction");
        if ($maj == 112 || $maj == 150 || $maj == 151 || $maj == 200 || $maj == 210 || $maj == 220) {
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
        }
        if ($maj == 200) {
            // si en sous-formulaire instructeur alors on cache le bouton ajouter
            if (isset($retourformulaire) && $retourformulaire === 'instructeur') {
                // Actions en coin : ajouter
            $tab_actions['corner']['ajouter'] = NULL;
            }
            $form->setVal('log_instructions', $this->view_get_log_di());
            $form->setType('log_instructions', "jsontotab");
        }
    }



    /**
     * Vérifie la division de l'instructeur et l'état du dossier.
     *
     * @return boolean
     */
    function check_instructeur_division() {

        // Si l'utilisateur est un intructeur qui correspond à la
        // division du dossier
        if ($this->is_instructeur_from_division_dossier() === true) {

            //
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_editable.
     *
     * Condition pour la modification.
     *
     * @return boolean
     */
    function is_editable() {

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_modifier_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }

        //
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        // Si l'utilisateur n'est pas un instructeur, qu'il possède une permission
        // spécifique et que le dossier d'instruction n'est pas encore instruit
        if ($this->is_instructeur_from_division_dossier() === false
            && $this->has_only_recepisse() === true
            && $this->f->isAccredited($this->get_absolute_class_name()."_corriger") === true) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_deletable.
     *
     * Condition pour la supression d'un dossier d'instruction non instruit.
     *
     * @return boolean
     */
    function is_deletable() {

        // Si le dossier d'instruction est déjà instruit
        if ($this->has_only_recepisse() === false) {
            return false;
        }

        // Si ce n'est pas le dernier dossier d'instruction de l'autorisation
        if ($this->is_last_di_of_da() === false) {
            return false;
        }

        // Lorsque l'option de saisie des numéros de dossier est désactivée, si
        // le dossier est un initial et le numero de séquence n'est pas égal au
        // numéro du dossier d'instruction
        if ($this->has_only_initial_di() === true
            && $this->f->is_option_dossier_saisie_numero_enabled($this->getVal('om_collectivite')) === false
            && $this->f->is_option_dossier_saisie_numero_complet_enabled($this->getVal('om_collectivite')) === false
            && $this->check_di_id_and_seq() === false) {
                //
                return false;
            }
            
        $demande = $this->get_inst_demande();
            
        if ($demande->getVal('source_depot') !== 'app') {
            return false;
        }
            
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_suppression_division_bypass");
        if ($bypass == true) {
            //
            return true;
        }

        // Vérifie la division de l'utilisateur connecté, s'il n'en possède pas
        // alors la valeur '0' est stockée en session
        $d_division = $this->getDivisionFromDossier($this->getVal($this->clePrimaire));
        if ($_SESSION['division'] !== '0'
            && $_SESSION['division'] !== $d_division) {
            //
            return false;
        }

        if (empty($this->getVal('geom')) === false) {
            if ($this->is_option_external_sig_enabled() === false) {
                return false;
            }
            $collectiviteParams = $this->f->getCollectivite($this->getVal('om_collectivite'));
            try {
                $geoads = $this->get_geoads_instance($collectiviteParams, '');
            } catch(Exception $e) {
                $this->addToLog(
                    __METHOD__."() échec de l'instanciation du connecteur SIG. ".
                    gettype($e).": ".$e->getMessage(), DEBUG_MODE);
                return false;
            }
            if (! method_exists($geoads, 'methodIsImplemented')
                || ! $geoads->methodIsImplemented('supprime_emprise')) {
                return false;
            }
        }

        // notification envoyé
        $sql_notif_envoye = sprintf(
            'SELECT 
                instruction_notification
            FROM
                %1$sinstruction_notification
                LEFT JOIN %1$sinstruction
                    ON instruction.instruction = instruction_notification.instruction
                LEFT JOIN %1$sdossier
                    ON dossier.dossier = instruction.dossier
            WHERE
                dossier.dossier = \'%2$s\' 
                AND instruction_notification.statut = \'envoyé\'',
            DB_PREFIXE,
            $this->f->db->escapeSimple($this->getVal('dossier'))
        );
        $res_notif_envoye = $this->f->get_all_results_from_db_query(
            $sql_notif_envoye,
            array(
                "origin" => __METHOD__
            )
        );

        // Si il y a une erreur
        if ($res_notif_envoye['code'] !== 'OK') {
            $this->addToLog(__METHOD__."() query : ".var_export($sql_notif_envoye, true)." error: ".var_export($res_notif_envoye['message'], true), DEBUG_MODE);
            return false;
        }

        if (empty($res_notif_envoye['result']) === false) {
            return false;
        }
        //
        return true;
    }

    /**
     * Fait appelle à la méthode utils->is_option_mode_service_consulte_enabled()
     * et renvoie le résultat.
     * Permet de savoir si on est en mode service consulté ou pas.
     *
     * @return boolean
     */
    function is_option_mode_service_consulte_enabled() {
        return $this->f->is_option_mode_service_consulte_enabled();
    }

    /**
     * Récupère le paramétrage des opérateurs et vérifie que le dossier
     * se trouve dans un des états paramétrés. Si c'est le cas renvoie
     * true sinon renvoie false.
     *
     * @return boolean
     */
    function is_param_operateur_etat_setted() {
        // Récupère le paramétrage de l'opérateur et vérifie si un ou plusieurs états
        // ont été paramétré. Si c'est le cas vérifie que l'état actuel du dossier
        // correspond a un des états paramétrés.
        $param_operateur = $this->f->get_option_param_operateur();
        $id_dossier_operateur_linked = $this->get_dossier_operateur_id();

        $inst_dossier_operateur = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_operateur",
            "idx" => $id_dossier_operateur_linked,
        ));

        if (is_object($param_operateur) === true && property_exists($param_operateur, 'etat') === true) {
            if (in_array($this->getVal('etat'), $param_operateur->etat) === true
                || ($inst_dossier_operateur->getVal('operateur_valide') == 't')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Récupère avec une requête sql l'id du dossier opérateur associé
     * au dossier d'instruction et renvoie son id.
     * Si aucun dossier opérateur n'est récupéré ou en cas d'erreur de
     * base de données renvoie false.
     *
     * @return integer|boolean
     */
    protected function get_dossier_operateur_id() {
        // Récupère le dossier_opérateur à l'aide du numéro de dossier
        // d'instruction
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_operateur
                FROM
                    %1$sdossier_operateur
                WHERE
                    dossier_instruction=\'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier'))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Vérifie si la requête à réussie
        if ($qres["code"] !== "OK") {
            return false;
        }
        // Vérifie si un résultat a été récupéré
        if (empty($qres["result"])) {
            return false;
        }
        // Renvoie l'id du dossier operateur du dossier
        return $qres["result"];
    }

    /** 
     * CONDITION - check_di_id_and_seq.
     *
     * Vérifie si le numéro de séquence est égal au numéro du dossier
     * d'instruction.
     *
     * @return boolean
     */
    function check_di_id_and_seq() {

        if(empty($this->getVal('numerotation_num'))) {
            throw new InvalidArgumentException("Empty var 'numerotation_num' for ".$this->getVal($this->clePrimaire));
        }

        // Compose le nom de la séquence
        $datc = $this->getVal('numerotation_type');
        $annee = $this->getVal('annee');
        $dep = $this->getVal('numerotation_dep');
        $com = $this->getVal('numerotation_com');
        // TODO si les tests se déroulent bien;
        //        - supprimer la création manuelle de la séquence avec 'sprintf(...)'
        //        - conserver uniquement l'usage de 'compose_sequence_name(...)'
        if (! empty($datc) && ! empty($annee) && ! empty($dep) && ! empty($com)) {
            $seq_name = strtolower(sprintf(
                '%sdossier_%s_%s_%s_%s_seq',
                DB_PREFIXE,
                $datc,
                $annee,
                $dep,
                $com
            ));
            $alt_seq_name = $this->compose_sequence_name($datc, $annee, $dep, $com);
            if ($seq_name != $alt_seq_name) {
                throw new RuntimeException("Sequence names differs ($seq_name != $alt_seq_name) for ".$this->getVal($this->clePrimaire));
            }
        }
        else {
            foreach(array('numerotation_type', 'annee', 'numerotation_dep', 'numerotation_com') as $key) {
                if (empty($this->getVal($key))) {
                    throw new InvalidArgumentException("Empty var '$key' for ".$this->getVal($this->clePrimaire));
                }
            }
        }

        // Instancie le dossier d'autorisation sans identifiant
        $da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => 0,
        ));

        // Si la séquence a pu être composée et que celle-ci existe
        if (! empty($seq_name ) && $da->doesNumeroDossierSequenceExists($seq_name) === true) {

            // Récupère la dernière valeur de la séquence du dossier d'instruction
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        last_value
                    FROM
                        %s',
                    $seq_name
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                throw new InvalidArgumentException("Database error when getting sequence '$seq_name' value for ".$this->getVal($this->clePrimaire));
            }
            $res_sequence_last_value = $qres["result"];

            // et la compare au numéro du dossier d'instruction courant
            return intval($res_sequence_last_value) === intval($this->getVal('numerotation_num'));
        }

        // si la séquence n'a pas pu être composée ou n'existe pas (ex: option saisie numéro complet)
        return false;
    }

    /**
     * CONDITION - is_last_di_of_da.
     *
     * Vérifie que le dossier d'instruction courant est le plus récent de son
     * autorisation.
     *
     * @return boolean
     */
    function is_last_di_of_da() {
        // Récupère la plus haute version des DI du DA
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(version)
                FROM
                    %1$sdossier
                WHERE
                    dossier_autorisation = \'%2$s\'
                    -- Permet de ne pas prendre en compte les numéros de version des
                    -- sous_dossier
                    AND dossier_parent IS NULL',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal("dossier_autorisation"))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Si la version du dossier d'instruction courant est la dernière
        // version
        if ($qres["result"] === $this->getVal("version")) {
            return true;
        }
        return false;
    }

    /**
     * CONDITION - is_option_suppression_dossier_instruction_enabled.
     *
     * Condition pour verifier que l'option suppression d'un dossier
     * d'instruction est activé.
     *
     * @return boolean
     */
    function is_option_suppression_dossier_instruction_enabled() {
        return $this->f->is_option_suppression_dossier_instruction_enabled($this->getVal('om_collectivite'));
    }

    /**
     * CONDITION - can_open_rapport_instruction.
     *
     * Condition pour afficher le rapport d'instruction en overlay.
     *
     * @return boolean
     */
    function can_open_rapport_instruction() {

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_rapport_instruction_rediger_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }

        // S'il y a un rapport d'instruction lié
        if ($this->getRapportInstruction() !== null
            && $this->getRapportInstruction() !== '') {
            return true;
        }

        // S'il n'y a pas de rapport d'instruction lié
        if ($this->getRapportInstruction() === null
            || $this->getRapportInstruction() === '') {
            //
            if ($this->check_instructeur_division() === true
                && $this->f->isAccredited(array(
                    "rapport_instruction",
                    "rapport_instruction_ajouter"), "OR") === true) {
                //
                return true;
            }
        }

        //
        return false;
    }

    /**
     * CONDITION - can_open_geolocalisation.
     *
     * Condition pour afficher la géolocalisation en overlay.
     *
     * @return boolean
     */
    function can_open_geolocalisation() {

        // Vérifie que l'option SIG est activé
        if ($this->is_option_external_sig_enabled() === false) {
            //
            return false;
        }

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_geolocalisation_consulter_bypass");
        //
        if ($bypass == true) {

            //
            return true;
        }

        // Contrôle le droit de l'instruction
        if ($this->check_instructeur_division() === true) {

            //
            return true;
        }

        //
        return false;
    }


    /**
     * Vérifie que l'option SIG est activée.
     *
     * @return boolean
     */
    public function is_option_external_sig_enabled() {

        // On récupère les informations de la collectivité du dossier
        $collectivite_param = $this->f->getCollectivite($this->getVal('om_collectivite'));

        // Si l'om_parametre *option_sig* existe et qu'il vaut sig_externe
        if (isset($collectivite_param['option_sig']) === true
            && $collectivite_param['option_sig'] === 'sig_externe') {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * CONDITION - can_access_attestation_date_affichage.
     *
     * Condition pour afficher l'attestion date d'affichage
     *
     * @return boolean
     */
    function can_access_attestation_date_affichage() {

        // il doit exister une instruction ayant un évènement
        // de type 'Affichage obligatoire' finalisée
        return !empty($this->get_last_instuction_affichage_obligatoire());
    }

    /**
     * CONDITION - can_regenerate_recepisse.
     *
     * Condition pour regénérer le récépissé.
     *
     * @return boolean
     */
    function can_regenerate_recepisse() {

        // Instanciation de l'instruction initiale
        $inst_instruction = $this->get_inst_instruction($this->get_demande_instruction_recepisse());
        // On récupère la lettre type de l'instruction initiale
        $lettretype = $inst_instruction->getVal('lettretype');

        // Vérifie que l'instruction initiale possède une lettre type
        if ($lettretype === null || $lettretype === '') {
            //
            return false;
        }

        //
        if ($this->has_only_recepisse() === true) {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * CONDITION - can_generate_citizen_access_key
     *
     * Vérifie que le DA lié au DI courant n'a pas de clé déjà générée.
     *
     * @return boolean true si on peut générer la clé, false sinon
     */
    protected function can_generate_citizen_access_key() {

        // Si la clé existe, on ne peut pas générer la clé
        if ($this->get_citizen_access_key() !== false) {
            return false;
        }

        // Si le dossier est cloturé
        if ($this->getStatut() == "cloture") {
            //
            return false;
        }

        //
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * CONDITION - can_regenerate_citizen_access_key
     *
     * Vérifie que le DA lié au DI courant possède déjà une clé d'accès.
     *
     * @return boolean true si on peut regénérer la clé, false sinon
     */
    protected function can_regenerate_citizen_access_key() {

        // Si la clé existe, on retourne true car on peut la regénérer
        if ($this->get_citizen_access_key() !== false) {
            return true;
        }
        //
        return false;
    }


    /**
     * CONDITION - is_option_citizen_access_portal_enabled
     *
     * Permet de savoir si le om_parametre acces_portail_citoyen est activé.
     *
     * @return boolean true si l'option acces_portail_citoyen vaut 'true', false sinon
     */
    protected function is_option_citizen_access_portal_enabled() {

        return $this->f->is_option_citizen_access_portal_enabled();
    }

    /**
     * CONDITION - is_dossier_autorisation_visible
     *
     * Permet de savoir si le type de DA lié au dossier d'instruction courant est visible.
     *
     * @return boolean true si le DA est visible, sinon false
     */
    public function is_dossier_autorisation_visible() {

        $inst_da = $this->get_inst_dossier_autorisation();
        //
        return $inst_da->is_dossier_autorisation_visible();
    }

    /**
     * VIEW - view_edition.
     *
     * Affiche le récapitulatif du dossier d'instruction.
     *
     * @return void
     */
    function view_edition() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Identifiant du dossier
        $idx = $this->getVal($this->clePrimaire);

        //
        $collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));

        // Génération du PDF
        $result = $this->compute_pdf_output('etat', $this->table, $collectivite, $idx);
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'], 
            $result['filename']
        );
    }

    /**
     * VIEW - view_donnees_techniques.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_donnees_techniques() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->display_overlay(
            $this->getVal($this->clePrimaire),
            "donnees_techniques"
        );
    }

    /**
     * VIEW - view_rapport_instruction.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_rapport_instruction() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->display_overlay(
            $this->getVal($this->clePrimaire),
            "rapport_instruction"
        );
    }

    /**
     * VIEW - view_designation_operateur.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_designation_operateur() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Vérifie si un dossier opérateur existe et si ce n'est pas le cas
        // ajoute ce dossier avant d'afficher le formulaire.
        $id_dossier_operateur = $this->get_dossier_operateur_id();
        if (empty($id_dossier_operateur)) {
            $inst_dossier_operateur = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_operateur",
                "idx" => "]",
            ));
            // Pour appeler la fonction modifier il faut traiter tous les champs de l'objet
            foreach($inst_dossier_operateur->champs as $identifiant => $champ) {
                $valF[$champ] = NULL;
            }
            // On fait ensuite nos modifications spécifiques
            $valF['dossier_instruction'] = $this->getVal('dossier');
            if ($inst_dossier_operateur->ajouter($valF) == false) {
                return false;
            };
        }
        //
        $this->display_overlay(
            $this->getVal($this->clePrimaire),
            "dossier_operateur"
        );
    }

    /**
     * Ouvre le sous-formulaire passé en paramètre en overlay
     * en mode ajout si aucun n'existe sinon en mode modifier.
     *
     * @return void
     */
    function display_overlay($idx = "", $obj = "", $table = "") {

        // Seulement si le numéro de dossier est fourni
        if (isset($idx) && !empty($idx) 
            && isset($obj) && !empty($obj)){

            if ($table === "") {
                $table = $obj;
            }
            // Vérifie que l'objet n'existe pas
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT 
                        %2$s
                    FROM 
                        %1$s%2$s
                    WHERE 
                        dossier_instruction = \'%3$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($table),
                    $this->f->db->escapeSimple($idx)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            // S'il n'y en a pas, afficher le formulaire d'ajout
            if ($qres['row_count'] == 0) {
                //
                echo '
                    <script type="text/javascript" >
                        overlayIt(\''.$obj.'\',\''.OM_ROUTE_SOUSFORM.'&objsf='.$obj.'&obj='.$obj.'&action=0&retourformulaire=dossier_instruction&idxformulaire='.$idx.'\', 1);
                    </script>
                ';
            }
            // Sinon afficher l'objet en consultation
            else {
                //
                $row = array_shift($qres['result']);
                //
                echo '
                    <script type="text/javascript" >
                        overlayIt(\''.$obj.'\',\''.OM_ROUTE_SOUSFORM.'&objsf='.$obj.'&idxformulaire='.$idx.'&retourformulaire=dossier_instruction&obj='.$obj.'&action=3&idx='.$row[$table].'\', 1);
                    </script>
                ';
            }
        }
    }

    /**
     * TREATMENT - supprimer_liaison.
     *
     * Supprime une liaison manuelle de deux DI.
     *
     * @return boolean
     */
    function supprimer_liaison($val = array()) {
        $this->begin_treatment(__METHOD__);
        $this->correct = true;
        $idx_source = $this->getVal($this->clePrimaire);
        $idx_cible = $this->f->get_submitted_get_value("idx_cible");
        $obj = $this->f->get_submitted_get_value("obj");

        // Si le lien n'est pas manuel on ne peut pas le supprimer
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    type_lien 
                FROM 
                    %1$slien_dossier_dossier
                WHERE 
                    dossier_src = \'%2$s\' 
                    AND dossier_cible = \'%3$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx_source),
                $this->f->db->escapeSimple($idx_cible)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->correct = false;
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Gestion des DI liés implicitement par le DA
        // NB : l'icone 'supprimer' est masquée donc ce cas d'utilisation n'est pas censé se produire
        if ($qres['row_count'] == 0) {
            $this->correct = false;
            $this->addToMessage(sprintf(_("Le dossier %s est lié implicitement et ne peut donc pas être supprimé."), $idx_cible));
            return $this->end_treatment(__METHOD__, false);
        }

        // Si le dossier cible est lié automatiquement alors une permission spécifique est requise
        // NB : l'icone 'supprimer' est masquée donc ce cas d'utilisation n'est pas censé se produire
        $row = array_shift($qres['result']);
        if (strpos($row['type_lien'], 'auto_') !== false
            && $this->f->isAccredited($this->get_absolute_class_name(). '_supprimer_liaison_auto') === false) {
            $this->correct = false;
            $this->addToMessage(_("Vous n'avez pas le droit de supprimer une liaison automatique."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Si le dossier est clôturé alors le bypass est requis
        // NB : l'icone 'supprimer' est masquée donc ce cas d'utilisation n'est pas censé se produire
        $row = array_shift($qres['result']);
        if ($this->f->getStatutDossier($idx_source) == "cloture"
            && $this->f->isAccredited('dossier_instruction_supprimer_liaison_bypass') === false) {
            $this->correct = false;
            $this->addToMessage(_("Vous n'avez pas le droit de supprimer de liaison sur un dossier clôturé."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Si instructeur de division différente alors le bypass est requis
        // NB : l'icone 'supprimer' est masquée donc ce cas d'utilisation n'est pas censé se produire
        $row = array_shift($qres['result']);
        if ($this->f->isUserInstructeur() === true
            && $this->getDivisionFromDossier($idx_source) != $_SESSION["division"]
            && $this->f->isAccredited('dossier_instruction_supprimer_liaison_bypass') === false) {
            $this->correct = false;
            $this->addToMessage(_("Vous n'avez pas le droit de supprimer de liaison sur un dossier d'une division différente de la votre."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Suppression du lien manuel
        $sql = "DELETE FROM ".DB_PREFIXE."lien_dossier_dossier
            WHERE dossier_src = '".$idx_source."'
            AND dossier_cible = '".$idx_cible."'";
        $res = $this->f->db->query($sql);
        $this->f->addToLog(__METHOD__.": db->query(\"".$sql."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true)) {
            $this->correct = false;
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }
        if ($res !== 1) {
            $this->correct = false;
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }
        $this->addToMessage(sprintf(_("Le dossier %s a été délié."), $idx_cible));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - generate_citizen_access_key.
     *
     * Génère la clé d'accès au portail citoyen sur un dossier qui n'en a pas.
     *
     * @return boolean
     */
    protected function generate_citizen_access_key() {

        // Récupération de l'instance du dossier d'autorisation lié au DI courant
        $inst_da = $this->get_inst_dossier_autorisation($this->getVal("dossier_autorisation"));
        $generation = $inst_da->update_citizen_access_key();
        if ($generation == true) {
            $this->correct = true;
            $this->addToMessage(_("La cle d'acces au portail citoyen a ete generee."));
            return true;
        }
        $this->addToMessage(sprintf("%s %s", _("La cle d'acces au portail citoyen n'a pas pu etre generee."), _("Veuillez contacter votre administrateur.")));
        //
        return false;
    }


    /**
     * VIEW - get_autorisation_contestee.
     *
     * Si le DI instancié est une autorisation contestable alors on récupère
     * les informations terrain et demandeurs.
     *
     * @return void
     */
    public function get_autorisation_contestee() {
        $this->f->disableLog();
        $retour = array();
        $retour['error']= sprintf(
            _("Il n'existe aucun dossier correspondant au numéro %s.")." ".
            _("Saisissez un nouveau numéro puis recommencez."),
            $this->getParameter('idx')
        );
        // Gestion multi
        $this->f->getUserInfos();

        // Si le dossier n'existe pas ou si l'utilisateur n'y a pas accès ou si c'est un
        // dossier du groupe "Contentieux", on renvoie une erreur
        if ($this->getVal($this->clePrimaire) === ""
            || $this->can_user_access_dossier() === false
            || ($this->f->isCollectiviteMono($this->f->om_utilisateur['om_collectivite']) === true
                && $this->is_user_from_allowed_collectivite() === false)
            || $this->get_groupe() === 'CTX') {
            //
            echo json_encode($retour);
            return;
        }
        
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.terrain_references_cadastrales,
                    dossier.terrain_adresse_voie_numero,
                    dossier.terrain_adresse_voie,
                    dossier.terrain_superficie,
                    dossier.terrain_adresse_lieu_dit,
                    dossier.terrain_adresse_localite,
                    dossier.terrain_adresse_code_postal,
                    dossier.terrain_adresse_bp,
                    dossier.terrain_adresse_cedex
                FROM 
                    %1$sdossier
                WHERE 
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres['code'] !== 'OK') {
            $retour['error']= sprintf(
                _("Erreur de base de données.")." ".
                _("Veuillez contacter votre administrateur.")
            );
            echo json_encode($retour);
            return;
        }
        $infos_dossier = array_shift($qres['result']);
        
        // Initialisation du message d'erreur
        $retour['error']= sprintf(
            _("Erreur lors de la récupération des informations des pétitionnaires du dossier contesté.")." ".
            _("Veuillez contacter votre administrateur.")
        );
        // Récupération de la liste des demandeurs
        $demandeur_list = $this->get_demandeur_list();
        if ($demandeur_list === false) {
            echo json_encode($retour);
            return;
        }
         // Duplication des demandeurs
         foreach ($demandeur_list as $type => $demandeur_type_list) {
             foreach ($demandeur_type_list as $key => $demandeur_id) {
                $new_demandeur_id = $this->duplicate_demandeur($demandeur_id);
                 if ($new_demandeur_id === false) {
                     echo json_encode($retour);
                     return;
                 }
                 $demandeur_list[$type][$key] = $new_demandeur_id;
             }
         }
        $infos_dossier['demandeurs'] = $demandeur_list;
        // Retour des information du dossier
        echo json_encode($infos_dossier);
        return;
    }

    /**
     * VIEW - get_dossier_instruction_trad
     *
     * Retourne sous le format JSON une liste de traduction ou de chaîne de caractères.
     *
     * @return void
     */
    function get_dossier_instruction_trad() {
        echo json_encode(
            array(
                'consulter' => __("Consulter le dossier d'instruction dématérialisé"),
                'info_terme_delai' => __("Aucune instruction ne sera appliquée automatiquement au terme du délai"),
            )
        );
        return;
    }


    /**
     * Méthode permettant de récupérer les identifiants des demandeurs du
     * dossier.
     */
    function get_demandeur_list() {
        // Récupération des demandeurs de la base
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    demandeur.type_demandeur,
                    lien_dossier_demandeur.petitionnaire_principal
                FROM 
                    %1$slien_dossier_demandeur
                    JOIN %1$sdemandeur
                        ON demandeur.demandeur = lien_dossier_demandeur.demandeur 
                WHERE 
                    lien_dossier_demandeur.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        // Stockage du résultat dans un tableau
        foreach ($qres['result'] as $row) {
            $type = $row['type_demandeur'];
            if ($row['petitionnaire_principal'] == 't') {
                $type .= "_principal";
            }
            $valIdDemandeur[$type][]=$row['demandeur'];
        }
        return $valIdDemandeur;
    }

    /**
     * Permet de dupliquer le demandeur dont l'identifiant est passé en
     * paramètre.
     * 
     * @param integer $idx Identifiant du demandeur à dupliquer.
     * 
     * @return integer Identifiant du demandeur dupliqué.   
     */
    private function duplicate_demandeur($idx) {
        $demandeur = $this->f->get_inst__om_dbform(array(
            "obj" => "demandeur",
            "idx" => $idx,
        ));
        $demandeur->setValFFromVal();
        $valF = $demandeur->valF;
        $valF['demandeur'] = '';
        $valF['frequent'] = 'f';
        if ($demandeur->ajouter($valF) === true) {
            return $demandeur->valF[$demandeur->clePrimaire];
        }
        return false;
    }


    /**
     * TREATMENT - regenerate_citizen_access_key.
     *
     * Régénère la clé d'accès au portail citoyen en écrasant la clé présente.
     *
     * @return boolean
     */
    protected function regenerate_citizen_access_key() {

        // Récupération de l'instance du dossier d'autorisation lié au DI courant
        $inst_da = $this->get_inst_dossier_autorisation();
        // L'appel à update_citizen_access_key avec la valeur true force la regénération
        $generation = $inst_da->update_citizen_access_key(true);
        if ($generation == true) {
            $this->correct = true;
            $this->addToMessage(_("La cle d'acces au portail citoyen a ete regeneree."));
            return true;
        }
        $this->addToMessage(sprintf("%s %s", _("La cle d'acces au portail citoyen n'a pas pu etre regeneree."), _("Veuillez contacter votre administrateur.")));
        //
        return false;
    }


    /**
     * VIEW - view_attestation_date_affichage.
     *
     * Affichage de l'attestion date d'affichage.
     *
     * @return void
     */
    function view_attestation_date_affichage() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // récupère la dernier instruction d'affichage obligatoire
        $idx_instr_aff_obli = $this->get_last_instuction_affichage_obligatoire();

        // instruction existante
        if ($idx_instr_aff_obli !== false) {

            // Instanciation de l'événement d'instruction
            $instr_aff_obli = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $idx_instr_aff_obli,
            ));

            // appel la méthode de visualisation de l'édition de l'instruction
            // comme si l'utilisateur était allé sur la page de l'instruction
            // et avait cliqué sur 'Édition'
            $ret = $instr_aff_obli->view_edition();
        }

        $this->addToMessage(
            _("Une erreur s'est produite lors de la récupération de l'attestation de la date d'affichage obligatoire.")
        );
    }


    /**
     * Retour, pour le dossier courant, l'identifiant de la
     * dernière instruction en date, ayant un évènement de type
     * 'Attestation d'affichage' ($aff_obli) finalisée
     * sinon retourne null.
     */
    function get_last_instuction_affichage_obligatoire() {

        // Récupération de l'événement correspondant à l'instruction à insérer pour chaque dossier du registre
        $params = $this->f->getCollectivite($this->getVal('om_collectivite'));
        $aff_obli = isset($params['id_affichage_obligatoire']) ? $params['id_affichage_obligatoire'] : null;

        // Si le paramétrage est vide ou pas numérique
        $erreur = false;
        if ($aff_obli == "" or !is_numeric($aff_obli)) {
            $erreur = true;
        }
        else {
            // Vérification de l'existance de l'événement
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        count(*)
                    FROM
                        %1$sevenement
                    WHERE
                        evenement = %2$d',
                    DB_PREFIXE,
                    intval($aff_obli)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            // Si pas de correspondance d'événement dans la base
            if ($qres["result"] === '0') {
                $erreur = true;
            }
        }
        // Affichage d'un message si en erreur
        if ($erreur == true) {
            // Affichage de l'erreur et sortie de la vue
            $this->f->displayMessage("error", sprintf("%s %s",
                __("Erreur de parametrage."),
                __("Veuillez contacter votre administrateur.")
            ));
            return false;
        }
        $idx_instr = null;
        // recherche, pour le dossier courant, l'identifiant de la
        // dernière instruction en date, ayant un évènement de type
        // 'Attestation d'affichage' ($aff_obli) finalisée
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    i.instruction
                FROM 
                    %1$sinstruction AS i
                WHERE 
                    i.dossier = \'%2$s\'
                    AND i.evenement = %3$d
                    AND i.om_final_instruction IS TRUE
                ORDER BY
                    i.date_evenement DESC
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier')),
                intVal($aff_obli)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        if ($row = array_shift($qres['result'])) {
            $idx_instr = $row['instruction'];
        }
        return $idx_instr;
    }


    /**
     * TREATMENT - regenerate_recepisse.
     *
     * Finalisation d'un événement d'instruction
     * et affichage du lien de téléchargement.
     *
     * @return void
     */
    function regenerate_recepisse() {
        //
        $this->begin_treatment(__METHOD__);
        $this->f->db->autoCommit(false);

        // Récupère l'identifiant du document
        $idx_instruction = $this->get_demande_instruction_recepisse();

        // Instanciation de l'événement d'instruction
        $instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction",
            "idx" => $idx_instruction,
        ));
        $instruction->setParameter('maj', 1);


        // Par défaut on considère que l'éventuelle définalisation est un succès
        $unfinalization = true;
        // On définalise et on met à jour ce marqueur le cas échéant
        $finalize = $instruction->is_unfinalizable_without_bypass();
        if ($finalize == true) {
            $unfinalization = $instruction->unfinalize($instruction->valF);
        }

        // Si la définalisation est OK,
        // ou qu'il n'y avait pas besoin de définaliser
        if ($unfinalization !== false) {
            // On supprime l'éventuel message de succès de définalisation
             $instruction->msg = '';
            // Finalise l'instruction
            $finalization = $instruction->finalize($instruction->valF);
            $url_fichier = '../app/index.php?module=form&snippet=file&obj=instruction&'.
                    'champ=om_fichier_instruction&id='.$idx_instruction;

            // Si la finalisation est ok
            if ($finalization !== false) {
                //
                $this->f->db->commit();
                // Lien PDF
                $lien_pdf = "<br/><br/>
                <a id='telecharger_recepisse' title=\""._("Telecharger le recepisse de la demande")."\" class='lien' href='".$url_fichier."' target='_blank'>
                    <span class=\"om-icon om-icon-16 om-icon-fix pdf-16\">".
                            _("Telecharger le recepisse de la demande").
                    "</span>&nbsp;".
                    _("Telecharger le recepisse de la demande")."
                </a>";
                $this->addToMessage(
                    _("Le recepisse de la demande a ete regenere.").$lien_pdf
                );
                //
                return $this->end_treatment(__METHOD__, true);
            }
        }

        //
        $this->correct = false;
        $this->f->db->rollback();
        $this->addToMessage(
            _("Une erreur s'est produite lors de la régénération du récépissé de la demande :")
            ."<br/><br/>".$instruction->msg
        );
        return $this->end_treatment(__METHOD__, false);
    }


    /**
     * VIEW - view_geocoder
     *
     * Permet d'afficher:
     * - le formulaire de géocodage des dossiers d'instruction;
     * - le résultat du géocodage.
     *
     * @return void
     */
    public function view_geocoder() {

        // Récupère les informations de la collectivité de l'utilisateur
        // connecté
        $collectivite = $this->f->getCollectivite();

        // Vérifie qu'il y ait un paramétrage du SIG
        if (isset($collectivite["sig"]) !== true) {
            $this->correct = false;
            $this->f->displayMessage('error', _("Erreur de paramétrage SIG.")." "._("Veuillez contacter votre administrateur."));
            return false;
        }

        // Si le formulaire est validé
        if ($this->f->get_submitted_post_value('geocoder') !== null) {
            $this->correct = true;

            // On lance le traitement de géocodage
            $geocodage = $this->treat_dossiers_without_geom();

            // Pour chaque collectivité, on compte le nombre d'occurence par
            // valeur de retour
            $count_value = array();
            foreach ($geocodage as $key => $value) {
                //$count_value[id de la collectivité][valeur de retour][occurence]
                $count_value[$key] = array_count_values($value);
            }

            // Pour chaque collectivité on affiche le message présentant les
            // résultats
            foreach ($count_value as $key => $value) {
                $om_collectivite = $this->f->get_inst__om_dbform(array(
                    "obj" => "om_collectivite",
                    "idx" => $key
                ));

                // Compteur des DI pour chaque résultats
                $nb_true = 0;
                $nb_verif_parcelle_error = 0;
                $nb_calcul_emprise_error = 0;
                $nb_calcul_centroide_error = 0;
                $nb_recup_contrainte_error = 0;
                // Initialisation du message de validation
                $message = '';

                if (isset($value['true']) === true) {
                    $nb_true = $value['true'];
                }
                if (isset($value['verif_parcelle_error']) === true) {
                    $nb_verif_parcelle_error = $value['verif_parcelle_error'];
                }
                if (isset($value['calcul_emprise_error']) === true) {
                    $nb_calcul_emprise_error = $value['calcul_emprise_error'];
                }
                if (isset($value['calcul_centroide_error']) === true) {
                    $nb_calcul_centroide_error = $value['calcul_centroide_error'];
                }
                if (isset($value['recup_contrainte_error']) === true) {
                    $nb_recup_contrainte_error = $value['recup_contrainte_error'];
                }
                if ($nb_true + $nb_verif_parcelle_error + $nb_calcul_emprise_error + $nb_calcul_centroide_error + $nb_recup_contrainte_error > 0) {
                    $message = sprintf("<span class='bold'>%s</span><br/>", $om_collectivite->getVal('libelle'));
                }
                if ($nb_true > 0) {
                    $message .= sprintf("%s %s.<br/>", $nb_true, _("dossier(s) d'instruction a(ont) été géolocalisé(s)"));
                }
                if ($nb_verif_parcelle_error + $nb_calcul_emprise_error + $nb_calcul_centroide_error > 0) {
                    $message .= sprintf("%s %s :<br/>", $nb_verif_parcelle_error + $nb_calcul_emprise_error + $nb_calcul_centroide_error, _("dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)"));
                }
                if ($nb_verif_parcelle_error > 0) {
                    $message .= sprintf("<span style=\"padding-left: 20px;\">%s %s</span>.<br/>", $nb_verif_parcelle_error,_("dossier(s) d'instruction en erreur à la vérification des parcelles"));
                }
                if ($nb_calcul_emprise_error > 0) {
                    $message .= sprintf("<span style=\"padding-left: 20px;\">%s %s</span>.<br/>", $nb_calcul_emprise_error,_("dossier(s) d'instruction en erreur au calcul de l'emprise"));
                }
                if ($nb_calcul_centroide_error > 0) {
                    $message .= sprintf("<span style=\"padding-left: 20px;\">%s %s</span>.", $nb_calcul_centroide_error,_("dossier(s) d'instruction en erreur au calcul du centroïde"));
                }
                if ($nb_recup_contrainte_error > 0) {
                    $message .= sprintf("<span style=\"padding-left: 20px;\">%s %s</span>.", $nb_recup_contrainte_error,_("dossier(s) d'instruction dont les contraintes n'ont pas pu être récupérées"));
                }

                // Affichage du message
                if ($message !== '') {
                    $this->addToMessage($message);
                    $this->message();
                    $this->msg = '';
                }
            }
        }

        // Ouvre le formulaire
        $this->f->layout->display__form_container__begin(array(
            "name" => "f1",
            "action" => "",
        ));

        // Description de la page
        $description = _("Cette page permet de géolocaliser les dossiers d'instruction qui ne l'ont pas déjà été.")."\n \r";
        // Affiche le nombre de dossier à taiter
        $nb_dossiers_sans_geom = $this->treat_dossiers_without_geom('count');
        if ($nb_dossiers_sans_geom == '0') {
            $description .= _("Il n'y a aucun dossier d'instruction à traiter.");
        } else {
            $description .= sprintf(_("Il y a %s dossier(s) d'instruction à traiter."), $nb_dossiers_sans_geom);
        }
        // Affichage de la description
        $this->f->displayDescription($description);

        // Affichage du bouton de validation
        $this->f->layout->display__form_controls_container__begin();
        $params_button = array(
            "value" => _("Géolocaliser"),
            "name" => "geocoder",
            "onclick" => "$('div#form-message').html(msg_loading);",
        );
        $this->f->layout->display_form_button($params_button);
        $this->f->layout->display__form_controls_container__end();

        // Ferme le formulaire
        $this->f->layout->display__form_container__end();
    }

    /**
     * Traite ou compte le nombre de dossiers d'instruction qui n'ont pas de
     * valeur de centroïde.
     *
     * mode result : geocode les dossier et renvoie un tableau de resultat
     * mode count : renvoie le nombre de dossiers à traiter
     *
     * @param string $mode Mode d'utilisation de la méthode.
     *
     * @return mixed Retourne Soit le nombre de dossier à traiter, soit le
     *               résultat du traitement.
     */
    public function treat_dossiers_without_geom($mode = 'result') {
        // Récupère les informations de la collectivité de l'utilisateur
        // connecté
        $collectivite = $this->f->getCollectivite();
        // Récupération du paramétrage pour le filtre des dossiers d'instruction
        // à géolocaliser automatiquement
        $param_geolocalisation_auto = $this->f->getParameter("param_geolocalisation_auto");
        // Initialisation du paramètre à la valeur par défaut
        $param_filtre = "";
        // Si le paramètre est renseigné
        if (is_null($param_geolocalisation_auto) === false
            && empty($param_geolocalisation_auto) === false) {
            //
            $date_depot = $this->f->is_option_date_depot_mairie_enabled() === true ? 'dossier.date_depot_mairie' : 'dossier.date_depot';
            $param_geolocalisation_auto = explode(';', $param_geolocalisation_auto);
            // Récupération de la date à partir de laquelle les dossiers sont geolocalisable selon
            // si l'on filtre selon les dossiers du jour ou ceux à la date paramétrée
            $dateGeolocAuto = $param_geolocalisation_auto[0] == 'today' ?
                date("Y-m-d") :
                $param_geolocalisation_auto[0];
            $param_filtre = sprintf(
                '%s
                %s
                %s
                ',
                sprintf('AND %s >= \'%s\'', $date_depot, $dateGeolocAuto),
                isset($param_geolocalisation_auto[1]) === true && $param_geolocalisation_auto[1] !== null && $param_geolocalisation_auto[1] !== '' ?
                    sprintf(
                        'AND dossier_autorisation_type.code IN (%s)',
                        $param_geolocalisation_auto[1]
                    ) :
                    '',
                isset($param_geolocalisation_auto[2]) === true && $param_geolocalisation_auto[2] !== null && $param_geolocalisation_auto[2] !== '' ?
                    sprintf(
                        'AND (dossier.avis_decision != (
                            SELECT avis_decision
                            FROM %savis_decision
                            WHERE libelle = \'%s\')
                            OR dossier.avis_decision IS NULL)',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($param_geolocalisation_auto[2])
                    ) :
                    ''
            );
        }
        // Si l'utilisateur est d'une collectivité mono alors on filtre les DI
        $collectivite_filtre = "";
        if ($this->f->isCollectiviteMono($collectivite['om_collectivite_idx']) === true) {
            $collectivite_filtre = sprintf(
                " AND dossier.om_collectivite = '%d' ",
                intval($collectivite['om_collectivite_idx'])
            );
        }

        // Requête de sélection des dossiers à traiter
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier,
                    dossier.om_collectivite,
                    dossier.terrain_references_cadastrales
                FROM
                    %1$sdossier
                    INNER JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                WHERE
                    dossier.geom IS NULL
                    AND dossier.terrain_references_cadastrales IS NOT NULL
                    AND dossier.terrain_references_cadastrales != \'\'
                    AND dossier.parcelle_temporaire IS NOT TRUE
                    %2$s
                    %3$s',
                DB_PREFIXE,
                $param_filtre,
                $collectivite_filtre
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Compte du nombre de dossiers à traiter
        $count = 0;
        // Tableau de résultat du géocodage
        $geocodage = array();

        // Récupération d'une instance de dossier_instruction pour utiliser
        // les méthodes de la classe
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => "]"
        ));
        // Pour chaque dossier retourné par la requête
        foreach($qres['result'] as $row) {
            // Récupère la collectivité du dossier : nécessaire dans le cas où
            // l'utilisateur est de la collectivité multi et donc recupère tous
            // les DI de toutes les collectivités
            $collectivite_dossier = $this->f->getCollectivite($row['om_collectivite']);

            // Si le dossier appartient à une collectivité qui n'a pas paramétré
            // son sig à "aucun"
            if (isset($collectivite_dossier["sig"]) === true) {
                if ($mode === 'result') {
                    // On envoie dans la fonction geocoder les valeurs récupérée dans la requête
                    $result = $dossier->geocoder($row);
                    // Met à jour les infos de la geolocalisation dans la base de données
                    $date = date('d/m/Y H:i:s');
                    $date_db = $this->f->formatTimestamp($date, false);
                    $message_verif_parcelle = _("Les parcelles existent.");
                    $message_calcul_emprise = _("L'emprise a été calculé.");
                    $message_calcul_centroide = _("Le centroide a été calculé.");
                    $message_error = _("Le traitement automatique a échoué.");
                    $msgGeolocMaj = array('verif_parcelle', 'calcul_emprise', 'calcul_centroide');

                    if ($result === true) {
                        $result = 'true';
                    }
                    // Met à jour les messages pour les différents traitement effectué
                    foreach ($msgGeolocMaj as $elementMaj) {
                        if ($result === $elementMaj.'_error') {
                            $this->update_dossier_geolocalisation($elementMaj, $date_db, false, $message_error, $row['dossier']);
                            break;
                        } else {
                            $messageAff = 'message_'.$elementMaj;
                            $this->update_dossier_geolocalisation($elementMaj, $date_db, true, ${$messageAff}, $row['dossier']);
                        }
                    }
                    $geocodage[$row['om_collectivite']][] = $result;
                }
                else if ($mode === 'count') {
                    $count = $count + 1;
                }
            }
        }

        // Retour
        if ($mode === 'result') {
            return $geocodage;
        }
        if ($mode === 'count') {
            return $count;
        }
    }

     /**
     * TREATMENT - geocoder.
     *
     * Action de géocodage : appelle une vérification de l'existence des
     * parcelles puis un calcul de l'emprise et du centroïde.
     *
     * @param array $valDI tableau contenant les informations du di nécesaire à la geolocalisation
     *  - TODO : mettre la liste des infos
     * @return mixed Retourne true si les trois traitements se sont bien
     *               déroulés, sinon retourne le code erreur du traitement en
     *               erreur.
     */
    public function geocoder($valDI) {
        $this->begin_treatment(__METHOD__);

        // Vérifie l'existence des parcelles
        $verif_parcelle = $this->geolocalisation_verif_parcelle(
            $valDI['om_collectivite'],
            $valDI['dossier'],
            $valDI['terrain_references_cadastrales']
        );
        foreach ($verif_parcelle as $parcelle) {
            // Si la parcelle n'existe pas on retourne une erreur
            if ($parcelle['existe'] !== true) {
                return $this->end_treatment(__METHOD__, 'verif_parcelle_error');
            }
        }

        // Calcul l'emprise
        $calcul_emprise = $this->geolocalisation_calcul_emprise(
            $valDI['om_collectivite'],
            $valDI['dossier'],
            $valDI['terrain_references_cadastrales']
        );
        if ($calcul_emprise === false) {
            return $this->end_treatment(__METHOD__, 'calcul_emprise_error');
        }

        // Calcul le centroïde
        $calcul_centroide = $this->geolocalisation_calcul_centroide(
            $valDI['om_collectivite'],
            $valDI['dossier']
        );
        if ($calcul_centroide === false) {
            return $this->end_treatment(__METHOD__, 'calcul_centroide_error');
        }

        // Récupère les contraintes si l'option de récupération auto est active
        if ($this->f->is_option_geolocalisation_auto_contrainte_enabled($valDI['om_collectivite']) === true) {
            $recup_contrainte = $this->geolocalisation_recup_contrainte_dossier(
                $valDI['om_collectivite'],
                $valDI['dossier']
            );
            if ($recup_contrainte['correct'] === false) {
                return $this->end_treatment(__METHOD__, 'recup_contrainte_error');
            }
        }

        return $this->end_treatment(__METHOD__, true);
    }

     /**
     * VIEW - view_geolocalisation_verif_parcelle.
     *
     * 1ere action de géolocalisation, permet de vérifier l'existence des
     * parcelles sur le sig.
     *
     * @return void
     */
    public function view_geolocalisation_verif_parcelle() {
        // Format de la date pour l'affichage
        $date = date('d/m/Y H:i:s');
        $correct = true;
        $message = "";

        // Récupération des informations (log) d'actions de localisation sur le dossier.
        require_once "../obj/dossier_geolocalisation.class.php";
        $dossier_geolocalisation = new dossier_geolocalisation(null, null, null, $this->getVal('dossier'));

        // Définition des références cadastrales dans la table dossier_geolocalisation
        // si elle n'existe pas encore afin de pouvoir les comparer par la suite.
        if($dossier_geolocalisation->get_terrain_references_cadastrales_archive() == "") {
            $dossier_geolocalisation->set_terrain_references_cadastrales_archive($this->getVal('terrain_references_cadastrales'));
        }

        // Traitement
        $execute = $this->geolocalisation_verif_parcelle(
            $this->getVal('om_collectivite'),
            $this->getVal('dossier'),
            $this->getVal('terrain_references_cadastrales')
        );

        // Initialisation des messages
        $message_diff_parcelle = _("Les parcelles ont ete modifiees.");
        $message = _("Les parcelles existent.");
        // Initialise le tableau qui contiendra les parcelles qui n'existent pas
        $list_error_parcelle = array();
        $date_db = $this->f->formatTimestamp($date, false);
        // Vérifie l'existence des parcelles
        foreach ($execute as $parcelle) {
            // Si la parcelle n'existe pas on la consigne dans un tableau
            if ($parcelle['existe'] != true) {
                $list_error_parcelle[] = $parcelle['parcelle'];
            }
        }
        // Si des parcelles n'existent pas alors on les affichent à l'utilisateur
        if (count($list_error_parcelle) != 0) {
            //
            $correct = false;
            //
            $string_error_parcelle = implode(", ", $list_error_parcelle);
            //
            $message = _("Les parcelles n'existent pas.");
        } else {

            if($dossier_geolocalisation->get_terrain_references_cadastrales_archive() !=
                $this->getVal('terrain_references_cadastrales')) {
                // Message affiché à l'utilisateur
                $message_diff_parcelle = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message_diff_parcelle;
                // Met à jour du message des autres boutons
                $this->update_dossier_geolocalisation('calcul_emprise', $date_db, $correct, $message_diff_parcelle);
                $this->update_dossier_geolocalisation('calcul_centroide', $date_db, $correct, $message_diff_parcelle);
                $this->update_dossier_geolocalisation('recup_contrainte', $date_db, $correct, $message_diff_parcelle);

                // Message affiché à l'utilisateur
                $message_diff_parcelle = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message_diff_parcelle;
            }
            // Mise à jour du champ terrain_references_cadastrales_archive dans
            // les informations de localisation du dossier.
            $dossier_geolocalisation->set_terrain_references_cadastrales_archive(
                                    $this->getVal('terrain_references_cadastrales')
                                );
        }

        // Message affiché à l'utilisateur
        $message = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message;
        $this->update_dossier_geolocalisation('verif_parcelle', $date_db, $correct, $message);
        // Tableau contenant l'adresse à retourner
        $return['return'] = $execute;
        // Ajoute les informations sur le traitement dans le tableau retourné
        $return['log'] = array(
            "date" => $date,
            "etat" => $correct,
            "message" => $message,
            "message_diff_parcelle" => $message_diff_parcelle

        );
        // Retourne le résultat dans un tableau json
        echo json_encode($return);
        return;
    }

    /**
     * TREATMENT - geolocalisation_verif_parcelle.
     *
     * Permet de vérifier l'existence des parcelles sur le sig.
     *
     * @param integer $omCollectivite collectivite du dossier
     * @param string $terrainRefCadastrale reference cadastrale du terrain
     * @return array Retour du web service.
     */
    public function geolocalisation_verif_parcelle($omCollectivite, $dossierIdx, $terrainRefCadastrale) {
        // Récupération des infos de la collectivité du DI
        $collectivite = $this->f->getCollectivite($omCollectivite);

        // Formatage des parcelles pour l'envoi au webservice
        $liste_parcelles = $this->f->parseParcelles(
            $terrainRefCadastrale,
            $omCollectivite
        );

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $dossierIdx);
            $execute = $geoads->verif_parcelle($liste_parcelles);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e, $dossierIdx);
            return;
        }
        return $execute;
    }

    /**
     * Vérification de la cohérence des parcelles actuelles :
     * si parcelles différentes de l'archive affichage d'une erreur.
     *
     * @return boolean false si identique, tableau json avec état d'erreur sinon
     */
    private function is_different_parcelle_from_dossier_geolocalisation() {
        $date = date('d/m/Y H:i:s');
        require_once "../obj/dossier_geolocalisation.class.php";
        $dossier_geolocalisation = new dossier_geolocalisation(null, null, null, $this->getVal('dossier'));
        $dessin_state = $dossier_geolocalisation->get_geolocalisation_state('dessin_emprise');
        if($dossier_geolocalisation->get_terrain_references_cadastrales_archive() != $this->getVal('terrain_references_cadastrales')
            && (isset($dessin_state['etat']) === false || $dessin_state['etat'] !== 't')) {
            //
            $return['log'] = array(
                "date" => $date,
                "etat" => false,
                "message" => sprintf(_("Les parcelles n'ont pas ete verifiees ou ont ete modifiees, veuillez (re)lancer leur verification.")." "._("Dernier traitement effectue le %s."), $date),
            );
            return json_encode($return);
        }
        return false;
    }


    /**
     * VIEW - view_geolocalisation_calcul_emprise.
     *
     * Permet de calculer l'emprise du dossier sur le sig.
     *
     * @return void
     */
    public function view_geolocalisation_calcul_emprise() {
        // Format de la date pour l'affichage
        $date = date('d/m/Y H:i:s');
        $correct = true;
        $message = "";
        // Vérification de la cohérence des parcelles actuelles.
        if(($different_parcelle = $this->is_different_parcelle_from_dossier_geolocalisation()) !== false) {
            echo $different_parcelle;
            return;
        }
        // Traitement
        $execute = $this->geolocalisation_calcul_emprise(
            $this->getVal('om_collectivite'),
            $this->getVal('dossier'),
            $this->getVal('terrain_references_cadastrales')
        );
        // Traitement du message
        $message = _("L'emprise a ete calculee.");
        if($execute != true) {
            $message = _("L'emprise n'a pas pu etre calculee.");
            $correct = false;
        }
        // Message affiché à l'utilisateur
        $message = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message;
        $date_db = $this->f->formatTimestamp($date, false);
        // Mise à jour de la table dossier_géolocalisation
        $this->update_dossier_geolocalisation('calcul_emprise', $date_db, $correct, $message);
        $return = array();
        $return['return'] = $execute;
        // Ajoute les informations sur le traitement dans le tableau retourné
        $return['log'] = array(
            "date" => $date,
            "etat" => $correct,
            "message" => $message,
        );

        // Retourne le résultat dans un tableau json
        echo json_encode($return);
        return;
    }

    /**
     * TREATMENT - geolocalisation_calcul_emprise.
     *
     * Permet de calculer l'emprise du dossier sur le sig.
     *
     * @return array Retour du web service.
     */
    public function geolocalisation_calcul_emprise($omCollectivite, $dossierIdx, $terrainRefCadastrale) {
        $collectivite = $this->f->getCollectivite($omCollectivite);

        // Formatage des parcelles pour l'envoi au webservice
        $liste_parcelles = $this->f->parseParcelles(
            $terrainRefCadastrale,
            $omCollectivite
        );

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $dossierIdx);
            $execute = $geoads->calcul_emprise($liste_parcelles, $dossierIdx);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e, $dossierIdx);
            return false;
        }
        return $execute;
    }

    /**
     * TREATMENT - geolocalisation_supprimer_emprise.
     *
     * Permet de supprimer l'emprise du dossier sur le sig.
     *
     * @return array Retour du web service.
     */
    public function geolocalisation_supprime_emprise(int $omCollectivite, $dossierIdx) {
        $collectivite = $this->f->getCollectivite($omCollectivite);

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $dossierIdx);
            $execute = $geoads->supprime_emprise($dossierIdx);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e, $dossierIdx);
            return false;
        }
        return $execute;
    }

    /**
     * VIEW - view_geolocalisation_dessin_emprise.
     * Permet de rediriger l'utilisateur vers le sig afin qu'il dessine l'emprise
     * du dossier.
     *
     * @return void
     */
    public function view_geolocalisation_dessin_emprise() {
        // Format de la date pour l'affichage
        $date = date('d/m/Y H:i:s');
        $correct = true;
        $message = "";
        $collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));

        $liste_parcelles = array();

        if ($this->getVal('terrain_references_cadastrales') != null || $this->getVal('terrain_references_cadastrales') != '' ) {
            // Formatage des parcelles pour l'envoi au webservice
            $liste_parcelles = $this->f->parseParcelles(
                $this->getVal('terrain_references_cadastrales'),
                $this->getVal('om_collectivite')
            );
        }

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $this->getVal('dossier'));
            $execute = $geoads->redirection_web_emprise($liste_parcelles, $this->getVal('dossier'));
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e);
            return;
        }

        // Traitement du message
        $message = _("Redirection vers le SIG.");

        // Message affiché à l'utilisateur
        $message = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message;
        $date_db = $this->f->formatTimestamp($date, false);
        // Mise à jour de la table dossier_géolocalisation
        $this->update_dossier_geolocalisation('dessin_emprise', $date_db, $correct, $message);
        // Tableau à retourner
        $return = array();
        $return['return'] = $execute;
        // Ajoute les informations sur les traitements dans le tableau retourné
        $return['log'] = array(
            "date" => $date,
            "etat" => $correct,
            "message" => $message,
        );

        // Retourne le résultat dans un tableau json
        echo json_encode($return);
    }


    /**
     * VIEW - view_geolocalisation_calcul_centroide.
     * Calcul du centroid qui sert à ajouter le geom sur le dossier.
     *
     * @return void
     */
    public function view_geolocalisation_calcul_centroide() {
        // Format de la date pour l'affichage
        $date = date('d/m/Y H:i:s');
        $correct = true;
        $message = "";
        // Vérification de la cohérence des parcelles actuelles.
        if(($different_parcelle = $this->is_different_parcelle_from_dossier_geolocalisation()) !== false) {
            echo $different_parcelle;
            return;
        }
        // Traitement
        $execute = $this->geolocalisation_calcul_centroide(
            $this->getVal('om_collectivite'),
            $this->getVal('dossier')
        );
        // Récupération du code de référentiel sig
        if($execute === false) {
            $correct = false;
            $message = _("Erreur de configuration (aucun referentiel). Contactez votre administrateur.");
        } else {

            // Traitement du message
            $message = _("Le centroide a ete calcule")." : ".
                            $execute['x'].", ".
                            $execute['y'].".";
        }

        // Message affiché à l'utilisateur
        $message = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message;
        $date_db = $this->f->formatTimestamp($date, false);
        // Mise à jour de la table dossier_géolocalisation
        $this->update_dossier_geolocalisation('calcul_centroide', $date_db, $correct, $message);
        // Tableau à retourner
        $return['return'] = $execute;
        // Ajoute les informations sur le traitements dans le tableau retourné
        $return['log'] = array(
            "date" => $date,
            "etat" => $correct,
            "message" => $message,
        );

        // Retourne le résultat dans un tableau json
        echo json_encode($return);
        return;
    }

    /**
     * TREATMENT - geolocalisation_calcul_centroide.
     *
     * Calcul du centroïde qui sert à ajouter le geom sur le dossier.
     *
     * @return array Retour du web service.
     */
    public function geolocalisation_calcul_centroide($omCollectivite, $dossierIdx) {
        $collectivite = $this->f->getCollectivite($omCollectivite);

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $dossierIdx);
            $execute = $geoads->calcul_centroide($dossierIdx);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e, $dossierIdx);
            return false;
        }

        // Récupération du code de référentiel sig
        if($collectivite["sig"]["sig_referentiel"] === "" ||
            $collectivite["sig"]["sig_referentiel"] === null) {
            //
            return false;
        }

        // Vérifie que le calcul du centroïde est correct
        if ($execute['statut_calcul_centroide'] === false){
            return false;
        }

        // Récupère les coordonnées retournés par le SIG
        $coord = $execute['x']." ".$execute['y'];
        // Vérifie que les coordonées ne sont pas vides
        if (trim($coord) === '') {
            return false;
        }

        // Met à jour le centroide dans le dossier
        $sql = sprintf(
            'UPDATE
                %1$sdossier
            SET
                geom = public.ST_GeomFromText(\'POINT(%2$s)\', %3$s)
            WHERE
                dossier = \'%4$s\'',
            DB_PREFIXE,
            $this->db->escapeSimple($coord),
            $this->db->escapeSimple($collectivite["sig"]["sig_referentiel"]),
            $this->db->escapeSimple($dossierIdx)
        );
        $res = $this->f->db->query($sql);
        $this->f->addToLog(__METHOD__.": db->query(\"".$sql."\"", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        // si la surface est également fournie
        if (isset($execute['surface']) && ! empty($execute['surface'])) {

            // Met à jour l'information dans le dossier
            $valF = array("terrain_superficie_calculee" => $this->db->escapeSimple($execute['surface']));
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $dossierIdx)
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $dossierIdx)."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true)) {
                return false;
            }
        }

        // si la liste des parcelles est également fournie
        // et que le dossier n'a pas de parcelle ecore définie
        // on met à jour le dossier avec cette liste
        if (isset($execute['parcelles']) && ! empty($execute['parcelles'])) {

            // récupère une instance du dossier
            $di_inst = $this->f->findObjectById('dossier', $dossierIdx);
            if (empty($di_inst)) {
                $this->addToLog(__METHOD__."() ".sprintf(__("Erreur lors de la mise à jour des références cadastralles du DI %s (dossier non-trouvé)"), $dossierIdx), DEBUG_MODE);
            }
            elseif (! empty($di_inst->getVal('terrain_references_cadastrales'))) {
                $this->addToLog(__METHOD__."() ".sprintf(__("Pas de mise à jour des références cadastralles (déjà définies pour le %s)"), $dossierIdx), VERBOSE_MODE);
            }
            // il n'y a aucune parcelle définie pour ce dossier
            else {
                $this->addToLog(__METHOD__."() ".sprintf(__("Mise à jour des références cadastralles (aucune définie pour le %s)"), $dossierIdx), VERBOSE_MODE);

                // Met à jour l'information dans le dossier
                $valF = array("terrain_references_cadastrales" => $this->db->escapeSimple($execute['parcelles']));
                $res = $this->f->db->autoExecute(
                    sprintf('%s%s', DB_PREFIXE, $this->table),
                    $valF,
                    DB_AUTOQUERY_UPDATE,
                    sprintf("%s = '%s'", $this->clePrimaire, $dossierIdx)
                );
                $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $dossierIdx)."\");", VERBOSE_MODE);
                if ($this->f->isDatabaseError($res, true)) {
                    return false;
                }

                // supprime toutes les dossier_parcelle associée au dossier
                $di_inst->supprimer_dossier_parcelle($dossierIdx);

                // met à jour la liste des parcelles pour ce dossier
                $di_inst->ajouter_dossier_parcelle($dossierIdx, $execute['parcelles']);
            }
        }

        // Retour
        return $execute;
    }

    /**
     * VIEW - view_geolocalisation_recup_contrainte.
     *
     * Permet de récupérer les contraintes et les affecter au dossier.
     *
     * @return void
     */
    public function view_geolocalisation_recup_contrainte() {
        // Format de la date pour l'affichage
        $date = date('d/m/Y H:i:s');
        $correct = true;
        $message = "";
        // Vérification de la cohérence des parcelles actuelles.
        if(($different_parcelle = $this->is_different_parcelle_from_dossier_geolocalisation()) !== false) {
            echo $different_parcelle;
            return;
        }
        
        // Effectue le traitement et met à jour les messages
        $resultat = $this->geolocalisation_recup_contrainte_dossier(
            $this->getVal('om_collectivite'),
            $this->getVal('dossier')
        );
        $message = $resultat['message'];
        $correct = $resultat['correct'];
        $listeDossierContrainteSIGAfter = $resultat['listeDossierContrainteSIG'];
        $return = array();
        $date_db = $this->f->formatTimestamp($date, false);
        // Message affiché à l'utilisateur
        $message = sprintf(_("Dernier traitement effectue le %s."), $date)." ".$message;
        // Mise à jour de la table dossier_géolocalisation
        $this->update_dossier_geolocalisation('recup_contrainte', $date_db, $correct, $message);
        // Ajoute les informations sur les traitements dans le tableau retourné
        $return['log'] = array(
            "date" => $date,
            "etat" => $correct,
            "message" => $message
        );
        // Ajoute les informations concernant les contraintes récupérées
        $return['dossier_contrainte'] = array(
            "nb_contrainte_sig" => count($listeDossierContrainteSIGAfter),
            "msg_contrainte_sig_empty" => _("Aucune contrainte ajoutee depuis le SIG"),
            "msg_contrainte_sig" => _("contrainte(s) ajoutee(s) depuis le SIG"),
        );
        // Retourne le résultat dans un tableau json
        echo json_encode($return);
        return;
    }

    /**
     * VIEW - geolocalisation_recup_contrainte.
     *
     * Permet de récupérer les contraintes et les affecter au dossier.
     *
     * @return void
     */
    public function geolocalisation_recup_contrainte_dossier($omCollectivite, $dossierIdx) {
        $correct = true;
        $message = '';
        $collectivite = $this->f->getCollectivite($omCollectivite);

        // Intérogation du web service du SIG
        try {
            $geoads = $this->get_geoads_instance($collectivite, $dossierIdx);
            $execute = $geoads->recup_contrainte_dossier($dossierIdx);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e);
            return;
        }

        // Initialisation des variables de comparaison
        $synchro = true;
        $ajouter = true;
        $supprimer = true;
        // Instancie la classe dossier_contrainte
        $dossier_contrainte_add = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_contrainte",
            "idx" => "]",
        ));

        // Récupère toutes les contraintes du dossier avant traitement
        $listeDossierContrainteSIG = $this->get_dossier_contrainte_SIG($dossierIdx);
        // Pour chaque contrainte;
        foreach ($execute as $key => $value) {
            // Vérifie que la contrainte est dans l'application
            $contrainte = $this->getContrainteByNumero($value['contrainte'], $omCollectivite);
            // Si la contrainte est vide
            if ($contrainte == "") {
                // Nécessite une synchronisation
                $synchro = false;
                break;
            }

            // Selon le connecteur, il est possible que le champ "texte" n'existe
            // pas ou soit vide dans la contrainte récupérée du SIG
            $texte_complete = $value['libelle'];
            if (array_key_exists("texte", $value) === true
                && $value['texte'] !== null
                && $value['texte'] !== '') {
                //
                $texte_complete = $value['texte'];
            }

            // Définit les valeurs
            $val = array(
                'dossier_contrainte' => ']',
                'dossier' => $dossierIdx,
                'contrainte' => $contrainte,
                'texte_complete' => $texte_complete,
                'reference' => true,
            );
            // Ajoute l'enregistrement
            $ajouter = $dossier_contrainte_add->ajouter($val);
            // Si erreur lors de l'ajout on sort de la boucle.
            if ($ajouter != true) {
                $ajouter = false;
                break;
            }
        }

        // On supprime les contraintes SIG déjà affectées au dossier
        if ($ajouter == true && $synchro == true) {
            // Si la liste des contraintes SIG déjà affectées au dossier
            if (count($listeDossierContrainteSIG) > 0) {
                // Pour chaque contrainte déjà affectées au dossier
                foreach ($listeDossierContrainteSIG as $dossier_contrainte_id) {
                    // Instancie la classe dossier_contrainte
                    $dossier_contrainte_del = $this->f->get_inst__om_dbform(array(
                        "obj" => "dossier_contrainte",
                        "idx" => $dossier_contrainte_id,
                    ));
                    // Valeurs de l'enregistrement
                    $value = array();
                    foreach ($dossier_contrainte_del->champs as $key => $champ) {
                        // Terme à chercher
                        $search_field = 'contrainte_';
                        // Si dans le champ le terme est trouvé
                        if (strpos($champ, $search_field) !== false) {
                            // Supprime le champ
                            unset($dossier_contrainte_del->champs[$key]);
                        } else {
                            // Récupère la valeur du champ
                            $value[$champ] = $dossier_contrainte_del->val[$key];
                        }
                    }
                    // Supprime l'enregistrement
                    $supprimer = $dossier_contrainte_del->supprimer($value);
                    // Si erreur lors de la suppression on sort de la boucle.
                    if ($supprimer != true) {
                        $supprimer = false;
                        break;
                    }
                }
            }
        }

        // Récupère toutes les contraintes du dossier après traitement
        $listeDossierContrainteSIGAfter = $this->get_dossier_contrainte_SIG($dossierIdx);

        // Si les contraintes ne sont pas synchronisées
        if ($synchro == false) {
            // Traitement du message
            $message = _("Les contraintes doivent etre synchronisees.");
            // État à false
            $correct = false;
        }
        
        if ($ajouter == false && $synchro == true) {
            // Traitement du message
            $message = _("Les contraintes n'ont pas ete ajoutees au dossier.");
            // État à false
            $correct = false;
        }
        
        if ($supprimer == false && $ajouter == true && $synchro == true) {
            // Traitement du message
            $message = _("Les anciennes contraintes n'ont pas ete supprimees.");
            // État à false
            $correct = false;
        }
        
        if ($synchro == false || $ajouter == false || $supprimer == false) {
            // Ajoute au message d'erreur
            $message .= " "._("Contactez votre administrateur.");
        }

        $date = date('d/m/Y H:i:s');
        $date_db = $this->f->formatTimestamp($date, false);
        if ($correct === true) {
            // Message affiché à l'utilisateur
            $message .= "Les contraintes ont été récupérées.";
            // Mise à jour de la table dossier_géolocalisation
        }
        $this->update_dossier_geolocalisation('recup_contrainte', $date_db, $correct, $message, $dossierIdx);

        return array(
            'message' => $message,
            'correct' => $correct,
            'listeDossierContrainteSIG' => $listeDossierContrainteSIGAfter
        );
    }


    /**
     * Récupérer la contrainte par le numéro de référence SIG.
     * 
     * @param string $numero Identifiant de la contrainte du SIG.
     * 
     * @return array          Tableau des résultats
     */
    public function getContrainteByNumero($numero, $omCollectivite) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    contrainte
                FROM
                    %1$scontrainte
                WHERE
                    reference = \'t\'
                    AND numero = \'%2$s\'
                    AND (
                        om_validite_fin > now()
                        OR om_validite_fin IS NULL
                    )
                    AND (
                        om_collectivite = %3$d
                        OR om_collectivite = %4$d
                    )
                ORDER BY
                    contrainte DESC',
                DB_PREFIXE,
                $this->f->db->escapeSimple($numero),
                intval($omCollectivite),
                intval($this->f->get_idx_collectivite_multi())
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }


    /**
     * Récupération des contraintes récupérées depuis le SIG liées au dossier
     * 
     * @return array Tableau des résultats
     */
    public function get_dossier_contrainte_SIG($dossierIdx = null) {
        if ($dossierIdx === null) {
            $dossierIdx = $this->getVal("dossier");
        }

        // Initialisation du tableau des résultats
        $listeDossierContrainteSIG = array();

        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    dossier_contrainte
                FROM 
                    %1$sdossier_contrainte
                WHERE 
                    dossier = \'%2$s\'
                    AND reference IS TRUE',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossierIdx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Pour chaque résultat
        foreach($qres['result'] as $row) {
            // Ajoute l'identifiant du lien dans le tableau des résultats
            $listeDossierContrainteSIG[] = $row['dossier_contrainte'];
        }

        // Tableau de résultat retourné
        return $listeDossierContrainteSIG;
    }


    /**
     * VIEW - view_geolocalisation.
     *
     * Redirige pour ouvrir le formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    public function view_geolocalisation() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        //
        $idx = $this->getVal($this->clePrimaire);

        require_once "../obj/dossier_geolocalisation.class.php";
        $dossier_geolocalisation = new dossier_geolocalisation(null, null, null, $this->getVal('dossier'));

        // Récupération des contraintes liées au DI
        $qres_contraintes = $this->f->get_all_results_from_db_query(
            sprintf(
                "SELECT 
                    dossier_contrainte, 
                    reference
                FROM 
                    %sdossier_contrainte
                WHERE 
                    dossier = '%s'",
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        //
        $geom = "";
        if ($this->getVal('geom') != '') {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT public.ST_AsText(\'%s\'::geometry)',
                    $this->f->db->escapeSimple($this->getVal('geom'))
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $geom = $qres["result"];
        }

        // Compteurs de contrainte manuelle et automatique
        $nb_contrainte_man = 0;
        $nb_contrainte_sig = 0;
        // Nombre de contrainte du DI
        foreach ($qres_contraintes['result'] as $row) {
            //
            if ($row['reference'] == 'f') {
                $nb_contrainte_man++;
            } else {
                $nb_contrainte_sig++;
            }
        }
        // Modifie les messages en fonction du nombre de contrainte
        if ($nb_contrainte_man == 0) {
            $msg_contrainte_man = _("Aucune contraintes ajoutees depuis l'application");
        } else {
            $msg_contrainte_man = $nb_contrainte_man." "._("contrainte(s) ajoutee(s) depuis l'application");
        }
        if ($nb_contrainte_sig == 0) {
            $msg_contrainte_sig = _("Aucune contraintes ajoutees depuis le SIG");
        } else {
            $msg_contrainte_sig = $nb_contrainte_sig." "._("contrainte(s) ajoutee(s) depuis le SIG");
        }
        $contrainte_val = "<span id='msg_contrainte_man'>".$msg_contrainte_man."</span>"."<br />".
            "<span id='msg_contrainte_sig'>".$msg_contrainte_sig."</span>";

        // Affichage du fil d'Ariane
        $this->f->displaySubTitle(_("Geolocalisation") . "->" . $this->getVal('dossier_libelle'));
        $this->f->display();

        // Message affiché
        $message_field = '<div class="message ui-widget ui-corner-all ui-state-highlight ui-state-%s" id="%s">
            <p>
                <span class="ui-icon ui-icon-info"></span> 
                <span class="text">%s<br></span>
            </p>
        </div>';

        // Message d'erreur si les références cadastrales ont été modifiées
        // dans le dossier d'instruction
        if ($dossier_geolocalisation->get_terrain_references_cadastrales_archive() != "" && 
            $dossier_geolocalisation->get_terrain_references_cadastrales_archive() != $this->getVal('terrain_references_cadastrales')) {
            
            if($this->getVal('terrain_references_cadastrales') != "") {

                $messageRefCadUtilisees = _("Les references cadastrales utilisees par le SIG")." : ".
                    $dossier_geolocalisation->get_terrain_references_cadastrales_archive();
            } else {
                $messageRefCadUtilisees = _("Aucune reference cadastrale n'est renseignee pour le SIG");
            }
            
            printf($message_field, "error", "geolocalisation-message",
                "<p>"._("Les references cadastrales ont ete modifiees dans le dossier d'instruction.")."</p>".
                "<p>".$messageRefCadUtilisees."</p>");
        }

        // Bouton retour
        $button_return = '<div class="formControls">
            <a id="retour-button" onclick="redirectPortletAction(1,\'main\'); refresh_page_return();" href="#" class="retour">Retour</a>
        </div>';

        // Affiche le bouton de retour
        printf($button_return);

        // Début du formulaire
        printf("\n<!-- ########## START FORMULAIRE ########## -->\n");
        printf("<div class=\"formEntete ui-corner-all\">\n");

        // Champ pour le bouton
        $button_field = '<div class="field field-type-static">
            <div class="form-libelle">
                <label id="lib-%1$s" class="libelle-%1$s" for="%1$s">
                %2$s
                </label>
            </div>
            <div class="form-content">
                <span id="%1$s" class="field_value">
                    %3$s  
                </span>
            </div>
        </div>';

        // Boutons d'action sur la géolocalisation
        $button = '<input type="submit" class="om-button ui-button ui-widget ui-state-default ui-corner-all" id="%s-button" value="%s" onclick="%s" role="button" aria-disabled="false">';

        $obj = $this->get_absolute_class_name();
        // Affiche le bouton permettant de lancer tous les traitements
        printf('<div class="alignBtnCenter">');
        printf($button, "chance", "J'ai de la chance", "all_geolocalisation_treatments('$obj', '$idx', '"._("Etes vous sur de vouloir recuperer les contraintes ?")."')");
        printf('</div>');

        // Tableau pour afficher l'interface sur deux colonnes
        printf("<div class='sousform-geolocalisation'><div class='list-buttons-geolocalisation'>");

        //Affichage des boutons
        $rowDonneesSIG = $dossier_geolocalisation->get_geolocalisation_state('verif_parcelle');
        printf($button_field, 'verif_parcelle', sprintf($button, 'verif_parcelle', "Vérifier les parcelles", "geolocalisation_treatment('$obj', '$idx', 'verif_parcelle', set_geolocalisation_message)"), $this->build_message('verif_parcelle', $message_field, $rowDonneesSIG));
        $rowDonneesSIG = $dossier_geolocalisation->get_geolocalisation_state('calcul_emprise');
        printf($button_field, 'calcul_emprise', sprintf($button, 'calcul_emprise', "Calculer l'emprise", "geolocalisation_treatment('$obj', '$idx', 'calcul_emprise', '')"), $this->build_message('calcul_emprise', $message_field, $rowDonneesSIG));
        $rowDonneesSIG = $dossier_geolocalisation->get_geolocalisation_state('dessin_emprise');
        printf($button_field, 'dessin_emprise', sprintf($button, 'dessin_emprise', "Dessiner l'emprise", "geolocalisation_treatment('$obj', '$idx', 'dessin_emprise', redirection_web_sig)"), $this->build_message('dessin_emprise', $message_field, $rowDonneesSIG));
        $rowDonneesSIG = $dossier_geolocalisation->get_geolocalisation_state('calcul_centroide');
        printf($button_field, 'calcul_centroide', sprintf($button, 'calcul_centroide', "Calculer le centroïde", "geolocalisation_treatment('$obj', '$idx', 'calcul_centroide', set_geolocalisation_centroide)"), $this->build_message('calcul_centroide', $message_field, $rowDonneesSIG));
        $rowDonneesSIG = $dossier_geolocalisation->get_geolocalisation_state('recup_contrainte');
        printf($button_field, 'recup_contrainte', sprintf($button, 'recup_contrainte', "Récupérer les contraintes", "geolocalisation_treatment('$obj', '$idx', 'recup_contrainte', set_geolocalisation_contrainte, '"._("Etes vous sur de vouloir recuperer les contraintes ?")."')"), $this->build_message('recup_contrainte', $message_field, $rowDonneesSIG));

        //
        printf("</div>");

        // Le formulaire n'a pas été validé
        $validation = 1;
        // Le formulaire est en mode consultation
        $maj = 3;

        // Champs du formulaire
        $champs = array("centroide", "contrainte", "adresse", "references_cadastrales");

        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => $validation,
            "maj" => $maj,
            "champs" => $champs,
        ));

        // Configuration des types de champs
        foreach ($champs as $key) {
            $form->setType($key, 'static');
        }
        $form->setType("references_cadastrales", "referencescadastralesstatic");

        // Configuration des libellés
        $form->setLib("references_cadastrales", _("terrain_references_cadastrales"));
        $form->setLib("adresse", _("adresse"));
        $form->setLib("centroide", _("centroide"));
        $form->setLib("contrainte", _("contrainte"));

        // Configuration des données
        $form->setVal("references_cadastrales", $this->getVal("terrain_references_cadastrales"));
        $address_val = sprintf('%s %s %s %s %s %s %s',
            $this->getVal('terrain_adresse_voie_numero'),
            $this->getVal('terrain_adresse_voie'),
            $this->getVal('terrain_adresse_lieu_dit'),
            $this->getVal('terrain_adresse_localite'),
            $this->getVal('terrain_adresse_code_postal'),
            $this->getVal('terrain_adresse_bp'),
            $this->getVal('terrain_adresse_cedex')
        );
        if ($this->getVal('adresse_normalisee') !== null
            && $this->getVal('adresse_normalisee') !== '') {
            //
            $address_val = $this->getVal('adresse_normalisee');
        }
        $form->setVal("adresse", trim(preg_replace('/\s\s+/', ' ', $address_val)));
        if($geom != "") {
            $form->setVal('centroide', $this->getGeolocalisationLink());
        } else {
            $form->setVal('centroide', $geom);
        }
        $form->setVal("contrainte", $contrainte_val);

        // Affichage des champs
        $form->setBloc("centroide", "D", _("Donnees du dossier d'instruction"), "alignForm col_12");
            $form->setBloc("centroide", "DF", "", "geoloc_form alignForm col_12");
            $form->setBloc("contrainte", "DF", "", "geoloc_form alignForm col_12");
            $form->setBloc("adresse", "DF", "", "geoloc_form alignForm col_12");
            $form->setBloc("references_cadastrales", "DF", "", "geoloc_form alignForm col_12");
        $form->setBloc("references_cadastrales", "F");

        $form->afficher($champs, $validation, false, false);
        // Ferme le tableau pour l'affichage sur deux colonnes
        printf("</div></div>");

        //Ajout d'un div vide pour éviter les superspositions des div
        printf("<div class=\"both\"></div>");

        // Fin du formulaire
        printf("</div></div>");

        // Affiche le bouton de retour
        printf($button_return);
    }


    /**
     * Compose le message affiché à l'utilisateur.
     * 
     * @param  string $field_name    Nom du champ.
     * @param  string $message_field Code html du message.
     * @param  mixed  $rowDonneesSIG Tableau des données.
     * 
     * @return string Message.
     */
    private function build_message($field_name, $message_field, $rowDonneesSIG) {

        // Récupération des infos
        $date = "";
        if (isset($rowDonneesSIG["date"])) {
            $date = $this->f->formatTimestamp($rowDonneesSIG["date"]);
        }
        $etat = "";
        if (isset($rowDonneesSIG["etat"])) {
            $etat = $rowDonneesSIG["etat"];
        }
        $text = "";
        if (isset($rowDonneesSIG["message"])) {
            $text = $rowDonneesSIG["message"];
        }

        // id du message
        $id_message = $field_name."-message";

        // Définit le type du message "empty", "valid" ou "error"
        // empty : message grisé
        // valid : message de validation
        // error : message d'erreur
        $type_message = "empty";
        if ($etat != "") {
            //
            $type_message = "valid";
            if ($etat == 'f') {
                $type_message = "error";
            }
        }

        // Si il y a une date, un message est ajouté en debut
        if ($date != "") {
            //
            $date = sprintf(_("Dernier traitement effectue le %s."), $date);
        }
        
        // Si aucun message alors l'action n'a jamais été effectuée
        if ($text == "") {
            //
            $text = _("Action non effectuee.");
            //
            $type_message = "empty";
        }

        // Compose le message
        $message = sprintf($message_field, $type_message, $id_message, $date." ".$text);

        // retour
        return $message;
    }


    /**
     * Affichage du widget dossiers_evenement_retour_finalise.
     *
     * Recherche à l'aide d'une requête les dossiers dont le dernier événement d'instruction
     * (hors événement retour) est de type arrêté finalisé ou changement de décision
     * et que les dates de retour de signature, envoi AR, notification et
     * contrôle de légalité de cet événement d'instruction ne sont pas remplies
     * que le dossier est en cours, qu'il est instruit par la communauté 
     * et que l'utilisateur connecté est un instructeur de la même commune que le dossier.
     * Tri les dossiers par date d'événement.
     *
     * Affiche dans un tableau les 5 premiers résultats obtenus.
     * 
     * @return boolean indique si la recherche a reussi et si des dossiers
     * sont concernés sinon renvoie false
     */
    function view_widget_dossiers_evenement_retour_finalise() {

        // Création de la requête de récupération des dossiers
        //
        // On recherche les dossiers dont le dernier événement d'instruction (hors événement retour)
        // est de type arrêté finalisé ou changement de décision
        // et que les dates de retour de signature, envoi AR, notification et
        // contrôle de légalité de cet événement d'instruction ne sont pas remplies
        // que le dossier est en cours, qu'il est instruit par la communauté 
        // et que l'utilisateur connecté est un instructeur de la même commune que le dossier

        // /!\ Requête lié à celles permettant de savoir si l'instructeur peut changer la
        // décision et à l'affichage du listing des dossiers éligibles au changement :
        //   * instruction.class.php : isInstrCanChangeDecision()
        //   * dossier_instruction.inc.php : si le paramètre filtre_decision = true
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier,
                    dossier.dossier_libelle,
                    CASE WHEN dossier.instructeur IS NOT NULL
                        THEN CONCAT(instructeur.nom, \' (\', division.libelle, \')\')
                    END as nom_instructeur,
                    CASE WHEN incomplet_notifie IS TRUE AND incompletude IS TRUE
                        THEN dossier.date_limite_incompletude
                        ELSE dossier.date_limite
                    END as date_limite_na,
                    COALESCE(demandeur.particulier_nom, demandeur.personne_morale_denomination) AS nom_petitionnaire
                FROM
                    %1$sdossier
                    JOIN %1$setat
                        ON dossier.etat = etat.etat AND etat.statut = \'encours\'
                    JOIN %1$slien_dossier_demandeur
                        ON dossier.dossier = lien_dossier_demandeur.dossier
                            AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
                    JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
                    JOIN %1$sinstruction
                        -- Recherche de la dernière instruction qui ne soit pas liée à un événement retour
                        ON instruction.instruction = (
                                SELECT
                                    instruction
                                FROM
                                    %1$sinstruction
                                    JOIN %1$sevenement
                                        ON instruction.evenement=evenement.evenement
                                        AND evenement.retour IS FALSE
                                WHERE
                                    instruction.dossier = dossier.dossier
                                ORDER BY
                                    date_evenement DESC,
                                    instruction DESC
                                LIMIT 1
                            )
                            -- On ne garde que les dossiers pour lesquels la dernière instruction est finalisée
                            -- ou alors pour laquelle l instruction a été ajouté par la commune et est
                            -- non signée, non notifié, etc.
                            AND (instruction.om_final_instruction IS TRUE
                                OR instruction.created_by_commune IS TRUE)
                            AND instruction.date_retour_signature IS NULL
                            AND instruction.date_envoi_rar IS NULL
                            AND instruction.date_retour_rar IS NULL
                            AND instruction.date_envoi_controle_legalite IS NULL
                            AND instruction.date_retour_controle_legalite IS NULL
                    -- On vérifie que l instruction soit un arrêté ou un changement de décision
                    JOIN %1$sevenement
                        ON instruction.evenement=evenement.evenement
                            AND (evenement.type = \'arrete\'
                                OR evenement.type = \'changement_decision\')
                    -- Recherche les informations du pétitionnaire principal pour l affichage
                    JOIN %1$sdemandeur
                        ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                    -- Recherche la collectivité rattachée à l instructeur
                    JOIN %1$sinstructeur
                        ON dossier.instructeur=instructeur.instructeur
                    JOIN %1$sdivision
                        ON instructeur.division=division.division
                    JOIN %1$sdirection
                        ON division.direction=direction.direction
                    JOIN %1$som_collectivite
                        ON direction.om_collectivite=om_collectivite.om_collectivite
                WHERE
                    -- Les sous_dossier ne doivent pas être pris en compte
                    dossier_instruction_type.sous_dossier IS NOT TRUE
                    -- Vérification que la décision a été prise par l agglo
                    AND om_collectivite.niveau = \'2\'
                    %2$s
                    ORDER BY
                        date_evenement DESC 
                    LIMIT 5',
                DB_PREFIXE,
                // Si collectivité de l'utilisateur niveau mono alors filtre sur celle-ci
                ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) ?
                    sprintf(' AND dossier.om_collectivite = %d', intVal($_SESSION['collectivite'])) :
                    ""
            ),
            array(
                "origin" => __METHOD__,
            )
        );
         
        // Exécution de la requête
        $nb_result = $qres['row_count'];
        // Ouverture conteneur
        echo '<div id="view_widget_dossiers_evenement_retour_finalise">';
        // Affiche des données résultats
        if ($nb_result > 0) {
            echo '<table class="tab-tab">';
            // Entête de tableau
            echo '<thead>';
                echo '<tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">';
                    echo '<th class="title col-0 firstcol">';
                        echo '<span class="name">';
                            echo _('dossier');
                        echo '</span>';
                    echo '</th>';
                    echo '<th class="title col-0 firstcol">';
                        echo '<span class="name">';
                            echo _('petitionnaire');
                        echo '</span>';
                    echo '</th>';
                    echo '<th class="title col-0 firstcol">';
                        echo '<span class="name">';
                            echo _('instructeur');
                        echo '</span>';
                    echo '</th>';
                echo '</tr>';
            echo '</thead>';
           
            echo '<tbody>';
           
            // Données dans le tableau
            foreach($qres['result'] as $row) {
         
                echo '<tr class="tab-data odd">';
                    // Numéro de dossier
                    echo '<td class="col-1 firstcol">';
                        echo '<a class="lienTable"
                            href="'.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx='.$row["dossier"].'&amp;premier=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab">'
                                .$row["dossier_libelle"]
                            .'</a>';
                    echo '</td>';
                   
                    // Nom du pétitionnaire
                    echo '<td class="col-1">';
                        echo '<a class="lienTable"
                            href="'.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx='.$row["dossier"].'&amp;premier=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab">'
                                .$row["nom_petitionnaire"]
                            .'</a>';
                    echo '</td>';
                   
                    // Instructeur
                    echo '<td class="col-2 lastcol">';
                        echo '<a class="lienTable"
                            href="'.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx='.$row["dossier"].'&amp;premier=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab">'
                                .$row["nom_instructeur"]
                            .'</a>';
                    echo '</td>';
                   
                echo "</tr>";
            }
         
            echo '</tbody>';
         
            echo '</table>';
            if ($nb_result > 5 && $this->f->isAccredited(array("dossier_instruction", "dossier_instruction_tab"), "OR")) {
                $link = OM_ROUTE_TAB.'&obj=dossier_instruction&decision=true';
                $title = _("Voir tous les dossiers");
                printf('<br/><a href="%s">%s</a>', $link, $title);
            }
        }
        else{
            echo _("Vous n'avez pas de dossier pour lequel on peut proposer une autre decision.");
            echo '</div>';
            return true;
        }
        // Fermeture conteneur
        echo '</div>';
        return false;
    }


    /**
     * VIEW - view_get_log_di
     *
     * Affiche le tableau des logs des événements d'instruction du DI.
     *
     * @return Faux
     */
    public function view_get_log_di() {
        // On récupère les logs
        $logs = $this->get_log_instructions();
        
        // On crée un tableau avec chacune des valeur du journal d'ínstruction
        $rows = array();

        // Pour chaque entrée du dossier d'instruction, on associe les donnés à leur libellé
        foreach ($logs as $log) {
            $cells = array();
            $cells[_('date')] = $log["date"];
            $cells[_('id')] = $log["values"]["instruction"];
            $cells[_('contexte')] = $log["action"];
            $cells[_('login')] = $log["user"];
            $cells[_('date_evenement')] = $log["values"]["date_evenement"];
            $cells[_('retour RAR')] = $log["values"]["date_retour_rar"];
            $cells[_('retour signature')] = $log["values"]["date_retour_signature"];
            $cells[_('evenement')] = $log["values"]["evenement"];
            $cells[_('action')] = $log["values"]["action"];
            $cells[_('etat')] = $log["values"]["etat"];
            $rows[] = $cells;
        }
        // On retourne un tableau que l'on convertit au format json
        return json_encode($rows);
    }

    /**
     * Récupère la liste des événements d'instruction du dossier
     * 
     * @param  boolean $no_display si vrai alors on exclut ceux de type affichage
     * @return array               tableau indexé des clés primaires des instructions
     */
    function get_list_instructions($no_display = false) {
        // Initialisation de la variable de retour
        $result = array();

        // SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    instruction.instruction AS id_instruction
                FROM 
                    %1$sinstruction
                    JOIN %1$sevenement
                        ON instruction.evenement = evenement.evenement
                WHERE
                    instruction.dossier = \'%2$s\'
                    %3$s
                ORDER BY instruction ASC',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire)),
                // on n'accepte que les événements sans type ou de type différent qu'affichage
                ($no_display === true) ?
                    " AND (evenement.type != 'affichage' OR evenement.type IS NULL) " :
                    ""
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Récupère les résultats dans un tableau
        foreach ($qres['result'] as $row) {
            //
            $result[] = $row['id_instruction'];
        }

        // Retourne le tableau de résultat
        return $result;
    }

    /**
     * Récupère le numéro d'instruction du récépissé de demande.
     *
     * @return integer
     */
    function get_demande_instruction_recepisse() {
        // Instance de demande
        $demande = $this->get_inst_demande();

        // Récupère la valeur du champ instruction_recepisse
        $instruction_recepisse = $demande->getVal('instruction_recepisse');

        //
        return $instruction_recepisse;
    }

    /**
     * Récupère l'instance de l'instruction.
     *
     * @param integer $instruction Identifiant de l'instruction obligatoire.
     *
     * @return object
     */
    public function get_inst_instruction($instruction) {
        //
        return $this->get_inst_common("instruction", $instruction);
    }


    /**
     * VIEW - view_localiser
     * Redirige l'utilisateur vers le SIG externe.
     *
     * @return void
     */
    public function view_localiser() {

        // Vérifie que l'option est activée
        if($this->is_option_external_sig_enabled() === false) {
            // On affiche un message d'erreur
            $this->f->displayMessage('error', _("La localisation SIG n'est pas activée pour cette commune."));
            // On redirige l'utilisateur vers la fiche du dossier en consultation
            $this->setParameter("maj", 3);
            $this->formulaire();
            return false;
        }

        // On récupère les informations de la collectivité du dossier
        $collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));
        // identifiant du dossier
        $idx = $this->getVal($this->clePrimaire);

        // Instance geoads
        try {
            $geoads = $this->get_geoads_instance($collectivite, $idx);
        } catch(Exception $e) {
                $this->addToLog(
                    __METHOD__."() échec de l'instanciation du connecteur SIG. ".
                    gettype($e).": ".$e->getMessage(), DEBUG_MODE);
                $this->handle_geoads_exception($e, $idx);
        }
        if(empty($geoads)) {
            // L'erreur geoads est affichée dans la méthode handle_geoads_exception
            // On redirige l'utilisateur vers la fiche du dossier en consultation
            $this->setParameter("maj", 3);
            $this->formulaire();
            return false;
        }

        // Si des références cadastrales ont été définies, ont les prépares
        $tabParcelles = null;
        if (! empty($this->getVal('terrain_references_cadastrales'))) {
            $tabParcelles = $this->f->parseParcelles(
                $this->getVal('terrain_references_cadastrales'),
                $this->getVal('om_collectivite')
            );
        }

        try {

            // redirection vers le sig
            $url = $geoads->redirection_web($tabParcelles, $idx);

            // Redirection
            header("Location: ".$url);

        } catch(Exception $e) {
                $this->addToLog(
                    __METHOD__."() échec de la redirection web du connecteur SIG. ".
                    gettype($e).": ".$e->getMessage(), DEBUG_MODE);
                $this->handle_geoads_exception($e, $idx);
                // L'erreur geoads est affichée dans la méthode handle_geoads_exception
                // On redirige l'utilisateur vers la fiche du dossier en consultation
                $this->setParameter("maj", 3);
                $this->formulaire();
                return false;
        }
    }

    /**
     * VIEW - formulaire.
     *
     * Surcharge de la méthode afin de sauvegarder le dossier consulté dans une
     * variable de session.
     *
     * @return void
     */
    function formulaire() {
        parent::formulaire();

        /**
         * Sauvegarde en session l'identifiant du dossier consulté
         */
        // Récupère l'identifiant du dossier
        $id_di = $this->getVal($this->clePrimaire);
        if (isset($_SESSION['dossiers_consulte']) !== false) {
            if(count($_SESSION['dossiers_consulte']) >= 20) {
                // Dépile l'élément au début du tableau
                array_shift($_SESSION['dossiers_consulte']);
            }

            if (in_array($id_di, $_SESSION['dossiers_consulte']) === true) {
                // Supprime la clé qui est déjà présente
                unset($_SESSION['dossiers_consulte'][$id_di]);
                // Ajoute à nouveau le dossier afin qu'il soit en fin du tableau
                // Utilisation d'un méthode de reverse lors de l'affichage
                $_SESSION['dossiers_consulte'][$id_di] = $id_di;
            } else {
                $_SESSION['dossiers_consulte'][$id_di] = $id_di;
            }
        } else {
            // Ajoute le dossier au tableau
            $_SESSION['dossiers_consulte'][$id_di] = $id_di;
        }
    }

    /**
     * Mutateur pour la propriété 'onchange'.
     *
     * @param string $form
     * @param string $maj
     *
     * @return void
     */
    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);
        //
        if ($maj == '1') {
            $idDossier = $this->getVal($this->clePrimaire);
            $form->setOnchange("instructeur", "changementDivision(this.value, '".$idDossier."')");
        }
    }

    /**
     * Récupère l'identifiant d'un instructeur et fait une requête
     * pour déterminer l'id de la division de cet instructeur.
     * Si aucun id d'instructeur n'est donné alors cette méthode renvoie
     * une chaine vide ''.
     *
     * @param integer identifiant de l'instructeur
     * @return integer identifiant de la division
     */
    function recuperation_division_instructeur($idInstructeur) {
        // Vérifie qu'un id d'instructeur a bien été passé en paramètre
        if ($idInstructeur == null || $idInstructeur == '' || ! is_numeric($idInstructeur)) {
            return '';
        }
        // Récupération de l'identifiant de la division
        $inst_instructeur = $this->f->get_inst__om_dbform(array(
            "obj" => "instructeur",
            "idx" => $idInstructeur,
        ));
        return $inst_instructeur->getVal("division");
    }

    /**
     * Récupère un identifiant d'instructeur passé dans le paramètre
     * instructeurId. A partir de cet identifiant récupère le numéro
     * de division de l'instructeur, le stockke dans un json et l'affiche.
     *
     * @return json
     */
    function get_division_instructeur() {
        // Récupération de l'id de l'instructeur dans le get
        $idInstructeur = $this->f->get_submitted_get_value('instructeurId');
        // Récupération de l'id de la division de l'instructeur
        if ($idInstructeur == null || $idInstructeur == '') {
            echo json_encode(array('division' => ''));
            return;
        }
        $idDivision = $this->recuperation_division_instructeur($idInstructeur);
        // Json récupèrer à l'aide d'une ajax dans le js changementDivision()
        // ce qui va permettre de mettre à jour la division
        echo json_encode(array('division' => $idDivision));
    }


    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // suppression de la géolocalisation du dossier dans le SIG
        $omCollectivite = $this->getVal('om_collectivite');
        if ($this->f->is_option_sig_enabled($omCollectivite) === true
            && ! empty($this->getVal('geom'))) {
            $dossierIdx = $this->getVal($this->clePrimaire);
            try {
                if ($this->geolocalisation_supprime_emprise(intval($omCollectivite), $dossierIdx) === false) {
                    $this->addToMessage(
                        __("Le dossier d'instruction ne peut pas être supprimé").
                        ' ('.__("échec de la suppression de sa géolocalisation").').');
                    return false;
                }
                // vidage du geom pour marquer le dossier comme plus géolocalisé
                $valF = array('geom' => null);
                $cle = " dossier='".$dossierIdx."'";
                $res = $this->f->db->autoExecute(
                    DB_PREFIXE.'dossier', $valF, DB_AUTOQUERY_UPDATE, $cle);
                $this->addToLog(__METHOD__."(): db->autoexecute(\""
                    .DB_PREFIXE."dossier\", ".print_r($valF, true)
                    .", DB_AUTOQUERY_UPDATE, \"".$cle."\");", VERBOSE_MODE);
                $this->f->isDatabaseError($res);
                $this->f->db->commit(); // commit pour être sûr que le geom est vidé
                $this->addToLog(__METHOD__."(): db->commit()", VERBOSE_MODE);
            }
            catch(geoads_connector_method_not_implemented_exception $e) {
                // ne pas déclencher d'erreur en cas de méthode non-implémentée
            }
        }

        return parent::triggersupprimer($id, $dnu1, $val, $dnu2);
    }
}

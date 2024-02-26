<?php
//$Id$ 
//gen openMairie le 07/03/2023 15:07

require_once "../obj/om_dbform.class.php";

class evenement_gen extends om_dbform {

    protected $_absolute_class_name = "evenement";

    var $table = "evenement";
    var $clePrimaire = "evenement";
    var $typeCle = "N";
    var $required_field = array(
        "evenement",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
        "action" => array("action", ),
        "autorite_competente" => array("autorite_competente", ),
        "avis_decision" => array("avis_decision", ),
        "etat" => array("etat", ),
        "evenement" => array("evenement", ),
        "pec_metier" => array("pec_metier", ),
        "phase" => array("phase", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("libelle");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "evenement",
            "libelle",
            "action",
            "etat",
            "delai",
            "accord_tacite",
            "delai_notification",
            "lettretype",
            "consultation",
            "avis_decision",
            "restriction",
            "type",
            "evenement_retour_ar",
            "evenement_suivant_tacite",
            "evenement_retour_signature",
            "autorite_competente",
            "retour",
            "non_verrouillable",
            "phase",
            "finaliser_automatiquement",
            "pec_metier",
            "commentaire",
            "non_modifiable",
            "non_supprimable",
            "notification",
            "envoi_cl_platau",
            "signataire_obligatoire",
            "notification_service",
            "notification_tiers",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_action() {
        return "SELECT action.action, action.libelle FROM ".DB_PREFIXE."action ORDER BY action.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_action_by_id() {
        return "SELECT action.action, action.libelle FROM ".DB_PREFIXE."action WHERE action = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente ORDER BY autorite_competente.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente_by_id() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente WHERE autorite_competente = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision() {
        return "SELECT avis_decision.avis_decision, avis_decision.libelle FROM ".DB_PREFIXE."avis_decision ORDER BY avis_decision.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_by_id() {
        return "SELECT avis_decision.avis_decision, avis_decision.libelle FROM ".DB_PREFIXE."avis_decision WHERE avis_decision = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat ORDER BY etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_by_id() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat WHERE etat = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_ar() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_ar_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_signature() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_retour_signature_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_pec_metier() {
        return "SELECT pec_metier.pec_metier, pec_metier.libelle FROM ".DB_PREFIXE."pec_metier WHERE ((pec_metier.om_validite_debut IS NULL AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)) OR (pec_metier.om_validite_debut <= CURRENT_DATE AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE))) ORDER BY pec_metier.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_pec_metier_by_id() {
        return "SELECT pec_metier.pec_metier, pec_metier.libelle FROM ".DB_PREFIXE."pec_metier WHERE pec_metier = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_phase() {
        return "SELECT phase.phase, phase.code FROM ".DB_PREFIXE."phase WHERE ((phase.om_validite_debut IS NULL AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE)) OR (phase.om_validite_debut <= CURRENT_DATE AND (phase.om_validite_fin IS NULL OR phase.om_validite_fin > CURRENT_DATE))) ORDER BY phase.code ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_phase_by_id() {
        return "SELECT phase.phase, phase.code FROM ".DB_PREFIXE."phase WHERE phase = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = ""; // -> requis
        } else {
            $this->valF['evenement'] = $val['evenement'];
        }
        $this->valF['libelle'] = $val['libelle'];
        if ($val['action'] == "") {
            $this->valF['action'] = NULL;
        } else {
            $this->valF['action'] = $val['action'];
        }
        if ($val['etat'] == "") {
            $this->valF['etat'] = NULL;
        } else {
            $this->valF['etat'] = $val['etat'];
        }
        if (!is_numeric($val['delai'])) {
            $this->valF['delai'] = NULL;
        } else {
            $this->valF['delai'] = $val['delai'];
        }
        if ($val['accord_tacite'] == "") {
            $this->valF['accord_tacite'] = ""; // -> default
        } else {
            $this->valF['accord_tacite'] = $val['accord_tacite'];
        }
        if (!is_numeric($val['delai_notification'])) {
            $this->valF['delai_notification'] = NULL;
        } else {
            $this->valF['delai_notification'] = $val['delai_notification'];
        }
        if ($val['lettretype'] == "") {
            $this->valF['lettretype'] = ""; // -> default
        } else {
            $this->valF['lettretype'] = $val['lettretype'];
        }
        if ($val['consultation'] == "") {
            $this->valF['consultation'] = ""; // -> default
        } else {
            $this->valF['consultation'] = $val['consultation'];
        }
        if (!is_numeric($val['avis_decision'])) {
            $this->valF['avis_decision'] = NULL;
        } else {
            $this->valF['avis_decision'] = $val['avis_decision'];
        }
        if ($val['restriction'] == "") {
            $this->valF['restriction'] = NULL;
        } else {
            $this->valF['restriction'] = $val['restriction'];
        }
        if ($val['type'] == "") {
            $this->valF['type'] = NULL;
        } else {
            $this->valF['type'] = $val['type'];
        }
        if (!is_numeric($val['evenement_retour_ar'])) {
            $this->valF['evenement_retour_ar'] = NULL;
        } else {
            $this->valF['evenement_retour_ar'] = $val['evenement_retour_ar'];
        }
        if (!is_numeric($val['evenement_suivant_tacite'])) {
            $this->valF['evenement_suivant_tacite'] = NULL;
        } else {
            $this->valF['evenement_suivant_tacite'] = $val['evenement_suivant_tacite'];
        }
        if (!is_numeric($val['evenement_retour_signature'])) {
            $this->valF['evenement_retour_signature'] = NULL;
        } else {
            $this->valF['evenement_retour_signature'] = $val['evenement_retour_signature'];
        }
        if (!is_numeric($val['autorite_competente'])) {
            $this->valF['autorite_competente'] = NULL;
        } else {
            $this->valF['autorite_competente'] = $val['autorite_competente'];
        }
        if ($val['retour'] == 1 || $val['retour'] == "t" || $val['retour'] == "Oui") {
            $this->valF['retour'] = true;
        } else {
            $this->valF['retour'] = false;
        }
        if ($val['non_verrouillable'] == 1 || $val['non_verrouillable'] == "t" || $val['non_verrouillable'] == "Oui") {
            $this->valF['non_verrouillable'] = true;
        } else {
            $this->valF['non_verrouillable'] = false;
        }
        if (!is_numeric($val['phase'])) {
            $this->valF['phase'] = NULL;
        } else {
            $this->valF['phase'] = $val['phase'];
        }
        if ($val['finaliser_automatiquement'] == 1 || $val['finaliser_automatiquement'] == "t" || $val['finaliser_automatiquement'] == "Oui") {
            $this->valF['finaliser_automatiquement'] = true;
        } else {
            $this->valF['finaliser_automatiquement'] = false;
        }
        if (!is_numeric($val['pec_metier'])) {
            $this->valF['pec_metier'] = NULL;
        } else {
            $this->valF['pec_metier'] = $val['pec_metier'];
        }
        if ($val['commentaire'] == 1 || $val['commentaire'] == "t" || $val['commentaire'] == "Oui") {
            $this->valF['commentaire'] = true;
        } else {
            $this->valF['commentaire'] = false;
        }
        if ($val['non_modifiable'] == 1 || $val['non_modifiable'] == "t" || $val['non_modifiable'] == "Oui") {
            $this->valF['non_modifiable'] = true;
        } else {
            $this->valF['non_modifiable'] = false;
        }
        if ($val['non_supprimable'] == 1 || $val['non_supprimable'] == "t" || $val['non_supprimable'] == "Oui") {
            $this->valF['non_supprimable'] = true;
        } else {
            $this->valF['non_supprimable'] = false;
        }
        if ($val['notification'] == "") {
            $this->valF['notification'] = NULL;
        } else {
            $this->valF['notification'] = $val['notification'];
        }
        if ($val['envoi_cl_platau'] == 1 || $val['envoi_cl_platau'] == "t" || $val['envoi_cl_platau'] == "Oui") {
            $this->valF['envoi_cl_platau'] = true;
        } else {
            $this->valF['envoi_cl_platau'] = false;
        }
        if ($val['signataire_obligatoire'] == 1 || $val['signataire_obligatoire'] == "t" || $val['signataire_obligatoire'] == "Oui") {
            $this->valF['signataire_obligatoire'] = true;
        } else {
            $this->valF['signataire_obligatoire'] = false;
        }
        if ($val['notification_service'] == 1 || $val['notification_service'] == "t" || $val['notification_service'] == "Oui") {
            $this->valF['notification_service'] = true;
        } else {
            $this->valF['notification_service'] = false;
        }
        if ($val['notification_tiers'] == "") {
            $this->valF['notification_tiers'] = NULL;
        } else {
            $this->valF['notification_tiers'] = $val['notification_tiers'];
        }
    }

    //=================================================
    //cle primaire automatique [automatic primary key]
    //==================================================

    function setId(&$dnu1 = null) {
    //numero automatique
        $this->valF[$this->clePrimaire] = $this->f->db->nextId(DB_PREFIXE.$this->table);
    }

    function setValFAjout($val = array()) {
    //numero automatique -> pas de controle ajout cle primaire
    }

    function verifierAjout($val = array(), &$dnu1 = null) {
    //numero automatique -> pas de verfication de cle primaire
    }

    //==========================
    // Formulaire  [form]
    //==========================
    /**
     *
     */
    function setType(&$form, $maj) {
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("evenement", "hidden");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("action", $this->retourformulaire)) {
                $form->setType("action", "selecthiddenstatic");
            } else {
                $form->setType("action", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            $form->setType("delai", "text");
            $form->setType("accord_tacite", "text");
            $form->setType("delai_notification", "text");
            $form->setType("lettretype", "text");
            $form->setType("consultation", "text");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("restriction", "text");
            $form->setType("type", "text");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_retour_ar", "selecthiddenstatic");
            } else {
                $form->setType("evenement_retour_ar", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_retour_signature", "selecthiddenstatic");
            } else {
                $form->setType("evenement_retour_signature", "select");
            }
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("retour", "checkbox");
            $form->setType("non_verrouillable", "checkbox");
            if ($this->is_in_context_of_foreign_key("phase", $this->retourformulaire)) {
                $form->setType("phase", "selecthiddenstatic");
            } else {
                $form->setType("phase", "select");
            }
            $form->setType("finaliser_automatiquement", "checkbox");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("commentaire", "checkbox");
            $form->setType("non_modifiable", "checkbox");
            $form->setType("non_supprimable", "checkbox");
            $form->setType("notification", "text");
            $form->setType("envoi_cl_platau", "checkbox");
            $form->setType("signataire_obligatoire", "checkbox");
            $form->setType("notification_service", "checkbox");
            $form->setType("notification_tiers", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("evenement", "hiddenstatic");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("action", $this->retourformulaire)) {
                $form->setType("action", "selecthiddenstatic");
            } else {
                $form->setType("action", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            $form->setType("delai", "text");
            $form->setType("accord_tacite", "text");
            $form->setType("delai_notification", "text");
            $form->setType("lettretype", "text");
            $form->setType("consultation", "text");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("restriction", "text");
            $form->setType("type", "text");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_retour_ar", "selecthiddenstatic");
            } else {
                $form->setType("evenement_retour_ar", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_retour_signature", "selecthiddenstatic");
            } else {
                $form->setType("evenement_retour_signature", "select");
            }
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("retour", "checkbox");
            $form->setType("non_verrouillable", "checkbox");
            if ($this->is_in_context_of_foreign_key("phase", $this->retourformulaire)) {
                $form->setType("phase", "selecthiddenstatic");
            } else {
                $form->setType("phase", "select");
            }
            $form->setType("finaliser_automatiquement", "checkbox");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("commentaire", "checkbox");
            $form->setType("non_modifiable", "checkbox");
            $form->setType("non_supprimable", "checkbox");
            $form->setType("notification", "text");
            $form->setType("envoi_cl_platau", "checkbox");
            $form->setType("signataire_obligatoire", "checkbox");
            $form->setType("notification_service", "checkbox");
            $form->setType("notification_tiers", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("evenement", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("action", "selectstatic");
            $form->setType("etat", "selectstatic");
            $form->setType("delai", "hiddenstatic");
            $form->setType("accord_tacite", "hiddenstatic");
            $form->setType("delai_notification", "hiddenstatic");
            $form->setType("lettretype", "hiddenstatic");
            $form->setType("consultation", "hiddenstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("restriction", "hiddenstatic");
            $form->setType("type", "hiddenstatic");
            $form->setType("evenement_retour_ar", "selectstatic");
            $form->setType("evenement_suivant_tacite", "selectstatic");
            $form->setType("evenement_retour_signature", "selectstatic");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("retour", "hiddenstatic");
            $form->setType("non_verrouillable", "hiddenstatic");
            $form->setType("phase", "selectstatic");
            $form->setType("finaliser_automatiquement", "hiddenstatic");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("commentaire", "hiddenstatic");
            $form->setType("non_modifiable", "hiddenstatic");
            $form->setType("non_supprimable", "hiddenstatic");
            $form->setType("notification", "hiddenstatic");
            $form->setType("envoi_cl_platau", "hiddenstatic");
            $form->setType("signataire_obligatoire", "hiddenstatic");
            $form->setType("notification_service", "hiddenstatic");
            $form->setType("notification_tiers", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("evenement", "static");
            $form->setType("libelle", "static");
            $form->setType("action", "selectstatic");
            $form->setType("etat", "selectstatic");
            $form->setType("delai", "static");
            $form->setType("accord_tacite", "static");
            $form->setType("delai_notification", "static");
            $form->setType("lettretype", "static");
            $form->setType("consultation", "static");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("restriction", "static");
            $form->setType("type", "static");
            $form->setType("evenement_retour_ar", "selectstatic");
            $form->setType("evenement_suivant_tacite", "selectstatic");
            $form->setType("evenement_retour_signature", "selectstatic");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("retour", "checkboxstatic");
            $form->setType("non_verrouillable", "checkboxstatic");
            $form->setType("phase", "selectstatic");
            $form->setType("finaliser_automatiquement", "checkboxstatic");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("commentaire", "checkboxstatic");
            $form->setType("non_modifiable", "checkboxstatic");
            $form->setType("non_supprimable", "checkboxstatic");
            $form->setType("notification", "static");
            $form->setType("envoi_cl_platau", "checkboxstatic");
            $form->setType("signataire_obligatoire", "checkboxstatic");
            $form->setType("notification_service", "checkboxstatic");
            $form->setType("notification_tiers", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('evenement','VerifNum(this)');
        $form->setOnchange('delai','VerifNum(this)');
        $form->setOnchange('delai_notification','VerifNum(this)');
        $form->setOnchange('avis_decision','VerifNum(this)');
        $form->setOnchange('evenement_retour_ar','VerifNum(this)');
        $form->setOnchange('evenement_suivant_tacite','VerifNum(this)');
        $form->setOnchange('evenement_retour_signature','VerifNum(this)');
        $form->setOnchange('autorite_competente','VerifNum(this)');
        $form->setOnchange('phase','VerifNum(this)');
        $form->setOnchange('pec_metier','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("evenement", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("action", 30);
        $form->setTaille("etat", 30);
        $form->setTaille("delai", 11);
        $form->setTaille("accord_tacite", 10);
        $form->setTaille("delai_notification", 11);
        $form->setTaille("lettretype", 30);
        $form->setTaille("consultation", 10);
        $form->setTaille("avis_decision", 11);
        $form->setTaille("restriction", 30);
        $form->setTaille("type", 30);
        $form->setTaille("evenement_retour_ar", 11);
        $form->setTaille("evenement_suivant_tacite", 11);
        $form->setTaille("evenement_retour_signature", 11);
        $form->setTaille("autorite_competente", 11);
        $form->setTaille("retour", 1);
        $form->setTaille("non_verrouillable", 1);
        $form->setTaille("phase", 11);
        $form->setTaille("finaliser_automatiquement", 1);
        $form->setTaille("pec_metier", 11);
        $form->setTaille("commentaire", 1);
        $form->setTaille("non_modifiable", 1);
        $form->setTaille("non_supprimable", 1);
        $form->setTaille("notification", 30);
        $form->setTaille("envoi_cl_platau", 1);
        $form->setTaille("signataire_obligatoire", 1);
        $form->setTaille("notification_service", 1);
        $form->setTaille("notification_tiers", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("evenement", 11);
        $form->setMax("libelle", 70);
        $form->setMax("action", 150);
        $form->setMax("etat", 150);
        $form->setMax("delai", 11);
        $form->setMax("accord_tacite", 3);
        $form->setMax("delai_notification", 11);
        $form->setMax("lettretype", 50);
        $form->setMax("consultation", 3);
        $form->setMax("avis_decision", 11);
        $form->setMax("restriction", 255);
        $form->setMax("type", 100);
        $form->setMax("evenement_retour_ar", 11);
        $form->setMax("evenement_suivant_tacite", 11);
        $form->setMax("evenement_retour_signature", 11);
        $form->setMax("autorite_competente", 11);
        $form->setMax("retour", 1);
        $form->setMax("non_verrouillable", 1);
        $form->setMax("phase", 11);
        $form->setMax("finaliser_automatiquement", 1);
        $form->setMax("pec_metier", 11);
        $form->setMax("commentaire", 1);
        $form->setMax("non_modifiable", 1);
        $form->setMax("non_supprimable", 1);
        $form->setMax("notification", 100);
        $form->setMax("envoi_cl_platau", 1);
        $form->setMax("signataire_obligatoire", 1);
        $form->setMax("notification_service", 1);
        $form->setMax("notification_tiers", 50);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('evenement', __('evenement'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('action', __('action'));
        $form->setLib('etat', __('etat'));
        $form->setLib('delai', __('delai'));
        $form->setLib('accord_tacite', __('accord_tacite'));
        $form->setLib('delai_notification', __('delai_notification'));
        $form->setLib('lettretype', __('lettretype'));
        $form->setLib('consultation', __('consultation'));
        $form->setLib('avis_decision', __('avis_decision'));
        $form->setLib('restriction', __('restriction'));
        $form->setLib('type', __('type'));
        $form->setLib('evenement_retour_ar', __('evenement_retour_ar'));
        $form->setLib('evenement_suivant_tacite', __('evenement_suivant_tacite'));
        $form->setLib('evenement_retour_signature', __('evenement_retour_signature'));
        $form->setLib('autorite_competente', __('autorite_competente'));
        $form->setLib('retour', __('retour'));
        $form->setLib('non_verrouillable', __('non_verrouillable'));
        $form->setLib('phase', __('phase'));
        $form->setLib('finaliser_automatiquement', __('finaliser_automatiquement'));
        $form->setLib('pec_metier', __('pec_metier'));
        $form->setLib('commentaire', __('commentaire'));
        $form->setLib('non_modifiable', __('non_modifiable'));
        $form->setLib('non_supprimable', __('non_supprimable'));
        $form->setLib('notification', __('notification'));
        $form->setLib('envoi_cl_platau', __('envoi_cl_platau'));
        $form->setLib('signataire_obligatoire', __('signataire_obligatoire'));
        $form->setLib('notification_service', __('notification_service'));
        $form->setLib('notification_tiers', __('notification_tiers'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // action
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "action",
            $this->get_var_sql_forminc__sql("action"),
            $this->get_var_sql_forminc__sql("action_by_id"),
            false
        );
        // autorite_competente
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "autorite_competente",
            $this->get_var_sql_forminc__sql("autorite_competente"),
            $this->get_var_sql_forminc__sql("autorite_competente_by_id"),
            false
        );
        // avis_decision
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "avis_decision",
            $this->get_var_sql_forminc__sql("avis_decision"),
            $this->get_var_sql_forminc__sql("avis_decision_by_id"),
            false
        );
        // etat
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "etat",
            $this->get_var_sql_forminc__sql("etat"),
            $this->get_var_sql_forminc__sql("etat_by_id"),
            false
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
            false
        );
        // evenement_retour_signature
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement_retour_signature",
            $this->get_var_sql_forminc__sql("evenement_retour_signature"),
            $this->get_var_sql_forminc__sql("evenement_retour_signature_by_id"),
            false
        );
        // evenement_suivant_tacite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement_suivant_tacite",
            $this->get_var_sql_forminc__sql("evenement_suivant_tacite"),
            $this->get_var_sql_forminc__sql("evenement_suivant_tacite_by_id"),
            false
        );
        // pec_metier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "pec_metier",
            $this->get_var_sql_forminc__sql("pec_metier"),
            $this->get_var_sql_forminc__sql("pec_metier_by_id"),
            true
        );
        // phase
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "phase",
            $this->get_var_sql_forminc__sql("phase"),
            $this->get_var_sql_forminc__sql("phase_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('action', $this->retourformulaire))
                $form->setVal('action', $idxformulaire);
            if($this->is_in_context_of_foreign_key('autorite_competente', $this->retourformulaire))
                $form->setVal('autorite_competente', $idxformulaire);
            if($this->is_in_context_of_foreign_key('avis_decision', $this->retourformulaire))
                $form->setVal('avis_decision', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat', $idxformulaire);
            if($this->is_in_context_of_foreign_key('pec_metier', $this->retourformulaire))
                $form->setVal('pec_metier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('phase', $this->retourformulaire))
                $form->setVal('phase', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement_retour_ar', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement_retour_signature', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement_suivant_tacite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    
    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::cleSecondaire($id);
        // Verification de la cle secondaire : bible
        $this->rechercheTable($this->f->db, "bible", "evenement", $id);
        // Verification de la cle secondaire : demande_type
        $this->rechercheTable($this->f->db, "demande_type", "evenement", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "evenement_suivant_tacite", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "evenement_suivant_tacite_incompletude", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "evenement_retour_ar", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "evenement_retour_signature", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "evenement_suivant_tacite", $id);
        // Verification de la cle secondaire : evenement_type_habilitation_tiers_consulte
        $this->rechercheTable($this->f->db, "evenement_type_habilitation_tiers_consulte", "evenement", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "archive_evenement_suivant_tacite", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "archive_evenement_suivant_tacite_incompletude", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "evenement", $id);
        // Verification de la cle secondaire : lien_dossier_instruction_type_evenement
        $this->rechercheTable($this->f->db, "lien_dossier_instruction_type_evenement", "evenement", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_evenement
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_evenement", "evenement", $id);
        // Verification de la cle secondaire : transition
        $this->rechercheTable($this->f->db, "transition", "evenement", $id);
    }


}

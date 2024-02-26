<?php
//$Id$ 
//gen openMairie le 22/02/2023 11:40

require_once "../obj/om_dbform.class.php";

class consultation_gen extends om_dbform {

    protected $_absolute_class_name = "consultation";

    var $table = "consultation";
    var $clePrimaire = "consultation";
    var $typeCle = "N";
    var $required_field = array(
        "consultation",
        "date_envoi",
        "dossier"
    );
    var $unique_key = array(
      "code_barres",
    );
    var $foreign_keys_extended = array(
        "avis_consultation" => array("avis_consultation", ),
        "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "motif_consultation" => array("motif_consultation", ),
        "service" => array("service", ),
        "tiers_consulte" => array("tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "consultation",
            "dossier",
            "date_envoi",
            "date_retour",
            "date_limite",
            "service",
            "avis_consultation",
            "date_reception",
            "motivation",
            "fichier",
            "lu",
            "code_barres",
            "om_fichier_consultation",
            "om_final_consultation",
            "marque",
            "visible",
            "om_fichier_consultation_dossier_final",
            "fichier_dossier_final",
            "texte_fondement_avis",
            "texte_avis",
            "texte_hypotheses",
            "nom_auteur",
            "prenom_auteur",
            "qualite_auteur",
            "categorie_tiers_consulte",
            "tiers_consulte",
            "motif_consultation",
            "commentaire",
            "fichier_pec",
            "motif_pec",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_consultation() {
        return "SELECT avis_consultation.avis_consultation, avis_consultation.libelle FROM ".DB_PREFIXE."avis_consultation WHERE ((avis_consultation.om_validite_debut IS NULL AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE)) OR (avis_consultation.om_validite_debut <= CURRENT_DATE AND (avis_consultation.om_validite_fin IS NULL OR avis_consultation.om_validite_fin > CURRENT_DATE))) ORDER BY avis_consultation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_consultation_by_id() {
        return "SELECT avis_consultation.avis_consultation, avis_consultation.libelle FROM ".DB_PREFIXE."avis_consultation WHERE avis_consultation = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE ((categorie_tiers_consulte.om_validite_debut IS NULL AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY categorie_tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte_by_id() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE categorie_tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_motif_consultation() {
        return "SELECT motif_consultation.motif_consultation, motif_consultation.libelle FROM ".DB_PREFIXE."motif_consultation WHERE ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE))) ORDER BY motif_consultation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_motif_consultation_by_id() {
        return "SELECT motif_consultation.motif_consultation, motif_consultation.libelle FROM ".DB_PREFIXE."motif_consultation WHERE motif_consultation = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service() {
        return "SELECT service.service, service.libelle FROM ".DB_PREFIXE."service WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE))) ORDER BY service.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_by_id() {
        return "SELECT service.service, service.libelle FROM ".DB_PREFIXE."service WHERE service = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['consultation'])) {
            $this->valF['consultation'] = ""; // -> requis
        } else {
            $this->valF['consultation'] = $val['consultation'];
        }
        $this->valF['dossier'] = $val['dossier'];
        if ($val['date_envoi'] != "") {
            $this->valF['date_envoi'] = $this->dateDB($val['date_envoi']);
        }
        if ($val['date_retour'] != "") {
            $this->valF['date_retour'] = $this->dateDB($val['date_retour']);
        } else {
            $this->valF['date_retour'] = NULL;
        }
        if ($val['date_limite'] != "") {
            $this->valF['date_limite'] = $this->dateDB($val['date_limite']);
        } else {
            $this->valF['date_limite'] = NULL;
        }
        if (!is_numeric($val['service'])) {
            $this->valF['service'] = NULL;
        } else {
            $this->valF['service'] = $val['service'];
        }
        if (!is_numeric($val['avis_consultation'])) {
            $this->valF['avis_consultation'] = NULL;
        } else {
            $this->valF['avis_consultation'] = $val['avis_consultation'];
        }
        if ($val['date_reception'] != "") {
            $this->valF['date_reception'] = $this->dateDB($val['date_reception']);
        } else {
            $this->valF['date_reception'] = NULL;
        }
            $this->valF['motivation'] = $val['motivation'];
        if ($val['fichier'] == "") {
            $this->valF['fichier'] = NULL;
        } else {
            $this->valF['fichier'] = $val['fichier'];
        }
        if ($val['lu'] == 1 || $val['lu'] == "t" || $val['lu'] == "Oui") {
            $this->valF['lu'] = true;
        } else {
            $this->valF['lu'] = false;
        }
        if ($val['code_barres'] == "") {
            $this->valF['code_barres'] = NULL;
        } else {
            $this->valF['code_barres'] = $val['code_barres'];
        }
        if ($val['om_fichier_consultation'] == "") {
            $this->valF['om_fichier_consultation'] = NULL;
        } else {
            $this->valF['om_fichier_consultation'] = $val['om_fichier_consultation'];
        }
        if ($val['om_final_consultation'] == 1 || $val['om_final_consultation'] == "t" || $val['om_final_consultation'] == "Oui") {
            $this->valF['om_final_consultation'] = true;
        } else {
            $this->valF['om_final_consultation'] = false;
        }
        if ($val['marque'] == 1 || $val['marque'] == "t" || $val['marque'] == "Oui") {
            $this->valF['marque'] = true;
        } else {
            $this->valF['marque'] = false;
        }
        if ($val['visible'] == 1 || $val['visible'] == "t" || $val['visible'] == "Oui") {
            $this->valF['visible'] = true;
        } else {
            $this->valF['visible'] = false;
        }
        if ($val['om_fichier_consultation_dossier_final'] == 1 || $val['om_fichier_consultation_dossier_final'] == "t" || $val['om_fichier_consultation_dossier_final'] == "Oui") {
            $this->valF['om_fichier_consultation_dossier_final'] = true;
        } else {
            $this->valF['om_fichier_consultation_dossier_final'] = false;
        }
        if ($val['fichier_dossier_final'] == 1 || $val['fichier_dossier_final'] == "t" || $val['fichier_dossier_final'] == "Oui") {
            $this->valF['fichier_dossier_final'] = true;
        } else {
            $this->valF['fichier_dossier_final'] = false;
        }
            $this->valF['texte_fondement_avis'] = $val['texte_fondement_avis'];
            $this->valF['texte_avis'] = $val['texte_avis'];
            $this->valF['texte_hypotheses'] = $val['texte_hypotheses'];
        if ($val['nom_auteur'] == "") {
            $this->valF['nom_auteur'] = NULL;
        } else {
            $this->valF['nom_auteur'] = $val['nom_auteur'];
        }
        if ($val['prenom_auteur'] == "") {
            $this->valF['prenom_auteur'] = NULL;
        } else {
            $this->valF['prenom_auteur'] = $val['prenom_auteur'];
        }
        if ($val['qualite_auteur'] == "") {
            $this->valF['qualite_auteur'] = NULL;
        } else {
            $this->valF['qualite_auteur'] = $val['qualite_auteur'];
        }
        if (!is_numeric($val['categorie_tiers_consulte'])) {
            $this->valF['categorie_tiers_consulte'] = NULL;
        } else {
            $this->valF['categorie_tiers_consulte'] = $val['categorie_tiers_consulte'];
        }
        if (!is_numeric($val['tiers_consulte'])) {
            $this->valF['tiers_consulte'] = NULL;
        } else {
            $this->valF['tiers_consulte'] = $val['tiers_consulte'];
        }
        if (!is_numeric($val['motif_consultation'])) {
            $this->valF['motif_consultation'] = NULL;
        } else {
            $this->valF['motif_consultation'] = $val['motif_consultation'];
        }
            $this->valF['commentaire'] = $val['commentaire'];
        if ($val['fichier_pec'] == "") {
            $this->valF['fichier_pec'] = NULL;
        } else {
            $this->valF['fichier_pec'] = $val['fichier_pec'];
        }
            $this->valF['motif_pec'] = $val['motif_pec'];
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
            $form->setType("consultation", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("date_envoi", "date");
            $form->setType("date_retour", "date");
            $form->setType("date_limite", "date");
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
            if ($this->is_in_context_of_foreign_key("avis_consultation", $this->retourformulaire)) {
                $form->setType("avis_consultation", "selecthiddenstatic");
            } else {
                $form->setType("avis_consultation", "select");
            }
            $form->setType("date_reception", "date");
            $form->setType("motivation", "textarea");
            $form->setType("fichier", "text");
            $form->setType("lu", "checkbox");
            $form->setType("code_barres", "text");
            $form->setType("om_fichier_consultation", "text");
            $form->setType("om_final_consultation", "checkbox");
            $form->setType("marque", "checkbox");
            $form->setType("visible", "checkbox");
            $form->setType("om_fichier_consultation_dossier_final", "checkbox");
            $form->setType("fichier_dossier_final", "checkbox");
            $form->setType("texte_fondement_avis", "textarea");
            $form->setType("texte_avis", "textarea");
            $form->setType("texte_hypotheses", "textarea");
            $form->setType("nom_auteur", "text");
            $form->setType("prenom_auteur", "text");
            $form->setType("qualite_auteur", "text");
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("motif_consultation", $this->retourformulaire)) {
                $form->setType("motif_consultation", "selecthiddenstatic");
            } else {
                $form->setType("motif_consultation", "select");
            }
            $form->setType("commentaire", "textarea");
            $form->setType("fichier_pec", "text");
            $form->setType("motif_pec", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("consultation", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("date_envoi", "date");
            $form->setType("date_retour", "date");
            $form->setType("date_limite", "date");
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
            if ($this->is_in_context_of_foreign_key("avis_consultation", $this->retourformulaire)) {
                $form->setType("avis_consultation", "selecthiddenstatic");
            } else {
                $form->setType("avis_consultation", "select");
            }
            $form->setType("date_reception", "date");
            $form->setType("motivation", "textarea");
            $form->setType("fichier", "text");
            $form->setType("lu", "checkbox");
            $form->setType("code_barres", "text");
            $form->setType("om_fichier_consultation", "text");
            $form->setType("om_final_consultation", "checkbox");
            $form->setType("marque", "checkbox");
            $form->setType("visible", "checkbox");
            $form->setType("om_fichier_consultation_dossier_final", "checkbox");
            $form->setType("fichier_dossier_final", "checkbox");
            $form->setType("texte_fondement_avis", "textarea");
            $form->setType("texte_avis", "textarea");
            $form->setType("texte_hypotheses", "textarea");
            $form->setType("nom_auteur", "text");
            $form->setType("prenom_auteur", "text");
            $form->setType("qualite_auteur", "text");
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("motif_consultation", $this->retourformulaire)) {
                $form->setType("motif_consultation", "selecthiddenstatic");
            } else {
                $form->setType("motif_consultation", "select");
            }
            $form->setType("commentaire", "textarea");
            $form->setType("fichier_pec", "text");
            $form->setType("motif_pec", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("consultation", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("date_envoi", "hiddenstatic");
            $form->setType("date_retour", "hiddenstatic");
            $form->setType("date_limite", "hiddenstatic");
            $form->setType("service", "selectstatic");
            $form->setType("avis_consultation", "selectstatic");
            $form->setType("date_reception", "hiddenstatic");
            $form->setType("motivation", "hiddenstatic");
            $form->setType("fichier", "hiddenstatic");
            $form->setType("lu", "hiddenstatic");
            $form->setType("code_barres", "hiddenstatic");
            $form->setType("om_fichier_consultation", "hiddenstatic");
            $form->setType("om_final_consultation", "hiddenstatic");
            $form->setType("marque", "hiddenstatic");
            $form->setType("visible", "hiddenstatic");
            $form->setType("om_fichier_consultation_dossier_final", "hiddenstatic");
            $form->setType("fichier_dossier_final", "hiddenstatic");
            $form->setType("texte_fondement_avis", "hiddenstatic");
            $form->setType("texte_avis", "hiddenstatic");
            $form->setType("texte_hypotheses", "hiddenstatic");
            $form->setType("nom_auteur", "hiddenstatic");
            $form->setType("prenom_auteur", "hiddenstatic");
            $form->setType("qualite_auteur", "hiddenstatic");
            $form->setType("categorie_tiers_consulte", "selectstatic");
            $form->setType("tiers_consulte", "selectstatic");
            $form->setType("motif_consultation", "selectstatic");
            $form->setType("commentaire", "hiddenstatic");
            $form->setType("fichier_pec", "hiddenstatic");
            $form->setType("motif_pec", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("consultation", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("date_envoi", "datestatic");
            $form->setType("date_retour", "datestatic");
            $form->setType("date_limite", "datestatic");
            $form->setType("service", "selectstatic");
            $form->setType("avis_consultation", "selectstatic");
            $form->setType("date_reception", "datestatic");
            $form->setType("motivation", "textareastatic");
            $form->setType("fichier", "static");
            $form->setType("lu", "checkboxstatic");
            $form->setType("code_barres", "static");
            $form->setType("om_fichier_consultation", "static");
            $form->setType("om_final_consultation", "checkboxstatic");
            $form->setType("marque", "checkboxstatic");
            $form->setType("visible", "checkboxstatic");
            $form->setType("om_fichier_consultation_dossier_final", "checkboxstatic");
            $form->setType("fichier_dossier_final", "checkboxstatic");
            $form->setType("texte_fondement_avis", "textareastatic");
            $form->setType("texte_avis", "textareastatic");
            $form->setType("texte_hypotheses", "textareastatic");
            $form->setType("nom_auteur", "static");
            $form->setType("prenom_auteur", "static");
            $form->setType("qualite_auteur", "static");
            $form->setType("categorie_tiers_consulte", "selectstatic");
            $form->setType("tiers_consulte", "selectstatic");
            $form->setType("motif_consultation", "selectstatic");
            $form->setType("commentaire", "textareastatic");
            $form->setType("fichier_pec", "static");
            $form->setType("motif_pec", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('consultation','VerifNum(this)');
        $form->setOnchange('date_envoi','fdate(this)');
        $form->setOnchange('date_retour','fdate(this)');
        $form->setOnchange('date_limite','fdate(this)');
        $form->setOnchange('service','VerifNum(this)');
        $form->setOnchange('avis_consultation','VerifNum(this)');
        $form->setOnchange('date_reception','fdate(this)');
        $form->setOnchange('categorie_tiers_consulte','VerifNum(this)');
        $form->setOnchange('tiers_consulte','VerifNum(this)');
        $form->setOnchange('motif_consultation','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("consultation", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("date_envoi", 12);
        $form->setTaille("date_retour", 12);
        $form->setTaille("date_limite", 12);
        $form->setTaille("service", 11);
        $form->setTaille("avis_consultation", 11);
        $form->setTaille("date_reception", 12);
        $form->setTaille("motivation", 80);
        $form->setTaille("fichier", 30);
        $form->setTaille("lu", 1);
        $form->setTaille("code_barres", 12);
        $form->setTaille("om_fichier_consultation", 30);
        $form->setTaille("om_final_consultation", 1);
        $form->setTaille("marque", 1);
        $form->setTaille("visible", 1);
        $form->setTaille("om_fichier_consultation_dossier_final", 1);
        $form->setTaille("fichier_dossier_final", 1);
        $form->setTaille("texte_fondement_avis", 80);
        $form->setTaille("texte_avis", 80);
        $form->setTaille("texte_hypotheses", 80);
        $form->setTaille("nom_auteur", 30);
        $form->setTaille("prenom_auteur", 30);
        $form->setTaille("qualite_auteur", 30);
        $form->setTaille("categorie_tiers_consulte", 11);
        $form->setTaille("tiers_consulte", 11);
        $form->setTaille("motif_consultation", 11);
        $form->setTaille("commentaire", 80);
        $form->setTaille("fichier_pec", 30);
        $form->setTaille("motif_pec", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("consultation", 11);
        $form->setMax("dossier", 30);
        $form->setMax("date_envoi", 12);
        $form->setMax("date_retour", 12);
        $form->setMax("date_limite", 12);
        $form->setMax("service", 11);
        $form->setMax("avis_consultation", 11);
        $form->setMax("date_reception", 12);
        $form->setMax("motivation", 6);
        $form->setMax("fichier", 255);
        $form->setMax("lu", 1);
        $form->setMax("code_barres", 12);
        $form->setMax("om_fichier_consultation", 255);
        $form->setMax("om_final_consultation", 1);
        $form->setMax("marque", 1);
        $form->setMax("visible", 1);
        $form->setMax("om_fichier_consultation_dossier_final", 1);
        $form->setMax("fichier_dossier_final", 1);
        $form->setMax("texte_fondement_avis", 6);
        $form->setMax("texte_avis", 6);
        $form->setMax("texte_hypotheses", 6);
        $form->setMax("nom_auteur", 255);
        $form->setMax("prenom_auteur", 255);
        $form->setMax("qualite_auteur", 255);
        $form->setMax("categorie_tiers_consulte", 11);
        $form->setMax("tiers_consulte", 11);
        $form->setMax("motif_consultation", 11);
        $form->setMax("commentaire", 6);
        $form->setMax("fichier_pec", 250);
        $form->setMax("motif_pec", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('consultation', __('consultation'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('date_envoi', __('date_envoi'));
        $form->setLib('date_retour', __('date_retour'));
        $form->setLib('date_limite', __('date_limite'));
        $form->setLib('service', __('service'));
        $form->setLib('avis_consultation', __('avis_consultation'));
        $form->setLib('date_reception', __('date_reception'));
        $form->setLib('motivation', __('motivation'));
        $form->setLib('fichier', __('fichier'));
        $form->setLib('lu', __('lu'));
        $form->setLib('code_barres', __('code_barres'));
        $form->setLib('om_fichier_consultation', __('om_fichier_consultation'));
        $form->setLib('om_final_consultation', __('om_final_consultation'));
        $form->setLib('marque', __('marque'));
        $form->setLib('visible', __('visible'));
        $form->setLib('om_fichier_consultation_dossier_final', __('om_fichier_consultation_dossier_final'));
        $form->setLib('fichier_dossier_final', __('fichier_dossier_final'));
        $form->setLib('texte_fondement_avis', __('texte_fondement_avis'));
        $form->setLib('texte_avis', __('texte_avis'));
        $form->setLib('texte_hypotheses', __('texte_hypotheses'));
        $form->setLib('nom_auteur', __('nom_auteur'));
        $form->setLib('prenom_auteur', __('prenom_auteur'));
        $form->setLib('qualite_auteur', __('qualite_auteur'));
        $form->setLib('categorie_tiers_consulte', __('categorie_tiers_consulte'));
        $form->setLib('tiers_consulte', __('tiers_consulte'));
        $form->setLib('motif_consultation', __('motif_consultation'));
        $form->setLib('commentaire', __('commentaire'));
        $form->setLib('fichier_pec', __('fichier_pec'));
        $form->setLib('motif_pec', __('motif_pec'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // avis_consultation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "avis_consultation",
            $this->get_var_sql_forminc__sql("avis_consultation"),
            $this->get_var_sql_forminc__sql("avis_consultation_by_id"),
            true
        );
        // categorie_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "categorie_tiers_consulte",
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte"),
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte_by_id"),
            true
        );
        // dossier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier",
            $this->get_var_sql_forminc__sql("dossier"),
            $this->get_var_sql_forminc__sql("dossier_by_id"),
            false
        );
        // motif_consultation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "motif_consultation",
            $this->get_var_sql_forminc__sql("motif_consultation"),
            $this->get_var_sql_forminc__sql("motif_consultation_by_id"),
            true
        );
        // service
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "service",
            $this->get_var_sql_forminc__sql("service"),
            $this->get_var_sql_forminc__sql("service_by_id"),
            true
        );
        // tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "tiers_consulte",
            $this->get_var_sql_forminc__sql("tiers_consulte"),
            $this->get_var_sql_forminc__sql("tiers_consulte_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('avis_consultation', $this->retourformulaire))
                $form->setVal('avis_consultation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('categorie_tiers_consulte', $this->retourformulaire))
                $form->setVal('categorie_tiers_consulte', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('motif_consultation', $this->retourformulaire))
                $form->setVal('motif_consultation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('service', $this->retourformulaire))
                $form->setVal('service', $idxformulaire);
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('tiers_consulte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

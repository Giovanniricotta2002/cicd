<?php
//$Id$ 
//gen openMairie le 25/07/2023 16:31

require_once "../obj/om_dbform.class.php";

class demande_gen extends om_dbform {

    protected $_absolute_class_name = "demande";

    var $table = "demande";
    var $clePrimaire = "demande";
    var $typeCle = "N";
    var $required_field = array(
        "date_demande",
        "demande",
        "demande_type",
        "dossier_autorisation_type_detaille",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "arrondissement" => array("arrondissement", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "commune" => array("commune", ),
        "demande_type" => array("demande_type", ),
        "dossier_autorisation" => array("dossier_autorisation", ),
        "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
        "instruction" => array("instruction", "instruction_modale", ),
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier_autorisation_type_detaille");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "demande",
            "dossier_autorisation_type_detaille",
            "demande_type",
            "dossier_instruction",
            "dossier_autorisation",
            "date_demande",
            "terrain_references_cadastrales",
            "terrain_adresse_voie_numero",
            "terrain_adresse_voie",
            "terrain_adresse_lieu_dit",
            "terrain_adresse_localite",
            "terrain_adresse_code_postal",
            "terrain_adresse_bp",
            "terrain_adresse_cedex",
            "terrain_superficie",
            "instruction_recepisse",
            "arrondissement",
            "om_collectivite",
            "autorisation_contestee",
            "depot_electronique",
            "parcelle_temporaire",
            "commune",
            "source_depot",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY arrondissement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement_by_id() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement WHERE arrondissement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE ((commune.om_validite_debut IS NULL AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)) OR (commune.om_validite_debut <= CURRENT_DATE AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE))) ORDER BY commune.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune_by_id() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE commune = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_type() {
        return "SELECT demande_type.demande_type, demande_type.libelle FROM ".DB_PREFIXE."demande_type ORDER BY demande_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_type_by_id() {
        return "SELECT demande_type.demande_type, demande_type.libelle FROM ".DB_PREFIXE."demande_type WHERE demande_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation ORDER BY dossier_autorisation.dossier_autorisation_type_detaille ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_by_id() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation WHERE dossier_autorisation = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille ORDER BY dossier_autorisation_type_detaille.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction_recepisse() {
        return "SELECT instruction.instruction, instruction.destinataire FROM ".DB_PREFIXE."instruction ORDER BY instruction.destinataire ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction_recepisse_by_id() {
        return "SELECT instruction.instruction, instruction.destinataire FROM ".DB_PREFIXE."instruction WHERE instruction = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite ORDER BY om_collectivite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_by_id() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['demande'])) {
            $this->valF['demande'] = ""; // -> requis
        } else {
            $this->valF['demande'] = $val['demande'];
        }
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = ""; // -> requis
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
        }
        if (!is_numeric($val['demande_type'])) {
            $this->valF['demande_type'] = ""; // -> requis
        } else {
            $this->valF['demande_type'] = $val['demande_type'];
        }
        if ($val['dossier_instruction'] == "") {
            $this->valF['dossier_instruction'] = NULL;
        } else {
            $this->valF['dossier_instruction'] = $val['dossier_instruction'];
        }
        if ($val['dossier_autorisation'] == "") {
            $this->valF['dossier_autorisation'] = NULL;
        } else {
            $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        }
        if ($val['date_demande'] != "") {
            $this->valF['date_demande'] = $this->dateDB($val['date_demande']);
        }
            $this->valF['terrain_references_cadastrales'] = $val['terrain_references_cadastrales'];
        if ($val['terrain_adresse_voie_numero'] == "") {
            $this->valF['terrain_adresse_voie_numero'] = NULL;
        } else {
            $this->valF['terrain_adresse_voie_numero'] = $val['terrain_adresse_voie_numero'];
        }
        if ($val['terrain_adresse_voie'] == "") {
            $this->valF['terrain_adresse_voie'] = NULL;
        } else {
            $this->valF['terrain_adresse_voie'] = $val['terrain_adresse_voie'];
        }
        if ($val['terrain_adresse_lieu_dit'] == "") {
            $this->valF['terrain_adresse_lieu_dit'] = NULL;
        } else {
            $this->valF['terrain_adresse_lieu_dit'] = $val['terrain_adresse_lieu_dit'];
        }
        if ($val['terrain_adresse_localite'] == "") {
            $this->valF['terrain_adresse_localite'] = NULL;
        } else {
            $this->valF['terrain_adresse_localite'] = $val['terrain_adresse_localite'];
        }
        if ($val['terrain_adresse_code_postal'] == "") {
            $this->valF['terrain_adresse_code_postal'] = NULL;
        } else {
            $this->valF['terrain_adresse_code_postal'] = $val['terrain_adresse_code_postal'];
        }
        if ($val['terrain_adresse_bp'] == "") {
            $this->valF['terrain_adresse_bp'] = NULL;
        } else {
            $this->valF['terrain_adresse_bp'] = $val['terrain_adresse_bp'];
        }
        if ($val['terrain_adresse_cedex'] == "") {
            $this->valF['terrain_adresse_cedex'] = NULL;
        } else {
            $this->valF['terrain_adresse_cedex'] = $val['terrain_adresse_cedex'];
        }
        if (!is_numeric($val['terrain_superficie'])) {
            $this->valF['terrain_superficie'] = NULL;
        } else {
            $this->valF['terrain_superficie'] = $val['terrain_superficie'];
        }
        if (!is_numeric($val['instruction_recepisse'])) {
            $this->valF['instruction_recepisse'] = NULL;
        } else {
            $this->valF['instruction_recepisse'] = $val['instruction_recepisse'];
        }
        if (!is_numeric($val['arrondissement'])) {
            $this->valF['arrondissement'] = NULL;
        } else {
            $this->valF['arrondissement'] = $val['arrondissement'];
        }
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if ($val['autorisation_contestee'] == "") {
            $this->valF['autorisation_contestee'] = NULL;
        } else {
            $this->valF['autorisation_contestee'] = $val['autorisation_contestee'];
        }
        if ($val['depot_electronique'] == 1 || $val['depot_electronique'] == "t" || $val['depot_electronique'] == "Oui") {
            $this->valF['depot_electronique'] = true;
        } else {
            $this->valF['depot_electronique'] = false;
        }
        if ($val['parcelle_temporaire'] == 1 || $val['parcelle_temporaire'] == "t" || $val['parcelle_temporaire'] == "Oui") {
            $this->valF['parcelle_temporaire'] = true;
        } else {
            $this->valF['parcelle_temporaire'] = false;
        }
        if (!is_numeric($val['commune'])) {
            $this->valF['commune'] = NULL;
        } else {
            $this->valF['commune'] = $val['commune'];
        }
        if ($val['source_depot'] == "") {
            $this->valF['source_depot'] = NULL;
        } else {
            $this->valF['source_depot'] = $val['source_depot'];
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
            $form->setType("demande", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("date_demande", "date");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("instruction", $this->retourformulaire)) {
                $form->setType("instruction_recepisse", "selecthiddenstatic");
            } else {
                $form->setType("instruction_recepisse", "select");
            }
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("autorisation_contestee", "selecthiddenstatic");
            } else {
                $form->setType("autorisation_contestee", "select");
            }
            $form->setType("depot_electronique", "checkbox");
            $form->setType("parcelle_temporaire", "checkbox");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("source_depot", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("demande", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("date_demande", "date");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("instruction", $this->retourformulaire)) {
                $form->setType("instruction_recepisse", "selecthiddenstatic");
            } else {
                $form->setType("instruction_recepisse", "select");
            }
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("autorisation_contestee", "selecthiddenstatic");
            } else {
                $form->setType("autorisation_contestee", "select");
            }
            $form->setType("depot_electronique", "checkbox");
            $form->setType("parcelle_temporaire", "checkbox");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("source_depot", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("demande", "hiddenstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("demande_type", "selectstatic");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("date_demande", "hiddenstatic");
            $form->setType("terrain_references_cadastrales", "hiddenstatic");
            $form->setType("terrain_adresse_voie_numero", "hiddenstatic");
            $form->setType("terrain_adresse_voie", "hiddenstatic");
            $form->setType("terrain_adresse_lieu_dit", "hiddenstatic");
            $form->setType("terrain_adresse_localite", "hiddenstatic");
            $form->setType("terrain_adresse_code_postal", "hiddenstatic");
            $form->setType("terrain_adresse_bp", "hiddenstatic");
            $form->setType("terrain_adresse_cedex", "hiddenstatic");
            $form->setType("terrain_superficie", "hiddenstatic");
            $form->setType("instruction_recepisse", "selectstatic");
            $form->setType("arrondissement", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("autorisation_contestee", "selectstatic");
            $form->setType("depot_electronique", "hiddenstatic");
            $form->setType("parcelle_temporaire", "hiddenstatic");
            $form->setType("commune", "selectstatic");
            $form->setType("source_depot", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("demande", "static");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("demande_type", "selectstatic");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("date_demande", "datestatic");
            $form->setType("terrain_references_cadastrales", "textareastatic");
            $form->setType("terrain_adresse_voie_numero", "static");
            $form->setType("terrain_adresse_voie", "static");
            $form->setType("terrain_adresse_lieu_dit", "static");
            $form->setType("terrain_adresse_localite", "static");
            $form->setType("terrain_adresse_code_postal", "static");
            $form->setType("terrain_adresse_bp", "static");
            $form->setType("terrain_adresse_cedex", "static");
            $form->setType("terrain_superficie", "static");
            $form->setType("instruction_recepisse", "selectstatic");
            $form->setType("arrondissement", "selectstatic");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("autorisation_contestee", "selectstatic");
            $form->setType("depot_electronique", "checkboxstatic");
            $form->setType("parcelle_temporaire", "checkboxstatic");
            $form->setType("commune", "selectstatic");
            $form->setType("source_depot", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('demande','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
        $form->setOnchange('demande_type','VerifNum(this)');
        $form->setOnchange('date_demande','fdate(this)');
        $form->setOnchange('terrain_superficie','VerifFloat(this)');
        $form->setOnchange('instruction_recepisse','VerifNum(this)');
        $form->setOnchange('arrondissement','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('commune','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("demande", 11);
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("demande_type", 11);
        $form->setTaille("dossier_instruction", 30);
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("date_demande", 12);
        $form->setTaille("terrain_references_cadastrales", 80);
        $form->setTaille("terrain_adresse_voie_numero", 20);
        $form->setTaille("terrain_adresse_voie", 30);
        $form->setTaille("terrain_adresse_lieu_dit", 30);
        $form->setTaille("terrain_adresse_localite", 30);
        $form->setTaille("terrain_adresse_code_postal", 10);
        $form->setTaille("terrain_adresse_bp", 15);
        $form->setTaille("terrain_adresse_cedex", 15);
        $form->setTaille("terrain_superficie", 20);
        $form->setTaille("instruction_recepisse", 11);
        $form->setTaille("arrondissement", 11);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("autorisation_contestee", 30);
        $form->setTaille("depot_electronique", 1);
        $form->setTaille("parcelle_temporaire", 1);
        $form->setTaille("commune", 11);
        $form->setTaille("source_depot", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("demande", 11);
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("demande_type", 11);
        $form->setMax("dossier_instruction", 255);
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("date_demande", 12);
        $form->setMax("terrain_references_cadastrales", 6);
        $form->setMax("terrain_adresse_voie_numero", 20);
        $form->setMax("terrain_adresse_voie", 300);
        $form->setMax("terrain_adresse_lieu_dit", 30);
        $form->setMax("terrain_adresse_localite", 45);
        $form->setMax("terrain_adresse_code_postal", 5);
        $form->setMax("terrain_adresse_bp", 15);
        $form->setMax("terrain_adresse_cedex", 15);
        $form->setMax("terrain_superficie", 20);
        $form->setMax("instruction_recepisse", 11);
        $form->setMax("arrondissement", 11);
        $form->setMax("om_collectivite", 11);
        $form->setMax("autorisation_contestee", 30);
        $form->setMax("depot_electronique", 1);
        $form->setMax("parcelle_temporaire", 1);
        $form->setMax("commune", 11);
        $form->setMax("source_depot", 255);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('demande', __('demande'));
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('demande_type', __('demande_type'));
        $form->setLib('dossier_instruction', __('dossier_instruction'));
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('date_demande', __('date_demande'));
        $form->setLib('terrain_references_cadastrales', __('terrain_references_cadastrales'));
        $form->setLib('terrain_adresse_voie_numero', __('terrain_adresse_voie_numero'));
        $form->setLib('terrain_adresse_voie', __('terrain_adresse_voie'));
        $form->setLib('terrain_adresse_lieu_dit', __('terrain_adresse_lieu_dit'));
        $form->setLib('terrain_adresse_localite', __('terrain_adresse_localite'));
        $form->setLib('terrain_adresse_code_postal', __('terrain_adresse_code_postal'));
        $form->setLib('terrain_adresse_bp', __('terrain_adresse_bp'));
        $form->setLib('terrain_adresse_cedex', __('terrain_adresse_cedex'));
        $form->setLib('terrain_superficie', __('terrain_superficie'));
        $form->setLib('instruction_recepisse', __('instruction_recepisse'));
        $form->setLib('arrondissement', __('arrondissement'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('autorisation_contestee', __('autorisation_contestee'));
        $form->setLib('depot_electronique', __('depot_electronique'));
        $form->setLib('parcelle_temporaire', __('parcelle_temporaire'));
        $form->setLib('commune', __('commune'));
        $form->setLib('source_depot', __('source_depot'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // arrondissement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "arrondissement",
            $this->get_var_sql_forminc__sql("arrondissement"),
            $this->get_var_sql_forminc__sql("arrondissement_by_id"),
            false
        );
        // autorisation_contestee
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "autorisation_contestee",
            $this->get_var_sql_forminc__sql("autorisation_contestee"),
            $this->get_var_sql_forminc__sql("autorisation_contestee_by_id"),
            false
        );
        // commune
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commune",
            $this->get_var_sql_forminc__sql("commune"),
            $this->get_var_sql_forminc__sql("commune_by_id"),
            true
        );
        // demande_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demande_type",
            $this->get_var_sql_forminc__sql("demande_type"),
            $this->get_var_sql_forminc__sql("demande_type_by_id"),
            false
        );
        // dossier_autorisation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation",
            $this->get_var_sql_forminc__sql("dossier_autorisation"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_by_id"),
            false
        );
        // dossier_autorisation_type_detaille
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation_type_detaille",
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille_by_id"),
            false
        );
        // dossier_instruction
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_instruction",
            $this->get_var_sql_forminc__sql("dossier_instruction"),
            $this->get_var_sql_forminc__sql("dossier_instruction_by_id"),
            false
        );
        // instruction_recepisse
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instruction_recepisse",
            $this->get_var_sql_forminc__sql("instruction_recepisse"),
            $this->get_var_sql_forminc__sql("instruction_recepisse_by_id"),
            false
        );
        // om_collectivite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false
        );
    }


    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setVal

    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('arrondissement', $this->retourformulaire))
                $form->setVal('arrondissement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('commune', $this->retourformulaire))
                $form->setVal('commune', $idxformulaire);
            if($this->is_in_context_of_foreign_key('demande_type', $this->retourformulaire))
                $form->setVal('demande_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation', $this->retourformulaire))
                $form->setVal('dossier_autorisation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type_detaille', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type_detaille', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instruction', $this->retourformulaire))
                $form->setVal('instruction_recepisse', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('autorisation_contestee', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_instruction', $idxformulaire);
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
        // Verification de la cle secondaire : lien_demande_demandeur
        $this->rechercheTable($this->f->db, "lien_demande_demandeur", "demande", $id);
    }


}

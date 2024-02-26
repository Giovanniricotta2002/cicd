<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class dossier_commission_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_commission";

    var $table = "dossier_commission";
    var $clePrimaire = "dossier_commission";
    var $typeCle = "N";
    var $required_field = array(
        "commission_type",
        "date_souhaitee",
        "dossier",
        "dossier_commission"
    );
    
    var $foreign_keys_extended = array(
        "commission" => array("commission", ),
        "commission_type" => array("commission_type", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
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
            "dossier_commission",
            "dossier",
            "commission_type",
            "date_souhaitee",
            "motivation",
            "commission",
            "avis",
            "lu",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission() {
        return "SELECT commission.commission, commission.libelle FROM ".DB_PREFIXE."commission ORDER BY commission.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_by_id() {
        return "SELECT commission.commission, commission.libelle FROM ".DB_PREFIXE."commission WHERE commission = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE))) ORDER BY commission_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type_by_id() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE commission_type = <idx>";
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_commission'])) {
            $this->valF['dossier_commission'] = ""; // -> requis
        } else {
            $this->valF['dossier_commission'] = $val['dossier_commission'];
        }
        $this->valF['dossier'] = $val['dossier'];
        if (!is_numeric($val['commission_type'])) {
            $this->valF['commission_type'] = ""; // -> requis
        } else {
            $this->valF['commission_type'] = $val['commission_type'];
        }
        if ($val['date_souhaitee'] != "") {
            $this->valF['date_souhaitee'] = $this->dateDB($val['date_souhaitee']);
        }
            $this->valF['motivation'] = $val['motivation'];
        if (!is_numeric($val['commission'])) {
            $this->valF['commission'] = NULL;
        } else {
            $this->valF['commission'] = $val['commission'];
        }
            $this->valF['avis'] = $val['avis'];
        if ($val['lu'] == 1 || $val['lu'] == "t" || $val['lu'] == "Oui") {
            $this->valF['lu'] = true;
        } else {
            $this->valF['lu'] = false;
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
            $form->setType("dossier_commission", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("commission_type", $this->retourformulaire)) {
                $form->setType("commission_type", "selecthiddenstatic");
            } else {
                $form->setType("commission_type", "select");
            }
            $form->setType("date_souhaitee", "date");
            $form->setType("motivation", "textarea");
            if ($this->is_in_context_of_foreign_key("commission", $this->retourformulaire)) {
                $form->setType("commission", "selecthiddenstatic");
            } else {
                $form->setType("commission", "select");
            }
            $form->setType("avis", "textarea");
            $form->setType("lu", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_commission", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("commission_type", $this->retourformulaire)) {
                $form->setType("commission_type", "selecthiddenstatic");
            } else {
                $form->setType("commission_type", "select");
            }
            $form->setType("date_souhaitee", "date");
            $form->setType("motivation", "textarea");
            if ($this->is_in_context_of_foreign_key("commission", $this->retourformulaire)) {
                $form->setType("commission", "selecthiddenstatic");
            } else {
                $form->setType("commission", "select");
            }
            $form->setType("avis", "textarea");
            $form->setType("lu", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_commission", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("commission_type", "selectstatic");
            $form->setType("date_souhaitee", "hiddenstatic");
            $form->setType("motivation", "hiddenstatic");
            $form->setType("commission", "selectstatic");
            $form->setType("avis", "hiddenstatic");
            $form->setType("lu", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_commission", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("commission_type", "selectstatic");
            $form->setType("date_souhaitee", "datestatic");
            $form->setType("motivation", "textareastatic");
            $form->setType("commission", "selectstatic");
            $form->setType("avis", "textareastatic");
            $form->setType("lu", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_commission','VerifNum(this)');
        $form->setOnchange('commission_type','VerifNum(this)');
        $form->setOnchange('date_souhaitee','fdate(this)');
        $form->setOnchange('commission','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_commission", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("commission_type", 11);
        $form->setTaille("date_souhaitee", 12);
        $form->setTaille("motivation", 80);
        $form->setTaille("commission", 11);
        $form->setTaille("avis", 80);
        $form->setTaille("lu", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_commission", 11);
        $form->setMax("dossier", 255);
        $form->setMax("commission_type", 11);
        $form->setMax("date_souhaitee", 12);
        $form->setMax("motivation", 6);
        $form->setMax("commission", 11);
        $form->setMax("avis", 6);
        $form->setMax("lu", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_commission', __('dossier_commission'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('commission_type', __('commission_type'));
        $form->setLib('date_souhaitee', __('date_souhaitee'));
        $form->setLib('motivation', __('motivation'));
        $form->setLib('commission', __('commission'));
        $form->setLib('avis', __('avis'));
        $form->setLib('lu', __('lu'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // commission
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commission",
            $this->get_var_sql_forminc__sql("commission"),
            $this->get_var_sql_forminc__sql("commission_by_id"),
            false
        );
        // commission_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commission_type",
            $this->get_var_sql_forminc__sql("commission_type"),
            $this->get_var_sql_forminc__sql("commission_type_by_id"),
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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('commission', $this->retourformulaire))
                $form->setVal('commission', $idxformulaire);
            if($this->is_in_context_of_foreign_key('commission_type', $this->retourformulaire))
                $form->setVal('commission_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

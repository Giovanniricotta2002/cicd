<?php
//$Id$ 
//gen openMairie le 17/10/2022 11:48

require_once "../obj/om_dbform.class.php";

class evenement_type_habilitation_tiers_consulte_gen extends om_dbform {

    protected $_absolute_class_name = "evenement_type_habilitation_tiers_consulte";

    var $table = "evenement_type_habilitation_tiers_consulte";
    var $clePrimaire = "evenement_type_habilitation_tiers_consulte";
    var $typeCle = "N";
    var $required_field = array(
        "evenement",
        "evenement_type_habilitation_tiers_consulte",
        "type_habilitation_tiers_consulte"
    );
    
    var $foreign_keys_extended = array(
        "evenement" => array("evenement", ),
        "type_habilitation_tiers_consulte" => array("type_habilitation_tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("evenement");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "evenement_type_habilitation_tiers_consulte",
            "evenement",
            "type_habilitation_tiers_consulte",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte() {
        return "SELECT type_habilitation_tiers_consulte.type_habilitation_tiers_consulte, type_habilitation_tiers_consulte.libelle FROM ".DB_PREFIXE."type_habilitation_tiers_consulte WHERE ((type_habilitation_tiers_consulte.om_validite_debut IS NULL AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY type_habilitation_tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte_by_id() {
        return "SELECT type_habilitation_tiers_consulte.type_habilitation_tiers_consulte, type_habilitation_tiers_consulte.libelle FROM ".DB_PREFIXE."type_habilitation_tiers_consulte WHERE type_habilitation_tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['evenement_type_habilitation_tiers_consulte'])) {
            $this->valF['evenement_type_habilitation_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['evenement_type_habilitation_tiers_consulte'] = $val['evenement_type_habilitation_tiers_consulte'];
        }
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = ""; // -> requis
        } else {
            $this->valF['evenement'] = $val['evenement'];
        }
        if (!is_numeric($val['type_habilitation_tiers_consulte'])) {
            $this->valF['type_habilitation_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['type_habilitation_tiers_consulte'] = $val['type_habilitation_tiers_consulte'];
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
            $form->setType("evenement_type_habilitation_tiers_consulte", "hidden");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            if ($this->is_in_context_of_foreign_key("type_habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("type_habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("type_habilitation_tiers_consulte", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("evenement_type_habilitation_tiers_consulte", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            if ($this->is_in_context_of_foreign_key("type_habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("type_habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("type_habilitation_tiers_consulte", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("evenement_type_habilitation_tiers_consulte", "hiddenstatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("type_habilitation_tiers_consulte", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("evenement_type_habilitation_tiers_consulte", "static");
            $form->setType("evenement", "selectstatic");
            $form->setType("type_habilitation_tiers_consulte", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('evenement_type_habilitation_tiers_consulte','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
        $form->setOnchange('type_habilitation_tiers_consulte','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("evenement_type_habilitation_tiers_consulte", 11);
        $form->setTaille("evenement", 11);
        $form->setTaille("type_habilitation_tiers_consulte", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("evenement_type_habilitation_tiers_consulte", 11);
        $form->setMax("evenement", 11);
        $form->setMax("type_habilitation_tiers_consulte", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('evenement_type_habilitation_tiers_consulte', __('evenement_type_habilitation_tiers_consulte'));
        $form->setLib('evenement', __('evenement'));
        $form->setLib('type_habilitation_tiers_consulte', __('type_habilitation_tiers_consulte'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // evenement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement",
            $this->get_var_sql_forminc__sql("evenement"),
            $this->get_var_sql_forminc__sql("evenement_by_id"),
            false
        );
        // type_habilitation_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "type_habilitation_tiers_consulte",
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte"),
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('type_habilitation_tiers_consulte', $this->retourformulaire))
                $form->setVal('type_habilitation_tiers_consulte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

<?php
//$Id$ 
//gen openMairie le 05/04/2023 17:40

require_once "../obj/om_dbform.class.php";

class lien_dossier_instruction_type_categorie_tiers_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_instruction_type_categorie_tiers";

    var $table = "lien_dossier_instruction_type_categorie_tiers";
    var $clePrimaire = "lien_dossier_instruction_type_categorie_tiers";
    var $typeCle = "N";
    var $required_field = array(
        "categorie_tiers",
        "dossier_instruction_type",
        "lien_dossier_instruction_type_categorie_tiers"
    );
    
    var $foreign_keys_extended = array(
        "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier_instruction_type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_dossier_instruction_type_categorie_tiers",
            "dossier_instruction_type",
            "categorie_tiers",
            "ajout_automatique",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE ((categorie_tiers_consulte.om_validite_debut IS NULL AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY categorie_tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_by_id() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE categorie_tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type ORDER BY dossier_instruction_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type WHERE dossier_instruction_type = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dossier_instruction_type_categorie_tiers'])) {
            $this->valF['lien_dossier_instruction_type_categorie_tiers'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_instruction_type_categorie_tiers'] = $val['lien_dossier_instruction_type_categorie_tiers'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        if (!is_numeric($val['categorie_tiers'])) {
            $this->valF['categorie_tiers'] = ""; // -> requis
        } else {
            $this->valF['categorie_tiers'] = $val['categorie_tiers'];
        }
        if ($val['ajout_automatique'] == 1 || $val['ajout_automatique'] == "t" || $val['ajout_automatique'] == "Oui") {
            $this->valF['ajout_automatique'] = true;
        } else {
            $this->valF['ajout_automatique'] = false;
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
            $form->setType("lien_dossier_instruction_type_categorie_tiers", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers", "select");
            }
            $form->setType("ajout_automatique", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_instruction_type_categorie_tiers", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers", "select");
            }
            $form->setType("ajout_automatique", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_instruction_type_categorie_tiers", "hiddenstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("categorie_tiers", "selectstatic");
            $form->setType("ajout_automatique", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_instruction_type_categorie_tiers", "static");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("categorie_tiers", "selectstatic");
            $form->setType("ajout_automatique", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_instruction_type_categorie_tiers','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('categorie_tiers','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_instruction_type_categorie_tiers", 11);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("categorie_tiers", 11);
        $form->setTaille("ajout_automatique", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_instruction_type_categorie_tiers", 11);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("categorie_tiers", 11);
        $form->setMax("ajout_automatique", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_instruction_type_categorie_tiers', __('lien_dossier_instruction_type_categorie_tiers'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('categorie_tiers', __('categorie_tiers'));
        $form->setLib('ajout_automatique', __('ajout_automatique'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // categorie_tiers
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "categorie_tiers",
            $this->get_var_sql_forminc__sql("categorie_tiers"),
            $this->get_var_sql_forminc__sql("categorie_tiers_by_id"),
            true
        );
        // dossier_instruction_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_instruction_type",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('categorie_tiers_consulte', $this->retourformulaire))
                $form->setVal('categorie_tiers', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

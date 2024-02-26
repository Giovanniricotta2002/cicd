<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

require_once "../obj/om_dbform.class.php";

class lien_dit_nature_travaux_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dit_nature_travaux";

    var $table = "lien_dit_nature_travaux";
    var $clePrimaire = "lien_dit_nature_travaux";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_instruction_type",
        "lien_dit_nature_travaux",
        "nature_travaux"
    );
    var $unique_key = array(
      array("dossier_instruction_type","nature_travaux"),
    );
    var $foreign_keys_extended = array(
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "nature_travaux" => array("nature_travaux", ),
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
            "lien_dit_nature_travaux",
            "dossier_instruction_type",
            "nature_travaux",
        );
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_nature_travaux() {
        return "SELECT nature_travaux.nature_travaux, nature_travaux.libelle FROM ".DB_PREFIXE."nature_travaux WHERE ((nature_travaux.om_validite_debut IS NULL AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE)) OR (nature_travaux.om_validite_debut <= CURRENT_DATE AND (nature_travaux.om_validite_fin IS NULL OR nature_travaux.om_validite_fin > CURRENT_DATE))) ORDER BY nature_travaux.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_nature_travaux_by_id() {
        return "SELECT nature_travaux.nature_travaux, nature_travaux.libelle FROM ".DB_PREFIXE."nature_travaux WHERE nature_travaux = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dit_nature_travaux'])) {
            $this->valF['lien_dit_nature_travaux'] = ""; // -> requis
        } else {
            $this->valF['lien_dit_nature_travaux'] = $val['lien_dit_nature_travaux'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        if (!is_numeric($val['nature_travaux'])) {
            $this->valF['nature_travaux'] = ""; // -> requis
        } else {
            $this->valF['nature_travaux'] = $val['nature_travaux'];
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
            $form->setType("lien_dit_nature_travaux", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("nature_travaux", $this->retourformulaire)) {
                $form->setType("nature_travaux", "selecthiddenstatic");
            } else {
                $form->setType("nature_travaux", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dit_nature_travaux", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("nature_travaux", $this->retourformulaire)) {
                $form->setType("nature_travaux", "selecthiddenstatic");
            } else {
                $form->setType("nature_travaux", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dit_nature_travaux", "hiddenstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("nature_travaux", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dit_nature_travaux", "static");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("nature_travaux", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dit_nature_travaux','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('nature_travaux','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dit_nature_travaux", 11);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("nature_travaux", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dit_nature_travaux", 11);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("nature_travaux", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dit_nature_travaux', __('lien_dit_nature_travaux'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('nature_travaux', __('nature_travaux'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
        // nature_travaux
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "nature_travaux",
            $this->get_var_sql_forminc__sql("nature_travaux"),
            $this->get_var_sql_forminc__sql("nature_travaux_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('nature_travaux', $this->retourformulaire))
                $form->setVal('nature_travaux', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

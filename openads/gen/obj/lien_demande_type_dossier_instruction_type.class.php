<?php
//$Id: lien_demande_type_dossier_instruction_type.class.php 8640 2019-03-27 11:49:05Z softime $ 
//gen openMairie le 15/11/2018 16:09

require_once "../obj/om_dbform.class.php";

class lien_demande_type_dossier_instruction_type_gen extends om_dbform {

    protected $_absolute_class_name = "lien_demande_type_dossier_instruction_type";

    var $table = "lien_demande_type_dossier_instruction_type";
    var $clePrimaire = "lien_demande_type_dossier_instruction_type";
    var $typeCle = "N";
    var $required_field = array(
        "lien_demande_type_dossier_instruction_type"
    );
    
    var $foreign_keys_extended = array(
        "demande_type" => array("demande_type", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("demande_type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_demande_type_dossier_instruction_type",
            "demande_type",
            "dossier_instruction_type",
        );
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
        if (!is_numeric($val['lien_demande_type_dossier_instruction_type'])) {
            $this->valF['lien_demande_type_dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['lien_demande_type_dossier_instruction_type'] = $val['lien_demande_type_dossier_instruction_type'];
        }
        if (!is_numeric($val['demande_type'])) {
            $this->valF['demande_type'] = NULL;
        } else {
            $this->valF['demande_type'] = $val['demande_type'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = NULL;
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
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
            $form->setType("lien_demande_type_dossier_instruction_type", "hidden");
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_demande_type_dossier_instruction_type", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_demande_type_dossier_instruction_type", "hiddenstatic");
            $form->setType("demande_type", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_demande_type_dossier_instruction_type", "static");
            $form->setType("demande_type", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_demande_type_dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('demande_type','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_demande_type_dossier_instruction_type", 11);
        $form->setTaille("demande_type", 11);
        $form->setTaille("dossier_instruction_type", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_demande_type_dossier_instruction_type", 11);
        $form->setMax("demande_type", 11);
        $form->setMax("dossier_instruction_type", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_demande_type_dossier_instruction_type', __('lien_demande_type_dossier_instruction_type'));
        $form->setLib('demande_type', __('demande_type'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
            if($this->is_in_context_of_foreign_key('demande_type', $this->retourformulaire))
                $form->setVal('demande_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

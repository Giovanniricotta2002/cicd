<?php
//$Id$ 
//gen openMairie le 15/07/2021 10:24

require_once "../obj/om_dbform.class.php";

class lien_document_n_type_d_i_t_gen extends om_dbform {

    protected $_absolute_class_name = "lien_document_n_type_d_i_t";

    var $table = "lien_document_n_type_d_i_t";
    var $clePrimaire = "lien_document_n_type_d_i_t";
    var $typeCle = "N";
    var $required_field = array(
        "code",
        "document_numerise_type",
        "dossier_instruction_type",
        "lien_document_n_type_d_i_t"
    );
    
    var $foreign_keys_extended = array(
        "document_numerise_type" => array("document_numerise_type", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("document_numerise_type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_document_n_type_d_i_t",
            "document_numerise_type",
            "dossier_instruction_type",
            "code",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type() {
        return "SELECT document_numerise_type.document_numerise_type, document_numerise_type.libelle FROM ".DB_PREFIXE."document_numerise_type WHERE ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE))) ORDER BY document_numerise_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_by_id() {
        return "SELECT document_numerise_type.document_numerise_type, document_numerise_type.libelle FROM ".DB_PREFIXE."document_numerise_type WHERE document_numerise_type = <idx>";
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
        if (!is_numeric($val['lien_document_n_type_d_i_t'])) {
            $this->valF['lien_document_n_type_d_i_t'] = ""; // -> requis
        } else {
            $this->valF['lien_document_n_type_d_i_t'] = $val['lien_document_n_type_d_i_t'];
        }
        if (!is_numeric($val['document_numerise_type'])) {
            $this->valF['document_numerise_type'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type'] = $val['document_numerise_type'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        $this->valF['code'] = $val['code'];
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
            $form->setType("lien_document_n_type_d_i_t", "hidden");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            $form->setType("code", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_document_n_type_d_i_t", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            $form->setType("code", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_document_n_type_d_i_t", "hiddenstatic");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("code", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_document_n_type_d_i_t", "static");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("code", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_document_n_type_d_i_t','VerifNum(this)');
        $form->setOnchange('document_numerise_type','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_document_n_type_d_i_t", 11);
        $form->setTaille("document_numerise_type", 11);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("code", 10);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_document_n_type_d_i_t", 11);
        $form->setMax("document_numerise_type", 11);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("code", 10);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_document_n_type_d_i_t', __('lien_document_n_type_d_i_t'));
        $form->setLib('document_numerise_type', __('document_numerise_type'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('code', __('code'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // document_numerise_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise_type",
            $this->get_var_sql_forminc__sql("document_numerise_type"),
            $this->get_var_sql_forminc__sql("document_numerise_type_by_id"),
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
            if($this->is_in_context_of_foreign_key('document_numerise_type', $this->retourformulaire))
                $form->setVal('document_numerise_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

<?php
//$Id$ 
//gen openMairie le 05/08/2022 11:05

require_once "../obj/om_dbform.class.php";

class lien_type_di_type_di_gen extends om_dbform {

    protected $_absolute_class_name = "lien_type_di_type_di";

    var $table = "lien_type_di_type_di";
    var $clePrimaire = "lien_type_di_type_di";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_instruction_type",
        "lien_type_di_type_di",
        "type_di_parent"
    );
    
    var $foreign_keys_extended = array(
        "dossier_instruction_type" => array("dossier_instruction_type", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("type_di_parent");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_type_di_type_di",
            "type_di_parent",
            "dossier_instruction_type",
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
    function get_var_sql_forminc__sql_type_di_parent() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type ORDER BY dossier_instruction_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_di_parent_by_id() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type WHERE dossier_instruction_type = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_type_di_type_di'])) {
            $this->valF['lien_type_di_type_di'] = ""; // -> requis
        } else {
            $this->valF['lien_type_di_type_di'] = $val['lien_type_di_type_di'];
        }
        if (!is_numeric($val['type_di_parent'])) {
            $this->valF['type_di_parent'] = ""; // -> requis
        } else {
            $this->valF['type_di_parent'] = $val['type_di_parent'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
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
            $form->setType("lien_type_di_type_di", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("type_di_parent", "selecthiddenstatic");
            } else {
                $form->setType("type_di_parent", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_type_di_type_di", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("type_di_parent", "selecthiddenstatic");
            } else {
                $form->setType("type_di_parent", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_type_di_type_di", "hiddenstatic");
            $form->setType("type_di_parent", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_type_di_type_di", "static");
            $form->setType("type_di_parent", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_type_di_type_di','VerifNum(this)');
        $form->setOnchange('type_di_parent','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_type_di_type_di", 11);
        $form->setTaille("type_di_parent", 11);
        $form->setTaille("dossier_instruction_type", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_type_di_type_di", 11);
        $form->setMax("type_di_parent", 11);
        $form->setMax("dossier_instruction_type", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_type_di_type_di', __('lien_type_di_type_di'));
        $form->setLib('type_di_parent', __('type_di_parent'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
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
        // type_di_parent
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "type_di_parent",
            $this->get_var_sql_forminc__sql("type_di_parent"),
            $this->get_var_sql_forminc__sql("type_di_parent_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('type_di_parent', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

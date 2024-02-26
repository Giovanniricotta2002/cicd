<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class lien_sig_contrainte_dossier_instruction_type_gen extends om_dbform {

    protected $_absolute_class_name = "lien_sig_contrainte_dossier_instruction_type";

    var $table = "lien_sig_contrainte_dossier_instruction_type";
    var $clePrimaire = "lien_sig_contrainte_dossier_instruction_type";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_instruction_type",
        "lien_sig_contrainte_dossier_instruction_type",
        "sig_contrainte"
    );
    
    var $foreign_keys_extended = array(
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "sig_contrainte" => array("sig_contrainte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("sig_contrainte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_sig_contrainte_dossier_instruction_type",
            "sig_contrainte",
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
    function get_var_sql_forminc__sql_sig_contrainte() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte ORDER BY sig_contrainte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte_by_id() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte WHERE sig_contrainte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_sig_contrainte_dossier_instruction_type'])) {
            $this->valF['lien_sig_contrainte_dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['lien_sig_contrainte_dossier_instruction_type'] = $val['lien_sig_contrainte_dossier_instruction_type'];
        }
        if (!is_numeric($val['sig_contrainte'])) {
            $this->valF['sig_contrainte'] = ""; // -> requis
        } else {
            $this->valF['sig_contrainte'] = $val['sig_contrainte'];
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
            $form->setType("lien_sig_contrainte_dossier_instruction_type", "hidden");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_sig_contrainte_dossier_instruction_type", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_sig_contrainte_dossier_instruction_type", "hiddenstatic");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_sig_contrainte_dossier_instruction_type", "static");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_sig_contrainte_dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('sig_contrainte','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_sig_contrainte_dossier_instruction_type", 11);
        $form->setTaille("sig_contrainte", 11);
        $form->setTaille("dossier_instruction_type", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_sig_contrainte_dossier_instruction_type", 11);
        $form->setMax("sig_contrainte", 11);
        $form->setMax("dossier_instruction_type", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_sig_contrainte_dossier_instruction_type', __('lien_sig_contrainte_dossier_instruction_type'));
        $form->setLib('sig_contrainte', __('sig_contrainte'));
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
        // sig_contrainte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_contrainte",
            $this->get_var_sql_forminc__sql("sig_contrainte"),
            $this->get_var_sql_forminc__sql("sig_contrainte_by_id"),
            false
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
            if($this->is_in_context_of_foreign_key('sig_contrainte', $this->retourformulaire))
                $form->setVal('sig_contrainte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

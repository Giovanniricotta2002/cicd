<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_dossier_instruction_type_evenement_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_instruction_type_evenement";

    var $table = "lien_dossier_instruction_type_evenement";
    var $clePrimaire = "lien_dossier_instruction_type_evenement";
    var $typeCle = "N";
    var $required_field = array(
        "lien_dossier_instruction_type_evenement"
    );
    
    var $foreign_keys_extended = array(
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "evenement" => array("evenement", ),
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
            "lien_dossier_instruction_type_evenement",
            "dossier_instruction_type",
            "evenement",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dossier_instruction_type_evenement'])) {
            $this->valF['lien_dossier_instruction_type_evenement'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_instruction_type_evenement'] = $val['lien_dossier_instruction_type_evenement'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = NULL;
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = NULL;
        } else {
            $this->valF['evenement'] = $val['evenement'];
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
            $form->setType("lien_dossier_instruction_type_evenement", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_instruction_type_evenement", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_instruction_type_evenement", "hiddenstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_instruction_type_evenement", "static");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_instruction_type_evenement','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_instruction_type_evenement", 11);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("evenement", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_instruction_type_evenement", 11);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("evenement", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_instruction_type_evenement', __('lien_dossier_instruction_type_evenement'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('evenement', __('evenement'));
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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

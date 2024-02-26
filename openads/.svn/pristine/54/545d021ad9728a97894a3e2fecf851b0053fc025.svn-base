<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

require_once "../obj/om_dbform.class.php";

class lien_dossier_nature_travaux_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_nature_travaux";

    var $table = "lien_dossier_nature_travaux";
    var $clePrimaire = "lien_dossier_nature_travaux";
    var $typeCle = "N";
    var $required_field = array(
        "dossier",
        "lien_dossier_nature_travaux",
        "nature_travaux"
    );
    var $unique_key = array(
      array("dossier","nature_travaux"),
    );
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "nature_travaux" => array("nature_travaux", ),
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
            "lien_dossier_nature_travaux",
            "dossier",
            "nature_travaux",
        );
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
        if (!is_numeric($val['lien_dossier_nature_travaux'])) {
            $this->valF['lien_dossier_nature_travaux'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_nature_travaux'] = $val['lien_dossier_nature_travaux'];
        }
        $this->valF['dossier'] = $val['dossier'];
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
            $form->setType("lien_dossier_nature_travaux", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("nature_travaux", $this->retourformulaire)) {
                $form->setType("nature_travaux", "selecthiddenstatic");
            } else {
                $form->setType("nature_travaux", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_nature_travaux", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("nature_travaux", $this->retourformulaire)) {
                $form->setType("nature_travaux", "selecthiddenstatic");
            } else {
                $form->setType("nature_travaux", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_nature_travaux", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("nature_travaux", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_nature_travaux", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("nature_travaux", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_nature_travaux','VerifNum(this)');
        $form->setOnchange('nature_travaux','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_nature_travaux", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("nature_travaux", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_nature_travaux", 11);
        $form->setMax("dossier", 255);
        $form->setMax("nature_travaux", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_nature_travaux', __('lien_dossier_nature_travaux'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('nature_travaux', __('nature_travaux'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('nature_travaux', $this->retourformulaire))
                $form->setVal('nature_travaux', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

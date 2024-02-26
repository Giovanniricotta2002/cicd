<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class lien_dossier_dossier_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_dossier";

    var $table = "lien_dossier_dossier";
    var $clePrimaire = "lien_dossier_dossier";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_cible",
        "dossier_src",
        "lien_dossier_dossier",
        "type_lien"
    );
    var $unique_key = array(
      array("dossier_cible","dossier_src"),
    );
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier_src");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_dossier_dossier",
            "dossier_src",
            "dossier_cible",
            "type_lien",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_cible() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_cible_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_src() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_src_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dossier_dossier'])) {
            $this->valF['lien_dossier_dossier'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_dossier'] = $val['lien_dossier_dossier'];
        }
        $this->valF['dossier_src'] = $val['dossier_src'];
        $this->valF['dossier_cible'] = $val['dossier_cible'];
            $this->valF['type_lien'] = $val['type_lien'];
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
            $form->setType("lien_dossier_dossier", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_src", "selecthiddenstatic");
            } else {
                $form->setType("dossier_src", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_cible", "selecthiddenstatic");
            } else {
                $form->setType("dossier_cible", "select");
            }
            $form->setType("type_lien", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_dossier", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_src", "selecthiddenstatic");
            } else {
                $form->setType("dossier_src", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_cible", "selecthiddenstatic");
            } else {
                $form->setType("dossier_cible", "select");
            }
            $form->setType("type_lien", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_dossier", "hiddenstatic");
            $form->setType("dossier_src", "selectstatic");
            $form->setType("dossier_cible", "selectstatic");
            $form->setType("type_lien", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_dossier", "static");
            $form->setType("dossier_src", "selectstatic");
            $form->setType("dossier_cible", "selectstatic");
            $form->setType("type_lien", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_dossier','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_dossier", 11);
        $form->setTaille("dossier_src", 30);
        $form->setTaille("dossier_cible", 30);
        $form->setTaille("type_lien", 4);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_dossier", 11);
        $form->setMax("dossier_src", 255);
        $form->setMax("dossier_cible", 255);
        $form->setMax("type_lien", 4);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_dossier', __('lien_dossier_dossier'));
        $form->setLib('dossier_src', __('dossier_src'));
        $form->setLib('dossier_cible', __('dossier_cible'));
        $form->setLib('type_lien', __('type_lien'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier_cible
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_cible",
            $this->get_var_sql_forminc__sql("dossier_cible"),
            $this->get_var_sql_forminc__sql("dossier_cible_by_id"),
            false
        );
        // dossier_src
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_src",
            $this->get_var_sql_forminc__sql("dossier_src"),
            $this->get_var_sql_forminc__sql("dossier_src_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_cible', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_src', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

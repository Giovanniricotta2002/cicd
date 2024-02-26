<?php
//$Id$ 
//gen openMairie le 23/01/2023 14:57

require_once "../obj/om_dbform.class.php";

class lien_dossier_tiers_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_tiers";

    var $table = "lien_dossier_tiers";
    var $clePrimaire = "lien_dossier_tiers";
    var $typeCle = "N";
    var $required_field = array(
        "dossier",
        "lien_dossier_tiers",
        "tiers"
    );
    var $unique_key = array(
      array("dossier","tiers"),
    );
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "tiers_consulte" => array("tiers_consulte", ),
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
            "lien_dossier_tiers",
            "dossier",
            "tiers",
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
    function get_var_sql_forminc__sql_tiers() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dossier_tiers'])) {
            $this->valF['lien_dossier_tiers'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_tiers'] = $val['lien_dossier_tiers'];
        }
        $this->valF['dossier'] = $val['dossier'];
        if (!is_numeric($val['tiers'])) {
            $this->valF['tiers'] = ""; // -> requis
        } else {
            $this->valF['tiers'] = $val['tiers'];
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
            $form->setType("lien_dossier_tiers", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers", "selecthiddenstatic");
            } else {
                $form->setType("tiers", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_tiers", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers", "selecthiddenstatic");
            } else {
                $form->setType("tiers", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_tiers", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("tiers", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_tiers", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("tiers", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_tiers','VerifNum(this)');
        $form->setOnchange('tiers','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_tiers", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("tiers", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_tiers", 11);
        $form->setMax("dossier", 255);
        $form->setMax("tiers", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_tiers', __('lien_dossier_tiers'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('tiers', __('tiers'));
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
        // tiers
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "tiers",
            $this->get_var_sql_forminc__sql("tiers"),
            $this->get_var_sql_forminc__sql("tiers_by_id"),
            false
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
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('tiers', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

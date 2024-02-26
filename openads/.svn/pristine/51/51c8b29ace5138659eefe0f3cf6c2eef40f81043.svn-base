<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

require_once "../obj/om_dbform.class.php";

class lien_habilitation_tiers_consulte_commune_gen extends om_dbform {

    protected $_absolute_class_name = "lien_habilitation_tiers_consulte_commune";

    var $table = "lien_habilitation_tiers_consulte_commune";
    var $clePrimaire = "lien_habilitation_tiers_consulte_commune";
    var $typeCle = "N";
    var $required_field = array(
        "commune",
        "habilitation_tiers_consulte",
        "lien_habilitation_tiers_consulte_commune"
    );
    
    var $foreign_keys_extended = array(
        "commune" => array("commune", ),
        "habilitation_tiers_consulte" => array("habilitation_tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("habilitation_tiers_consulte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_habilitation_tiers_consulte_commune",
            "habilitation_tiers_consulte",
            "commune",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE ((commune.om_validite_debut IS NULL AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)) OR (commune.om_validite_debut <= CURRENT_DATE AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE))) ORDER BY commune.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune_by_id() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE commune = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_habilitation_tiers_consulte() {
        return "SELECT habilitation_tiers_consulte.habilitation_tiers_consulte, habilitation_tiers_consulte.type_habilitation_tiers_consulte FROM ".DB_PREFIXE."habilitation_tiers_consulte WHERE ((habilitation_tiers_consulte.om_validite_debut IS NULL AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (habilitation_tiers_consulte.om_validite_fin IS NULL OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY habilitation_tiers_consulte.type_habilitation_tiers_consulte ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_habilitation_tiers_consulte_by_id() {
        return "SELECT habilitation_tiers_consulte.habilitation_tiers_consulte, habilitation_tiers_consulte.type_habilitation_tiers_consulte FROM ".DB_PREFIXE."habilitation_tiers_consulte WHERE habilitation_tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_habilitation_tiers_consulte_commune'])) {
            $this->valF['lien_habilitation_tiers_consulte_commune'] = ""; // -> requis
        } else {
            $this->valF['lien_habilitation_tiers_consulte_commune'] = $val['lien_habilitation_tiers_consulte_commune'];
        }
        if (!is_numeric($val['habilitation_tiers_consulte'])) {
            $this->valF['habilitation_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['habilitation_tiers_consulte'] = $val['habilitation_tiers_consulte'];
        }
        if (!is_numeric($val['commune'])) {
            $this->valF['commune'] = ""; // -> requis
        } else {
            $this->valF['commune'] = $val['commune'];
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
            $form->setType("lien_habilitation_tiers_consulte_commune", "hidden");
            if ($this->is_in_context_of_foreign_key("habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("habilitation_tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_habilitation_tiers_consulte_commune", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("habilitation_tiers_consulte", "select");
            }
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_habilitation_tiers_consulte_commune", "hiddenstatic");
            $form->setType("habilitation_tiers_consulte", "selectstatic");
            $form->setType("commune", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_habilitation_tiers_consulte_commune", "static");
            $form->setType("habilitation_tiers_consulte", "selectstatic");
            $form->setType("commune", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_habilitation_tiers_consulte_commune','VerifNum(this)');
        $form->setOnchange('habilitation_tiers_consulte','VerifNum(this)');
        $form->setOnchange('commune','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_habilitation_tiers_consulte_commune", 11);
        $form->setTaille("habilitation_tiers_consulte", 11);
        $form->setTaille("commune", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_habilitation_tiers_consulte_commune", 11);
        $form->setMax("habilitation_tiers_consulte", 11);
        $form->setMax("commune", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_habilitation_tiers_consulte_commune', __('lien_habilitation_tiers_consulte_commune'));
        $form->setLib('habilitation_tiers_consulte', __('habilitation_tiers_consulte'));
        $form->setLib('commune', __('commune'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // commune
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commune",
            $this->get_var_sql_forminc__sql("commune"),
            $this->get_var_sql_forminc__sql("commune_by_id"),
            true
        );
        // habilitation_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "habilitation_tiers_consulte",
            $this->get_var_sql_forminc__sql("habilitation_tiers_consulte"),
            $this->get_var_sql_forminc__sql("habilitation_tiers_consulte_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('commune', $this->retourformulaire))
                $form->setVal('commune', $idxformulaire);
            if($this->is_in_context_of_foreign_key('habilitation_tiers_consulte', $this->retourformulaire))
                $form->setVal('habilitation_tiers_consulte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_donnees_techniques_moyen_retenu_juge_gen extends om_dbform {

    protected $_absolute_class_name = "lien_donnees_techniques_moyen_retenu_juge";

    var $table = "lien_donnees_techniques_moyen_retenu_juge";
    var $clePrimaire = "lien_donnees_techniques_moyen_retenu_juge";
    var $typeCle = "N";
    var $required_field = array(
        "donnees_techniques",
        "lien_donnees_techniques_moyen_retenu_juge",
        "moyen_retenu_juge"
    );
    
    var $foreign_keys_extended = array(
        "donnees_techniques" => array("donnees_techniques", ),
        "moyen_retenu_juge" => array("moyen_retenu_juge", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("donnees_techniques");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_donnees_techniques_moyen_retenu_juge",
            "donnees_techniques",
            "moyen_retenu_juge",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_donnees_techniques() {
        return "SELECT donnees_techniques.donnees_techniques, donnees_techniques.dossier_instruction FROM ".DB_PREFIXE."donnees_techniques ORDER BY donnees_techniques.dossier_instruction ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_donnees_techniques_by_id() {
        return "SELECT donnees_techniques.donnees_techniques, donnees_techniques.dossier_instruction FROM ".DB_PREFIXE."donnees_techniques WHERE donnees_techniques = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_moyen_retenu_juge() {
        return "SELECT moyen_retenu_juge.moyen_retenu_juge, moyen_retenu_juge.libelle FROM ".DB_PREFIXE."moyen_retenu_juge WHERE ((moyen_retenu_juge.om_validite_debut IS NULL AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)) OR (moyen_retenu_juge.om_validite_debut <= CURRENT_DATE AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE))) ORDER BY moyen_retenu_juge.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_moyen_retenu_juge_by_id() {
        return "SELECT moyen_retenu_juge.moyen_retenu_juge, moyen_retenu_juge.libelle FROM ".DB_PREFIXE."moyen_retenu_juge WHERE moyen_retenu_juge = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_donnees_techniques_moyen_retenu_juge'])) {
            $this->valF['lien_donnees_techniques_moyen_retenu_juge'] = ""; // -> requis
        } else {
            $this->valF['lien_donnees_techniques_moyen_retenu_juge'] = $val['lien_donnees_techniques_moyen_retenu_juge'];
        }
        if (!is_numeric($val['donnees_techniques'])) {
            $this->valF['donnees_techniques'] = ""; // -> requis
        } else {
            $this->valF['donnees_techniques'] = $val['donnees_techniques'];
        }
        if (!is_numeric($val['moyen_retenu_juge'])) {
            $this->valF['moyen_retenu_juge'] = ""; // -> requis
        } else {
            $this->valF['moyen_retenu_juge'] = $val['moyen_retenu_juge'];
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
            $form->setType("lien_donnees_techniques_moyen_retenu_juge", "hidden");
            if ($this->is_in_context_of_foreign_key("donnees_techniques", $this->retourformulaire)) {
                $form->setType("donnees_techniques", "selecthiddenstatic");
            } else {
                $form->setType("donnees_techniques", "select");
            }
            if ($this->is_in_context_of_foreign_key("moyen_retenu_juge", $this->retourformulaire)) {
                $form->setType("moyen_retenu_juge", "selecthiddenstatic");
            } else {
                $form->setType("moyen_retenu_juge", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_donnees_techniques_moyen_retenu_juge", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("donnees_techniques", $this->retourformulaire)) {
                $form->setType("donnees_techniques", "selecthiddenstatic");
            } else {
                $form->setType("donnees_techniques", "select");
            }
            if ($this->is_in_context_of_foreign_key("moyen_retenu_juge", $this->retourformulaire)) {
                $form->setType("moyen_retenu_juge", "selecthiddenstatic");
            } else {
                $form->setType("moyen_retenu_juge", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_donnees_techniques_moyen_retenu_juge", "hiddenstatic");
            $form->setType("donnees_techniques", "selectstatic");
            $form->setType("moyen_retenu_juge", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_donnees_techniques_moyen_retenu_juge", "static");
            $form->setType("donnees_techniques", "selectstatic");
            $form->setType("moyen_retenu_juge", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_donnees_techniques_moyen_retenu_juge','VerifNum(this)');
        $form->setOnchange('donnees_techniques','VerifNum(this)');
        $form->setOnchange('moyen_retenu_juge','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_donnees_techniques_moyen_retenu_juge", 11);
        $form->setTaille("donnees_techniques", 11);
        $form->setTaille("moyen_retenu_juge", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_donnees_techniques_moyen_retenu_juge", 11);
        $form->setMax("donnees_techniques", 11);
        $form->setMax("moyen_retenu_juge", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_donnees_techniques_moyen_retenu_juge', __('lien_donnees_techniques_moyen_retenu_juge'));
        $form->setLib('donnees_techniques', __('donnees_techniques'));
        $form->setLib('moyen_retenu_juge', __('moyen_retenu_juge'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // donnees_techniques
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "donnees_techniques",
            $this->get_var_sql_forminc__sql("donnees_techniques"),
            $this->get_var_sql_forminc__sql("donnees_techniques_by_id"),
            false
        );
        // moyen_retenu_juge
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "moyen_retenu_juge",
            $this->get_var_sql_forminc__sql("moyen_retenu_juge"),
            $this->get_var_sql_forminc__sql("moyen_retenu_juge_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('donnees_techniques', $this->retourformulaire))
                $form->setVal('donnees_techniques', $idxformulaire);
            if($this->is_in_context_of_foreign_key('moyen_retenu_juge', $this->retourformulaire))
                $form->setVal('moyen_retenu_juge', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

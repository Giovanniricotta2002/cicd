<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_donnees_techniques_moyen_souleve_gen extends om_dbform {

    protected $_absolute_class_name = "lien_donnees_techniques_moyen_souleve";

    var $table = "lien_donnees_techniques_moyen_souleve";
    var $clePrimaire = "lien_donnees_techniques_moyen_souleve";
    var $typeCle = "N";
    var $required_field = array(
        "donnees_techniques",
        "lien_donnees_techniques_moyen_souleve",
        "moyen_souleve"
    );
    
    var $foreign_keys_extended = array(
        "donnees_techniques" => array("donnees_techniques", ),
        "moyen_souleve" => array("moyen_souleve", ),
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
            "lien_donnees_techniques_moyen_souleve",
            "donnees_techniques",
            "moyen_souleve",
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
    function get_var_sql_forminc__sql_moyen_souleve() {
        return "SELECT moyen_souleve.moyen_souleve, moyen_souleve.libelle FROM ".DB_PREFIXE."moyen_souleve WHERE ((moyen_souleve.om_validite_debut IS NULL AND (moyen_souleve.om_validite_fin IS NULL OR moyen_souleve.om_validite_fin > CURRENT_DATE)) OR (moyen_souleve.om_validite_debut <= CURRENT_DATE AND (moyen_souleve.om_validite_fin IS NULL OR moyen_souleve.om_validite_fin > CURRENT_DATE))) ORDER BY moyen_souleve.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_moyen_souleve_by_id() {
        return "SELECT moyen_souleve.moyen_souleve, moyen_souleve.libelle FROM ".DB_PREFIXE."moyen_souleve WHERE moyen_souleve = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_donnees_techniques_moyen_souleve'])) {
            $this->valF['lien_donnees_techniques_moyen_souleve'] = ""; // -> requis
        } else {
            $this->valF['lien_donnees_techniques_moyen_souleve'] = $val['lien_donnees_techniques_moyen_souleve'];
        }
        if (!is_numeric($val['donnees_techniques'])) {
            $this->valF['donnees_techniques'] = ""; // -> requis
        } else {
            $this->valF['donnees_techniques'] = $val['donnees_techniques'];
        }
        if (!is_numeric($val['moyen_souleve'])) {
            $this->valF['moyen_souleve'] = ""; // -> requis
        } else {
            $this->valF['moyen_souleve'] = $val['moyen_souleve'];
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
            $form->setType("lien_donnees_techniques_moyen_souleve", "hidden");
            if ($this->is_in_context_of_foreign_key("donnees_techniques", $this->retourformulaire)) {
                $form->setType("donnees_techniques", "selecthiddenstatic");
            } else {
                $form->setType("donnees_techniques", "select");
            }
            if ($this->is_in_context_of_foreign_key("moyen_souleve", $this->retourformulaire)) {
                $form->setType("moyen_souleve", "selecthiddenstatic");
            } else {
                $form->setType("moyen_souleve", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_donnees_techniques_moyen_souleve", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("donnees_techniques", $this->retourformulaire)) {
                $form->setType("donnees_techniques", "selecthiddenstatic");
            } else {
                $form->setType("donnees_techniques", "select");
            }
            if ($this->is_in_context_of_foreign_key("moyen_souleve", $this->retourformulaire)) {
                $form->setType("moyen_souleve", "selecthiddenstatic");
            } else {
                $form->setType("moyen_souleve", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_donnees_techniques_moyen_souleve", "hiddenstatic");
            $form->setType("donnees_techniques", "selectstatic");
            $form->setType("moyen_souleve", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_donnees_techniques_moyen_souleve", "static");
            $form->setType("donnees_techniques", "selectstatic");
            $form->setType("moyen_souleve", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_donnees_techniques_moyen_souleve','VerifNum(this)');
        $form->setOnchange('donnees_techniques','VerifNum(this)');
        $form->setOnchange('moyen_souleve','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_donnees_techniques_moyen_souleve", 11);
        $form->setTaille("donnees_techniques", 11);
        $form->setTaille("moyen_souleve", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_donnees_techniques_moyen_souleve", 11);
        $form->setMax("donnees_techniques", 11);
        $form->setMax("moyen_souleve", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_donnees_techniques_moyen_souleve', __('lien_donnees_techniques_moyen_souleve'));
        $form->setLib('donnees_techniques', __('donnees_techniques'));
        $form->setLib('moyen_souleve', __('moyen_souleve'));
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
        // moyen_souleve
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "moyen_souleve",
            $this->get_var_sql_forminc__sql("moyen_souleve"),
            $this->get_var_sql_forminc__sql("moyen_souleve_by_id"),
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
            if($this->is_in_context_of_foreign_key('moyen_souleve', $this->retourformulaire))
                $form->setVal('moyen_souleve', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

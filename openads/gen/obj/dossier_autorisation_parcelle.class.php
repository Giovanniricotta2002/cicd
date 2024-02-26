<?php
//$Id$ 
//gen openMairie le 22/10/2020 12:41

require_once "../obj/om_dbform.class.php";

class dossier_autorisation_parcelle_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_autorisation_parcelle";

    var $table = "dossier_autorisation_parcelle";
    var $clePrimaire = "dossier_autorisation_parcelle";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_autorisation",
        "dossier_autorisation_parcelle"
    );
    
    var $foreign_keys_extended = array(
        "dossier_autorisation" => array("dossier_autorisation", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("libelle");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_autorisation_parcelle",
            "dossier_autorisation",
            "parcelle",
            "libelle",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation ORDER BY dossier_autorisation.dossier_autorisation_type_detaille ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_by_id() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation WHERE dossier_autorisation = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_autorisation_parcelle'])) {
            $this->valF['dossier_autorisation_parcelle'] = ""; // -> requis
        } else {
            $this->valF['dossier_autorisation_parcelle'] = $val['dossier_autorisation_parcelle'];
        }
        $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        if ($val['parcelle'] == "") {
            $this->valF['parcelle'] = NULL;
        } else {
            $this->valF['parcelle'] = $val['parcelle'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
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
            $form->setType("dossier_autorisation_parcelle", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("parcelle", "text");
            $form->setType("libelle", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_autorisation_parcelle", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("parcelle", "text");
            $form->setType("libelle", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_autorisation_parcelle", "hiddenstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("parcelle", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_autorisation_parcelle", "static");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("parcelle", "static");
            $form->setType("libelle", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_autorisation_parcelle','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_autorisation_parcelle", 11);
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("parcelle", 20);
        $form->setTaille("libelle", 20);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_autorisation_parcelle", 11);
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("parcelle", 20);
        $form->setMax("libelle", 20);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_autorisation_parcelle', __('dossier_autorisation_parcelle'));
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('parcelle', __('parcelle'));
        $form->setLib('libelle', __('libelle'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier_autorisation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation",
            $this->get_var_sql_forminc__sql("dossier_autorisation"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier_autorisation', $this->retourformulaire))
                $form->setVal('dossier_autorisation', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

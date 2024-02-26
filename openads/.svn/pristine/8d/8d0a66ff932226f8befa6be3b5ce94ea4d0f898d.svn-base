<?php
//$Id$ 
//gen openMairie le 22/10/2020 12:41

require_once "../obj/om_dbform.class.php";

class lien_dossier_autorisation_demandeur_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_autorisation_demandeur";

    var $table = "lien_dossier_autorisation_demandeur";
    var $clePrimaire = "lien_dossier_autorisation_demandeur";
    var $typeCle = "N";
    var $required_field = array(
        "lien_dossier_autorisation_demandeur"
    );
    
    var $foreign_keys_extended = array(
        "demandeur" => array("demandeur", ),
        "dossier_autorisation" => array("dossier_autorisation", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("petitionnaire_principal");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_dossier_autorisation_demandeur",
            "petitionnaire_principal",
            "dossier_autorisation",
            "demandeur",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur() {
        return "SELECT demandeur.demandeur, demandeur.type_demandeur FROM ".DB_PREFIXE."demandeur ORDER BY demandeur.type_demandeur ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur_by_id() {
        return "SELECT demandeur.demandeur, demandeur.type_demandeur FROM ".DB_PREFIXE."demandeur WHERE demandeur = <idx>";
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
        if (!is_numeric($val['lien_dossier_autorisation_demandeur'])) {
            $this->valF['lien_dossier_autorisation_demandeur'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_autorisation_demandeur'] = $val['lien_dossier_autorisation_demandeur'];
        }
        if ($val['petitionnaire_principal'] == 1 || $val['petitionnaire_principal'] == "t" || $val['petitionnaire_principal'] == "Oui") {
            $this->valF['petitionnaire_principal'] = true;
        } else {
            $this->valF['petitionnaire_principal'] = false;
        }
        if ($val['dossier_autorisation'] == "") {
            $this->valF['dossier_autorisation'] = NULL;
        } else {
            $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        }
        if (!is_numeric($val['demandeur'])) {
            $this->valF['demandeur'] = NULL;
        } else {
            $this->valF['demandeur'] = $val['demandeur'];
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
            $form->setType("lien_dossier_autorisation_demandeur", "hidden");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_autorisation_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_autorisation_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "hiddenstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_autorisation_demandeur", "static");
            $form->setType("petitionnaire_principal", "checkboxstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_autorisation_demandeur','VerifNum(this)');
        $form->setOnchange('demandeur','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_autorisation_demandeur", 11);
        $form->setTaille("petitionnaire_principal", 1);
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("demandeur", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_autorisation_demandeur", 11);
        $form->setMax("petitionnaire_principal", 1);
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("demandeur", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_autorisation_demandeur', __('lien_dossier_autorisation_demandeur'));
        $form->setLib('petitionnaire_principal', __('petitionnaire_principal'));
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('demandeur', __('demandeur'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // demandeur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demandeur",
            $this->get_var_sql_forminc__sql("demandeur"),
            $this->get_var_sql_forminc__sql("demandeur_by_id"),
            false
        );
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
            if($this->is_in_context_of_foreign_key('demandeur', $this->retourformulaire))
                $form->setVal('demandeur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation', $this->retourformulaire))
                $form->setVal('dossier_autorisation', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

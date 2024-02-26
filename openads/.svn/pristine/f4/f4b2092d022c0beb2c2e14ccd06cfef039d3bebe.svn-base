<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class lien_dossier_demandeur_gen extends om_dbform {

    protected $_absolute_class_name = "lien_dossier_demandeur";

    var $table = "lien_dossier_demandeur";
    var $clePrimaire = "lien_dossier_demandeur";
    var $typeCle = "N";
    var $required_field = array(
        "lien_dossier_demandeur"
    );
    
    var $foreign_keys_extended = array(
        "demandeur" => array("demandeur", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
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
            "lien_dossier_demandeur",
            "petitionnaire_principal",
            "dossier",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_dossier_demandeur'])) {
            $this->valF['lien_dossier_demandeur'] = ""; // -> requis
        } else {
            $this->valF['lien_dossier_demandeur'] = $val['lien_dossier_demandeur'];
        }
        if ($val['petitionnaire_principal'] == 1 || $val['petitionnaire_principal'] == "t" || $val['petitionnaire_principal'] == "Oui") {
            $this->valF['petitionnaire_principal'] = true;
        } else {
            $this->valF['petitionnaire_principal'] = false;
        }
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
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
            $form->setType("lien_dossier_demandeur", "hidden");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_dossier_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_dossier_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_dossier_demandeur", "static");
            $form->setType("petitionnaire_principal", "checkboxstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_dossier_demandeur','VerifNum(this)');
        $form->setOnchange('demandeur','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_dossier_demandeur", 11);
        $form->setTaille("petitionnaire_principal", 1);
        $form->setTaille("dossier", 30);
        $form->setTaille("demandeur", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_dossier_demandeur", 11);
        $form->setMax("petitionnaire_principal", 1);
        $form->setMax("dossier", 255);
        $form->setMax("demandeur", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_dossier_demandeur', __('lien_dossier_demandeur'));
        $form->setLib('petitionnaire_principal', __('petitionnaire_principal'));
        $form->setLib('dossier', __('dossier'));
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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('demandeur', $this->retourformulaire))
                $form->setVal('demandeur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

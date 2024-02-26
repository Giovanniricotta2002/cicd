<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class dossier_contrainte_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_contrainte";

    var $table = "dossier_contrainte";
    var $clePrimaire = "dossier_contrainte";
    var $typeCle = "N";
    var $required_field = array(
        "contrainte",
        "dossier",
        "dossier_contrainte"
    );
    
    var $foreign_keys_extended = array(
        "contrainte" => array("contrainte", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
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
            "dossier_contrainte",
            "dossier",
            "contrainte",
            "texte_complete",
            "reference",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_contrainte() {
        return "SELECT contrainte.contrainte, contrainte.libelle FROM ".DB_PREFIXE."contrainte WHERE ((contrainte.om_validite_debut IS NULL AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE)) OR (contrainte.om_validite_debut <= CURRENT_DATE AND (contrainte.om_validite_fin IS NULL OR contrainte.om_validite_fin > CURRENT_DATE))) ORDER BY contrainte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_contrainte_by_id() {
        return "SELECT contrainte.contrainte, contrainte.libelle FROM ".DB_PREFIXE."contrainte WHERE contrainte = <idx>";
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
        if (!is_numeric($val['dossier_contrainte'])) {
            $this->valF['dossier_contrainte'] = ""; // -> requis
        } else {
            $this->valF['dossier_contrainte'] = $val['dossier_contrainte'];
        }
        $this->valF['dossier'] = $val['dossier'];
        if (!is_numeric($val['contrainte'])) {
            $this->valF['contrainte'] = ""; // -> requis
        } else {
            $this->valF['contrainte'] = $val['contrainte'];
        }
            $this->valF['texte_complete'] = $val['texte_complete'];
        if ($val['reference'] == 1 || $val['reference'] == "t" || $val['reference'] == "Oui") {
            $this->valF['reference'] = true;
        } else {
            $this->valF['reference'] = false;
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
            $form->setType("dossier_contrainte", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("contrainte", $this->retourformulaire)) {
                $form->setType("contrainte", "selecthiddenstatic");
            } else {
                $form->setType("contrainte", "select");
            }
            $form->setType("texte_complete", "textarea");
            $form->setType("reference", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_contrainte", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("contrainte", $this->retourformulaire)) {
                $form->setType("contrainte", "selecthiddenstatic");
            } else {
                $form->setType("contrainte", "select");
            }
            $form->setType("texte_complete", "textarea");
            $form->setType("reference", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_contrainte", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("contrainte", "selectstatic");
            $form->setType("texte_complete", "hiddenstatic");
            $form->setType("reference", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_contrainte", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("contrainte", "selectstatic");
            $form->setType("texte_complete", "textareastatic");
            $form->setType("reference", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_contrainte','VerifNum(this)');
        $form->setOnchange('contrainte','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_contrainte", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("contrainte", 11);
        $form->setTaille("texte_complete", 80);
        $form->setTaille("reference", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_contrainte", 11);
        $form->setMax("dossier", 255);
        $form->setMax("contrainte", 11);
        $form->setMax("texte_complete", 6);
        $form->setMax("reference", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_contrainte', __('dossier_contrainte'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('contrainte', __('contrainte'));
        $form->setLib('texte_complete', __('texte_complete'));
        $form->setLib('reference', __('reference'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // contrainte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "contrainte",
            $this->get_var_sql_forminc__sql("contrainte"),
            $this->get_var_sql_forminc__sql("contrainte_by_id"),
            true
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
            if($this->is_in_context_of_foreign_key('contrainte', $this->retourformulaire))
                $form->setVal('contrainte', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

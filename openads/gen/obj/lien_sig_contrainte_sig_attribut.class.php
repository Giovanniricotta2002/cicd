<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class lien_sig_contrainte_sig_attribut_gen extends om_dbform {

    protected $_absolute_class_name = "lien_sig_contrainte_sig_attribut";

    var $table = "lien_sig_contrainte_sig_attribut";
    var $clePrimaire = "lien_sig_contrainte_sig_attribut";
    var $typeCle = "N";
    var $required_field = array(
        "lien_sig_contrainte_sig_attribut",
        "sig_attribut",
        "sig_contrainte",
        "valeur"
    );
    
    var $foreign_keys_extended = array(
        "sig_attribut" => array("sig_attribut", ),
        "sig_contrainte" => array("sig_contrainte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("sig_contrainte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_sig_contrainte_sig_attribut",
            "sig_contrainte",
            "sig_attribut",
            "valeur",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_attribut() {
        return "SELECT sig_attribut.sig_attribut, sig_attribut.libelle FROM ".DB_PREFIXE."sig_attribut ORDER BY sig_attribut.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_attribut_by_id() {
        return "SELECT sig_attribut.sig_attribut, sig_attribut.libelle FROM ".DB_PREFIXE."sig_attribut WHERE sig_attribut = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte ORDER BY sig_contrainte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte_by_id() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte WHERE sig_contrainte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_sig_contrainte_sig_attribut'])) {
            $this->valF['lien_sig_contrainte_sig_attribut'] = ""; // -> requis
        } else {
            $this->valF['lien_sig_contrainte_sig_attribut'] = $val['lien_sig_contrainte_sig_attribut'];
        }
        if (!is_numeric($val['sig_contrainte'])) {
            $this->valF['sig_contrainte'] = ""; // -> requis
        } else {
            $this->valF['sig_contrainte'] = $val['sig_contrainte'];
        }
        if (!is_numeric($val['sig_attribut'])) {
            $this->valF['sig_attribut'] = ""; // -> requis
        } else {
            $this->valF['sig_attribut'] = $val['sig_attribut'];
        }
        $this->valF['valeur'] = $val['valeur'];
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
            $form->setType("lien_sig_contrainte_sig_attribut", "hidden");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("sig_attribut", $this->retourformulaire)) {
                $form->setType("sig_attribut", "selecthiddenstatic");
            } else {
                $form->setType("sig_attribut", "select");
            }
            $form->setType("valeur", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_sig_contrainte_sig_attribut", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("sig_attribut", $this->retourformulaire)) {
                $form->setType("sig_attribut", "selecthiddenstatic");
            } else {
                $form->setType("sig_attribut", "select");
            }
            $form->setType("valeur", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_sig_contrainte_sig_attribut", "hiddenstatic");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("sig_attribut", "selectstatic");
            $form->setType("valeur", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_sig_contrainte_sig_attribut", "static");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("sig_attribut", "selectstatic");
            $form->setType("valeur", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_sig_contrainte_sig_attribut','VerifNum(this)');
        $form->setOnchange('sig_contrainte','VerifNum(this)');
        $form->setOnchange('sig_attribut','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_sig_contrainte_sig_attribut", 11);
        $form->setTaille("sig_contrainte", 11);
        $form->setTaille("sig_attribut", 11);
        $form->setTaille("valeur", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_sig_contrainte_sig_attribut", 11);
        $form->setMax("sig_contrainte", 11);
        $form->setMax("sig_attribut", 11);
        $form->setMax("valeur", 250);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_sig_contrainte_sig_attribut', __('lien_sig_contrainte_sig_attribut'));
        $form->setLib('sig_contrainte', __('sig_contrainte'));
        $form->setLib('sig_attribut', __('sig_attribut'));
        $form->setLib('valeur', __('valeur'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // sig_attribut
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_attribut",
            $this->get_var_sql_forminc__sql("sig_attribut"),
            $this->get_var_sql_forminc__sql("sig_attribut_by_id"),
            false
        );
        // sig_contrainte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_contrainte",
            $this->get_var_sql_forminc__sql("sig_contrainte"),
            $this->get_var_sql_forminc__sql("sig_contrainte_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('sig_attribut', $this->retourformulaire))
                $form->setVal('sig_attribut', $idxformulaire);
            if($this->is_in_context_of_foreign_key('sig_contrainte', $this->retourformulaire))
                $form->setVal('sig_contrainte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

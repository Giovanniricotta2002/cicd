<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class sig_attribut_gen extends om_dbform {

    protected $_absolute_class_name = "sig_attribut";

    var $table = "sig_attribut";
    var $clePrimaire = "sig_attribut";
    var $typeCle = "N";
    var $required_field = array(
        "identifiant",
        "libelle",
        "sig_attribut",
        "sig_couche"
    );
    
    var $foreign_keys_extended = array(
        "sig_couche" => array("sig_couche", ),
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
            "sig_attribut",
            "sig_couche",
            "libelle",
            "identifiant",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche() {
        return "SELECT sig_couche.sig_couche, sig_couche.libelle FROM ".DB_PREFIXE."sig_couche ORDER BY sig_couche.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche_by_id() {
        return "SELECT sig_couche.sig_couche, sig_couche.libelle FROM ".DB_PREFIXE."sig_couche WHERE sig_couche = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['sig_attribut'])) {
            $this->valF['sig_attribut'] = ""; // -> requis
        } else {
            $this->valF['sig_attribut'] = $val['sig_attribut'];
        }
        if (!is_numeric($val['sig_couche'])) {
            $this->valF['sig_couche'] = ""; // -> requis
        } else {
            $this->valF['sig_couche'] = $val['sig_couche'];
        }
        $this->valF['libelle'] = $val['libelle'];
        $this->valF['identifiant'] = $val['identifiant'];
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
            $form->setType("sig_attribut", "hidden");
            if ($this->is_in_context_of_foreign_key("sig_couche", $this->retourformulaire)) {
                $form->setType("sig_couche", "selecthiddenstatic");
            } else {
                $form->setType("sig_couche", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("identifiant", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("sig_attribut", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("sig_couche", $this->retourformulaire)) {
                $form->setType("sig_couche", "selecthiddenstatic");
            } else {
                $form->setType("sig_couche", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("identifiant", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("sig_attribut", "hiddenstatic");
            $form->setType("sig_couche", "selectstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("identifiant", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("sig_attribut", "static");
            $form->setType("sig_couche", "selectstatic");
            $form->setType("libelle", "static");
            $form->setType("identifiant", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('sig_attribut','VerifNum(this)');
        $form->setOnchange('sig_couche','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("sig_attribut", 11);
        $form->setTaille("sig_couche", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("identifiant", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("sig_attribut", 11);
        $form->setMax("sig_couche", 11);
        $form->setMax("libelle", 250);
        $form->setMax("identifiant", 250);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('sig_attribut', __('sig_attribut'));
        $form->setLib('sig_couche', __('sig_couche'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('identifiant', __('identifiant'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // sig_couche
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_couche",
            $this->get_var_sql_forminc__sql("sig_couche"),
            $this->get_var_sql_forminc__sql("sig_couche_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('sig_couche', $this->retourformulaire))
                $form->setVal('sig_couche', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    
    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::cleSecondaire($id);
        // Verification de la cle secondaire : lien_sig_contrainte_sig_attribut
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_sig_attribut", "sig_attribut", $id);
    }


}

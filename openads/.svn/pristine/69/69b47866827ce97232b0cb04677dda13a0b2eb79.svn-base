<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class sig_couche_gen extends om_dbform {

    protected $_absolute_class_name = "sig_couche";

    var $table = "sig_couche";
    var $clePrimaire = "sig_couche";
    var $typeCle = "N";
    var $required_field = array(
        "id_couche",
        "libelle",
        "sig_couche"
    );
    
    var $foreign_keys_extended = array(
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
            "sig_couche",
            "libelle",
            "id_couche",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['sig_couche'])) {
            $this->valF['sig_couche'] = ""; // -> requis
        } else {
            $this->valF['sig_couche'] = $val['sig_couche'];
        }
        $this->valF['libelle'] = $val['libelle'];
        $this->valF['id_couche'] = $val['id_couche'];
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
            $form->setType("sig_couche", "hidden");
            $form->setType("libelle", "text");
            $form->setType("id_couche", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("sig_couche", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("id_couche", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("sig_couche", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("id_couche", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("sig_couche", "static");
            $form->setType("libelle", "static");
            $form->setType("id_couche", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('sig_couche','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("sig_couche", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("id_couche", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("sig_couche", 11);
        $form->setMax("libelle", 250);
        $form->setMax("id_couche", 250);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('sig_couche', __('sig_couche'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('id_couche', __('id_couche'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
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
        // Verification de la cle secondaire : sig_attribut
        $this->rechercheTable($this->f->db, "sig_attribut", "sig_couche", $id);
        // Verification de la cle secondaire : sig_contrainte
        $this->rechercheTable($this->f->db, "sig_contrainte", "sig_couche", $id);
    }


}

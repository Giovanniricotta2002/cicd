<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class sig_groupe_gen extends om_dbform {

    protected $_absolute_class_name = "sig_groupe";

    var $table = "sig_groupe";
    var $clePrimaire = "sig_groupe";
    var $typeCle = "N";
    var $required_field = array(
        "libelle",
        "sig_groupe"
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
            "sig_groupe",
            "libelle",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['sig_groupe'])) {
            $this->valF['sig_groupe'] = ""; // -> requis
        } else {
            $this->valF['sig_groupe'] = $val['sig_groupe'];
        }
        $this->valF['libelle'] = $val['libelle'];
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
            $form->setType("sig_groupe", "hidden");
            $form->setType("libelle", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("sig_groupe", "hiddenstatic");
            $form->setType("libelle", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("sig_groupe", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("sig_groupe", "static");
            $form->setType("libelle", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('sig_groupe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("sig_groupe", 11);
        $form->setTaille("libelle", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("sig_groupe", 11);
        $form->setMax("libelle", 250);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('sig_groupe', __('sig_groupe'));
        $form->setLib('libelle', __('libelle'));
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
        // Verification de la cle secondaire : sig_contrainte
        $this->rechercheTable($this->f->db, "sig_contrainte", "groupe", $id);
    }


}

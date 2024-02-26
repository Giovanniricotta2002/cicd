<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class arrondissement_gen extends om_dbform {

    protected $_absolute_class_name = "arrondissement";

    var $table = "arrondissement";
    var $clePrimaire = "arrondissement";
    var $typeCle = "N";
    var $required_field = array(
        "arrondissement",
        "code_impots",
        "code_postal",
        "libelle"
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
            "arrondissement",
            "libelle",
            "code_postal",
            "code_impots",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['arrondissement'])) {
            $this->valF['arrondissement'] = ""; // -> requis
        } else {
            $this->valF['arrondissement'] = $val['arrondissement'];
        }
        $this->valF['libelle'] = $val['libelle'];
        $this->valF['code_postal'] = $val['code_postal'];
        $this->valF['code_impots'] = $val['code_impots'];
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
            $form->setType("arrondissement", "hidden");
            $form->setType("libelle", "text");
            $form->setType("code_postal", "text");
            $form->setType("code_impots", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("arrondissement", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("code_postal", "text");
            $form->setType("code_impots", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("arrondissement", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("code_postal", "hiddenstatic");
            $form->setType("code_impots", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("arrondissement", "static");
            $form->setType("libelle", "static");
            $form->setType("code_postal", "static");
            $form->setType("code_impots", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('arrondissement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("arrondissement", 11);
        $form->setTaille("libelle", 10);
        $form->setTaille("code_postal", 10);
        $form->setTaille("code_impots", 10);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("arrondissement", 11);
        $form->setMax("libelle", 3);
        $form->setMax("code_postal", 5);
        $form->setMax("code_impots", 3);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('arrondissement', __('arrondissement'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('code_postal', __('code_postal'));
        $form->setLib('code_impots', __('code_impots'));
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
        // Verification de la cle secondaire : affectation_automatique
        $this->rechercheTable($this->f->db, "affectation_automatique", "arrondissement", $id);
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "arrondissement", $id);
        // Verification de la cle secondaire : dossier_autorisation
        $this->rechercheTable($this->f->db, "dossier_autorisation", "arrondissement", $id);
        // Verification de la cle secondaire : quartier
        $this->rechercheTable($this->f->db, "quartier", "arrondissement", $id);
    }


}

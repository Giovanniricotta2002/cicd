<?php
//$Id$ 
//gen openMairie le 07/01/2022 14:14

require_once "../obj/om_dbform.class.php";

class document_numerise_type_categorie_gen extends om_dbform {

    protected $_absolute_class_name = "document_numerise_type_categorie";

    var $table = "document_numerise_type_categorie";
    var $clePrimaire = "document_numerise_type_categorie";
    var $typeCle = "N";
    var $required_field = array(
        "document_numerise_type_categorie",
        "libelle"
    );
    var $unique_key = array(
      "code",
      "libelle",
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
            "document_numerise_type_categorie",
            "libelle",
            "code",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['document_numerise_type_categorie'])) {
            $this->valF['document_numerise_type_categorie'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type_categorie'] = $val['document_numerise_type_categorie'];
        }
        $this->valF['libelle'] = $val['libelle'];
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
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
            $form->setType("document_numerise_type_categorie", "hidden");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("document_numerise_type_categorie", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("document_numerise_type_categorie", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("document_numerise_type_categorie", "static");
            $form->setType("libelle", "static");
            $form->setType("code", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('document_numerise_type_categorie','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("document_numerise_type_categorie", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("code", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("document_numerise_type_categorie", 11);
        $form->setMax("libelle", 255);
        $form->setMax("code", 50);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('document_numerise_type_categorie', __('document_numerise_type_categorie'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('code', __('code'));
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
        // Verification de la cle secondaire : document_numerise_type
        $this->rechercheTable($this->f->db, "document_numerise_type", "document_numerise_type_categorie", $id);
    }


}

<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class genre_gen extends om_dbform {

    protected $_absolute_class_name = "genre";

    var $table = "genre";
    var $clePrimaire = "genre";
    var $typeCle = "N";
    var $required_field = array(
        "genre"
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
            "genre",
            "code",
            "libelle",
            "description",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['genre'])) {
            $this->valF['genre'] = ""; // -> requis
        } else {
            $this->valF['genre'] = $val['genre'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
            $this->valF['description'] = $val['description'];
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
            $form->setType("genre", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("genre", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("genre", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("genre", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('genre','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("genre", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("genre", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('genre', __('genre'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
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
        // Verification de la cle secondaire : groupe
        $this->rechercheTable($this->f->db, "groupe", "genre", $id);
    }


}

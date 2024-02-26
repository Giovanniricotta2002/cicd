<?php
//$Id$ 
//gen openMairie le 23/11/2021 19:20

require_once "../obj/om_dbform.class.php";

class lien_id_interne_uid_externe_gen extends om_dbform {

    protected $_absolute_class_name = "lien_id_interne_uid_externe";

    var $table = "lien_id_interne_uid_externe";
    var $clePrimaire = "lien_id_interne_uid_externe";
    var $typeCle = "N";
    var $required_field = array(
        "external_uid",
        "lien_id_interne_uid_externe",
        "object",
        "object_id"
    );
    var $unique_key = array(
      array("category","external_uid","object","object_id"),
    );
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("object");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_id_interne_uid_externe",
            "object",
            "object_id",
            "external_uid",
            "dossier",
            "category",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_id_interne_uid_externe'])) {
            $this->valF['lien_id_interne_uid_externe'] = ""; // -> requis
        } else {
            $this->valF['lien_id_interne_uid_externe'] = $val['lien_id_interne_uid_externe'];
        }
        $this->valF['object'] = $val['object'];
        $this->valF['object_id'] = $val['object_id'];
        $this->valF['external_uid'] = $val['external_uid'];
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
        }
        if ($val['category'] == "") {
            $this->valF['category'] = NULL;
        } else {
            $this->valF['category'] = $val['category'];
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
            $form->setType("lien_id_interne_uid_externe", "hidden");
            $form->setType("object", "text");
            $form->setType("object_id", "text");
            $form->setType("external_uid", "text");
            $form->setType("dossier", "text");
            $form->setType("category", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_id_interne_uid_externe", "hiddenstatic");
            $form->setType("object", "text");
            $form->setType("object_id", "text");
            $form->setType("external_uid", "text");
            $form->setType("dossier", "text");
            $form->setType("category", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_id_interne_uid_externe", "hiddenstatic");
            $form->setType("object", "hiddenstatic");
            $form->setType("object_id", "hiddenstatic");
            $form->setType("external_uid", "hiddenstatic");
            $form->setType("dossier", "hiddenstatic");
            $form->setType("category", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_id_interne_uid_externe", "static");
            $form->setType("object", "static");
            $form->setType("object_id", "static");
            $form->setType("external_uid", "static");
            $form->setType("dossier", "static");
            $form->setType("category", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_id_interne_uid_externe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_id_interne_uid_externe", 11);
        $form->setTaille("object", 30);
        $form->setTaille("object_id", 30);
        $form->setTaille("external_uid", 30);
        $form->setTaille("dossier", 30);
        $form->setTaille("category", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_id_interne_uid_externe", 11);
        $form->setMax("object", 30);
        $form->setMax("object_id", 30);
        $form->setMax("external_uid", 255);
        $form->setMax("dossier", 255);
        $form->setMax("category", 2000);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_id_interne_uid_externe', __('lien_id_interne_uid_externe'));
        $form->setLib('object', __('object'));
        $form->setLib('object_id', __('object_id'));
        $form->setLib('external_uid', __('external_uid'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('category', __('category'));
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
    

}

<?php
//$Id$ 
//gen openMairie le 17/04/2020 11:36

require_once "../obj/om_dbform.class.php";

class lien_document_numerise_type_instructeur_qualite_gen extends om_dbform {

    protected $_absolute_class_name = "lien_document_numerise_type_instructeur_qualite";

    var $table = "lien_document_numerise_type_instructeur_qualite";
    var $clePrimaire = "lien_document_numerise_type_instructeur_qualite";
    var $typeCle = "N";
    var $required_field = array(
        "document_numerise_type",
        "instructeur_qualite",
        "lien_document_numerise_type_instructeur_qualite"
    );
    
    var $foreign_keys_extended = array(
        "document_numerise_type" => array("document_numerise_type", ),
        "instructeur_qualite" => array("instructeur_qualite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("document_numerise_type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_document_numerise_type_instructeur_qualite",
            "document_numerise_type",
            "instructeur_qualite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type() {
        return "SELECT document_numerise_type.document_numerise_type, document_numerise_type.libelle FROM ".DB_PREFIXE."document_numerise_type WHERE ((document_numerise_type.om_validite_debut IS NULL AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE)) OR (document_numerise_type.om_validite_debut <= CURRENT_DATE AND (document_numerise_type.om_validite_fin IS NULL OR document_numerise_type.om_validite_fin > CURRENT_DATE))) ORDER BY document_numerise_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_by_id() {
        return "SELECT document_numerise_type.document_numerise_type, document_numerise_type.libelle FROM ".DB_PREFIXE."document_numerise_type WHERE document_numerise_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_qualite() {
        return "SELECT instructeur_qualite.instructeur_qualite, instructeur_qualite.libelle FROM ".DB_PREFIXE."instructeur_qualite ORDER BY instructeur_qualite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_qualite_by_id() {
        return "SELECT instructeur_qualite.instructeur_qualite, instructeur_qualite.libelle FROM ".DB_PREFIXE."instructeur_qualite WHERE instructeur_qualite = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_document_numerise_type_instructeur_qualite'])) {
            $this->valF['lien_document_numerise_type_instructeur_qualite'] = ""; // -> requis
        } else {
            $this->valF['lien_document_numerise_type_instructeur_qualite'] = $val['lien_document_numerise_type_instructeur_qualite'];
        }
        if (!is_numeric($val['document_numerise_type'])) {
            $this->valF['document_numerise_type'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type'] = $val['document_numerise_type'];
        }
        if (!is_numeric($val['instructeur_qualite'])) {
            $this->valF['instructeur_qualite'] = ""; // -> requis
        } else {
            $this->valF['instructeur_qualite'] = $val['instructeur_qualite'];
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
            $form->setType("lien_document_numerise_type_instructeur_qualite", "hidden");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("instructeur_qualite", $this->retourformulaire)) {
                $form->setType("instructeur_qualite", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_qualite", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_document_numerise_type_instructeur_qualite", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("instructeur_qualite", $this->retourformulaire)) {
                $form->setType("instructeur_qualite", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_qualite", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_document_numerise_type_instructeur_qualite", "hiddenstatic");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("instructeur_qualite", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_document_numerise_type_instructeur_qualite", "static");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("instructeur_qualite", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_document_numerise_type_instructeur_qualite','VerifNum(this)');
        $form->setOnchange('document_numerise_type','VerifNum(this)');
        $form->setOnchange('instructeur_qualite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_document_numerise_type_instructeur_qualite", 11);
        $form->setTaille("document_numerise_type", 11);
        $form->setTaille("instructeur_qualite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_document_numerise_type_instructeur_qualite", 11);
        $form->setMax("document_numerise_type", 11);
        $form->setMax("instructeur_qualite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_document_numerise_type_instructeur_qualite', __('lien_document_numerise_type_instructeur_qualite'));
        $form->setLib('document_numerise_type', __('document_numerise_type'));
        $form->setLib('instructeur_qualite', __('instructeur_qualite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // document_numerise_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise_type",
            $this->get_var_sql_forminc__sql("document_numerise_type"),
            $this->get_var_sql_forminc__sql("document_numerise_type_by_id"),
            true
        );
        // instructeur_qualite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instructeur_qualite",
            $this->get_var_sql_forminc__sql("instructeur_qualite"),
            $this->get_var_sql_forminc__sql("instructeur_qualite_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('document_numerise_type', $this->retourformulaire))
                $form->setVal('document_numerise_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instructeur_qualite', $this->retourformulaire))
                $form->setVal('instructeur_qualite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

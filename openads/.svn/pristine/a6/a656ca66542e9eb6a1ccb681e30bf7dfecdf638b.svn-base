<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class document_numerise_gen extends om_dbform {

    protected $_absolute_class_name = "document_numerise";

    var $table = "document_numerise";
    var $clePrimaire = "document_numerise";
    var $typeCle = "N";
    var $required_field = array(
        "date_creation",
        "document_numerise",
        "document_numerise_type",
        "dossier",
        "nom_fichier",
        "uid"
    );
    var $unique_key = array(
      "uid",
    );
    var $foreign_keys_extended = array(
        "document_numerise_nature" => array("document_numerise_nature", ),
        "document_numerise_type" => array("document_numerise_type", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("uid");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "document_numerise",
            "uid",
            "dossier",
            "nom_fichier",
            "date_creation",
            "document_numerise_type",
            "uid_dossier_final",
            "document_numerise_nature",
            "uid_thumbnail",
            "description_type",
            "document_travail",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_nature() {
        return "SELECT document_numerise_nature.document_numerise_nature, document_numerise_nature.libelle FROM ".DB_PREFIXE."document_numerise_nature WHERE ((document_numerise_nature.om_validite_debut IS NULL AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE)) OR (document_numerise_nature.om_validite_debut <= CURRENT_DATE AND (document_numerise_nature.om_validite_fin IS NULL OR document_numerise_nature.om_validite_fin > CURRENT_DATE))) ORDER BY document_numerise_nature.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_nature_by_id() {
        return "SELECT document_numerise_nature.document_numerise_nature, document_numerise_nature.libelle FROM ".DB_PREFIXE."document_numerise_nature WHERE document_numerise_nature = <idx>";
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
        if (!is_numeric($val['document_numerise'])) {
            $this->valF['document_numerise'] = ""; // -> requis
        } else {
            $this->valF['document_numerise'] = $val['document_numerise'];
        }
        $this->valF['uid'] = $val['uid'];
        $this->valF['dossier'] = $val['dossier'];
        $this->valF['nom_fichier'] = $val['nom_fichier'];
        if ($val['date_creation'] != "") {
            $this->valF['date_creation'] = $this->dateDB($val['date_creation']);
        }
        if (!is_numeric($val['document_numerise_type'])) {
            $this->valF['document_numerise_type'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type'] = $val['document_numerise_type'];
        }
        if ($val['uid_dossier_final'] == 1 || $val['uid_dossier_final'] == "t" || $val['uid_dossier_final'] == "Oui") {
            $this->valF['uid_dossier_final'] = true;
        } else {
            $this->valF['uid_dossier_final'] = false;
        }
        if (!is_numeric($val['document_numerise_nature'])) {
            $this->valF['document_numerise_nature'] = NULL;
        } else {
            $this->valF['document_numerise_nature'] = $val['document_numerise_nature'];
        }
        if ($val['uid_thumbnail'] == "") {
            $this->valF['uid_thumbnail'] = NULL;
        } else {
            $this->valF['uid_thumbnail'] = $val['uid_thumbnail'];
        }
        if ($val['description_type'] == "") {
            $this->valF['description_type'] = NULL;
        } else {
            $this->valF['description_type'] = $val['description_type'];
        }
        if ($val['document_travail'] == 1 || $val['document_travail'] == "t" || $val['document_travail'] == "Oui") {
            $this->valF['document_travail'] = true;
        } else {
            $this->valF['document_travail'] = false;
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
            $form->setType("document_numerise", "hidden");
            $form->setType("uid", "text");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("nom_fichier", "text");
            $form->setType("date_creation", "date");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            $form->setType("uid_dossier_final", "checkbox");
            if ($this->is_in_context_of_foreign_key("document_numerise_nature", $this->retourformulaire)) {
                $form->setType("document_numerise_nature", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_nature", "select");
            }
            $form->setType("uid_thumbnail", "text");
            $form->setType("description_type", "text");
            $form->setType("document_travail", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("document_numerise", "hiddenstatic");
            $form->setType("uid", "text");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("nom_fichier", "text");
            $form->setType("date_creation", "date");
            if ($this->is_in_context_of_foreign_key("document_numerise_type", $this->retourformulaire)) {
                $form->setType("document_numerise_type", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type", "select");
            }
            $form->setType("uid_dossier_final", "checkbox");
            if ($this->is_in_context_of_foreign_key("document_numerise_nature", $this->retourformulaire)) {
                $form->setType("document_numerise_nature", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_nature", "select");
            }
            $form->setType("uid_thumbnail", "text");
            $form->setType("description_type", "text");
            $form->setType("document_travail", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("document_numerise", "hiddenstatic");
            $form->setType("uid", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("nom_fichier", "hiddenstatic");
            $form->setType("date_creation", "hiddenstatic");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("uid_dossier_final", "hiddenstatic");
            $form->setType("document_numerise_nature", "selectstatic");
            $form->setType("uid_thumbnail", "hiddenstatic");
            $form->setType("description_type", "hiddenstatic");
            $form->setType("document_travail", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("document_numerise", "static");
            $form->setType("uid", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("nom_fichier", "static");
            $form->setType("date_creation", "datestatic");
            $form->setType("document_numerise_type", "selectstatic");
            $form->setType("uid_dossier_final", "checkboxstatic");
            $form->setType("document_numerise_nature", "selectstatic");
            $form->setType("uid_thumbnail", "static");
            $form->setType("description_type", "static");
            $form->setType("document_travail", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('document_numerise','VerifNum(this)');
        $form->setOnchange('date_creation','fdate(this)');
        $form->setOnchange('document_numerise_type','VerifNum(this)');
        $form->setOnchange('document_numerise_nature','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("document_numerise", 11);
        $form->setTaille("uid", 30);
        $form->setTaille("dossier", 30);
        $form->setTaille("nom_fichier", 30);
        $form->setTaille("date_creation", 12);
        $form->setTaille("document_numerise_type", 11);
        $form->setTaille("uid_dossier_final", 1);
        $form->setTaille("document_numerise_nature", 11);
        $form->setTaille("uid_thumbnail", 30);
        $form->setTaille("description_type", 30);
        $form->setTaille("document_travail", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("document_numerise", 11);
        $form->setMax("uid", 255);
        $form->setMax("dossier", 255);
        $form->setMax("nom_fichier", 255);
        $form->setMax("date_creation", 12);
        $form->setMax("document_numerise_type", 11);
        $form->setMax("uid_dossier_final", 1);
        $form->setMax("document_numerise_nature", 11);
        $form->setMax("uid_thumbnail", 255);
        $form->setMax("description_type", 2000);
        $form->setMax("document_travail", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('document_numerise', __('document_numerise'));
        $form->setLib('uid', __('uid'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('nom_fichier', __('nom_fichier'));
        $form->setLib('date_creation', __('date_creation'));
        $form->setLib('document_numerise_type', __('document_numerise_type'));
        $form->setLib('uid_dossier_final', __('uid_dossier_final'));
        $form->setLib('document_numerise_nature', __('document_numerise_nature'));
        $form->setLib('uid_thumbnail', __('uid_thumbnail'));
        $form->setLib('description_type', __('description_type'));
        $form->setLib('document_travail', __('document_travail'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // document_numerise_nature
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise_nature",
            $this->get_var_sql_forminc__sql("document_numerise_nature"),
            $this->get_var_sql_forminc__sql("document_numerise_nature_by_id"),
            true
        );
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
            if($this->is_in_context_of_foreign_key('document_numerise_nature', $this->retourformulaire))
                $form->setVal('document_numerise_nature', $idxformulaire);
            if($this->is_in_context_of_foreign_key('document_numerise_type', $this->retourformulaire))
                $form->setVal('document_numerise_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
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
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "document_numerise", $id);
    }


}

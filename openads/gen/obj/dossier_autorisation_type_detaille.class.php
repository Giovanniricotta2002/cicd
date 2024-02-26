<?php
//$Id$ 
//gen openMairie le 24/05/2023 13:50

require_once "../obj/om_dbform.class.php";

class dossier_autorisation_type_detaille_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_autorisation_type_detaille";

    var $table = "dossier_autorisation_type_detaille";
    var $clePrimaire = "dossier_autorisation_type_detaille";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_autorisation_type",
        "dossier_autorisation_type_detaille"
    );
    
    var $foreign_keys_extended = array(
        "cerfa" => array("cerfa", ),
        "dossier_autorisation_type" => array("dossier_autorisation_type", ),
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
            "dossier_autorisation_type_detaille",
            "code",
            "libelle",
            "description",
            "dossier_autorisation_type",
            "cerfa",
            "cerfa_lot",
            "duree_validite_parametrage",
            "dossier_platau",
            "couleur",
            "secret_instruction",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_cerfa() {
        return "SELECT cerfa.cerfa, cerfa.libelle FROM ".DB_PREFIXE."cerfa WHERE ((cerfa.om_validite_debut IS NULL AND (cerfa.om_validite_fin IS NULL OR cerfa.om_validite_fin > CURRENT_DATE)) OR (cerfa.om_validite_debut <= CURRENT_DATE AND (cerfa.om_validite_fin IS NULL OR cerfa.om_validite_fin > CURRENT_DATE))) ORDER BY cerfa.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_cerfa_by_id() {
        return "SELECT cerfa.cerfa, cerfa.libelle FROM ".DB_PREFIXE."cerfa WHERE cerfa = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_cerfa_lot() {
        return "SELECT cerfa.cerfa, cerfa.libelle FROM ".DB_PREFIXE."cerfa WHERE ((cerfa.om_validite_debut IS NULL AND (cerfa.om_validite_fin IS NULL OR cerfa.om_validite_fin > CURRENT_DATE)) OR (cerfa.om_validite_debut <= CURRENT_DATE AND (cerfa.om_validite_fin IS NULL OR cerfa.om_validite_fin > CURRENT_DATE))) ORDER BY cerfa.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_cerfa_lot_by_id() {
        return "SELECT cerfa.cerfa, cerfa.libelle FROM ".DB_PREFIXE."cerfa WHERE cerfa = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, dossier_autorisation_type.libelle FROM ".DB_PREFIXE."dossier_autorisation_type ORDER BY dossier_autorisation_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_by_id() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, dossier_autorisation_type.libelle FROM ".DB_PREFIXE."dossier_autorisation_type WHERE dossier_autorisation_type = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = ""; // -> requis
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
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
        if (!is_numeric($val['dossier_autorisation_type'])) {
            $this->valF['dossier_autorisation_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_autorisation_type'] = $val['dossier_autorisation_type'];
        }
        if (!is_numeric($val['cerfa'])) {
            $this->valF['cerfa'] = NULL;
        } else {
            $this->valF['cerfa'] = $val['cerfa'];
        }
        if (!is_numeric($val['cerfa_lot'])) {
            $this->valF['cerfa_lot'] = NULL;
        } else {
            $this->valF['cerfa_lot'] = $val['cerfa_lot'];
        }
        if (!is_numeric($val['duree_validite_parametrage'])) {
            $this->valF['duree_validite_parametrage'] = 0; // -> default
        } else {
            $this->valF['duree_validite_parametrage'] = $val['duree_validite_parametrage'];
        }
        if ($val['dossier_platau'] == 1 || $val['dossier_platau'] == "t" || $val['dossier_platau'] == "Oui") {
            $this->valF['dossier_platau'] = true;
        } else {
            $this->valF['dossier_platau'] = false;
        }
        if ($val['couleur'] == "") {
            $this->valF['couleur'] = NULL;
        } else {
            $this->valF['couleur'] = $val['couleur'];
        }
        if ($val['secret_instruction'] == 1 || $val['secret_instruction'] == "t" || $val['secret_instruction'] == "Oui") {
            $this->valF['secret_instruction'] = true;
        } else {
            $this->valF['secret_instruction'] = false;
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
            $form->setType("dossier_autorisation_type_detaille", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("cerfa", $this->retourformulaire)) {
                $form->setType("cerfa", "selecthiddenstatic");
            } else {
                $form->setType("cerfa", "select");
            }
            if ($this->is_in_context_of_foreign_key("cerfa", $this->retourformulaire)) {
                $form->setType("cerfa_lot", "selecthiddenstatic");
            } else {
                $form->setType("cerfa_lot", "select");
            }
            $form->setType("duree_validite_parametrage", "text");
            $form->setType("dossier_platau", "checkbox");
            $form->setType("couleur", "text");
            $form->setType("secret_instruction", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_autorisation_type_detaille", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("cerfa", $this->retourformulaire)) {
                $form->setType("cerfa", "selecthiddenstatic");
            } else {
                $form->setType("cerfa", "select");
            }
            if ($this->is_in_context_of_foreign_key("cerfa", $this->retourformulaire)) {
                $form->setType("cerfa_lot", "selecthiddenstatic");
            } else {
                $form->setType("cerfa_lot", "select");
            }
            $form->setType("duree_validite_parametrage", "text");
            $form->setType("dossier_platau", "checkbox");
            $form->setType("couleur", "text");
            $form->setType("secret_instruction", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_autorisation_type_detaille", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("dossier_autorisation_type", "selectstatic");
            $form->setType("cerfa", "selectstatic");
            $form->setType("cerfa_lot", "selectstatic");
            $form->setType("duree_validite_parametrage", "hiddenstatic");
            $form->setType("dossier_platau", "hiddenstatic");
            $form->setType("couleur", "hiddenstatic");
            $form->setType("secret_instruction", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_autorisation_type_detaille", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("dossier_autorisation_type", "selectstatic");
            $form->setType("cerfa", "selectstatic");
            $form->setType("cerfa_lot", "selectstatic");
            $form->setType("duree_validite_parametrage", "static");
            $form->setType("dossier_platau", "checkboxstatic");
            $form->setType("couleur", "static");
            $form->setType("secret_instruction", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type','VerifNum(this)');
        $form->setOnchange('cerfa','VerifNum(this)');
        $form->setOnchange('cerfa_lot','VerifNum(this)');
        $form->setOnchange('duree_validite_parametrage','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("dossier_autorisation_type", 11);
        $form->setTaille("cerfa", 11);
        $form->setTaille("cerfa_lot", 11);
        $form->setTaille("duree_validite_parametrage", 11);
        $form->setTaille("dossier_platau", 1);
        $form->setTaille("couleur", 10);
        $form->setTaille("secret_instruction", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("dossier_autorisation_type", 11);
        $form->setMax("cerfa", 11);
        $form->setMax("cerfa_lot", 11);
        $form->setMax("duree_validite_parametrage", 11);
        $form->setMax("dossier_platau", 1);
        $form->setMax("couleur", 6);
        $form->setMax("secret_instruction", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('dossier_autorisation_type', __('dossier_autorisation_type'));
        $form->setLib('cerfa', __('cerfa'));
        $form->setLib('cerfa_lot', __('cerfa_lot'));
        $form->setLib('duree_validite_parametrage', __('duree_validite_parametrage'));
        $form->setLib('dossier_platau', __('dossier_platau'));
        $form->setLib('couleur', __('couleur'));
        $form->setLib('secret_instruction', __('secret_instruction'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // cerfa
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "cerfa",
            $this->get_var_sql_forminc__sql("cerfa"),
            $this->get_var_sql_forminc__sql("cerfa_by_id"),
            true
        );
        // cerfa_lot
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "cerfa_lot",
            $this->get_var_sql_forminc__sql("cerfa_lot"),
            $this->get_var_sql_forminc__sql("cerfa_lot_by_id"),
            true
        );
        // dossier_autorisation_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation_type",
            $this->get_var_sql_forminc__sql("dossier_autorisation_type"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('cerfa', $this->retourformulaire))
                $form->setVal('cerfa', $idxformulaire);
            if($this->is_in_context_of_foreign_key('cerfa', $this->retourformulaire))
                $form->setVal('cerfa_lot', $idxformulaire);
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
        // Verification de la cle secondaire : affectation_automatique
        $this->rechercheTable($this->f->db, "affectation_automatique", "dossier_autorisation_type_detaille", $id);
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "dossier_autorisation_type_detaille", $id);
        // Verification de la cle secondaire : demande_type
        $this->rechercheTable($this->f->db, "demande_type", "dossier_autorisation_type_detaille", $id);
        // Verification de la cle secondaire : dossier_autorisation
        $this->rechercheTable($this->f->db, "dossier_autorisation", "dossier_autorisation_type_detaille", $id);
        // Verification de la cle secondaire : dossier_instruction_type
        $this->rechercheTable($this->f->db, "dossier_instruction_type", "dossier_autorisation_type_detaille", $id);
    }


}

<?php
//$Id$ 
//gen openMairie le 30/11/2021 18:58

require_once "../obj/om_dbform.class.php";

class avis_decision_gen extends om_dbform {

    protected $_absolute_class_name = "avis_decision";

    var $table = "avis_decision";
    var $clePrimaire = "avis_decision";
    var $typeCle = "N";
    var $required_field = array(
        "avis_decision",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
        "avis_decision_nature" => array("avis_decision_nature", ),
        "avis_decision_type" => array("avis_decision_type", ),
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
            "libelle",
            "typeavis",
            "sitadel",
            "sitadel_motif",
            "avis_decision",
            "tacite",
            "avis_decision_type",
            "avis_decision_nature",
            "prescription",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_nature() {
        return "SELECT avis_decision_nature.avis_decision_nature, avis_decision_nature.libelle FROM ".DB_PREFIXE."avis_decision_nature WHERE ((avis_decision_nature.om_validite_debut IS NULL AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE)) OR (avis_decision_nature.om_validite_debut <= CURRENT_DATE AND (avis_decision_nature.om_validite_fin IS NULL OR avis_decision_nature.om_validite_fin > CURRENT_DATE))) ORDER BY avis_decision_nature.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_nature_by_id() {
        return "SELECT avis_decision_nature.avis_decision_nature, avis_decision_nature.libelle FROM ".DB_PREFIXE."avis_decision_nature WHERE avis_decision_nature = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_type() {
        return "SELECT avis_decision_type.avis_decision_type, avis_decision_type.libelle FROM ".DB_PREFIXE."avis_decision_type WHERE ((avis_decision_type.om_validite_debut IS NULL AND (avis_decision_type.om_validite_fin IS NULL OR avis_decision_type.om_validite_fin > CURRENT_DATE)) OR (avis_decision_type.om_validite_debut <= CURRENT_DATE AND (avis_decision_type.om_validite_fin IS NULL OR avis_decision_type.om_validite_fin > CURRENT_DATE))) ORDER BY avis_decision_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_type_by_id() {
        return "SELECT avis_decision_type.avis_decision_type, avis_decision_type.libelle FROM ".DB_PREFIXE."avis_decision_type WHERE avis_decision_type = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['libelle'] = $val['libelle'];
        if ($val['typeavis'] == "") {
            $this->valF['typeavis'] = ""; // -> default
        } else {
            $this->valF['typeavis'] = $val['typeavis'];
        }
        if ($val['sitadel'] == "") {
            $this->valF['sitadel'] = ""; // -> default
        } else {
            $this->valF['sitadel'] = $val['sitadel'];
        }
        if ($val['sitadel_motif'] == "") {
            $this->valF['sitadel_motif'] = ""; // -> default
        } else {
            $this->valF['sitadel_motif'] = $val['sitadel_motif'];
        }
        if (!is_numeric($val['avis_decision'])) {
            $this->valF['avis_decision'] = ""; // -> requis
        } else {
            $this->valF['avis_decision'] = $val['avis_decision'];
        }
        if ($val['tacite'] == 1 || $val['tacite'] == "t" || $val['tacite'] == "Oui") {
            $this->valF['tacite'] = true;
        } else {
            $this->valF['tacite'] = false;
        }
        if (!is_numeric($val['avis_decision_type'])) {
            $this->valF['avis_decision_type'] = NULL;
        } else {
            $this->valF['avis_decision_type'] = $val['avis_decision_type'];
        }
        if (!is_numeric($val['avis_decision_nature'])) {
            $this->valF['avis_decision_nature'] = NULL;
        } else {
            $this->valF['avis_decision_nature'] = $val['avis_decision_nature'];
        }
        if ($val['prescription'] == 1 || $val['prescription'] == "t" || $val['prescription'] == "Oui") {
            $this->valF['prescription'] = true;
        } else {
            $this->valF['prescription'] = false;
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
            $form->setType("libelle", "text");
            $form->setType("typeavis", "text");
            $form->setType("sitadel", "text");
            $form->setType("sitadel_motif", "text");
            $form->setType("avis_decision", "hidden");
            $form->setType("tacite", "checkbox");
            if ($this->is_in_context_of_foreign_key("avis_decision_type", $this->retourformulaire)) {
                $form->setType("avis_decision_type", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("avis_decision_nature", $this->retourformulaire)) {
                $form->setType("avis_decision_nature", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision_nature", "select");
            }
            $form->setType("prescription", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("libelle", "text");
            $form->setType("typeavis", "text");
            $form->setType("sitadel", "text");
            $form->setType("sitadel_motif", "text");
            $form->setType("avis_decision", "hiddenstatic");
            $form->setType("tacite", "checkbox");
            if ($this->is_in_context_of_foreign_key("avis_decision_type", $this->retourformulaire)) {
                $form->setType("avis_decision_type", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("avis_decision_nature", $this->retourformulaire)) {
                $form->setType("avis_decision_nature", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision_nature", "select");
            }
            $form->setType("prescription", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("libelle", "hiddenstatic");
            $form->setType("typeavis", "hiddenstatic");
            $form->setType("sitadel", "hiddenstatic");
            $form->setType("sitadel_motif", "hiddenstatic");
            $form->setType("avis_decision", "hiddenstatic");
            $form->setType("tacite", "hiddenstatic");
            $form->setType("avis_decision_type", "selectstatic");
            $form->setType("avis_decision_nature", "selectstatic");
            $form->setType("prescription", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("libelle", "static");
            $form->setType("typeavis", "static");
            $form->setType("sitadel", "static");
            $form->setType("sitadel_motif", "static");
            $form->setType("avis_decision", "static");
            $form->setType("tacite", "checkboxstatic");
            $form->setType("avis_decision_type", "selectstatic");
            $form->setType("avis_decision_nature", "selectstatic");
            $form->setType("prescription", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('avis_decision','VerifNum(this)');
        $form->setOnchange('avis_decision_type','VerifNum(this)');
        $form->setOnchange('avis_decision_nature','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("libelle", 30);
        $form->setTaille("typeavis", 10);
        $form->setTaille("sitadel", 10);
        $form->setTaille("sitadel_motif", 10);
        $form->setTaille("avis_decision", 11);
        $form->setTaille("tacite", 1);
        $form->setTaille("avis_decision_type", 11);
        $form->setTaille("avis_decision_nature", 11);
        $form->setTaille("prescription", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("libelle", 50);
        $form->setMax("typeavis", 1);
        $form->setMax("sitadel", 1);
        $form->setMax("sitadel_motif", 1);
        $form->setMax("avis_decision", 11);
        $form->setMax("tacite", 1);
        $form->setMax("avis_decision_type", 11);
        $form->setMax("avis_decision_nature", 11);
        $form->setMax("prescription", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('libelle', __('libelle'));
        $form->setLib('typeavis', __('typeavis'));
        $form->setLib('sitadel', __('sitadel'));
        $form->setLib('sitadel_motif', __('sitadel_motif'));
        $form->setLib('avis_decision', __('avis_decision'));
        $form->setLib('tacite', __('tacite'));
        $form->setLib('avis_decision_type', __('avis_decision_type'));
        $form->setLib('avis_decision_nature', __('avis_decision_nature'));
        $form->setLib('prescription', __('prescription'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // avis_decision_nature
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "avis_decision_nature",
            $this->get_var_sql_forminc__sql("avis_decision_nature"),
            $this->get_var_sql_forminc__sql("avis_decision_nature_by_id"),
            true
        );
        // avis_decision_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "avis_decision_type",
            $this->get_var_sql_forminc__sql("avis_decision_type"),
            $this->get_var_sql_forminc__sql("avis_decision_type_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('avis_decision_nature', $this->retourformulaire))
                $form->setVal('avis_decision_nature', $idxformulaire);
            if($this->is_in_context_of_foreign_key('avis_decision_type', $this->retourformulaire))
                $form->setVal('avis_decision_type', $idxformulaire);
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
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "avis_decision", $id);
        // Verification de la cle secondaire : dossier_autorisation
        $this->rechercheTable($this->f->db, "dossier_autorisation", "avis_decision", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "avis_decision", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "avis_decision", $id);
    }


}

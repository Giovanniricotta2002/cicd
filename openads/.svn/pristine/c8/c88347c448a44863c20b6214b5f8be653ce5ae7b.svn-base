<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

require_once "../obj/om_dbform.class.php";

class dossier_instruction_type_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_instruction_type";

    var $table = "dossier_instruction_type";
    var $clePrimaire = "dossier_instruction_type";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_instruction_type"
    );
    
    var $foreign_keys_extended = array(
        "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
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
            "dossier_instruction_type",
            "code",
            "libelle",
            "description",
            "dossier_autorisation_type_detaille",
            "suffixe",
            "mouvement_sitadel",
            "maj_da_localisation",
            "maj_da_lot",
            "maj_da_demandeur",
            "maj_da_etat",
            "maj_da_date_init",
            "maj_da_date_validite",
            "maj_da_date_doc",
            "maj_da_date_daact",
            "maj_da_dt",
            "sous_dossier",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille ORDER BY dossier_autorisation_type_detaille.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
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
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = NULL;
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
        }
        if ($val['suffixe'] == 1 || $val['suffixe'] == "t" || $val['suffixe'] == "Oui") {
            $this->valF['suffixe'] = true;
        } else {
            $this->valF['suffixe'] = false;
        }
        if ($val['mouvement_sitadel'] == "") {
            $this->valF['mouvement_sitadel'] = NULL;
        } else {
            $this->valF['mouvement_sitadel'] = $val['mouvement_sitadel'];
        }
        if ($val['maj_da_localisation'] == 1 || $val['maj_da_localisation'] == "t" || $val['maj_da_localisation'] == "Oui") {
            $this->valF['maj_da_localisation'] = true;
        } else {
            $this->valF['maj_da_localisation'] = false;
        }
        if ($val['maj_da_lot'] == 1 || $val['maj_da_lot'] == "t" || $val['maj_da_lot'] == "Oui") {
            $this->valF['maj_da_lot'] = true;
        } else {
            $this->valF['maj_da_lot'] = false;
        }
        if ($val['maj_da_demandeur'] == 1 || $val['maj_da_demandeur'] == "t" || $val['maj_da_demandeur'] == "Oui") {
            $this->valF['maj_da_demandeur'] = true;
        } else {
            $this->valF['maj_da_demandeur'] = false;
        }
        if ($val['maj_da_etat'] == 1 || $val['maj_da_etat'] == "t" || $val['maj_da_etat'] == "Oui") {
            $this->valF['maj_da_etat'] = true;
        } else {
            $this->valF['maj_da_etat'] = false;
        }
        if ($val['maj_da_date_init'] == 1 || $val['maj_da_date_init'] == "t" || $val['maj_da_date_init'] == "Oui") {
            $this->valF['maj_da_date_init'] = true;
        } else {
            $this->valF['maj_da_date_init'] = false;
        }
        if ($val['maj_da_date_validite'] == 1 || $val['maj_da_date_validite'] == "t" || $val['maj_da_date_validite'] == "Oui") {
            $this->valF['maj_da_date_validite'] = true;
        } else {
            $this->valF['maj_da_date_validite'] = false;
        }
        if ($val['maj_da_date_doc'] == 1 || $val['maj_da_date_doc'] == "t" || $val['maj_da_date_doc'] == "Oui") {
            $this->valF['maj_da_date_doc'] = true;
        } else {
            $this->valF['maj_da_date_doc'] = false;
        }
        if ($val['maj_da_date_daact'] == 1 || $val['maj_da_date_daact'] == "t" || $val['maj_da_date_daact'] == "Oui") {
            $this->valF['maj_da_date_daact'] = true;
        } else {
            $this->valF['maj_da_date_daact'] = false;
        }
        if ($val['maj_da_dt'] == 1 || $val['maj_da_dt'] == "t" || $val['maj_da_dt'] == "Oui") {
            $this->valF['maj_da_dt'] = true;
        } else {
            $this->valF['maj_da_dt'] = false;
        }
        if ($val['sous_dossier'] == 1 || $val['sous_dossier'] == "t" || $val['sous_dossier'] == "Oui") {
            $this->valF['sous_dossier'] = true;
        } else {
            $this->valF['sous_dossier'] = false;
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
            $form->setType("dossier_instruction_type", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("suffixe", "checkbox");
            $form->setType("mouvement_sitadel", "text");
            $form->setType("maj_da_localisation", "checkbox");
            $form->setType("maj_da_lot", "checkbox");
            $form->setType("maj_da_demandeur", "checkbox");
            $form->setType("maj_da_etat", "checkbox");
            $form->setType("maj_da_date_init", "checkbox");
            $form->setType("maj_da_date_validite", "checkbox");
            $form->setType("maj_da_date_doc", "checkbox");
            $form->setType("maj_da_date_daact", "checkbox");
            $form->setType("maj_da_dt", "checkbox");
            $form->setType("sous_dossier", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_instruction_type", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("suffixe", "checkbox");
            $form->setType("mouvement_sitadel", "text");
            $form->setType("maj_da_localisation", "checkbox");
            $form->setType("maj_da_lot", "checkbox");
            $form->setType("maj_da_demandeur", "checkbox");
            $form->setType("maj_da_etat", "checkbox");
            $form->setType("maj_da_date_init", "checkbox");
            $form->setType("maj_da_date_validite", "checkbox");
            $form->setType("maj_da_date_doc", "checkbox");
            $form->setType("maj_da_date_daact", "checkbox");
            $form->setType("maj_da_dt", "checkbox");
            $form->setType("sous_dossier", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_instruction_type", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("suffixe", "hiddenstatic");
            $form->setType("mouvement_sitadel", "hiddenstatic");
            $form->setType("maj_da_localisation", "hiddenstatic");
            $form->setType("maj_da_lot", "hiddenstatic");
            $form->setType("maj_da_demandeur", "hiddenstatic");
            $form->setType("maj_da_etat", "hiddenstatic");
            $form->setType("maj_da_date_init", "hiddenstatic");
            $form->setType("maj_da_date_validite", "hiddenstatic");
            $form->setType("maj_da_date_doc", "hiddenstatic");
            $form->setType("maj_da_date_daact", "hiddenstatic");
            $form->setType("maj_da_dt", "hiddenstatic");
            $form->setType("sous_dossier", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_instruction_type", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("suffixe", "checkboxstatic");
            $form->setType("mouvement_sitadel", "static");
            $form->setType("maj_da_localisation", "checkboxstatic");
            $form->setType("maj_da_lot", "checkboxstatic");
            $form->setType("maj_da_demandeur", "checkboxstatic");
            $form->setType("maj_da_etat", "checkboxstatic");
            $form->setType("maj_da_date_init", "checkboxstatic");
            $form->setType("maj_da_date_validite", "checkboxstatic");
            $form->setType("maj_da_date_doc", "checkboxstatic");
            $form->setType("maj_da_date_daact", "checkboxstatic");
            $form->setType("maj_da_dt", "checkboxstatic");
            $form->setType("sous_dossier", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("suffixe", 1);
        $form->setTaille("mouvement_sitadel", 20);
        $form->setTaille("maj_da_localisation", 1);
        $form->setTaille("maj_da_lot", 1);
        $form->setTaille("maj_da_demandeur", 1);
        $form->setTaille("maj_da_etat", 1);
        $form->setTaille("maj_da_date_init", 1);
        $form->setTaille("maj_da_date_validite", 1);
        $form->setTaille("maj_da_date_doc", 1);
        $form->setTaille("maj_da_date_daact", 1);
        $form->setTaille("maj_da_dt", 1);
        $form->setTaille("sous_dossier", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("suffixe", 1);
        $form->setMax("mouvement_sitadel", 20);
        $form->setMax("maj_da_localisation", 1);
        $form->setMax("maj_da_lot", 1);
        $form->setMax("maj_da_demandeur", 1);
        $form->setMax("maj_da_etat", 1);
        $form->setMax("maj_da_date_init", 1);
        $form->setMax("maj_da_date_validite", 1);
        $form->setMax("maj_da_date_doc", 1);
        $form->setMax("maj_da_date_daact", 1);
        $form->setMax("maj_da_dt", 1);
        $form->setMax("sous_dossier", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('suffixe', __('suffixe'));
        $form->setLib('mouvement_sitadel', __('mouvement_sitadel'));
        $form->setLib('maj_da_localisation', __('maj_da_localisation'));
        $form->setLib('maj_da_lot', __('maj_da_lot'));
        $form->setLib('maj_da_demandeur', __('maj_da_demandeur'));
        $form->setLib('maj_da_etat', __('maj_da_etat'));
        $form->setLib('maj_da_date_init', __('maj_da_date_init'));
        $form->setLib('maj_da_date_validite', __('maj_da_date_validite'));
        $form->setLib('maj_da_date_doc', __('maj_da_date_doc'));
        $form->setLib('maj_da_date_daact', __('maj_da_date_daact'));
        $form->setLib('maj_da_dt', __('maj_da_dt'));
        $form->setLib('sous_dossier', __('sous_dossier'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier_autorisation_type_detaille
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation_type_detaille",
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type_detaille', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type_detaille', $idxformulaire);
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
        $this->rechercheTable($this->f->db, "affectation_automatique", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : demande_type
        $this->rechercheTable($this->f->db, "demande_type", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_demande_type_dossier_instruction_type
        $this->rechercheTable($this->f->db, "lien_demande_type_dossier_instruction_type", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_dit_nature_travaux
        $this->rechercheTable($this->f->db, "lien_dit_nature_travaux", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_document_n_type_d_i_t
        $this->rechercheTable($this->f->db, "lien_document_n_type_d_i_t", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_dossier_instruction_type_categorie_tiers
        $this->rechercheTable($this->f->db, "lien_dossier_instruction_type_categorie_tiers", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_dossier_instruction_type_evenement
        $this->rechercheTable($this->f->db, "lien_dossier_instruction_type_evenement", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_dossier_instruction_type
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_dossier_instruction_type", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_type_di_type_di
        $this->rechercheTable($this->f->db, "lien_type_di_type_di", "dossier_instruction_type", $id);
        // Verification de la cle secondaire : lien_type_di_type_di
        $this->rechercheTable($this->f->db, "lien_type_di_type_di", "type_di_parent", $id);
    }


}

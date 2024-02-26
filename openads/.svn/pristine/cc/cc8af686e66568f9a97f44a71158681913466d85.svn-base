<?php
//$Id$ 
//gen openMairie le 15/11/2018 16:09

require_once "../obj/om_dbform.class.php";

class demande_type_gen extends om_dbform {

    protected $_absolute_class_name = "demande_type";

    var $table = "demande_type";
    var $clePrimaire = "demande_type";
    var $typeCle = "N";
    var $required_field = array(
        "code",
        "demande_nature",
        "demande_type",
        "evenement",
        "groupe",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
        "demande_nature" => array("demande_nature", ),
        "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "evenement" => array("evenement", ),
        "groupe" => array("groupe", ),
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
            "demande_type",
            "code",
            "libelle",
            "description",
            "demande_nature",
            "groupe",
            "dossier_instruction_type",
            "dossier_autorisation_type_detaille",
            "contraintes",
            "qualification",
            "evenement",
            "document_obligatoire",
            "regeneration_cle_citoyen",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_nature() {
        return "SELECT demande_nature.demande_nature, demande_nature.libelle FROM ".DB_PREFIXE."demande_nature ORDER BY demande_nature.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_nature_by_id() {
        return "SELECT demande_nature.demande_nature, demande_nature.libelle FROM ".DB_PREFIXE."demande_nature WHERE demande_nature = <idx>";
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type ORDER BY dossier_instruction_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type WHERE dossier_instruction_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe() {
        return "SELECT groupe.groupe, groupe.libelle FROM ".DB_PREFIXE."groupe ORDER BY groupe.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe_by_id() {
        return "SELECT groupe.groupe, groupe.libelle FROM ".DB_PREFIXE."groupe WHERE groupe = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['demande_type'])) {
            $this->valF['demande_type'] = ""; // -> requis
        } else {
            $this->valF['demande_type'] = $val['demande_type'];
        }
        $this->valF['code'] = $val['code'];
        $this->valF['libelle'] = $val['libelle'];
            $this->valF['description'] = $val['description'];
        if (!is_numeric($val['demande_nature'])) {
            $this->valF['demande_nature'] = ""; // -> requis
        } else {
            $this->valF['demande_nature'] = $val['demande_nature'];
        }
        if (!is_numeric($val['groupe'])) {
            $this->valF['groupe'] = ""; // -> requis
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = NULL;
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = NULL;
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
        }
        if ($val['contraintes'] == "") {
            $this->valF['contraintes'] = NULL;
        } else {
            $this->valF['contraintes'] = $val['contraintes'];
        }
        if ($val['qualification'] == 1 || $val['qualification'] == "t" || $val['qualification'] == "Oui") {
            $this->valF['qualification'] = true;
        } else {
            $this->valF['qualification'] = false;
        }
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = ""; // -> requis
        } else {
            $this->valF['evenement'] = $val['evenement'];
        }
            $this->valF['document_obligatoire'] = $val['document_obligatoire'];
        if ($val['regeneration_cle_citoyen'] == 1 || $val['regeneration_cle_citoyen'] == "t" || $val['regeneration_cle_citoyen'] == "Oui") {
            $this->valF['regeneration_cle_citoyen'] = true;
        } else {
            $this->valF['regeneration_cle_citoyen'] = false;
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
            $form->setType("demande_type", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("demande_nature", $this->retourformulaire)) {
                $form->setType("demande_nature", "selecthiddenstatic");
            } else {
                $form->setType("demande_nature", "select");
            }
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("contraintes", "text");
            $form->setType("qualification", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("document_obligatoire", "textarea");
            $form->setType("regeneration_cle_citoyen", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("demande_type", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("demande_nature", $this->retourformulaire)) {
                $form->setType("demande_nature", "selecthiddenstatic");
            } else {
                $form->setType("demande_nature", "select");
            }
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("contraintes", "text");
            $form->setType("qualification", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("document_obligatoire", "textarea");
            $form->setType("regeneration_cle_citoyen", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("demande_type", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("demande_nature", "selectstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("contraintes", "hiddenstatic");
            $form->setType("qualification", "hiddenstatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("document_obligatoire", "hiddenstatic");
            $form->setType("regeneration_cle_citoyen", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("demande_type", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("demande_nature", "selectstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("contraintes", "static");
            $form->setType("qualification", "checkboxstatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("document_obligatoire", "textareastatic");
            $form->setType("regeneration_cle_citoyen", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('demande_type','VerifNum(this)');
        $form->setOnchange('demande_nature','VerifNum(this)');
        $form->setOnchange('groupe','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("demande_type", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("demande_nature", 11);
        $form->setTaille("groupe", 11);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("contraintes", 20);
        $form->setTaille("qualification", 1);
        $form->setTaille("evenement", 11);
        $form->setTaille("document_obligatoire", 80);
        $form->setTaille("regeneration_cle_citoyen", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("demande_type", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("demande_nature", 11);
        $form->setMax("groupe", 11);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("contraintes", 20);
        $form->setMax("qualification", 1);
        $form->setMax("evenement", 11);
        $form->setMax("document_obligatoire", 6);
        $form->setMax("regeneration_cle_citoyen", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('demande_type', __('demande_type'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('demande_nature', __('demande_nature'));
        $form->setLib('groupe', __('groupe'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('contraintes', __('contraintes'));
        $form->setLib('qualification', __('qualification'));
        $form->setLib('evenement', __('evenement'));
        $form->setLib('document_obligatoire', __('document_obligatoire'));
        $form->setLib('regeneration_cle_citoyen', __('regeneration_cle_citoyen'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // demande_nature
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demande_nature",
            $this->get_var_sql_forminc__sql("demande_nature"),
            $this->get_var_sql_forminc__sql("demande_nature_by_id"),
            false
        );
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
        // dossier_instruction_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_instruction_type",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false
        );
        // evenement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement",
            $this->get_var_sql_forminc__sql("evenement"),
            $this->get_var_sql_forminc__sql("evenement_by_id"),
            false
        );
        // groupe
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "groupe",
            $this->get_var_sql_forminc__sql("groupe"),
            $this->get_var_sql_forminc__sql("groupe_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('demande_nature', $this->retourformulaire))
                $form->setVal('demande_nature', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type_detaille', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type_detaille', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('groupe', $this->retourformulaire))
                $form->setVal('groupe', $idxformulaire);
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
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "demande_type", $id);
        // Verification de la cle secondaire : lien_demande_type_dossier_instruction_type
        $this->rechercheTable($this->f->db, "lien_demande_type_dossier_instruction_type", "demande_type", $id);
        // Verification de la cle secondaire : lien_demande_type_etat
        $this->rechercheTable($this->f->db, "lien_demande_type_etat", "demande_type", $id);
    }


}

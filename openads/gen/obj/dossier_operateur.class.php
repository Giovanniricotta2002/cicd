<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class dossier_operateur_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_operateur";

    var $table = "dossier_operateur";
    var $clePrimaire = "dossier_operateur";
    var $typeCle = "N";
    var $required_field = array(
        "dossier_instruction",
        "dossier_operateur"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "tiers_consulte" => array("tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("operateur_designation_initialisee");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_operateur",
            "operateur_designation_initialisee",
            "operateur_detecte_inrap",
            "operateur_detecte_collterr",
            "operateur_collterr_type_agrement",
            "operateur_amenagement_pers_publique",
            "operateur_pers_publique_amenageur",
            "operateur_collterr_kpark_avis",
            "operateur_selectionne",
            "operateur_personne_publique",
            "operateur_personne_publique_avis",
            "operateur_kpark_libelle",
            "operateur_kpark_type_operateur",
            "operateur_kpark_evenement",
            "operateur_designe",
            "operateur_valide",
            "operateur_designe_historique",
            "dossier_instruction",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_designe() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_designe_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_detecte_inrap() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_detecte_inrap_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_personne_publique() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_personne_publique_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_selectionne() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_selectionne_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_operateur'])) {
            $this->valF['dossier_operateur'] = ""; // -> requis
        } else {
            $this->valF['dossier_operateur'] = $val['dossier_operateur'];
        }
        if ($val['operateur_designation_initialisee'] == 1 || $val['operateur_designation_initialisee'] == "t" || $val['operateur_designation_initialisee'] == "Oui") {
            $this->valF['operateur_designation_initialisee'] = true;
        } else {
            $this->valF['operateur_designation_initialisee'] = false;
        }
        if (!is_numeric($val['operateur_detecte_inrap'])) {
            $this->valF['operateur_detecte_inrap'] = NULL;
        } else {
            $this->valF['operateur_detecte_inrap'] = $val['operateur_detecte_inrap'];
        }
            $this->valF['operateur_detecte_collterr'] = $val['operateur_detecte_collterr'];
        if ($val['operateur_collterr_type_agrement'] == "") {
            $this->valF['operateur_collterr_type_agrement'] = NULL;
        } else {
            $this->valF['operateur_collterr_type_agrement'] = $val['operateur_collterr_type_agrement'];
        }
        if ($val['operateur_amenagement_pers_publique'] == "") {
            $this->valF['operateur_amenagement_pers_publique'] = NULL;
        } else {
            $this->valF['operateur_amenagement_pers_publique'] = $val['operateur_amenagement_pers_publique'];
        }
        if ($val['operateur_pers_publique_amenageur'] == "") {
            $this->valF['operateur_pers_publique_amenageur'] = NULL;
        } else {
            $this->valF['operateur_pers_publique_amenageur'] = $val['operateur_pers_publique_amenageur'];
        }
        if ($val['operateur_collterr_kpark_avis'] == "") {
            $this->valF['operateur_collterr_kpark_avis'] = NULL;
        } else {
            $this->valF['operateur_collterr_kpark_avis'] = $val['operateur_collterr_kpark_avis'];
        }
        if (!is_numeric($val['operateur_selectionne'])) {
            $this->valF['operateur_selectionne'] = NULL;
        } else {
            $this->valF['operateur_selectionne'] = $val['operateur_selectionne'];
        }
        if (!is_numeric($val['operateur_personne_publique'])) {
            $this->valF['operateur_personne_publique'] = NULL;
        } else {
            $this->valF['operateur_personne_publique'] = $val['operateur_personne_publique'];
        }
        if ($val['operateur_personne_publique_avis'] == "") {
            $this->valF['operateur_personne_publique_avis'] = NULL;
        } else {
            $this->valF['operateur_personne_publique_avis'] = $val['operateur_personne_publique_avis'];
        }
        if ($val['operateur_kpark_libelle'] == "") {
            $this->valF['operateur_kpark_libelle'] = NULL;
        } else {
            $this->valF['operateur_kpark_libelle'] = $val['operateur_kpark_libelle'];
        }
        if ($val['operateur_kpark_type_operateur'] == "") {
            $this->valF['operateur_kpark_type_operateur'] = NULL;
        } else {
            $this->valF['operateur_kpark_type_operateur'] = $val['operateur_kpark_type_operateur'];
        }
        if ($val['operateur_kpark_evenement'] == "") {
            $this->valF['operateur_kpark_evenement'] = NULL;
        } else {
            $this->valF['operateur_kpark_evenement'] = $val['operateur_kpark_evenement'];
        }
        if (!is_numeric($val['operateur_designe'])) {
            $this->valF['operateur_designe'] = NULL;
        } else {
            $this->valF['operateur_designe'] = $val['operateur_designe'];
        }
        if ($val['operateur_valide'] == 1 || $val['operateur_valide'] == "t" || $val['operateur_valide'] == "Oui") {
            $this->valF['operateur_valide'] = true;
        } else {
            $this->valF['operateur_valide'] = false;
        }
            $this->valF['operateur_designe_historique'] = $val['operateur_designe_historique'];
        $this->valF['dossier_instruction'] = $val['dossier_instruction'];
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
            $form->setType("dossier_operateur", "hidden");
            $form->setType("operateur_designation_initialisee", "checkbox");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_detecte_inrap", "selecthiddenstatic");
            } else {
                $form->setType("operateur_detecte_inrap", "select");
            }
            $form->setType("operateur_detecte_collterr", "textarea");
            $form->setType("operateur_collterr_type_agrement", "text");
            $form->setType("operateur_amenagement_pers_publique", "text");
            $form->setType("operateur_pers_publique_amenageur", "text");
            $form->setType("operateur_collterr_kpark_avis", "text");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_selectionne", "selecthiddenstatic");
            } else {
                $form->setType("operateur_selectionne", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_personne_publique", "selecthiddenstatic");
            } else {
                $form->setType("operateur_personne_publique", "select");
            }
            $form->setType("operateur_personne_publique_avis", "text");
            $form->setType("operateur_kpark_libelle", "text");
            $form->setType("operateur_kpark_type_operateur", "text");
            $form->setType("operateur_kpark_evenement", "text");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_designe", "selecthiddenstatic");
            } else {
                $form->setType("operateur_designe", "select");
            }
            $form->setType("operateur_valide", "checkbox");
            $form->setType("operateur_designe_historique", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_operateur", "hiddenstatic");
            $form->setType("operateur_designation_initialisee", "checkbox");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_detecte_inrap", "selecthiddenstatic");
            } else {
                $form->setType("operateur_detecte_inrap", "select");
            }
            $form->setType("operateur_detecte_collterr", "textarea");
            $form->setType("operateur_collterr_type_agrement", "text");
            $form->setType("operateur_amenagement_pers_publique", "text");
            $form->setType("operateur_pers_publique_amenageur", "text");
            $form->setType("operateur_collterr_kpark_avis", "text");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_selectionne", "selecthiddenstatic");
            } else {
                $form->setType("operateur_selectionne", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_personne_publique", "selecthiddenstatic");
            } else {
                $form->setType("operateur_personne_publique", "select");
            }
            $form->setType("operateur_personne_publique_avis", "text");
            $form->setType("operateur_kpark_libelle", "text");
            $form->setType("operateur_kpark_type_operateur", "text");
            $form->setType("operateur_kpark_evenement", "text");
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("operateur_designe", "selecthiddenstatic");
            } else {
                $form->setType("operateur_designe", "select");
            }
            $form->setType("operateur_valide", "checkbox");
            $form->setType("operateur_designe_historique", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_operateur", "hiddenstatic");
            $form->setType("operateur_designation_initialisee", "hiddenstatic");
            $form->setType("operateur_detecte_inrap", "selectstatic");
            $form->setType("operateur_detecte_collterr", "hiddenstatic");
            $form->setType("operateur_collterr_type_agrement", "hiddenstatic");
            $form->setType("operateur_amenagement_pers_publique", "hiddenstatic");
            $form->setType("operateur_pers_publique_amenageur", "hiddenstatic");
            $form->setType("operateur_collterr_kpark_avis", "hiddenstatic");
            $form->setType("operateur_selectionne", "selectstatic");
            $form->setType("operateur_personne_publique", "selectstatic");
            $form->setType("operateur_personne_publique_avis", "hiddenstatic");
            $form->setType("operateur_kpark_libelle", "hiddenstatic");
            $form->setType("operateur_kpark_type_operateur", "hiddenstatic");
            $form->setType("operateur_kpark_evenement", "hiddenstatic");
            $form->setType("operateur_designe", "selectstatic");
            $form->setType("operateur_valide", "hiddenstatic");
            $form->setType("operateur_designe_historique", "hiddenstatic");
            $form->setType("dossier_instruction", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_operateur", "static");
            $form->setType("operateur_designation_initialisee", "checkboxstatic");
            $form->setType("operateur_detecte_inrap", "selectstatic");
            $form->setType("operateur_detecte_collterr", "textareastatic");
            $form->setType("operateur_collterr_type_agrement", "static");
            $form->setType("operateur_amenagement_pers_publique", "static");
            $form->setType("operateur_pers_publique_amenageur", "static");
            $form->setType("operateur_collterr_kpark_avis", "static");
            $form->setType("operateur_selectionne", "selectstatic");
            $form->setType("operateur_personne_publique", "selectstatic");
            $form->setType("operateur_personne_publique_avis", "static");
            $form->setType("operateur_kpark_libelle", "static");
            $form->setType("operateur_kpark_type_operateur", "static");
            $form->setType("operateur_kpark_evenement", "static");
            $form->setType("operateur_designe", "selectstatic");
            $form->setType("operateur_valide", "checkboxstatic");
            $form->setType("operateur_designe_historique", "textareastatic");
            $form->setType("dossier_instruction", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_operateur','VerifNum(this)');
        $form->setOnchange('operateur_detecte_inrap','VerifNum(this)');
        $form->setOnchange('operateur_selectionne','VerifNum(this)');
        $form->setOnchange('operateur_personne_publique','VerifNum(this)');
        $form->setOnchange('operateur_designe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_operateur", 11);
        $form->setTaille("operateur_designation_initialisee", 1);
        $form->setTaille("operateur_detecte_inrap", 11);
        $form->setTaille("operateur_detecte_collterr", 80);
        $form->setTaille("operateur_collterr_type_agrement", 30);
        $form->setTaille("operateur_amenagement_pers_publique", 10);
        $form->setTaille("operateur_pers_publique_amenageur", 10);
        $form->setTaille("operateur_collterr_kpark_avis", 30);
        $form->setTaille("operateur_selectionne", 11);
        $form->setTaille("operateur_personne_publique", 11);
        $form->setTaille("operateur_personne_publique_avis", 30);
        $form->setTaille("operateur_kpark_libelle", 30);
        $form->setTaille("operateur_kpark_type_operateur", 30);
        $form->setTaille("operateur_kpark_evenement", 30);
        $form->setTaille("operateur_designe", 11);
        $form->setTaille("operateur_valide", 1);
        $form->setTaille("operateur_designe_historique", 80);
        $form->setTaille("dossier_instruction", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_operateur", 11);
        $form->setMax("operateur_designation_initialisee", 1);
        $form->setMax("operateur_detecte_inrap", 11);
        $form->setMax("operateur_detecte_collterr", 6);
        $form->setMax("operateur_collterr_type_agrement", 30);
        $form->setMax("operateur_amenagement_pers_publique", 1);
        $form->setMax("operateur_pers_publique_amenageur", 1);
        $form->setMax("operateur_collterr_kpark_avis", 30);
        $form->setMax("operateur_selectionne", 11);
        $form->setMax("operateur_personne_publique", 11);
        $form->setMax("operateur_personne_publique_avis", 30);
        $form->setMax("operateur_kpark_libelle", 50);
        $form->setMax("operateur_kpark_type_operateur", 50);
        $form->setMax("operateur_kpark_evenement", 50);
        $form->setMax("operateur_designe", 11);
        $form->setMax("operateur_valide", 1);
        $form->setMax("operateur_designe_historique", 6);
        $form->setMax("dossier_instruction", 255);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_operateur', __('dossier_operateur'));
        $form->setLib('operateur_designation_initialisee', __('operateur_designation_initialisee'));
        $form->setLib('operateur_detecte_inrap', __('operateur_detecte_inrap'));
        $form->setLib('operateur_detecte_collterr', __('operateur_detecte_collterr'));
        $form->setLib('operateur_collterr_type_agrement', __('operateur_collterr_type_agrement'));
        $form->setLib('operateur_amenagement_pers_publique', __('operateur_amenagement_pers_publique'));
        $form->setLib('operateur_pers_publique_amenageur', __('operateur_pers_publique_amenageur'));
        $form->setLib('operateur_collterr_kpark_avis', __('operateur_collterr_kpark_avis'));
        $form->setLib('operateur_selectionne', __('operateur_selectionne'));
        $form->setLib('operateur_personne_publique', __('operateur_personne_publique'));
        $form->setLib('operateur_personne_publique_avis', __('operateur_personne_publique_avis'));
        $form->setLib('operateur_kpark_libelle', __('operateur_kpark_libelle'));
        $form->setLib('operateur_kpark_type_operateur', __('operateur_kpark_type_operateur'));
        $form->setLib('operateur_kpark_evenement', __('operateur_kpark_evenement'));
        $form->setLib('operateur_designe', __('operateur_designe'));
        $form->setLib('operateur_valide', __('operateur_valide'));
        $form->setLib('operateur_designe_historique', __('operateur_designe_historique'));
        $form->setLib('dossier_instruction', __('dossier_instruction'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier_instruction
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_instruction",
            $this->get_var_sql_forminc__sql("dossier_instruction"),
            $this->get_var_sql_forminc__sql("dossier_instruction_by_id"),
            false
        );
        // operateur_designe
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "operateur_designe",
            $this->get_var_sql_forminc__sql("operateur_designe"),
            $this->get_var_sql_forminc__sql("operateur_designe_by_id"),
            false
        );
        // operateur_detecte_inrap
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "operateur_detecte_inrap",
            $this->get_var_sql_forminc__sql("operateur_detecte_inrap"),
            $this->get_var_sql_forminc__sql("operateur_detecte_inrap_by_id"),
            false
        );
        // operateur_personne_publique
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "operateur_personne_publique",
            $this->get_var_sql_forminc__sql("operateur_personne_publique"),
            $this->get_var_sql_forminc__sql("operateur_personne_publique_by_id"),
            false
        );
        // operateur_selectionne
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "operateur_selectionne",
            $this->get_var_sql_forminc__sql("operateur_selectionne"),
            $this->get_var_sql_forminc__sql("operateur_selectionne_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_instruction', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('operateur_designe', $idxformulaire);
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('operateur_detecte_inrap', $idxformulaire);
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('operateur_personne_publique', $idxformulaire);
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('operateur_selectionne', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

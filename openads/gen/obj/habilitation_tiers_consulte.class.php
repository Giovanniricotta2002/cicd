<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

require_once "../obj/om_dbform.class.php";

class habilitation_tiers_consulte_gen extends om_dbform {

    protected $_absolute_class_name = "habilitation_tiers_consulte";

    var $table = "habilitation_tiers_consulte";
    var $clePrimaire = "habilitation_tiers_consulte";
    var $typeCle = "N";
    var $required_field = array(
        "habilitation_tiers_consulte",
        "tiers_consulte",
        "type_habilitation_tiers_consulte"
    );
    
    var $foreign_keys_extended = array(
        "tiers_consulte" => array("tiers_consulte", ),
        "type_habilitation_tiers_consulte" => array("type_habilitation_tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("type_habilitation_tiers_consulte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "habilitation_tiers_consulte",
            "type_habilitation_tiers_consulte",
            "texte_agrement",
            "division_territoriales",
            "om_validite_debut",
            "om_validite_fin",
            "tiers_consulte",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte() {
        return "SELECT type_habilitation_tiers_consulte.type_habilitation_tiers_consulte, type_habilitation_tiers_consulte.libelle FROM ".DB_PREFIXE."type_habilitation_tiers_consulte WHERE ((type_habilitation_tiers_consulte.om_validite_debut IS NULL AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY type_habilitation_tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_habilitation_tiers_consulte_by_id() {
        return "SELECT type_habilitation_tiers_consulte.type_habilitation_tiers_consulte, type_habilitation_tiers_consulte.libelle FROM ".DB_PREFIXE."type_habilitation_tiers_consulte WHERE type_habilitation_tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['habilitation_tiers_consulte'])) {
            $this->valF['habilitation_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['habilitation_tiers_consulte'] = $val['habilitation_tiers_consulte'];
        }
        if (!is_numeric($val['type_habilitation_tiers_consulte'])) {
            $this->valF['type_habilitation_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['type_habilitation_tiers_consulte'] = $val['type_habilitation_tiers_consulte'];
        }
            $this->valF['texte_agrement'] = $val['texte_agrement'];
            $this->valF['division_territoriales'] = $val['division_territoriales'];
        if ($val['om_validite_debut'] != "") {
            $this->valF['om_validite_debut'] = $this->dateDB($val['om_validite_debut']);
        } else {
            $this->valF['om_validite_debut'] = NULL;
        }
        if ($val['om_validite_fin'] != "") {
            $this->valF['om_validite_fin'] = $this->dateDB($val['om_validite_fin']);
        } else {
            $this->valF['om_validite_fin'] = NULL;
        }
        if (!is_numeric($val['tiers_consulte'])) {
            $this->valF['tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['tiers_consulte'] = $val['tiers_consulte'];
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
    /**
     * Methode verifier
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::verifier($val, $this->f->db, null);

        // gestion des dates de validites
        $date_debut = $this->valF['om_validite_debut'];
        $date_fin = $this->valF['om_validite_fin'];

        if ($date_debut != '' and $date_fin != '') {
        
            $date_debut = explode('-', $this->valF['om_validite_debut']);
            $date_fin = explode('-', $this->valF['om_validite_fin']);

            $time_debut = mktime(0, 0, 0, $date_debut[1], $date_debut[2],
                                 $date_debut[0]);
            $time_fin = mktime(0, 0, 0, $date_fin[1], $date_fin[2],
                                 $date_fin[0]);

            if ($time_debut > $time_fin or $time_debut == $time_fin) {
                $this->correct = false;
                $this->addToMessage(__('La date de fin de validite doit etre future a la de debut de validite.'));
            }
        }
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
            $form->setType("habilitation_tiers_consulte", "hidden");
            if ($this->is_in_context_of_foreign_key("type_habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("type_habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("type_habilitation_tiers_consulte", "select");
            }
            $form->setType("texte_agrement", "textarea");
            $form->setType("division_territoriales", "textarea");
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_debut", "date");
            } else {
                $form->setType("om_validite_debut", "hiddenstaticdate");
            }
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_fin", "date");
            } else {
                $form->setType("om_validite_fin", "hiddenstaticdate");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("habilitation_tiers_consulte", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("type_habilitation_tiers_consulte", $this->retourformulaire)) {
                $form->setType("type_habilitation_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("type_habilitation_tiers_consulte", "select");
            }
            $form->setType("texte_agrement", "textarea");
            $form->setType("division_territoriales", "textarea");
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_debut", "date");
            } else {
                $form->setType("om_validite_debut", "hiddenstaticdate");
            }
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_fin", "date");
            } else {
                $form->setType("om_validite_fin", "hiddenstaticdate");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("habilitation_tiers_consulte", "hiddenstatic");
            $form->setType("type_habilitation_tiers_consulte", "selectstatic");
            $form->setType("texte_agrement", "hiddenstatic");
            $form->setType("division_territoriales", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            $form->setType("tiers_consulte", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("habilitation_tiers_consulte", "static");
            $form->setType("type_habilitation_tiers_consulte", "selectstatic");
            $form->setType("texte_agrement", "textareastatic");
            $form->setType("division_territoriales", "textareastatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
            $form->setType("tiers_consulte", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('habilitation_tiers_consulte','VerifNum(this)');
        $form->setOnchange('type_habilitation_tiers_consulte','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('tiers_consulte','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("habilitation_tiers_consulte", 11);
        $form->setTaille("type_habilitation_tiers_consulte", 11);
        $form->setTaille("texte_agrement", 80);
        $form->setTaille("division_territoriales", 80);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("tiers_consulte", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("habilitation_tiers_consulte", 11);
        $form->setMax("type_habilitation_tiers_consulte", 11);
        $form->setMax("texte_agrement", 6);
        $form->setMax("division_territoriales", 6);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("tiers_consulte", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('habilitation_tiers_consulte', __('habilitation_tiers_consulte'));
        $form->setLib('type_habilitation_tiers_consulte', __('type_habilitation_tiers_consulte'));
        $form->setLib('texte_agrement', __('texte_agrement'));
        $form->setLib('division_territoriales', __('division_territoriales'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
        $form->setLib('tiers_consulte', __('tiers_consulte'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "tiers_consulte",
            $this->get_var_sql_forminc__sql("tiers_consulte"),
            $this->get_var_sql_forminc__sql("tiers_consulte_by_id"),
            false
        );
        // type_habilitation_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "type_habilitation_tiers_consulte",
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte"),
            $this->get_var_sql_forminc__sql("type_habilitation_tiers_consulte_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('tiers_consulte', $idxformulaire);
            if($this->is_in_context_of_foreign_key('type_habilitation_tiers_consulte', $this->retourformulaire))
                $form->setVal('type_habilitation_tiers_consulte', $idxformulaire);
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
        // Verification de la cle secondaire : lien_habilitation_tiers_consulte_commune
        $this->rechercheTable($this->f->db, "lien_habilitation_tiers_consulte_commune", "habilitation_tiers_consulte", $id);
        // Verification de la cle secondaire : lien_habilitation_tiers_consulte_departement
        $this->rechercheTable($this->f->db, "lien_habilitation_tiers_consulte_departement", "habilitation_tiers_consulte", $id);
        // Verification de la cle secondaire : lien_habilitation_tiers_consulte_specialite_tiers_consulte
        $this->rechercheTable($this->f->db, "lien_habilitation_tiers_consulte_specialite_tiers_consulte", "habilitation_tiers_consulte", $id);
    }


}

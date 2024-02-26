<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class division_gen extends om_dbform {

    protected $_absolute_class_name = "division";

    var $table = "division";
    var $clePrimaire = "division";
    var $typeCle = "N";
    var $required_field = array(
        "chef",
        "code",
        "direction",
        "division",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
        "direction" => array("direction", ),
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
            "division",
            "code",
            "libelle",
            "description",
            "chef",
            "direction",
            "om_validite_debut",
            "om_validite_fin",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_direction() {
        return "SELECT direction.direction, direction.libelle FROM ".DB_PREFIXE."direction WHERE ((direction.om_validite_debut IS NULL AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE)) OR (direction.om_validite_debut <= CURRENT_DATE AND (direction.om_validite_fin IS NULL OR direction.om_validite_fin > CURRENT_DATE))) ORDER BY direction.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_direction_by_id() {
        return "SELECT direction.direction, direction.libelle FROM ".DB_PREFIXE."direction WHERE direction = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['division'])) {
            $this->valF['division'] = ""; // -> requis
        } else {
            $this->valF['division'] = $val['division'];
        }
        $this->valF['code'] = $val['code'];
        $this->valF['libelle'] = $val['libelle'];
            $this->valF['description'] = $val['description'];
        $this->valF['chef'] = $val['chef'];
        if (!is_numeric($val['direction'])) {
            $this->valF['direction'] = ""; // -> requis
        } else {
            $this->valF['direction'] = $val['direction'];
        }
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
            $form->setType("division", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            $form->setType("chef", "text");
            if ($this->is_in_context_of_foreign_key("direction", $this->retourformulaire)) {
                $form->setType("direction", "selecthiddenstatic");
            } else {
                $form->setType("direction", "select");
            }
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
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("division", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            $form->setType("chef", "text");
            if ($this->is_in_context_of_foreign_key("direction", $this->retourformulaire)) {
                $form->setType("direction", "selecthiddenstatic");
            } else {
                $form->setType("direction", "select");
            }
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
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("division", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("chef", "hiddenstatic");
            $form->setType("direction", "selectstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("division", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("chef", "static");
            $form->setType("direction", "selectstatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('division','VerifNum(this)');
        $form->setOnchange('direction','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("division", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("chef", 30);
        $form->setTaille("direction", 11);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("division", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("chef", 100);
        $form->setMax("direction", 11);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('division', __('division'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('chef', __('chef'));
        $form->setLib('direction', __('direction'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // direction
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "direction",
            $this->get_var_sql_forminc__sql("direction"),
            $this->get_var_sql_forminc__sql("direction_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('direction', $this->retourformulaire))
                $form->setVal('direction', $idxformulaire);
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
        $this->rechercheTable($this->f->db, "dossier", "division", $id);
        // Verification de la cle secondaire : instructeur
        $this->rechercheTable($this->f->db, "instructeur", "division", $id);
    }


}

<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class instructeur_gen extends om_dbform {

    protected $_absolute_class_name = "instructeur";

    var $table = "instructeur";
    var $clePrimaire = "instructeur";
    var $typeCle = "N";
    var $required_field = array(
        "division",
        "instructeur",
        "instructeur_qualite",
        "nom"
    );
    
    var $foreign_keys_extended = array(
        "division" => array("division", ),
        "instructeur_qualite" => array("instructeur_qualite", ),
        "om_utilisateur" => array("om_utilisateur", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("nom");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "instructeur",
            "nom",
            "telephone",
            "division",
            "om_utilisateur",
            "om_validite_debut",
            "om_validite_fin",
            "instructeur_qualite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division() {
        return "SELECT division.division, division.libelle FROM ".DB_PREFIXE."division WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE))) ORDER BY division.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_by_id() {
        return "SELECT division.division, division.libelle FROM ".DB_PREFIXE."division WHERE division = <idx>";
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_utilisateur() {
        return "SELECT om_utilisateur.om_utilisateur, om_utilisateur.nom FROM ".DB_PREFIXE."om_utilisateur ORDER BY om_utilisateur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_utilisateur_by_id() {
        return "SELECT om_utilisateur.om_utilisateur, om_utilisateur.nom FROM ".DB_PREFIXE."om_utilisateur WHERE om_utilisateur = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['instructeur'])) {
            $this->valF['instructeur'] = ""; // -> requis
        } else {
            $this->valF['instructeur'] = $val['instructeur'];
        }
        $this->valF['nom'] = $val['nom'];
        if ($val['telephone'] == "") {
            $this->valF['telephone'] = NULL;
        } else {
            $this->valF['telephone'] = $val['telephone'];
        }
        if (!is_numeric($val['division'])) {
            $this->valF['division'] = ""; // -> requis
        } else {
            $this->valF['division'] = $val['division'];
        }
        if (!is_numeric($val['om_utilisateur'])) {
            $this->valF['om_utilisateur'] = NULL;
        } else {
            $this->valF['om_utilisateur'] = $val['om_utilisateur'];
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
            $form->setType("instructeur", "hidden");
            $form->setType("nom", "text");
            $form->setType("telephone", "text");
            if ($this->is_in_context_of_foreign_key("division", $this->retourformulaire)) {
                $form->setType("division", "selecthiddenstatic");
            } else {
                $form->setType("division", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
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
            if ($this->is_in_context_of_foreign_key("instructeur_qualite", $this->retourformulaire)) {
                $form->setType("instructeur_qualite", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_qualite", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("instructeur", "hiddenstatic");
            $form->setType("nom", "text");
            $form->setType("telephone", "text");
            if ($this->is_in_context_of_foreign_key("division", $this->retourformulaire)) {
                $form->setType("division", "selecthiddenstatic");
            } else {
                $form->setType("division", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
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
            if ($this->is_in_context_of_foreign_key("instructeur_qualite", $this->retourformulaire)) {
                $form->setType("instructeur_qualite", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_qualite", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("instructeur", "hiddenstatic");
            $form->setType("nom", "hiddenstatic");
            $form->setType("telephone", "hiddenstatic");
            $form->setType("division", "selectstatic");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            $form->setType("instructeur_qualite", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("instructeur", "static");
            $form->setType("nom", "static");
            $form->setType("telephone", "static");
            $form->setType("division", "selectstatic");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
            $form->setType("instructeur_qualite", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('instructeur','VerifNum(this)');
        $form->setOnchange('division','VerifNum(this)');
        $form->setOnchange('om_utilisateur','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('instructeur_qualite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("instructeur", 11);
        $form->setTaille("nom", 30);
        $form->setTaille("telephone", 20);
        $form->setTaille("division", 11);
        $form->setTaille("om_utilisateur", 11);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("instructeur_qualite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("instructeur", 11);
        $form->setMax("nom", 100);
        $form->setMax("telephone", 20);
        $form->setMax("division", 11);
        $form->setMax("om_utilisateur", 11);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("instructeur_qualite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('instructeur', __('instructeur'));
        $form->setLib('nom', __('nom'));
        $form->setLib('telephone', __('telephone'));
        $form->setLib('division', __('division'));
        $form->setLib('om_utilisateur', __('om_utilisateur'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
        $form->setLib('instructeur_qualite', __('instructeur_qualite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // division
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "division",
            $this->get_var_sql_forminc__sql("division"),
            $this->get_var_sql_forminc__sql("division_by_id"),
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
        // om_utilisateur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_utilisateur",
            $this->get_var_sql_forminc__sql("om_utilisateur"),
            $this->get_var_sql_forminc__sql("om_utilisateur_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('division', $this->retourformulaire))
                $form->setVal('division', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instructeur_qualite', $this->retourformulaire))
                $form->setVal('instructeur_qualite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_utilisateur', $this->retourformulaire))
                $form->setVal('om_utilisateur', $idxformulaire);
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
        $this->rechercheTable($this->f->db, "affectation_automatique", "instructeur", $id);
        // Verification de la cle secondaire : affectation_automatique
        $this->rechercheTable($this->f->db, "affectation_automatique", "instructeur_2", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "instructeur", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "instructeur_2", $id);
    }


}

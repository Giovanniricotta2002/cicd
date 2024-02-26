<?php
//$Id$ 
//gen openMairie le 18/03/2022 19:10

require_once "../obj/om_dbform.class.php";

class motif_consultation_gen extends om_dbform {

    protected $_absolute_class_name = "motif_consultation";

    var $table = "motif_consultation";
    var $clePrimaire = "motif_consultation";
    var $typeCle = "N";
    var $required_field = array(
        "motif_consultation",
        "service_type"
    );
    
    var $foreign_keys_extended = array(
        "om_etat" => array("om_etat", ),
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
            "motif_consultation",
            "code",
            "description",
            "libelle",
            "notification_email",
            "delai_type",
            "delai",
            "consultation_papier",
            "om_validite_debut",
            "om_validite_fin",
            "type_consultation",
            "om_etat",
            "service_type",
            "generate_edition",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_etat() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat ORDER BY om_etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_etat_by_id() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat WHERE om_etat = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['motif_consultation'])) {
            $this->valF['motif_consultation'] = ""; // -> requis
        } else {
            $this->valF['motif_consultation'] = $val['motif_consultation'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
            $this->valF['description'] = $val['description'];
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
        if ($val['notification_email'] == 1 || $val['notification_email'] == "t" || $val['notification_email'] == "Oui") {
            $this->valF['notification_email'] = true;
        } else {
            $this->valF['notification_email'] = false;
        }
        if ($val['delai_type'] == "") {
            $this->valF['delai_type'] = NULL;
        } else {
            $this->valF['delai_type'] = $val['delai_type'];
        }
        if (!is_numeric($val['delai'])) {
            $this->valF['delai'] = NULL;
        } else {
            $this->valF['delai'] = $val['delai'];
        }
        if ($val['consultation_papier'] == 1 || $val['consultation_papier'] == "t" || $val['consultation_papier'] == "Oui") {
            $this->valF['consultation_papier'] = true;
        } else {
            $this->valF['consultation_papier'] = false;
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
        if ($val['type_consultation'] == "") {
            $this->valF['type_consultation'] = NULL;
        } else {
            $this->valF['type_consultation'] = $val['type_consultation'];
        }
        if (!is_numeric($val['om_etat'])) {
            $this->valF['om_etat'] = NULL;
        } else {
            $this->valF['om_etat'] = $val['om_etat'];
        }
        $this->valF['service_type'] = $val['service_type'];
        if ($val['generate_edition'] == 1 || $val['generate_edition'] == "t" || $val['generate_edition'] == "Oui") {
            $this->valF['generate_edition'] = true;
        } else {
            $this->valF['generate_edition'] = false;
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
            $form->setType("motif_consultation", "hidden");
            $form->setType("code", "text");
            $form->setType("description", "textarea");
            $form->setType("libelle", "text");
            $form->setType("notification_email", "checkbox");
            $form->setType("delai_type", "text");
            $form->setType("delai", "text");
            $form->setType("consultation_papier", "checkbox");
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
            $form->setType("type_consultation", "text");
            if ($this->is_in_context_of_foreign_key("om_etat", $this->retourformulaire)) {
                $form->setType("om_etat", "selecthiddenstatic");
            } else {
                $form->setType("om_etat", "select");
            }
            $form->setType("service_type", "text");
            $form->setType("generate_edition", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("motif_consultation", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("description", "textarea");
            $form->setType("libelle", "text");
            $form->setType("notification_email", "checkbox");
            $form->setType("delai_type", "text");
            $form->setType("delai", "text");
            $form->setType("consultation_papier", "checkbox");
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
            $form->setType("type_consultation", "text");
            if ($this->is_in_context_of_foreign_key("om_etat", $this->retourformulaire)) {
                $form->setType("om_etat", "selecthiddenstatic");
            } else {
                $form->setType("om_etat", "select");
            }
            $form->setType("service_type", "text");
            $form->setType("generate_edition", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("motif_consultation", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("notification_email", "hiddenstatic");
            $form->setType("delai_type", "hiddenstatic");
            $form->setType("delai", "hiddenstatic");
            $form->setType("consultation_papier", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            $form->setType("type_consultation", "hiddenstatic");
            $form->setType("om_etat", "selectstatic");
            $form->setType("service_type", "hiddenstatic");
            $form->setType("generate_edition", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("motif_consultation", "static");
            $form->setType("code", "static");
            $form->setType("description", "textareastatic");
            $form->setType("libelle", "static");
            $form->setType("notification_email", "checkboxstatic");
            $form->setType("delai_type", "static");
            $form->setType("delai", "static");
            $form->setType("consultation_papier", "checkboxstatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
            $form->setType("type_consultation", "static");
            $form->setType("om_etat", "selectstatic");
            $form->setType("service_type", "static");
            $form->setType("generate_edition", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('motif_consultation','VerifNum(this)');
        $form->setOnchange('delai','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('om_etat','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("motif_consultation", 11);
        $form->setTaille("code", 30);
        $form->setTaille("description", 80);
        $form->setTaille("libelle", 30);
        $form->setTaille("notification_email", 1);
        $form->setTaille("delai_type", 30);
        $form->setTaille("delai", 11);
        $form->setTaille("consultation_papier", 1);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("type_consultation", 30);
        $form->setTaille("om_etat", 11);
        $form->setTaille("service_type", 30);
        $form->setTaille("generate_edition", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("motif_consultation", 11);
        $form->setMax("code", 50);
        $form->setMax("description", 6);
        $form->setMax("libelle", 255);
        $form->setMax("notification_email", 1);
        $form->setMax("delai_type", 100);
        $form->setMax("delai", 11);
        $form->setMax("consultation_papier", 1);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("type_consultation", 70);
        $form->setMax("om_etat", 11);
        $form->setMax("service_type", 255);
        $form->setMax("generate_edition", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('motif_consultation', __('motif_consultation'));
        $form->setLib('code', __('code'));
        $form->setLib('description', __('description'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('notification_email', __('notification_email'));
        $form->setLib('delai_type', __('delai_type'));
        $form->setLib('delai', __('delai'));
        $form->setLib('consultation_papier', __('consultation_papier'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
        $form->setLib('type_consultation', __('type_consultation'));
        $form->setLib('om_etat', __('om_etat'));
        $form->setLib('service_type', __('service_type'));
        $form->setLib('generate_edition', __('generate_edition'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // om_etat
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_etat",
            $this->get_var_sql_forminc__sql("om_etat"),
            $this->get_var_sql_forminc__sql("om_etat_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('om_etat', $this->retourformulaire))
                $form->setVal('om_etat', $idxformulaire);
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
        // Verification de la cle secondaire : consultation
        $this->rechercheTable($this->f->db, "consultation", "motif_consultation", $id);
        // Verification de la cle secondaire : lien_motif_consultation_om_collectivite
        $this->rechercheTable($this->f->db, "lien_motif_consultation_om_collectivite", "motif_consultation", $id);
    }


}

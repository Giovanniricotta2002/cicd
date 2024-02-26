<?php
//$Id$ 
//gen openMairie le 21/02/2022 16:51

require_once "../obj/om_dbform.class.php";

class service_gen extends om_dbform {

    protected $_absolute_class_name = "service";

    var $table = "service";
    var $clePrimaire = "service";
    var $typeCle = "N";
    var $required_field = array(
        "abrege",
        "edition",
        "libelle",
        "om_collectivite",
        "service",
        "service_type"
    );
    
    var $foreign_keys_extended = array(
        "om_etat" => array("om_etat", ),
        "om_collectivite" => array("om_collectivite", ),
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
            "abrege",
            "libelle",
            "adresse",
            "adresse2",
            "cp",
            "ville",
            "email",
            "delai",
            "service",
            "consultation_papier",
            "notification_email",
            "om_validite_debut",
            "om_validite_fin",
            "type_consultation",
            "edition",
            "om_collectivite",
            "delai_type",
            "service_type",
            "generate_edition",
            "uid_platau_acteur",
            "accepte_notification_email",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_edition() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat ORDER BY om_etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_edition_by_id() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat WHERE om_etat = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite ORDER BY om_collectivite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_by_id() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['abrege'] = $val['abrege'];
        $this->valF['libelle'] = $val['libelle'];
        if ($val['adresse'] == "") {
            $this->valF['adresse'] = ""; // -> default
        } else {
            $this->valF['adresse'] = $val['adresse'];
        }
        if ($val['adresse2'] == "") {
            $this->valF['adresse2'] = ""; // -> default
        } else {
            $this->valF['adresse2'] = $val['adresse2'];
        }
        if ($val['cp'] == "") {
            $this->valF['cp'] = ""; // -> default
        } else {
            $this->valF['cp'] = $val['cp'];
        }
        if ($val['ville'] == "") {
            $this->valF['ville'] = ""; // -> default
        } else {
            $this->valF['ville'] = $val['ville'];
        }
            $this->valF['email'] = $val['email'];
        if (!is_numeric($val['delai'])) {
            $this->valF['delai'] = NULL;
        } else {
            $this->valF['delai'] = $val['delai'];
        }
        if (!is_numeric($val['service'])) {
            $this->valF['service'] = ""; // -> requis
        } else {
            $this->valF['service'] = $val['service'];
        }
        if ($val['consultation_papier'] == 1 || $val['consultation_papier'] == "t" || $val['consultation_papier'] == "Oui") {
            $this->valF['consultation_papier'] = true;
        } else {
            $this->valF['consultation_papier'] = false;
        }
        if ($val['notification_email'] == 1 || $val['notification_email'] == "t" || $val['notification_email'] == "Oui") {
            $this->valF['notification_email'] = true;
        } else {
            $this->valF['notification_email'] = false;
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
            $this->valF['type_consultation'] = ""; // -> default
        } else {
            $this->valF['type_consultation'] = $val['type_consultation'];
        }
        if (!is_numeric($val['edition'])) {
            $this->valF['edition'] = ""; // -> requis
        } else {
            $this->valF['edition'] = $val['edition'];
        }
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if ($val['delai_type'] == "") {
            $this->valF['delai_type'] = NULL;
        } else {
            $this->valF['delai_type'] = $val['delai_type'];
        }
        $this->valF['service_type'] = $val['service_type'];
        if ($val['generate_edition'] == 1 || $val['generate_edition'] == "t" || $val['generate_edition'] == "Oui") {
            $this->valF['generate_edition'] = true;
        } else {
            $this->valF['generate_edition'] = false;
        }
        if ($val['uid_platau_acteur'] == "") {
            $this->valF['uid_platau_acteur'] = NULL;
        } else {
            $this->valF['uid_platau_acteur'] = $val['uid_platau_acteur'];
        }
        if ($val['accepte_notification_email'] == 1 || $val['accepte_notification_email'] == "t" || $val['accepte_notification_email'] == "Oui") {
            $this->valF['accepte_notification_email'] = true;
        } else {
            $this->valF['accepte_notification_email'] = false;
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
            $form->setType("abrege", "text");
            $form->setType("libelle", "text");
            $form->setType("adresse", "text");
            $form->setType("adresse2", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("email", "textarea");
            $form->setType("delai", "text");
            $form->setType("service", "hidden");
            $form->setType("consultation_papier", "checkbox");
            $form->setType("notification_email", "checkbox");
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
                $form->setType("edition", "selecthiddenstatic");
            } else {
                $form->setType("edition", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("delai_type", "text");
            $form->setType("service_type", "text");
            $form->setType("generate_edition", "checkbox");
            $form->setType("uid_platau_acteur", "text");
            $form->setType("accepte_notification_email", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("abrege", "text");
            $form->setType("libelle", "text");
            $form->setType("adresse", "text");
            $form->setType("adresse2", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("email", "textarea");
            $form->setType("delai", "text");
            $form->setType("service", "hiddenstatic");
            $form->setType("consultation_papier", "checkbox");
            $form->setType("notification_email", "checkbox");
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
                $form->setType("edition", "selecthiddenstatic");
            } else {
                $form->setType("edition", "select");
            }
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("delai_type", "text");
            $form->setType("service_type", "text");
            $form->setType("generate_edition", "checkbox");
            $form->setType("uid_platau_acteur", "text");
            $form->setType("accepte_notification_email", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("abrege", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("adresse", "hiddenstatic");
            $form->setType("adresse2", "hiddenstatic");
            $form->setType("cp", "hiddenstatic");
            $form->setType("ville", "hiddenstatic");
            $form->setType("email", "hiddenstatic");
            $form->setType("delai", "hiddenstatic");
            $form->setType("service", "hiddenstatic");
            $form->setType("consultation_papier", "hiddenstatic");
            $form->setType("notification_email", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            $form->setType("type_consultation", "hiddenstatic");
            $form->setType("edition", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("delai_type", "hiddenstatic");
            $form->setType("service_type", "hiddenstatic");
            $form->setType("generate_edition", "hiddenstatic");
            $form->setType("uid_platau_acteur", "hiddenstatic");
            $form->setType("accepte_notification_email", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("abrege", "static");
            $form->setType("libelle", "static");
            $form->setType("adresse", "static");
            $form->setType("adresse2", "static");
            $form->setType("cp", "static");
            $form->setType("ville", "static");
            $form->setType("email", "textareastatic");
            $form->setType("delai", "static");
            $form->setType("service", "static");
            $form->setType("consultation_papier", "checkboxstatic");
            $form->setType("notification_email", "checkboxstatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
            $form->setType("type_consultation", "static");
            $form->setType("edition", "selectstatic");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("delai_type", "static");
            $form->setType("service_type", "static");
            $form->setType("generate_edition", "checkboxstatic");
            $form->setType("uid_platau_acteur", "static");
            $form->setType("accepte_notification_email", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('delai','VerifNum(this)');
        $form->setOnchange('service','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('edition','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("abrege", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("adresse", 30);
        $form->setTaille("adresse2", 30);
        $form->setTaille("cp", 10);
        $form->setTaille("ville", 30);
        $form->setTaille("email", 80);
        $form->setTaille("delai", 11);
        $form->setTaille("service", 11);
        $form->setTaille("consultation_papier", 1);
        $form->setTaille("notification_email", 1);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("type_consultation", 30);
        $form->setTaille("edition", 11);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("delai_type", 30);
        $form->setTaille("service_type", 30);
        $form->setTaille("generate_edition", 1);
        $form->setTaille("uid_platau_acteur", 30);
        $form->setTaille("accepte_notification_email", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("abrege", 30);
        $form->setMax("libelle", 255);
        $form->setMax("adresse", 40);
        $form->setMax("adresse2", 39);
        $form->setMax("cp", 5);
        $form->setMax("ville", 30);
        $form->setMax("email", 6);
        $form->setMax("delai", 11);
        $form->setMax("service", 11);
        $form->setMax("consultation_papier", 1);
        $form->setMax("notification_email", 1);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("type_consultation", 70);
        $form->setMax("edition", 11);
        $form->setMax("om_collectivite", 11);
        $form->setMax("delai_type", 100);
        $form->setMax("service_type", 255);
        $form->setMax("generate_edition", 1);
        $form->setMax("uid_platau_acteur", 255);
        $form->setMax("accepte_notification_email", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('abrege', __('abrege'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('adresse', __('adresse'));
        $form->setLib('adresse2', __('adresse2'));
        $form->setLib('cp', __('cp'));
        $form->setLib('ville', __('ville'));
        $form->setLib('email', __('email'));
        $form->setLib('delai', __('delai'));
        $form->setLib('service', __('service'));
        $form->setLib('consultation_papier', __('consultation_papier'));
        $form->setLib('notification_email', __('notification_email'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
        $form->setLib('type_consultation', __('type_consultation'));
        $form->setLib('edition', __('edition'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('delai_type', __('delai_type'));
        $form->setLib('service_type', __('service_type'));
        $form->setLib('generate_edition', __('generate_edition'));
        $form->setLib('uid_platau_acteur', __('uid_platau_acteur'));
        $form->setLib('accepte_notification_email', __('accepte_notification_email'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // edition
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "edition",
            $this->get_var_sql_forminc__sql("edition"),
            $this->get_var_sql_forminc__sql("edition_by_id"),
            false
        );
        // om_collectivite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false
        );
    }


    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setVal

    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('om_etat', $this->retourformulaire))
                $form->setVal('edition', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
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
        $this->rechercheTable($this->f->db, "consultation", "service", $id);
        // Verification de la cle secondaire : lien_service_om_utilisateur
        $this->rechercheTable($this->f->db, "lien_service_om_utilisateur", "service", $id);
        // Verification de la cle secondaire : lien_service_service_categorie
        $this->rechercheTable($this->f->db, "lien_service_service_categorie", "service", $id);
    }


}

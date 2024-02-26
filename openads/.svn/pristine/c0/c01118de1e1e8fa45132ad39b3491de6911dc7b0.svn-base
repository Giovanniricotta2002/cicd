<?php
//$Id$ 
//gen openMairie le 14/03/2022 16:43

require_once "../obj/om_dbform.class.php";

class signataire_arrete_gen extends om_dbform {

    protected $_absolute_class_name = "signataire_arrete";

    var $table = "signataire_arrete";
    var $clePrimaire = "signataire_arrete";
    var $typeCle = "N";
    var $required_field = array(
        "om_collectivite",
        "signataire_arrete"
    );
    
    var $foreign_keys_extended = array(
        "civilite" => array("civilite", ),
        "om_collectivite" => array("om_collectivite", ),
        "signataire_habilitation" => array("signataire_habilitation", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("civilite");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "signataire_arrete",
            "civilite",
            "nom",
            "prenom",
            "qualite",
            "signature",
            "defaut",
            "om_validite_debut",
            "om_validite_fin",
            "om_collectivite",
            "email",
            "parametre_parapheur",
            "description",
            "signataire_habilitation",
            "agrement",
            "visa",
            "visa_2",
            "visa_3",
            "visa_4",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_civilite() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE ((civilite.om_validite_debut IS NULL AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE)) OR (civilite.om_validite_debut <= CURRENT_DATE AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE))) ORDER BY civilite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_civilite_by_id() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE civilite = '<idx>'";
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_habilitation() {
        return "SELECT signataire_habilitation.signataire_habilitation, signataire_habilitation.libelle FROM ".DB_PREFIXE."signataire_habilitation WHERE ((signataire_habilitation.om_validite_debut IS NULL AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE)) OR (signataire_habilitation.om_validite_debut <= CURRENT_DATE AND (signataire_habilitation.om_validite_fin IS NULL OR signataire_habilitation.om_validite_fin > CURRENT_DATE))) ORDER BY signataire_habilitation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_habilitation_by_id() {
        return "SELECT signataire_habilitation.signataire_habilitation, signataire_habilitation.libelle FROM ".DB_PREFIXE."signataire_habilitation WHERE signataire_habilitation = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['signataire_arrete'])) {
            $this->valF['signataire_arrete'] = ""; // -> requis
        } else {
            $this->valF['signataire_arrete'] = $val['signataire_arrete'];
        }
        if (!is_numeric($val['civilite'])) {
            $this->valF['civilite'] = NULL;
        } else {
            $this->valF['civilite'] = $val['civilite'];
        }
        if ($val['nom'] == "") {
            $this->valF['nom'] = NULL;
        } else {
            $this->valF['nom'] = $val['nom'];
        }
        if ($val['prenom'] == "") {
            $this->valF['prenom'] = NULL;
        } else {
            $this->valF['prenom'] = $val['prenom'];
        }
        if ($val['qualite'] == "") {
            $this->valF['qualite'] = NULL;
        } else {
            $this->valF['qualite'] = $val['qualite'];
        }
            $this->valF['signature'] = $val['signature'];
        if ($val['defaut'] == 1 || $val['defaut'] == "t" || $val['defaut'] == "Oui") {
            $this->valF['defaut'] = true;
        } else {
            $this->valF['defaut'] = false;
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
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if ($val['email'] == "") {
            $this->valF['email'] = NULL;
        } else {
            $this->valF['email'] = $val['email'];
        }
            $this->valF['parametre_parapheur'] = $val['parametre_parapheur'];
        if ($val['description'] == "") {
            $this->valF['description'] = NULL;
        } else {
            $this->valF['description'] = $val['description'];
        }
        if (!is_numeric($val['signataire_habilitation'])) {
            $this->valF['signataire_habilitation'] = NULL;
        } else {
            $this->valF['signataire_habilitation'] = $val['signataire_habilitation'];
        }
            $this->valF['agrement'] = $val['agrement'];
            $this->valF['visa'] = $val['visa'];
            $this->valF['visa_2'] = $val['visa_2'];
            $this->valF['visa_3'] = $val['visa_3'];
            $this->valF['visa_4'] = $val['visa_4'];
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
            $form->setType("signataire_arrete", "hidden");
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("civilite", "selecthiddenstatic");
            } else {
                $form->setType("civilite", "select");
            }
            $form->setType("nom", "text");
            $form->setType("prenom", "text");
            $form->setType("qualite", "text");
            $form->setType("signature", "textarea");
            $form->setType("defaut", "checkbox");
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
            $form->setType("email", "text");
            $form->setType("parametre_parapheur", "textarea");
            $form->setType("description", "text");
            if ($this->is_in_context_of_foreign_key("signataire_habilitation", $this->retourformulaire)) {
                $form->setType("signataire_habilitation", "selecthiddenstatic");
            } else {
                $form->setType("signataire_habilitation", "select");
            }
            $form->setType("agrement", "textarea");
            $form->setType("visa", "textarea");
            $form->setType("visa_2", "textarea");
            $form->setType("visa_3", "textarea");
            $form->setType("visa_4", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("signataire_arrete", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("civilite", "selecthiddenstatic");
            } else {
                $form->setType("civilite", "select");
            }
            $form->setType("nom", "text");
            $form->setType("prenom", "text");
            $form->setType("qualite", "text");
            $form->setType("signature", "textarea");
            $form->setType("defaut", "checkbox");
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
            $form->setType("email", "text");
            $form->setType("parametre_parapheur", "textarea");
            $form->setType("description", "text");
            if ($this->is_in_context_of_foreign_key("signataire_habilitation", $this->retourformulaire)) {
                $form->setType("signataire_habilitation", "selecthiddenstatic");
            } else {
                $form->setType("signataire_habilitation", "select");
            }
            $form->setType("agrement", "textarea");
            $form->setType("visa", "textarea");
            $form->setType("visa_2", "textarea");
            $form->setType("visa_3", "textarea");
            $form->setType("visa_4", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("signataire_arrete", "hiddenstatic");
            $form->setType("civilite", "selectstatic");
            $form->setType("nom", "hiddenstatic");
            $form->setType("prenom", "hiddenstatic");
            $form->setType("qualite", "hiddenstatic");
            $form->setType("signature", "hiddenstatic");
            $form->setType("defaut", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("email", "hiddenstatic");
            $form->setType("parametre_parapheur", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("signataire_habilitation", "selectstatic");
            $form->setType("agrement", "hiddenstatic");
            $form->setType("visa", "hiddenstatic");
            $form->setType("visa_2", "hiddenstatic");
            $form->setType("visa_3", "hiddenstatic");
            $form->setType("visa_4", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("signataire_arrete", "static");
            $form->setType("civilite", "selectstatic");
            $form->setType("nom", "static");
            $form->setType("prenom", "static");
            $form->setType("qualite", "static");
            $form->setType("signature", "textareastatic");
            $form->setType("defaut", "checkboxstatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
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
            $form->setType("email", "static");
            $form->setType("parametre_parapheur", "textareastatic");
            $form->setType("description", "static");
            $form->setType("signataire_habilitation", "selectstatic");
            $form->setType("agrement", "textareastatic");
            $form->setType("visa", "textareastatic");
            $form->setType("visa_2", "textareastatic");
            $form->setType("visa_3", "textareastatic");
            $form->setType("visa_4", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('signataire_arrete','VerifNum(this)');
        $form->setOnchange('civilite','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('signataire_habilitation','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("signataire_arrete", 11);
        $form->setTaille("civilite", 11);
        $form->setTaille("nom", 30);
        $form->setTaille("prenom", 30);
        $form->setTaille("qualite", 30);
        $form->setTaille("signature", 80);
        $form->setTaille("defaut", 1);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("email", 30);
        $form->setTaille("parametre_parapheur", 80);
        $form->setTaille("description", 30);
        $form->setTaille("signataire_habilitation", 11);
        $form->setTaille("agrement", 80);
        $form->setTaille("visa", 80);
        $form->setTaille("visa_2", 80);
        $form->setTaille("visa_3", 80);
        $form->setTaille("visa_4", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("signataire_arrete", 11);
        $form->setMax("civilite", 11);
        $form->setMax("nom", 80);
        $form->setMax("prenom", 80);
        $form->setMax("qualite", 80);
        $form->setMax("signature", 6);
        $form->setMax("defaut", 1);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("om_collectivite", 11);
        $form->setMax("email", 255);
        $form->setMax("parametre_parapheur", 6);
        $form->setMax("description", 255);
        $form->setMax("signataire_habilitation", 11);
        $form->setMax("agrement", 6);
        $form->setMax("visa", 6);
        $form->setMax("visa_2", 6);
        $form->setMax("visa_3", 6);
        $form->setMax("visa_4", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('signataire_arrete', __('signataire_arrete'));
        $form->setLib('civilite', __('civilite'));
        $form->setLib('nom', __('nom'));
        $form->setLib('prenom', __('prenom'));
        $form->setLib('qualite', __('qualite'));
        $form->setLib('signature', __('signature'));
        $form->setLib('defaut', __('defaut'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('email', __('email'));
        $form->setLib('parametre_parapheur', __('parametre_parapheur'));
        $form->setLib('description', __('description'));
        $form->setLib('signataire_habilitation', __('signataire_habilitation'));
        $form->setLib('agrement', __('agrement'));
        $form->setLib('visa', __('visa'));
        $form->setLib('visa_2', __('visa_2'));
        $form->setLib('visa_3', __('visa_3'));
        $form->setLib('visa_4', __('visa_4'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // civilite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "civilite",
            $this->get_var_sql_forminc__sql("civilite"),
            $this->get_var_sql_forminc__sql("civilite_by_id"),
            true
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
        // signataire_habilitation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "signataire_habilitation",
            $this->get_var_sql_forminc__sql("signataire_habilitation"),
            $this->get_var_sql_forminc__sql("signataire_habilitation_by_id"),
            true
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
            if($this->is_in_context_of_foreign_key('civilite', $this->retourformulaire))
                $form->setVal('civilite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('signataire_habilitation', $this->retourformulaire))
                $form->setVal('signataire_habilitation', $idxformulaire);
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
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "signataire_arrete", $id);
    }


}

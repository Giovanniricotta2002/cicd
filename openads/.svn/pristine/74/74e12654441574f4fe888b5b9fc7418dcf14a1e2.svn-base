<?php
//$Id$ 
//gen openMairie le 29/09/2021 12:11

require_once "../obj/om_dbform.class.php";

class commission_gen extends om_dbform {

    protected $_absolute_class_name = "commission";

    var $table = "commission";
    var $clePrimaire = "commission";
    var $typeCle = "N";
    var $required_field = array(
        "commission",
        "commission_type",
        "date_commission",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "commission_type" => array("commission_type", ),
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
            "commission",
            "code",
            "commission_type",
            "libelle",
            "date_commission",
            "heure_commission",
            "lieu_adresse_ligne1",
            "lieu_adresse_ligne2",
            "lieu_salle",
            "listes_de_diffusion",
            "participants",
            "om_fichier_commission_ordre_jour",
            "om_final_commission_ordre_jour",
            "om_fichier_commission_compte_rendu",
            "om_final_commission_compte_rendu",
            "om_collectivite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE))) ORDER BY commission_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type_by_id() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE commission_type = <idx>";
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
        if (!is_numeric($val['commission'])) {
            $this->valF['commission'] = ""; // -> requis
        } else {
            $this->valF['commission'] = $val['commission'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if (!is_numeric($val['commission_type'])) {
            $this->valF['commission_type'] = ""; // -> requis
        } else {
            $this->valF['commission_type'] = $val['commission_type'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
        if ($val['date_commission'] != "") {
            $this->valF['date_commission'] = $this->dateDB($val['date_commission']);
        }
        if ($val['heure_commission'] == "") {
            $this->valF['heure_commission'] = NULL;
        } else {
            $this->valF['heure_commission'] = $val['heure_commission'];
        }
        if ($val['lieu_adresse_ligne1'] == "") {
            $this->valF['lieu_adresse_ligne1'] = NULL;
        } else {
            $this->valF['lieu_adresse_ligne1'] = $val['lieu_adresse_ligne1'];
        }
        if ($val['lieu_adresse_ligne2'] == "") {
            $this->valF['lieu_adresse_ligne2'] = NULL;
        } else {
            $this->valF['lieu_adresse_ligne2'] = $val['lieu_adresse_ligne2'];
        }
        if ($val['lieu_salle'] == "") {
            $this->valF['lieu_salle'] = NULL;
        } else {
            $this->valF['lieu_salle'] = $val['lieu_salle'];
        }
            $this->valF['listes_de_diffusion'] = $val['listes_de_diffusion'];
            $this->valF['participants'] = $val['participants'];
        if ($val['om_fichier_commission_ordre_jour'] == "") {
            $this->valF['om_fichier_commission_ordre_jour'] = NULL;
        } else {
            $this->valF['om_fichier_commission_ordre_jour'] = $val['om_fichier_commission_ordre_jour'];
        }
        if ($val['om_final_commission_ordre_jour'] == 1 || $val['om_final_commission_ordre_jour'] == "t" || $val['om_final_commission_ordre_jour'] == "Oui") {
            $this->valF['om_final_commission_ordre_jour'] = true;
        } else {
            $this->valF['om_final_commission_ordre_jour'] = false;
        }
        if ($val['om_fichier_commission_compte_rendu'] == "") {
            $this->valF['om_fichier_commission_compte_rendu'] = NULL;
        } else {
            $this->valF['om_fichier_commission_compte_rendu'] = $val['om_fichier_commission_compte_rendu'];
        }
        if ($val['om_final_commission_compte_rendu'] == 1 || $val['om_final_commission_compte_rendu'] == "t" || $val['om_final_commission_compte_rendu'] == "Oui") {
            $this->valF['om_final_commission_compte_rendu'] = true;
        } else {
            $this->valF['om_final_commission_compte_rendu'] = false;
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
            $form->setType("commission", "hidden");
            $form->setType("code", "text");
            if ($this->is_in_context_of_foreign_key("commission_type", $this->retourformulaire)) {
                $form->setType("commission_type", "selecthiddenstatic");
            } else {
                $form->setType("commission_type", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("date_commission", "date");
            $form->setType("heure_commission", "text");
            $form->setType("lieu_adresse_ligne1", "text");
            $form->setType("lieu_adresse_ligne2", "text");
            $form->setType("lieu_salle", "text");
            $form->setType("listes_de_diffusion", "textarea");
            $form->setType("participants", "textarea");
            $form->setType("om_fichier_commission_ordre_jour", "text");
            $form->setType("om_final_commission_ordre_jour", "checkbox");
            $form->setType("om_fichier_commission_compte_rendu", "text");
            $form->setType("om_final_commission_compte_rendu", "checkbox");
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
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("commission", "hiddenstatic");
            $form->setType("code", "text");
            if ($this->is_in_context_of_foreign_key("commission_type", $this->retourformulaire)) {
                $form->setType("commission_type", "selecthiddenstatic");
            } else {
                $form->setType("commission_type", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("date_commission", "date");
            $form->setType("heure_commission", "text");
            $form->setType("lieu_adresse_ligne1", "text");
            $form->setType("lieu_adresse_ligne2", "text");
            $form->setType("lieu_salle", "text");
            $form->setType("listes_de_diffusion", "textarea");
            $form->setType("participants", "textarea");
            $form->setType("om_fichier_commission_ordre_jour", "text");
            $form->setType("om_final_commission_ordre_jour", "checkbox");
            $form->setType("om_fichier_commission_compte_rendu", "text");
            $form->setType("om_final_commission_compte_rendu", "checkbox");
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
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("commission", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("commission_type", "selectstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("date_commission", "hiddenstatic");
            $form->setType("heure_commission", "hiddenstatic");
            $form->setType("lieu_adresse_ligne1", "hiddenstatic");
            $form->setType("lieu_adresse_ligne2", "hiddenstatic");
            $form->setType("lieu_salle", "hiddenstatic");
            $form->setType("listes_de_diffusion", "hiddenstatic");
            $form->setType("participants", "hiddenstatic");
            $form->setType("om_fichier_commission_ordre_jour", "hiddenstatic");
            $form->setType("om_final_commission_ordre_jour", "hiddenstatic");
            $form->setType("om_fichier_commission_compte_rendu", "hiddenstatic");
            $form->setType("om_final_commission_compte_rendu", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("commission", "static");
            $form->setType("code", "static");
            $form->setType("commission_type", "selectstatic");
            $form->setType("libelle", "static");
            $form->setType("date_commission", "datestatic");
            $form->setType("heure_commission", "static");
            $form->setType("lieu_adresse_ligne1", "static");
            $form->setType("lieu_adresse_ligne2", "static");
            $form->setType("lieu_salle", "static");
            $form->setType("listes_de_diffusion", "textareastatic");
            $form->setType("participants", "textareastatic");
            $form->setType("om_fichier_commission_ordre_jour", "static");
            $form->setType("om_final_commission_ordre_jour", "checkboxstatic");
            $form->setType("om_fichier_commission_compte_rendu", "static");
            $form->setType("om_final_commission_compte_rendu", "checkboxstatic");
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
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('commission','VerifNum(this)');
        $form->setOnchange('commission_type','VerifNum(this)');
        $form->setOnchange('date_commission','fdate(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("commission", 11);
        $form->setTaille("code", 20);
        $form->setTaille("commission_type", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("date_commission", 12);
        $form->setTaille("heure_commission", 10);
        $form->setTaille("lieu_adresse_ligne1", 30);
        $form->setTaille("lieu_adresse_ligne2", 30);
        $form->setTaille("lieu_salle", 30);
        $form->setTaille("listes_de_diffusion", 80);
        $form->setTaille("participants", 80);
        $form->setTaille("om_fichier_commission_ordre_jour", 30);
        $form->setTaille("om_final_commission_ordre_jour", 1);
        $form->setTaille("om_fichier_commission_compte_rendu", 30);
        $form->setTaille("om_final_commission_compte_rendu", 1);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("commission", 11);
        $form->setMax("code", 20);
        $form->setMax("commission_type", 11);
        $form->setMax("libelle", 100);
        $form->setMax("date_commission", 12);
        $form->setMax("heure_commission", 5);
        $form->setMax("lieu_adresse_ligne1", 100);
        $form->setMax("lieu_adresse_ligne2", 100);
        $form->setMax("lieu_salle", 100);
        $form->setMax("listes_de_diffusion", 6);
        $form->setMax("participants", 6);
        $form->setMax("om_fichier_commission_ordre_jour", 255);
        $form->setMax("om_final_commission_ordre_jour", 1);
        $form->setMax("om_fichier_commission_compte_rendu", 255);
        $form->setMax("om_final_commission_compte_rendu", 1);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('commission', __('commission'));
        $form->setLib('code', __('code'));
        $form->setLib('commission_type', __('commission_type'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('date_commission', __('date_commission'));
        $form->setLib('heure_commission', __('heure_commission'));
        $form->setLib('lieu_adresse_ligne1', __('lieu_adresse_ligne1'));
        $form->setLib('lieu_adresse_ligne2', __('lieu_adresse_ligne2'));
        $form->setLib('lieu_salle', __('lieu_salle'));
        $form->setLib('listes_de_diffusion', __('listes_de_diffusion'));
        $form->setLib('participants', __('participants'));
        $form->setLib('om_fichier_commission_ordre_jour', __('om_fichier_commission_ordre_jour'));
        $form->setLib('om_final_commission_ordre_jour', __('om_final_commission_ordre_jour'));
        $form->setLib('om_fichier_commission_compte_rendu', __('om_fichier_commission_compte_rendu'));
        $form->setLib('om_final_commission_compte_rendu', __('om_final_commission_compte_rendu'));
        $form->setLib('om_collectivite', __('om_collectivite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // commission_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commission_type",
            $this->get_var_sql_forminc__sql("commission_type"),
            $this->get_var_sql_forminc__sql("commission_type_by_id"),
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
            if($this->is_in_context_of_foreign_key('commission_type', $this->retourformulaire))
                $form->setVal('commission_type', $idxformulaire);
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
        // Verification de la cle secondaire : dossier_commission
        $this->rechercheTable($this->f->db, "dossier_commission", "commission", $id);
    }


}

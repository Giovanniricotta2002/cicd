<?php
//$Id$ 
//gen openMairie le 16/09/2020 15:11

require_once "../obj/om_dbform.class.php";

class affectation_automatique_gen extends om_dbform {

    protected $_absolute_class_name = "affectation_automatique";

    var $table = "affectation_automatique";
    var $clePrimaire = "affectation_automatique";
    var $typeCle = "N";
    var $required_field = array(
        "affectation_automatique",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "arrondissement" => array("arrondissement", ),
        "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "instructeur" => array("instructeur", ),
        "om_collectivite" => array("om_collectivite", ),
        "quartier" => array("quartier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("arrondissement");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "affectation_automatique",
            "arrondissement",
            "quartier",
            "section",
            "instructeur",
            "dossier_autorisation_type_detaille",
            "om_collectivite",
            "instructeur_2",
            "communes",
            "affectation_manuelle",
            "dossier_instruction_type",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY arrondissement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement_by_id() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement WHERE arrondissement = <idx>";
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
    function get_var_sql_forminc__sql_instructeur() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE))) ORDER BY instructeur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_by_id() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE instructeur = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE))) ORDER BY instructeur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_by_id() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE instructeur = <idx>";
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
    function get_var_sql_forminc__sql_quartier() {
        return "SELECT quartier.quartier, quartier.libelle FROM ".DB_PREFIXE."quartier ORDER BY quartier.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_quartier_by_id() {
        return "SELECT quartier.quartier, quartier.libelle FROM ".DB_PREFIXE."quartier WHERE quartier = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['affectation_automatique'])) {
            $this->valF['affectation_automatique'] = ""; // -> requis
        } else {
            $this->valF['affectation_automatique'] = $val['affectation_automatique'];
        }
        if (!is_numeric($val['arrondissement'])) {
            $this->valF['arrondissement'] = NULL;
        } else {
            $this->valF['arrondissement'] = $val['arrondissement'];
        }
        if (!is_numeric($val['quartier'])) {
            $this->valF['quartier'] = NULL;
        } else {
            $this->valF['quartier'] = $val['quartier'];
        }
        if ($val['section'] == "") {
            $this->valF['section'] = NULL;
        } else {
            $this->valF['section'] = $val['section'];
        }
        if (!is_numeric($val['instructeur'])) {
            $this->valF['instructeur'] = NULL;
        } else {
            $this->valF['instructeur'] = $val['instructeur'];
        }
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = NULL;
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
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
        if (!is_numeric($val['instructeur_2'])) {
            $this->valF['instructeur_2'] = NULL;
        } else {
            $this->valF['instructeur_2'] = $val['instructeur_2'];
        }
        if ($val['communes'] == "") {
            $this->valF['communes'] = NULL;
        } else {
            $this->valF['communes'] = $val['communes'];
        }
        if ($val['affectation_manuelle'] == "") {
            $this->valF['affectation_manuelle'] = NULL;
        } else {
            $this->valF['affectation_manuelle'] = $val['affectation_manuelle'];
        }
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = NULL;
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
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
            $form->setType("affectation_automatique", "hidden");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            if ($this->is_in_context_of_foreign_key("quartier", $this->retourformulaire)) {
                $form->setType("quartier", "selecthiddenstatic");
            } else {
                $form->setType("quartier", "select");
            }
            $form->setType("section", "text");
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur", "selecthiddenstatic");
            } else {
                $form->setType("instructeur", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
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
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur_2", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_2", "select");
            }
            $form->setType("communes", "text");
            $form->setType("affectation_manuelle", "text");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("affectation_automatique", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            if ($this->is_in_context_of_foreign_key("quartier", $this->retourformulaire)) {
                $form->setType("quartier", "selecthiddenstatic");
            } else {
                $form->setType("quartier", "select");
            }
            $form->setType("section", "text");
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur", "selecthiddenstatic");
            } else {
                $form->setType("instructeur", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
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
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur_2", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_2", "select");
            }
            $form->setType("communes", "text");
            $form->setType("affectation_manuelle", "text");
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("affectation_automatique", "hiddenstatic");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("quartier", "selectstatic");
            $form->setType("section", "hiddenstatic");
            $form->setType("instructeur", "selectstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("instructeur_2", "selectstatic");
            $form->setType("communes", "hiddenstatic");
            $form->setType("affectation_manuelle", "hiddenstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("affectation_automatique", "static");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("quartier", "selectstatic");
            $form->setType("section", "static");
            $form->setType("instructeur", "selectstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
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
            $form->setType("instructeur_2", "selectstatic");
            $form->setType("communes", "static");
            $form->setType("affectation_manuelle", "static");
            $form->setType("dossier_instruction_type", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('affectation_automatique','VerifNum(this)');
        $form->setOnchange('arrondissement','VerifNum(this)');
        $form->setOnchange('quartier','VerifNum(this)');
        $form->setOnchange('instructeur','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('instructeur_2','VerifNum(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("affectation_automatique", 11);
        $form->setTaille("arrondissement", 11);
        $form->setTaille("quartier", 11);
        $form->setTaille("section", 10);
        $form->setTaille("instructeur", 11);
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("instructeur_2", 11);
        $form->setTaille("communes", 30);
        $form->setTaille("affectation_manuelle", 30);
        $form->setTaille("dossier_instruction_type", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("affectation_automatique", 11);
        $form->setMax("arrondissement", 11);
        $form->setMax("quartier", 11);
        $form->setMax("section", 2);
        $form->setMax("instructeur", 11);
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("om_collectivite", 11);
        $form->setMax("instructeur_2", 11);
        $form->setMax("communes", 2000);
        $form->setMax("affectation_manuelle", 100);
        $form->setMax("dossier_instruction_type", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('affectation_automatique', __('affectation_automatique'));
        $form->setLib('arrondissement', __('arrondissement'));
        $form->setLib('quartier', __('quartier'));
        $form->setLib('section', __('section'));
        $form->setLib('instructeur', __('instructeur'));
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('instructeur_2', __('instructeur_2'));
        $form->setLib('communes', __('communes'));
        $form->setLib('affectation_manuelle', __('affectation_manuelle'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // arrondissement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "arrondissement",
            $this->get_var_sql_forminc__sql("arrondissement"),
            $this->get_var_sql_forminc__sql("arrondissement_by_id"),
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
        // instructeur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instructeur",
            $this->get_var_sql_forminc__sql("instructeur"),
            $this->get_var_sql_forminc__sql("instructeur_by_id"),
            true
        );
        // instructeur_2
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instructeur_2",
            $this->get_var_sql_forminc__sql("instructeur_2"),
            $this->get_var_sql_forminc__sql("instructeur_2_by_id"),
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
        // quartier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "quartier",
            $this->get_var_sql_forminc__sql("quartier"),
            $this->get_var_sql_forminc__sql("quartier_by_id"),
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
            if($this->is_in_context_of_foreign_key('arrondissement', $this->retourformulaire))
                $form->setVal('arrondissement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type_detaille', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type_detaille', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('quartier', $this->retourformulaire))
                $form->setVal('quartier', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('instructeur', $this->retourformulaire))
                $form->setVal('instructeur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instructeur', $this->retourformulaire))
                $form->setVal('instructeur_2', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

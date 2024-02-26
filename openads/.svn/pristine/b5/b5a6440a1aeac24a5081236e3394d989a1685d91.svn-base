<?php
//$Id$ 
//gen openMairie le 04/06/2019 13:00

require_once "../obj/om_dbform.class.php";

class bible_gen extends om_dbform {

    protected $_absolute_class_name = "bible";

    var $table = "bible";
    var $clePrimaire = "bible";
    var $typeCle = "N";
    var $required_field = array(
        "bible",
        "contenu",
        "libelle",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "dossier_autorisation_type" => array("dossier_autorisation_type", ),
        "evenement" => array("evenement", ),
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
            "bible",
            "libelle",
            "evenement",
            "contenu",
            "complement",
            "automatique",
            "dossier_autorisation_type",
            "om_collectivite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, dossier_autorisation_type.libelle FROM ".DB_PREFIXE."dossier_autorisation_type ORDER BY dossier_autorisation_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_by_id() {
        return "SELECT dossier_autorisation_type.dossier_autorisation_type, dossier_autorisation_type.libelle FROM ".DB_PREFIXE."dossier_autorisation_type WHERE dossier_autorisation_type = <idx>";
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
        if (!is_numeric($val['bible'])) {
            $this->valF['bible'] = ""; // -> requis
        } else {
            $this->valF['bible'] = $val['bible'];
        }
        $this->valF['libelle'] = $val['libelle'];
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = NULL;
        } else {
            $this->valF['evenement'] = $val['evenement'];
        }
            $this->valF['contenu'] = $val['contenu'];
        if (!is_numeric($val['complement'])) {
            $this->valF['complement'] = NULL;
        } else {
            $this->valF['complement'] = $val['complement'];
        }
        if ($val['automatique'] == "") {
            $this->valF['automatique'] = ""; // -> default
        } else {
            $this->valF['automatique'] = $val['automatique'];
        }
        if (!is_numeric($val['dossier_autorisation_type'])) {
            $this->valF['dossier_autorisation_type'] = NULL;
        } else {
            $this->valF['dossier_autorisation_type'] = $val['dossier_autorisation_type'];
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
            $form->setType("bible", "hidden");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("contenu", "textarea");
            $form->setType("complement", "text");
            $form->setType("automatique", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type", "select");
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
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("bible", "hiddenstatic");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("contenu", "textarea");
            $form->setType("complement", "text");
            $form->setType("automatique", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type", "select");
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
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("bible", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("contenu", "hiddenstatic");
            $form->setType("complement", "hiddenstatic");
            $form->setType("automatique", "hiddenstatic");
            $form->setType("dossier_autorisation_type", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("bible", "static");
            $form->setType("libelle", "static");
            $form->setType("evenement", "selectstatic");
            $form->setType("contenu", "textareastatic");
            $form->setType("complement", "static");
            $form->setType("automatique", "static");
            $form->setType("dossier_autorisation_type", "selectstatic");
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
        $form->setOnchange('bible','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
        $form->setOnchange('complement','VerifNum(this)');
        $form->setOnchange('dossier_autorisation_type','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("bible", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("evenement", 11);
        $form->setTaille("contenu", 80);
        $form->setTaille("complement", 11);
        $form->setTaille("automatique", 10);
        $form->setTaille("dossier_autorisation_type", 11);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("bible", 11);
        $form->setMax("libelle", 60);
        $form->setMax("evenement", 11);
        $form->setMax("contenu", 6);
        $form->setMax("complement", 11);
        $form->setMax("automatique", 3);
        $form->setMax("dossier_autorisation_type", 11);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('bible', __('bible'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('evenement', __('evenement'));
        $form->setLib('contenu', __('contenu'));
        $form->setLib('complement', __('complement'));
        $form->setLib('automatique', __('automatique'));
        $form->setLib('dossier_autorisation_type', __('dossier_autorisation_type'));
        $form->setLib('om_collectivite', __('om_collectivite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier_autorisation_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation_type",
            $this->get_var_sql_forminc__sql("dossier_autorisation_type"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_by_id"),
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
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

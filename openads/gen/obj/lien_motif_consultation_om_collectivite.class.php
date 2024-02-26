<?php
//$Id$ 
//gen openMairie le 25/02/2022 15:50

require_once "../obj/om_dbform.class.php";

class lien_motif_consultation_om_collectivite_gen extends om_dbform {

    protected $_absolute_class_name = "lien_motif_consultation_om_collectivite";

    var $table = "lien_motif_consultation_om_collectivite";
    var $clePrimaire = "lien_motif_consultation_om_collectivite";
    var $typeCle = "N";
    var $required_field = array(
        "lien_motif_consultation_om_collectivite",
        "motif_consultation",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "motif_consultation" => array("motif_consultation", ),
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("motif_consultation");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_motif_consultation_om_collectivite",
            "motif_consultation",
            "om_collectivite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_motif_consultation() {
        return "SELECT motif_consultation.motif_consultation, motif_consultation.libelle FROM ".DB_PREFIXE."motif_consultation WHERE ((motif_consultation.om_validite_debut IS NULL AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE)) OR (motif_consultation.om_validite_debut <= CURRENT_DATE AND (motif_consultation.om_validite_fin IS NULL OR motif_consultation.om_validite_fin > CURRENT_DATE))) ORDER BY motif_consultation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_motif_consultation_by_id() {
        return "SELECT motif_consultation.motif_consultation, motif_consultation.libelle FROM ".DB_PREFIXE."motif_consultation WHERE motif_consultation = <idx>";
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
        if (!is_numeric($val['lien_motif_consultation_om_collectivite'])) {
            $this->valF['lien_motif_consultation_om_collectivite'] = ""; // -> requis
        } else {
            $this->valF['lien_motif_consultation_om_collectivite'] = $val['lien_motif_consultation_om_collectivite'];
        }
        if (!is_numeric($val['motif_consultation'])) {
            $this->valF['motif_consultation'] = ""; // -> requis
        } else {
            $this->valF['motif_consultation'] = $val['motif_consultation'];
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
            $form->setType("lien_motif_consultation_om_collectivite", "hidden");
            if ($this->is_in_context_of_foreign_key("motif_consultation", $this->retourformulaire)) {
                $form->setType("motif_consultation", "selecthiddenstatic");
            } else {
                $form->setType("motif_consultation", "select");
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
            $form->setType("lien_motif_consultation_om_collectivite", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("motif_consultation", $this->retourformulaire)) {
                $form->setType("motif_consultation", "selecthiddenstatic");
            } else {
                $form->setType("motif_consultation", "select");
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
            $form->setType("lien_motif_consultation_om_collectivite", "hiddenstatic");
            $form->setType("motif_consultation", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_motif_consultation_om_collectivite", "static");
            $form->setType("motif_consultation", "selectstatic");
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
        $form->setOnchange('lien_motif_consultation_om_collectivite','VerifNum(this)');
        $form->setOnchange('motif_consultation','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_motif_consultation_om_collectivite", 11);
        $form->setTaille("motif_consultation", 11);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_motif_consultation_om_collectivite", 11);
        $form->setMax("motif_consultation", 11);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_motif_consultation_om_collectivite', __('lien_motif_consultation_om_collectivite'));
        $form->setLib('motif_consultation', __('motif_consultation'));
        $form->setLib('om_collectivite', __('om_collectivite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // motif_consultation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "motif_consultation",
            $this->get_var_sql_forminc__sql("motif_consultation"),
            $this->get_var_sql_forminc__sql("motif_consultation_by_id"),
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
            if($this->is_in_context_of_foreign_key('motif_consultation', $this->retourformulaire))
                $form->setVal('motif_consultation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

require_once "../obj/om_dbform.class.php";

class lien_sig_contrainte_om_collectivite_gen extends om_dbform {

    protected $_absolute_class_name = "lien_sig_contrainte_om_collectivite";

    var $table = "lien_sig_contrainte_om_collectivite";
    var $clePrimaire = "lien_sig_contrainte_om_collectivite";
    var $typeCle = "N";
    var $required_field = array(
        "lien_sig_contrainte_om_collectivite",
        "om_collectivite",
        "sig_contrainte"
    );
    
    var $foreign_keys_extended = array(
        "om_collectivite" => array("om_collectivite", ),
        "sig_contrainte" => array("sig_contrainte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("sig_contrainte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_sig_contrainte_om_collectivite",
            "sig_contrainte",
            "om_collectivite",
        );
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
    function get_var_sql_forminc__sql_sig_contrainte() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte ORDER BY sig_contrainte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte_by_id() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte WHERE sig_contrainte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_sig_contrainte_om_collectivite'])) {
            $this->valF['lien_sig_contrainte_om_collectivite'] = ""; // -> requis
        } else {
            $this->valF['lien_sig_contrainte_om_collectivite'] = $val['lien_sig_contrainte_om_collectivite'];
        }
        if (!is_numeric($val['sig_contrainte'])) {
            $this->valF['sig_contrainte'] = ""; // -> requis
        } else {
            $this->valF['sig_contrainte'] = $val['sig_contrainte'];
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
            $form->setType("lien_sig_contrainte_om_collectivite", "hidden");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
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
            $form->setType("lien_sig_contrainte_om_collectivite", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
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
            $form->setType("lien_sig_contrainte_om_collectivite", "hiddenstatic");
            $form->setType("sig_contrainte", "selectstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_sig_contrainte_om_collectivite", "static");
            $form->setType("sig_contrainte", "selectstatic");
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
        $form->setOnchange('lien_sig_contrainte_om_collectivite','VerifNum(this)');
        $form->setOnchange('sig_contrainte','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_sig_contrainte_om_collectivite", 11);
        $form->setTaille("sig_contrainte", 11);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_sig_contrainte_om_collectivite", 11);
        $form->setMax("sig_contrainte", 11);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_sig_contrainte_om_collectivite', __('lien_sig_contrainte_om_collectivite'));
        $form->setLib('sig_contrainte', __('sig_contrainte'));
        $form->setLib('om_collectivite', __('om_collectivite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
        // sig_contrainte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_contrainte",
            $this->get_var_sql_forminc__sql("sig_contrainte"),
            $this->get_var_sql_forminc__sql("sig_contrainte_by_id"),
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
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('sig_contrainte', $this->retourformulaire))
                $form->setVal('sig_contrainte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

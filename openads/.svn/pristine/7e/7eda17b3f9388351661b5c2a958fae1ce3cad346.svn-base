<?php
//$Id$ 
//gen openMairie le 26/11/2019 18:30

require_once "../obj/om_dbform.class.php";

class num_dossier_gen extends om_dbform {

    protected $_absolute_class_name = "num_dossier";

    var $table = "num_dossier";
    var $clePrimaire = "num_dossier";
    var $typeCle = "N";
    var $required_field = array(
        "code",
        "num_dossier",
        "om_collectivite",
        "petition",
        "ref"
    );
    
    var $foreign_keys_extended = array(
        "num_bordereau" => array("num_bordereau", ),
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("ref");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "num_dossier",
            "ref",
            "code",
            "petition",
            "total_pages",
            "pa3a4",
            "pa0",
            "date_depot",
            "num_bordereau",
            "datenum",
            "num_commande",
            "om_collectivite",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_num_bordereau() {
        return "SELECT num_bordereau.num_bordereau, num_bordereau.libelle FROM ".DB_PREFIXE."num_bordereau ORDER BY num_bordereau.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_num_bordereau_by_id() {
        return "SELECT num_bordereau.num_bordereau, num_bordereau.libelle FROM ".DB_PREFIXE."num_bordereau WHERE num_bordereau = <idx>";
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
        if (!is_numeric($val['num_dossier'])) {
            $this->valF['num_dossier'] = ""; // -> requis
        } else {
            $this->valF['num_dossier'] = $val['num_dossier'];
        }
        $this->valF['ref'] = $val['ref'];
        $this->valF['code'] = $val['code'];
        $this->valF['petition'] = $val['petition'];
        if (!is_numeric($val['total_pages'])) {
            $this->valF['total_pages'] = NULL;
        } else {
            $this->valF['total_pages'] = $val['total_pages'];
        }
        if (!is_numeric($val['pa3a4'])) {
            $this->valF['pa3a4'] = NULL;
        } else {
            $this->valF['pa3a4'] = $val['pa3a4'];
        }
        if (!is_numeric($val['pa0'])) {
            $this->valF['pa0'] = NULL;
        } else {
            $this->valF['pa0'] = $val['pa0'];
        }
        if ($val['date_depot'] != "") {
            $this->valF['date_depot'] = $this->dateDB($val['date_depot']);
        } else {
            $this->valF['date_depot'] = NULL;
        }
        if (!is_numeric($val['num_bordereau'])) {
            $this->valF['num_bordereau'] = NULL;
        } else {
            $this->valF['num_bordereau'] = $val['num_bordereau'];
        }
        if ($val['datenum'] != "") {
            $this->valF['datenum'] = $this->dateDB($val['datenum']);
        } else {
            $this->valF['datenum'] = NULL;
        }
        if (!is_numeric($val['num_commande'])) {
            $this->valF['num_commande'] = NULL;
        } else {
            $this->valF['num_commande'] = $val['num_commande'];
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
            $form->setType("num_dossier", "hidden");
            $form->setType("ref", "text");
            $form->setType("code", "text");
            $form->setType("petition", "text");
            $form->setType("total_pages", "text");
            $form->setType("pa3a4", "text");
            $form->setType("pa0", "text");
            $form->setType("date_depot", "date");
            if ($this->is_in_context_of_foreign_key("num_bordereau", $this->retourformulaire)) {
                $form->setType("num_bordereau", "selecthiddenstatic");
            } else {
                $form->setType("num_bordereau", "select");
            }
            $form->setType("datenum", "date");
            $form->setType("num_commande", "text");
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
            $form->setType("num_dossier", "hiddenstatic");
            $form->setType("ref", "text");
            $form->setType("code", "text");
            $form->setType("petition", "text");
            $form->setType("total_pages", "text");
            $form->setType("pa3a4", "text");
            $form->setType("pa0", "text");
            $form->setType("date_depot", "date");
            if ($this->is_in_context_of_foreign_key("num_bordereau", $this->retourformulaire)) {
                $form->setType("num_bordereau", "selecthiddenstatic");
            } else {
                $form->setType("num_bordereau", "select");
            }
            $form->setType("datenum", "date");
            $form->setType("num_commande", "text");
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
            $form->setType("num_dossier", "hiddenstatic");
            $form->setType("ref", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("petition", "hiddenstatic");
            $form->setType("total_pages", "hiddenstatic");
            $form->setType("pa3a4", "hiddenstatic");
            $form->setType("pa0", "hiddenstatic");
            $form->setType("date_depot", "hiddenstatic");
            $form->setType("num_bordereau", "selectstatic");
            $form->setType("datenum", "hiddenstatic");
            $form->setType("num_commande", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("num_dossier", "static");
            $form->setType("ref", "static");
            $form->setType("code", "static");
            $form->setType("petition", "static");
            $form->setType("total_pages", "static");
            $form->setType("pa3a4", "static");
            $form->setType("pa0", "static");
            $form->setType("date_depot", "datestatic");
            $form->setType("num_bordereau", "selectstatic");
            $form->setType("datenum", "datestatic");
            $form->setType("num_commande", "static");
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
        $form->setOnchange('num_dossier','VerifNum(this)');
        $form->setOnchange('total_pages','VerifNum(this)');
        $form->setOnchange('pa3a4','VerifNum(this)');
        $form->setOnchange('pa0','VerifNum(this)');
        $form->setOnchange('date_depot','fdate(this)');
        $form->setOnchange('num_bordereau','VerifNum(this)');
        $form->setOnchange('datenum','fdate(this)');
        $form->setOnchange('num_commande','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("num_dossier", 11);
        $form->setTaille("ref", 30);
        $form->setTaille("code", 20);
        $form->setTaille("petition", 30);
        $form->setTaille("total_pages", 11);
        $form->setTaille("pa3a4", 11);
        $form->setTaille("pa0", 11);
        $form->setTaille("date_depot", 12);
        $form->setTaille("num_bordereau", 11);
        $form->setTaille("datenum", 12);
        $form->setTaille("num_commande", 11);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("num_dossier", 11);
        $form->setMax("ref", 30);
        $form->setMax("code", 20);
        $form->setMax("petition", 200);
        $form->setMax("total_pages", 11);
        $form->setMax("pa3a4", 11);
        $form->setMax("pa0", 11);
        $form->setMax("date_depot", 12);
        $form->setMax("num_bordereau", 11);
        $form->setMax("datenum", 12);
        $form->setMax("num_commande", 11);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('num_dossier', __('num_dossier'));
        $form->setLib('ref', __('ref'));
        $form->setLib('code', __('code'));
        $form->setLib('petition', __('petition'));
        $form->setLib('total_pages', __('total_pages'));
        $form->setLib('pa3a4', __('pa3a4'));
        $form->setLib('pa0', __('pa0'));
        $form->setLib('date_depot', __('date_depot'));
        $form->setLib('num_bordereau', __('num_bordereau'));
        $form->setLib('datenum', __('datenum'));
        $form->setLib('num_commande', __('num_commande'));
        $form->setLib('om_collectivite', __('om_collectivite'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // num_bordereau
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "num_bordereau",
            $this->get_var_sql_forminc__sql("num_bordereau"),
            $this->get_var_sql_forminc__sql("num_bordereau_by_id"),
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
            if($this->is_in_context_of_foreign_key('num_bordereau', $this->retourformulaire))
                $form->setVal('num_bordereau', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

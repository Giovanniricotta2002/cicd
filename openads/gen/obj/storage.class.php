<?php
//$Id: storage.class.php 10573 2021-10-14 12:43:35Z softime $ 
//gen openMairie le 30/09/2021 16:50

require_once "../obj/om_dbform.class.php";

class storage_gen extends om_dbform {

    protected $_absolute_class_name = "storage";

    var $table = "storage";
    var $clePrimaire = "storage";
    var $typeCle = "N";
    var $required_field = array(
        "creation_date",
        "creation_time",
        "filename",
        "mimetype",
        "om_collectivite",
        "size",
        "storage",
        "type",
        "uid"
    );
    
    var $foreign_keys_extended = array(
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("creation_date");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "storage",
            "creation_date",
            "creation_time",
            "uid",
            "filename",
            "size",
            "mimetype",
            "type",
            "info",
            "om_collectivite",
            "uid_dossier_final",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['storage'])) {
            $this->valF['storage'] = ""; // -> requis
        } else {
            $this->valF['storage'] = $val['storage'];
        }
        if ($val['creation_date'] != "") {
            $this->valF['creation_date'] = $this->dateDB($val['creation_date']);
        }
            $this->valF['creation_time'] = $val['creation_time'];
        $this->valF['uid'] = $val['uid'];
        $this->valF['filename'] = $val['filename'];
        if (!is_numeric($val['size'])) {
            $this->valF['size'] = ""; // -> requis
        } else {
            $this->valF['size'] = $val['size'];
        }
        $this->valF['mimetype'] = $val['mimetype'];
        $this->valF['type'] = $val['type'];
            $this->valF['info'] = $val['info'];
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if ($val['uid_dossier_final'] == 1 || $val['uid_dossier_final'] == "t" || $val['uid_dossier_final'] == "Oui") {
            $this->valF['uid_dossier_final'] = true;
        } else {
            $this->valF['uid_dossier_final'] = false;
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
            $form->setType("storage", "hidden");
            $form->setType("creation_date", "date");
            $form->setType("creation_time", "text");
            $form->setType("uid", "text");
            $form->setType("filename", "text");
            $form->setType("size", "text");
            $form->setType("mimetype", "text");
            $form->setType("type", "text");
            $form->setType("info", "textarea");
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
            $form->setType("uid_dossier_final", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("storage", "hiddenstatic");
            $form->setType("creation_date", "date");
            $form->setType("creation_time", "text");
            $form->setType("uid", "text");
            $form->setType("filename", "text");
            $form->setType("size", "text");
            $form->setType("mimetype", "text");
            $form->setType("type", "text");
            $form->setType("info", "textarea");
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
            $form->setType("uid_dossier_final", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("storage", "hiddenstatic");
            $form->setType("creation_date", "hiddenstatic");
            $form->setType("creation_time", "hiddenstatic");
            $form->setType("uid", "hiddenstatic");
            $form->setType("filename", "hiddenstatic");
            $form->setType("size", "hiddenstatic");
            $form->setType("mimetype", "hiddenstatic");
            $form->setType("type", "hiddenstatic");
            $form->setType("info", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("uid_dossier_final", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("storage", "static");
            $form->setType("creation_date", "datestatic");
            $form->setType("creation_time", "static");
            $form->setType("uid", "static");
            $form->setType("filename", "static");
            $form->setType("size", "static");
            $form->setType("mimetype", "static");
            $form->setType("type", "static");
            $form->setType("info", "textareastatic");
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
            $form->setType("uid_dossier_final", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('storage','VerifNum(this)');
        $form->setOnchange('creation_date','fdate(this)');
        $form->setOnchange('size','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("storage", 11);
        $form->setTaille("creation_date", 12);
        $form->setTaille("creation_time", 8);
        $form->setTaille("uid", 30);
        $form->setTaille("filename", 30);
        $form->setTaille("size", 11);
        $form->setTaille("mimetype", 30);
        $form->setTaille("type", 30);
        $form->setTaille("info", 80);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("uid_dossier_final", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("storage", 11);
        $form->setMax("creation_date", 12);
        $form->setMax("creation_time", 8);
        $form->setMax("uid", 64);
        $form->setMax("filename", 256);
        $form->setMax("size", 11);
        $form->setMax("mimetype", 256);
        $form->setMax("type", 256);
        $form->setMax("info", 6);
        $form->setMax("om_collectivite", 11);
        $form->setMax("uid_dossier_final", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('storage', __('storage'));
        $form->setLib('creation_date', __('creation_date'));
        $form->setLib('creation_time', __('creation_time'));
        $form->setLib('uid', __('uid'));
        $form->setLib('filename', __('filename'));
        $form->setLib('size', __('size'));
        $form->setLib('mimetype', __('mimetype'));
        $form->setLib('type', __('type'));
        $form->setLib('info', __('info'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('uid_dossier_final', __('uid_dossier_final'));
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
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

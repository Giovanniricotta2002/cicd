<?php
//$Id$ 
//gen openMairie le 20/10/2022 18:07

require_once "../obj/om_dbform.class.php";

class compteur_gen extends om_dbform {

    protected $_absolute_class_name = "compteur";

    var $table = "compteur";
    var $clePrimaire = "compteur";
    var $typeCle = "N";
    var $required_field = array(
        "code",
        "compteur",
        "description",
        "om_collectivite",
        "om_validite_debut",
        "quantite",
        "quota"
    );
    var $unique_key = array(
      array("code","om_collectivite","om_validite_debut","om_validite_fin"),
    );
    var $foreign_keys_extended = array(
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("code");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "compteur",
            "code",
            "description",
            "unite",
            "quantite",
            "quota",
            "alerte",
            "om_collectivite",
            "date_modification",
            "om_validite_debut",
            "om_validite_fin",
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
        if (!is_numeric($val['compteur'])) {
            $this->valF['compteur'] = ""; // -> requis
        } else {
            $this->valF['compteur'] = $val['compteur'];
        }
        $this->valF['code'] = $val['code'];
        $this->valF['description'] = $val['description'];
        if ($val['unite'] == "") {
            $this->valF['unite'] = NULL;
        } else {
            $this->valF['unite'] = $val['unite'];
        }
        if (!is_numeric($val['quantite'])) {
            $this->valF['quantite'] = ""; // -> requis
        } else {
            $this->valF['quantite'] = $val['quantite'];
        }
        if (!is_numeric($val['quota'])) {
            $this->valF['quota'] = ""; // -> requis
        } else {
            $this->valF['quota'] = $val['quota'];
        }
        if (!is_numeric($val['alerte'])) {
            $this->valF['alerte'] = NULL;
        } else {
            $this->valF['alerte'] = $val['alerte'];
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
            $this->valF['date_modification'] = $val['date_modification'];
        if ($val['om_validite_debut'] != "") {
            $this->valF['om_validite_debut'] = $this->dateDB($val['om_validite_debut']);
        }
        if ($val['om_validite_fin'] != "") {
            $this->valF['om_validite_fin'] = $this->dateDB($val['om_validite_fin']);
        } else {
            $this->valF['om_validite_fin'] = NULL;
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
            $form->setType("compteur", "hidden");
            $form->setType("code", "text");
            $form->setType("description", "text");
            $form->setType("unite", "text");
            $form->setType("quantite", "text");
            $form->setType("quota", "text");
            $form->setType("alerte", "text");
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
            $form->setType("date_modification", "text");
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
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("compteur", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("description", "text");
            $form->setType("unite", "text");
            $form->setType("quantite", "text");
            $form->setType("quota", "text");
            $form->setType("alerte", "text");
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
            $form->setType("date_modification", "text");
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
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("compteur", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("unite", "hiddenstatic");
            $form->setType("quantite", "hiddenstatic");
            $form->setType("quota", "hiddenstatic");
            $form->setType("alerte", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("date_modification", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("compteur", "static");
            $form->setType("code", "static");
            $form->setType("description", "static");
            $form->setType("unite", "static");
            $form->setType("quantite", "static");
            $form->setType("quota", "static");
            $form->setType("alerte", "static");
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
            $form->setType("date_modification", "static");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('compteur','VerifNum(this)');
        $form->setOnchange('quantite','VerifFloat(this)');
        $form->setOnchange('quota','VerifFloat(this)');
        $form->setOnchange('alerte','VerifFloat(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("compteur", 11);
        $form->setTaille("code", 30);
        $form->setTaille("description", 30);
        $form->setTaille("unite", 10);
        $form->setTaille("quantite", 20);
        $form->setTaille("quota", 20);
        $form->setTaille("alerte", 20);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("date_modification", 8);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("compteur", 11);
        $form->setMax("code", 150);
        $form->setMax("description", 300);
        $form->setMax("unite", 10);
        $form->setMax("quantite", 20);
        $form->setMax("quota", 20);
        $form->setMax("alerte", 20);
        $form->setMax("om_collectivite", 11);
        $form->setMax("date_modification", 8);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('compteur', __('compteur'));
        $form->setLib('code', __('code'));
        $form->setLib('description', __('description'));
        $form->setLib('unite', __('unite'));
        $form->setLib('quantite', __('quantite'));
        $form->setLib('quota', __('quota'));
        $form->setLib('alerte', __('alerte'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('date_modification', __('date_modification'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
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

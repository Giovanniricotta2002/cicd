<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class commission_type_gen extends om_dbform {

    protected $_absolute_class_name = "commission_type";

    var $table = "commission_type";
    var $clePrimaire = "commission_type";
    var $typeCle = "N";
    var $required_field = array(
        "commission_type",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
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
            "commission_type",
            "code",
            "libelle",
            "lieu_adresse_ligne1",
            "lieu_adresse_ligne2",
            "lieu_salle",
            "listes_de_diffusion",
            "participants",
            "corps_du_courriel",
            "om_validite_debut",
            "om_validite_fin",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['commission_type'])) {
            $this->valF['commission_type'] = ""; // -> requis
        } else {
            $this->valF['commission_type'] = $val['commission_type'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
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
            $this->valF['corps_du_courriel'] = $val['corps_du_courriel'];
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
            $form->setType("commission_type", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("lieu_adresse_ligne1", "text");
            $form->setType("lieu_adresse_ligne2", "text");
            $form->setType("lieu_salle", "text");
            $form->setType("listes_de_diffusion", "textarea");
            $form->setType("participants", "textarea");
            $form->setType("corps_du_courriel", "textarea");
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
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("commission_type", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("lieu_adresse_ligne1", "text");
            $form->setType("lieu_adresse_ligne2", "text");
            $form->setType("lieu_salle", "text");
            $form->setType("listes_de_diffusion", "textarea");
            $form->setType("participants", "textarea");
            $form->setType("corps_du_courriel", "textarea");
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
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("commission_type", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("lieu_adresse_ligne1", "hiddenstatic");
            $form->setType("lieu_adresse_ligne2", "hiddenstatic");
            $form->setType("lieu_salle", "hiddenstatic");
            $form->setType("listes_de_diffusion", "hiddenstatic");
            $form->setType("participants", "hiddenstatic");
            $form->setType("corps_du_courriel", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("commission_type", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("lieu_adresse_ligne1", "static");
            $form->setType("lieu_adresse_ligne2", "static");
            $form->setType("lieu_salle", "static");
            $form->setType("listes_de_diffusion", "textareastatic");
            $form->setType("participants", "textareastatic");
            $form->setType("corps_du_courriel", "textareastatic");
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
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('commission_type','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("commission_type", 11);
        $form->setTaille("code", 10);
        $form->setTaille("libelle", 30);
        $form->setTaille("lieu_adresse_ligne1", 30);
        $form->setTaille("lieu_adresse_ligne2", 30);
        $form->setTaille("lieu_salle", 30);
        $form->setTaille("listes_de_diffusion", 80);
        $form->setTaille("participants", 80);
        $form->setTaille("corps_du_courriel", 80);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("commission_type", 11);
        $form->setMax("code", 10);
        $form->setMax("libelle", 100);
        $form->setMax("lieu_adresse_ligne1", 150);
        $form->setMax("lieu_adresse_ligne2", 100);
        $form->setMax("lieu_salle", 100);
        $form->setMax("listes_de_diffusion", 6);
        $form->setMax("participants", 6);
        $form->setMax("corps_du_courriel", 6);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('commission_type', __('commission_type'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('lieu_adresse_ligne1', __('lieu_adresse_ligne1'));
        $form->setLib('lieu_adresse_ligne2', __('lieu_adresse_ligne2'));
        $form->setLib('lieu_salle', __('lieu_salle'));
        $form->setLib('listes_de_diffusion', __('listes_de_diffusion'));
        $form->setLib('participants', __('participants'));
        $form->setLib('corps_du_courriel', __('corps_du_courriel'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
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
    
    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::cleSecondaire($id);
        // Verification de la cle secondaire : commission
        $this->rechercheTable($this->f->db, "commission", "commission_type", $id);
        // Verification de la cle secondaire : dossier_commission
        $this->rechercheTable($this->f->db, "dossier_commission", "commission_type", $id);
    }


}

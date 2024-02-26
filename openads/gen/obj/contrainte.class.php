<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class contrainte_gen extends om_dbform {

    protected $_absolute_class_name = "contrainte";

    var $table = "contrainte";
    var $clePrimaire = "contrainte";
    var $typeCle = "N";
    var $required_field = array(
        "contrainte",
        "libelle",
        "nature",
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
            "contrainte",
            "numero",
            "nature",
            "groupe",
            "sousgroupe",
            "libelle",
            "texte",
            "no_ordre",
            "reference",
            "service_consulte",
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
        if (!is_numeric($val['contrainte'])) {
            $this->valF['contrainte'] = ""; // -> requis
        } else {
            $this->valF['contrainte'] = $val['contrainte'];
        }
        if ($val['numero'] == "") {
            $this->valF['numero'] = NULL;
        } else {
            $this->valF['numero'] = $val['numero'];
        }
        $this->valF['nature'] = $val['nature'];
        if ($val['groupe'] == "") {
            $this->valF['groupe'] = NULL;
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        if ($val['sousgroupe'] == "") {
            $this->valF['sousgroupe'] = NULL;
        } else {
            $this->valF['sousgroupe'] = $val['sousgroupe'];
        }
        $this->valF['libelle'] = $val['libelle'];
            $this->valF['texte'] = $val['texte'];
        if (!is_numeric($val['no_ordre'])) {
            $this->valF['no_ordre'] = NULL;
        } else {
            $this->valF['no_ordre'] = $val['no_ordre'];
        }
        if ($val['reference'] == 1 || $val['reference'] == "t" || $val['reference'] == "Oui") {
            $this->valF['reference'] = true;
        } else {
            $this->valF['reference'] = false;
        }
        if ($val['service_consulte'] == 1 || $val['service_consulte'] == "t" || $val['service_consulte'] == "Oui") {
            $this->valF['service_consulte'] = true;
        } else {
            $this->valF['service_consulte'] = false;
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
            $form->setType("contrainte", "hidden");
            $form->setType("numero", "text");
            $form->setType("nature", "text");
            $form->setType("groupe", "text");
            $form->setType("sousgroupe", "text");
            $form->setType("libelle", "text");
            $form->setType("texte", "textarea");
            $form->setType("no_ordre", "text");
            $form->setType("reference", "checkbox");
            $form->setType("service_consulte", "checkbox");
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
            $form->setType("contrainte", "hiddenstatic");
            $form->setType("numero", "text");
            $form->setType("nature", "text");
            $form->setType("groupe", "text");
            $form->setType("sousgroupe", "text");
            $form->setType("libelle", "text");
            $form->setType("texte", "textarea");
            $form->setType("no_ordre", "text");
            $form->setType("reference", "checkbox");
            $form->setType("service_consulte", "checkbox");
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
            $form->setType("contrainte", "hiddenstatic");
            $form->setType("numero", "hiddenstatic");
            $form->setType("nature", "hiddenstatic");
            $form->setType("groupe", "hiddenstatic");
            $form->setType("sousgroupe", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("texte", "hiddenstatic");
            $form->setType("no_ordre", "hiddenstatic");
            $form->setType("reference", "hiddenstatic");
            $form->setType("service_consulte", "hiddenstatic");
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
            $form->setType("contrainte", "static");
            $form->setType("numero", "static");
            $form->setType("nature", "static");
            $form->setType("groupe", "static");
            $form->setType("sousgroupe", "static");
            $form->setType("libelle", "static");
            $form->setType("texte", "textareastatic");
            $form->setType("no_ordre", "static");
            $form->setType("reference", "checkboxstatic");
            $form->setType("service_consulte", "checkboxstatic");
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
        $form->setOnchange('contrainte','VerifNum(this)');
        $form->setOnchange('no_ordre','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("contrainte", 11);
        $form->setTaille("numero", 30);
        $form->setTaille("nature", 10);
        $form->setTaille("groupe", 30);
        $form->setTaille("sousgroupe", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("texte", 80);
        $form->setTaille("no_ordre", 11);
        $form->setTaille("reference", 1);
        $form->setTaille("service_consulte", 1);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("om_collectivite", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("contrainte", 11);
        $form->setMax("numero", 250);
        $form->setMax("nature", 10);
        $form->setMax("groupe", 250);
        $form->setMax("sousgroupe", 250);
        $form->setMax("libelle", 250);
        $form->setMax("texte", 6);
        $form->setMax("no_ordre", 11);
        $form->setMax("reference", 1);
        $form->setMax("service_consulte", 1);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("om_collectivite", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('contrainte', __('contrainte'));
        $form->setLib('numero', __('numero'));
        $form->setLib('nature', __('nature'));
        $form->setLib('groupe', __('groupe'));
        $form->setLib('sousgroupe', __('sousgroupe'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('texte', __('texte'));
        $form->setLib('no_ordre', __('no_ordre'));
        $form->setLib('reference', __('reference'));
        $form->setLib('service_consulte', __('service_consulte'));
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
        // Verification de la cle secondaire : dossier_contrainte
        $this->rechercheTable($this->f->db, "dossier_contrainte", "contrainte", $id);
    }


}

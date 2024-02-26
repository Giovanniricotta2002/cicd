<?php
//$Id$ 
//gen openMairie le 07/06/2022 18:32

require_once "../obj/om_dbform.class.php";

class commune_gen extends om_dbform {

    protected $_absolute_class_name = "commune";

    var $table = "commune";
    var $clePrimaire = "commune";
    var $typeCle = "N";
    var $required_field = array(
        "com",
        "commune",
        "dep",
        "reg"
    );
    
    var $foreign_keys_extended = array(
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
            "commune",
            "typecom",
            "com",
            "reg",
            "dep",
            "arr",
            "tncc",
            "ncc",
            "nccenr",
            "libelle",
            "can",
            "comparent",
            "om_validite_debut",
            "om_validite_fin",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['commune'])) {
            $this->valF['commune'] = ""; // -> requis
        } else {
            $this->valF['commune'] = $val['commune'];
        }
        if ($val['typecom'] == "") {
            $this->valF['typecom'] = NULL;
        } else {
            $this->valF['typecom'] = $val['typecom'];
        }
        $this->valF['com'] = $val['com'];
        $this->valF['reg'] = $val['reg'];
        $this->valF['dep'] = $val['dep'];
        if ($val['arr'] == "") {
            $this->valF['arr'] = NULL;
        } else {
            $this->valF['arr'] = $val['arr'];
        }
        if ($val['tncc'] == "") {
            $this->valF['tncc'] = NULL;
        } else {
            $this->valF['tncc'] = $val['tncc'];
        }
        if ($val['ncc'] == "") {
            $this->valF['ncc'] = NULL;
        } else {
            $this->valF['ncc'] = $val['ncc'];
        }
        if ($val['nccenr'] == "") {
            $this->valF['nccenr'] = NULL;
        } else {
            $this->valF['nccenr'] = $val['nccenr'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
        if ($val['can'] == "") {
            $this->valF['can'] = NULL;
        } else {
            $this->valF['can'] = $val['can'];
        }
        if ($val['comparent'] == "") {
            $this->valF['comparent'] = NULL;
        } else {
            $this->valF['comparent'] = $val['comparent'];
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
            $form->setType("commune", "hidden");
            $form->setType("typecom", "text");
            $form->setType("com", "text");
            $form->setType("reg", "text");
            $form->setType("dep", "text");
            $form->setType("arr", "text");
            $form->setType("tncc", "text");
            $form->setType("ncc", "text");
            $form->setType("nccenr", "text");
            $form->setType("libelle", "text");
            $form->setType("can", "text");
            $form->setType("comparent", "text");
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
            $form->setType("commune", "hiddenstatic");
            $form->setType("typecom", "text");
            $form->setType("com", "text");
            $form->setType("reg", "text");
            $form->setType("dep", "text");
            $form->setType("arr", "text");
            $form->setType("tncc", "text");
            $form->setType("ncc", "text");
            $form->setType("nccenr", "text");
            $form->setType("libelle", "text");
            $form->setType("can", "text");
            $form->setType("comparent", "text");
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
            $form->setType("commune", "hiddenstatic");
            $form->setType("typecom", "hiddenstatic");
            $form->setType("com", "hiddenstatic");
            $form->setType("reg", "hiddenstatic");
            $form->setType("dep", "hiddenstatic");
            $form->setType("arr", "hiddenstatic");
            $form->setType("tncc", "hiddenstatic");
            $form->setType("ncc", "hiddenstatic");
            $form->setType("nccenr", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("can", "hiddenstatic");
            $form->setType("comparent", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("commune", "static");
            $form->setType("typecom", "static");
            $form->setType("com", "static");
            $form->setType("reg", "static");
            $form->setType("dep", "static");
            $form->setType("arr", "static");
            $form->setType("tncc", "static");
            $form->setType("ncc", "static");
            $form->setType("nccenr", "static");
            $form->setType("libelle", "static");
            $form->setType("can", "static");
            $form->setType("comparent", "static");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('commune','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("commune", 11);
        $form->setTaille("typecom", 10);
        $form->setTaille("com", 10);
        $form->setTaille("reg", 10);
        $form->setTaille("dep", 10);
        $form->setTaille("arr", 10);
        $form->setTaille("tncc", 10);
        $form->setTaille("ncc", 30);
        $form->setTaille("nccenr", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("can", 10);
        $form->setTaille("comparent", 10);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("commune", 11);
        $form->setMax("typecom", 4);
        $form->setMax("com", 5);
        $form->setMax("reg", 2);
        $form->setMax("dep", 3);
        $form->setMax("arr", 4);
        $form->setMax("tncc", 1);
        $form->setMax("ncc", 200);
        $form->setMax("nccenr", 200);
        $form->setMax("libelle", 45);
        $form->setMax("can", 5);
        $form->setMax("comparent", 5);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('commune', __('commune'));
        $form->setLib('typecom', __('typecom'));
        $form->setLib('com', __('com'));
        $form->setLib('reg', __('reg'));
        $form->setLib('dep', __('dep'));
        $form->setLib('arr', __('arr'));
        $form->setLib('tncc', __('tncc'));
        $form->setLib('ncc', __('ncc'));
        $form->setLib('nccenr', __('nccenr'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('can', __('can'));
        $form->setLib('comparent', __('comparent'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
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
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "commune", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "commune", $id);
        // Verification de la cle secondaire : dossier_autorisation
        $this->rechercheTable($this->f->db, "dossier_autorisation", "commune", $id);
        // Verification de la cle secondaire : lien_habilitation_tiers_consulte_commune
        $this->rechercheTable($this->f->db, "lien_habilitation_tiers_consulte_commune", "commune", $id);
    }


}

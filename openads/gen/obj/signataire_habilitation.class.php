<?php
//$Id$ 
//gen openMairie le 23/02/2022 17:28

require_once "../obj/om_dbform.class.php";

class signataire_habilitation_gen extends om_dbform {

    protected $_absolute_class_name = "signataire_habilitation";

    var $table = "signataire_habilitation";
    var $clePrimaire = "signataire_habilitation";
    var $typeCle = "N";
    var $required_field = array(
        "libelle",
        "signataire_habilitation"
    );
    var $unique_key = array(
      "code",
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
            "signataire_habilitation",
            "libelle",
            "code",
            "description",
            "om_validite_debut",
            "om_validite_fin",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['signataire_habilitation'])) {
            $this->valF['signataire_habilitation'] = ""; // -> requis
        } else {
            $this->valF['signataire_habilitation'] = $val['signataire_habilitation'];
        }
        $this->valF['libelle'] = $val['libelle'];
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if ($val['description'] == "") {
            $this->valF['description'] = NULL;
        } else {
            $this->valF['description'] = $val['description'];
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
            $form->setType("signataire_habilitation", "hidden");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
            $form->setType("description", "text");
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
            $form->setType("signataire_habilitation", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
            $form->setType("description", "text");
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
            $form->setType("signataire_habilitation", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("signataire_habilitation", "static");
            $form->setType("libelle", "static");
            $form->setType("code", "static");
            $form->setType("description", "static");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('signataire_habilitation','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("signataire_habilitation", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("code", 20);
        $form->setTaille("description", 30);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("signataire_habilitation", 11);
        $form->setMax("libelle", 255);
        $form->setMax("code", 20);
        $form->setMax("description", 255);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('signataire_habilitation', __('signataire_habilitation'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('code', __('code'));
        $form->setLib('description', __('description'));
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
        // Verification de la cle secondaire : signataire_arrete
        $this->rechercheTable($this->f->db, "signataire_arrete", "signataire_habilitation", $id);
    }


}

<?php
//$Id$ 
//gen openMairie le 15/09/2020 13:20

require_once "../obj/om_dbform.class.php";

class region_gen extends om_dbform {

    protected $_absolute_class_name = "region";

    var $table = "region";
    var $clePrimaire = "region";
    var $typeCle = "N";
    var $required_field = array(
        "cheflieu",
        "om_validite_debut",
        "reg",
        "region"
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
            "region",
            "reg",
            "cheflieu",
            "tncc",
            "ncc",
            "nccenr",
            "libelle",
            "om_validite_debut",
            "om_validite_fin",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['region'])) {
            $this->valF['region'] = ""; // -> requis
        } else {
            $this->valF['region'] = $val['region'];
        }
        $this->valF['reg'] = $val['reg'];
        $this->valF['cheflieu'] = $val['cheflieu'];
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
            $form->setType("region", "hidden");
            $form->setType("reg", "text");
            $form->setType("cheflieu", "text");
            $form->setType("tncc", "text");
            $form->setType("ncc", "text");
            $form->setType("nccenr", "text");
            $form->setType("libelle", "text");
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
            $form->setType("region", "hiddenstatic");
            $form->setType("reg", "text");
            $form->setType("cheflieu", "text");
            $form->setType("tncc", "text");
            $form->setType("ncc", "text");
            $form->setType("nccenr", "text");
            $form->setType("libelle", "text");
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
            $form->setType("region", "hiddenstatic");
            $form->setType("reg", "hiddenstatic");
            $form->setType("cheflieu", "hiddenstatic");
            $form->setType("tncc", "hiddenstatic");
            $form->setType("ncc", "hiddenstatic");
            $form->setType("nccenr", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("region", "static");
            $form->setType("reg", "static");
            $form->setType("cheflieu", "static");
            $form->setType("tncc", "static");
            $form->setType("ncc", "static");
            $form->setType("nccenr", "static");
            $form->setType("libelle", "static");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('region','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("region", 11);
        $form->setTaille("reg", 10);
        $form->setTaille("cheflieu", 10);
        $form->setTaille("tncc", 10);
        $form->setTaille("ncc", 30);
        $form->setTaille("nccenr", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("region", 11);
        $form->setMax("reg", 2);
        $form->setMax("cheflieu", 5);
        $form->setMax("tncc", 1);
        $form->setMax("ncc", 200);
        $form->setMax("nccenr", 200);
        $form->setMax("libelle", 45);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('region', __('region'));
        $form->setLib('reg', __('reg'));
        $form->setLib('cheflieu', __('cheflieu'));
        $form->setLib('tncc', __('tncc'));
        $form->setLib('ncc', __('ncc'));
        $form->setLib('nccenr', __('nccenr'));
        $form->setLib('libelle', __('libelle'));
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
    

}

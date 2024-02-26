<?php
//$Id$ 
//gen openMairie le 15/07/2021 10:24

require_once "../obj/om_dbform.class.php";

class document_numerise_type_gen extends om_dbform {

    protected $_absolute_class_name = "document_numerise_type";

    var $table = "document_numerise_type";
    var $clePrimaire = "document_numerise_type";
    var $typeCle = "N";
    var $required_field = array(
        "code",
        "document_numerise_type",
        "document_numerise_type_categorie",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
        "document_numerise_type_categorie" => array("document_numerise_type_categorie", ),
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
            "document_numerise_type",
            "code",
            "libelle",
            "document_numerise_type_categorie",
            "aff_service_consulte",
            "aff_da",
            "synchro_metadonnee",
            "description",
            "om_validite_debut",
            "om_validite_fin",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_categorie() {
        return "SELECT document_numerise_type_categorie.document_numerise_type_categorie, document_numerise_type_categorie.libelle FROM ".DB_PREFIXE."document_numerise_type_categorie ORDER BY document_numerise_type_categorie.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_categorie_by_id() {
        return "SELECT document_numerise_type_categorie.document_numerise_type_categorie, document_numerise_type_categorie.libelle FROM ".DB_PREFIXE."document_numerise_type_categorie WHERE document_numerise_type_categorie = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['document_numerise_type'])) {
            $this->valF['document_numerise_type'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type'] = $val['document_numerise_type'];
        }
        $this->valF['code'] = $val['code'];
        $this->valF['libelle'] = $val['libelle'];
        if (!is_numeric($val['document_numerise_type_categorie'])) {
            $this->valF['document_numerise_type_categorie'] = ""; // -> requis
        } else {
            $this->valF['document_numerise_type_categorie'] = $val['document_numerise_type_categorie'];
        }
        if ($val['aff_service_consulte'] == 1 || $val['aff_service_consulte'] == "t" || $val['aff_service_consulte'] == "Oui") {
            $this->valF['aff_service_consulte'] = true;
        } else {
            $this->valF['aff_service_consulte'] = false;
        }
        if ($val['aff_da'] == 1 || $val['aff_da'] == "t" || $val['aff_da'] == "Oui") {
            $this->valF['aff_da'] = true;
        } else {
            $this->valF['aff_da'] = false;
        }
        if ($val['synchro_metadonnee'] == 1 || $val['synchro_metadonnee'] == "t" || $val['synchro_metadonnee'] == "Oui") {
            $this->valF['synchro_metadonnee'] = true;
        } else {
            $this->valF['synchro_metadonnee'] = false;
        }
            $this->valF['description'] = $val['description'];
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
            $form->setType("document_numerise_type", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("document_numerise_type_categorie", $this->retourformulaire)) {
                $form->setType("document_numerise_type_categorie", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type_categorie", "select");
            }
            $form->setType("aff_service_consulte", "checkbox");
            $form->setType("aff_da", "checkbox");
            $form->setType("synchro_metadonnee", "checkbox");
            $form->setType("description", "textarea");
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
            $form->setType("document_numerise_type", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            if ($this->is_in_context_of_foreign_key("document_numerise_type_categorie", $this->retourformulaire)) {
                $form->setType("document_numerise_type_categorie", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise_type_categorie", "select");
            }
            $form->setType("aff_service_consulte", "checkbox");
            $form->setType("aff_da", "checkbox");
            $form->setType("synchro_metadonnee", "checkbox");
            $form->setType("description", "textarea");
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
            $form->setType("document_numerise_type", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("document_numerise_type_categorie", "selectstatic");
            $form->setType("aff_service_consulte", "hiddenstatic");
            $form->setType("aff_da", "hiddenstatic");
            $form->setType("synchro_metadonnee", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("document_numerise_type", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("document_numerise_type_categorie", "selectstatic");
            $form->setType("aff_service_consulte", "checkboxstatic");
            $form->setType("aff_da", "checkboxstatic");
            $form->setType("synchro_metadonnee", "checkboxstatic");
            $form->setType("description", "textareastatic");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('document_numerise_type','VerifNum(this)');
        $form->setOnchange('document_numerise_type_categorie','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("document_numerise_type", 11);
        $form->setTaille("code", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("document_numerise_type_categorie", 11);
        $form->setTaille("aff_service_consulte", 1);
        $form->setTaille("aff_da", 1);
        $form->setTaille("synchro_metadonnee", 1);
        $form->setTaille("description", 80);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("document_numerise_type", 11);
        $form->setMax("code", 50);
        $form->setMax("libelle", 2000);
        $form->setMax("document_numerise_type_categorie", 11);
        $form->setMax("aff_service_consulte", 1);
        $form->setMax("aff_da", 1);
        $form->setMax("synchro_metadonnee", 1);
        $form->setMax("description", 6);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('document_numerise_type', __('document_numerise_type'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('document_numerise_type_categorie', __('document_numerise_type_categorie'));
        $form->setLib('aff_service_consulte', __('aff_service_consulte'));
        $form->setLib('aff_da', __('aff_da'));
        $form->setLib('synchro_metadonnee', __('synchro_metadonnee'));
        $form->setLib('description', __('description'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // document_numerise_type_categorie
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise_type_categorie",
            $this->get_var_sql_forminc__sql("document_numerise_type_categorie"),
            $this->get_var_sql_forminc__sql("document_numerise_type_categorie_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('document_numerise_type_categorie', $this->retourformulaire))
                $form->setVal('document_numerise_type_categorie', $idxformulaire);
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
        // Verification de la cle secondaire : document_numerise
        $this->rechercheTable($this->f->db, "document_numerise", "document_numerise_type", $id);
        // Verification de la cle secondaire : lien_document_n_type_d_i_t
        $this->rechercheTable($this->f->db, "lien_document_n_type_d_i_t", "document_numerise_type", $id);
        // Verification de la cle secondaire : lien_document_numerise_type_instructeur_qualite
        $this->rechercheTable($this->f->db, "lien_document_numerise_type_instructeur_qualite", "document_numerise_type", $id);
    }


}

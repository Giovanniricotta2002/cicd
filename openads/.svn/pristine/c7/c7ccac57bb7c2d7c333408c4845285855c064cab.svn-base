<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class dossier_autorisation_type_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_autorisation_type";

    var $table = "dossier_autorisation_type";
    var $clePrimaire = "dossier_autorisation_type";
    var $typeCle = "N";
    var $required_field = array(
        "affichage_form",
        "code",
        "dossier_autorisation_type"
    );
    var $unique_key = array(
      "code",
    );
    var $foreign_keys_extended = array(
        "groupe" => array("groupe", ),
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
            "dossier_autorisation_type",
            "code",
            "libelle",
            "description",
            "confidentiel",
            "groupe",
            "affichage_form",
            "cacher_da",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe() {
        return "SELECT groupe.groupe, groupe.libelle FROM ".DB_PREFIXE."groupe ORDER BY groupe.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe_by_id() {
        return "SELECT groupe.groupe, groupe.libelle FROM ".DB_PREFIXE."groupe WHERE groupe = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_autorisation_type'])) {
            $this->valF['dossier_autorisation_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_autorisation_type'] = $val['dossier_autorisation_type'];
        }
        $this->valF['code'] = $val['code'];
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
            $this->valF['description'] = $val['description'];
        if ($val['confidentiel'] == 1 || $val['confidentiel'] == "t" || $val['confidentiel'] == "Oui") {
            $this->valF['confidentiel'] = true;
        } else {
            $this->valF['confidentiel'] = false;
        }
        if (!is_numeric($val['groupe'])) {
            $this->valF['groupe'] = NULL;
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        $this->valF['affichage_form'] = $val['affichage_form'];
        if ($val['cacher_da'] == 1 || $val['cacher_da'] == "t" || $val['cacher_da'] == "Oui") {
            $this->valF['cacher_da'] = true;
        } else {
            $this->valF['cacher_da'] = false;
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
            $form->setType("dossier_autorisation_type", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            $form->setType("confidentiel", "checkbox");
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            $form->setType("affichage_form", "text");
            $form->setType("cacher_da", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_autorisation_type", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            $form->setType("confidentiel", "checkbox");
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            $form->setType("affichage_form", "text");
            $form->setType("cacher_da", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_autorisation_type", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("confidentiel", "hiddenstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("affichage_form", "hiddenstatic");
            $form->setType("cacher_da", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_autorisation_type", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("confidentiel", "checkboxstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("affichage_form", "static");
            $form->setType("cacher_da", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_autorisation_type','VerifNum(this)');
        $form->setOnchange('groupe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_autorisation_type", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("confidentiel", 1);
        $form->setTaille("groupe", 11);
        $form->setTaille("affichage_form", 30);
        $form->setTaille("cacher_da", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_autorisation_type", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("confidentiel", 1);
        $form->setMax("groupe", 11);
        $form->setMax("affichage_form", 250);
        $form->setMax("cacher_da", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_autorisation_type', __('dossier_autorisation_type'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('confidentiel', __('confidentiel'));
        $form->setLib('groupe', __('groupe'));
        $form->setLib('affichage_form', __('affichage_form'));
        $form->setLib('cacher_da', __('cacher_da'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // groupe
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "groupe",
            $this->get_var_sql_forminc__sql("groupe"),
            $this->get_var_sql_forminc__sql("groupe_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('groupe', $this->retourformulaire))
                $form->setVal('groupe', $idxformulaire);
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
        // Verification de la cle secondaire : bible
        $this->rechercheTable($this->f->db, "bible", "dossier_autorisation_type", $id);
        // Verification de la cle secondaire : dossier_autorisation_type_detaille
        $this->rechercheTable($this->f->db, "dossier_autorisation_type_detaille", "dossier_autorisation_type", $id);
    }


}

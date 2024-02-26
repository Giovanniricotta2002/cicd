<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_om_profil_groupe_gen extends om_dbform {

    protected $_absolute_class_name = "lien_om_profil_groupe";

    var $table = "lien_om_profil_groupe";
    var $clePrimaire = "lien_om_profil_groupe";
    var $typeCle = "N";
    var $required_field = array(
        "groupe",
        "lien_om_profil_groupe",
        "om_profil"
    );
    var $unique_key = array(
      array("groupe","om_profil"),
    );
    var $foreign_keys_extended = array(
        "groupe" => array("groupe", ),
        "om_profil" => array("om_profil", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("om_profil");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_om_profil_groupe",
            "om_profil",
            "groupe",
            "confidentiel",
            "enregistrement_demande",
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_profil() {
        return "SELECT om_profil.om_profil, om_profil.libelle FROM ".DB_PREFIXE."om_profil WHERE ((om_profil.om_validite_debut IS NULL AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE)) OR (om_profil.om_validite_debut <= CURRENT_DATE AND (om_profil.om_validite_fin IS NULL OR om_profil.om_validite_fin > CURRENT_DATE))) ORDER BY om_profil.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_profil_by_id() {
        return "SELECT om_profil.om_profil, om_profil.libelle FROM ".DB_PREFIXE."om_profil WHERE om_profil = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_om_profil_groupe'])) {
            $this->valF['lien_om_profil_groupe'] = ""; // -> requis
        } else {
            $this->valF['lien_om_profil_groupe'] = $val['lien_om_profil_groupe'];
        }
        if (!is_numeric($val['om_profil'])) {
            $this->valF['om_profil'] = ""; // -> requis
        } else {
            $this->valF['om_profil'] = $val['om_profil'];
        }
        if (!is_numeric($val['groupe'])) {
            $this->valF['groupe'] = ""; // -> requis
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        if ($val['confidentiel'] == 1 || $val['confidentiel'] == "t" || $val['confidentiel'] == "Oui") {
            $this->valF['confidentiel'] = true;
        } else {
            $this->valF['confidentiel'] = false;
        }
        if ($val['enregistrement_demande'] == 1 || $val['enregistrement_demande'] == "t" || $val['enregistrement_demande'] == "Oui") {
            $this->valF['enregistrement_demande'] = true;
        } else {
            $this->valF['enregistrement_demande'] = false;
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
            $form->setType("lien_om_profil_groupe", "hidden");
            if ($this->is_in_context_of_foreign_key("om_profil", $this->retourformulaire)) {
                $form->setType("om_profil", "selecthiddenstatic");
            } else {
                $form->setType("om_profil", "select");
            }
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            $form->setType("confidentiel", "checkbox");
            $form->setType("enregistrement_demande", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_om_profil_groupe", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("om_profil", $this->retourformulaire)) {
                $form->setType("om_profil", "selecthiddenstatic");
            } else {
                $form->setType("om_profil", "select");
            }
            if ($this->is_in_context_of_foreign_key("groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            $form->setType("confidentiel", "checkbox");
            $form->setType("enregistrement_demande", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_om_profil_groupe", "hiddenstatic");
            $form->setType("om_profil", "selectstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("confidentiel", "hiddenstatic");
            $form->setType("enregistrement_demande", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_om_profil_groupe", "static");
            $form->setType("om_profil", "selectstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("confidentiel", "checkboxstatic");
            $form->setType("enregistrement_demande", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_om_profil_groupe','VerifNum(this)');
        $form->setOnchange('om_profil','VerifNum(this)');
        $form->setOnchange('groupe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_om_profil_groupe", 11);
        $form->setTaille("om_profil", 11);
        $form->setTaille("groupe", 11);
        $form->setTaille("confidentiel", 1);
        $form->setTaille("enregistrement_demande", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_om_profil_groupe", 11);
        $form->setMax("om_profil", 11);
        $form->setMax("groupe", 11);
        $form->setMax("confidentiel", 1);
        $form->setMax("enregistrement_demande", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_om_profil_groupe', __('lien_om_profil_groupe'));
        $form->setLib('om_profil', __('om_profil'));
        $form->setLib('groupe', __('groupe'));
        $form->setLib('confidentiel', __('confidentiel'));
        $form->setLib('enregistrement_demande', __('enregistrement_demande'));
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
        // om_profil
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_profil",
            $this->get_var_sql_forminc__sql("om_profil"),
            $this->get_var_sql_forminc__sql("om_profil_by_id"),
            true
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
            if($this->is_in_context_of_foreign_key('om_profil', $this->retourformulaire))
                $form->setVal('om_profil', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

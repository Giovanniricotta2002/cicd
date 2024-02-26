<?php
//$Id$ 
//gen openMairie le 04/05/2023 15:22

require_once "../obj/om_dbform.class.php";

class lien_om_utilisateur_tiers_consulte_gen extends om_dbform {

    protected $_absolute_class_name = "lien_om_utilisateur_tiers_consulte";

    var $table = "lien_om_utilisateur_tiers_consulte";
    var $clePrimaire = "lien_om_utilisateur_tiers_consulte";
    var $typeCle = "N";
    var $required_field = array(
        "lien_om_utilisateur_tiers_consulte",
        "om_utilisateur",
        "tiers_consulte"
    );
    
    var $foreign_keys_extended = array(
        "om_utilisateur" => array("om_utilisateur", ),
        "tiers_consulte" => array("tiers_consulte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("om_utilisateur");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_om_utilisateur_tiers_consulte",
            "om_utilisateur",
            "tiers_consulte",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_utilisateur() {
        return "SELECT om_utilisateur.om_utilisateur, om_utilisateur.nom FROM ".DB_PREFIXE."om_utilisateur ORDER BY om_utilisateur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_utilisateur_by_id() {
        return "SELECT om_utilisateur.om_utilisateur, om_utilisateur.nom FROM ".DB_PREFIXE."om_utilisateur WHERE om_utilisateur = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte ORDER BY tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_consulte_by_id() {
        return "SELECT tiers_consulte.tiers_consulte, tiers_consulte.libelle FROM ".DB_PREFIXE."tiers_consulte WHERE tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_om_utilisateur_tiers_consulte'])) {
            $this->valF['lien_om_utilisateur_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['lien_om_utilisateur_tiers_consulte'] = $val['lien_om_utilisateur_tiers_consulte'];
        }
        if (!is_numeric($val['om_utilisateur'])) {
            $this->valF['om_utilisateur'] = ""; // -> requis
        } else {
            $this->valF['om_utilisateur'] = $val['om_utilisateur'];
        }
        if (!is_numeric($val['tiers_consulte'])) {
            $this->valF['tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['tiers_consulte'] = $val['tiers_consulte'];
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
            $form->setType("lien_om_utilisateur_tiers_consulte", "hidden");
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_om_utilisateur_tiers_consulte", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
            }
            if ($this->is_in_context_of_foreign_key("tiers_consulte", $this->retourformulaire)) {
                $form->setType("tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("tiers_consulte", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_om_utilisateur_tiers_consulte", "hiddenstatic");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("tiers_consulte", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_om_utilisateur_tiers_consulte", "static");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("tiers_consulte", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_om_utilisateur_tiers_consulte','VerifNum(this)');
        $form->setOnchange('om_utilisateur','VerifNum(this)');
        $form->setOnchange('tiers_consulte','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_om_utilisateur_tiers_consulte", 11);
        $form->setTaille("om_utilisateur", 11);
        $form->setTaille("tiers_consulte", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_om_utilisateur_tiers_consulte", 11);
        $form->setMax("om_utilisateur", 11);
        $form->setMax("tiers_consulte", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_om_utilisateur_tiers_consulte', __('lien_om_utilisateur_tiers_consulte'));
        $form->setLib('om_utilisateur', __('om_utilisateur'));
        $form->setLib('tiers_consulte', __('tiers_consulte'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // om_utilisateur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_utilisateur",
            $this->get_var_sql_forminc__sql("om_utilisateur"),
            $this->get_var_sql_forminc__sql("om_utilisateur_by_id"),
            false
        );
        // tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "tiers_consulte",
            $this->get_var_sql_forminc__sql("tiers_consulte"),
            $this->get_var_sql_forminc__sql("tiers_consulte_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('om_utilisateur', $this->retourformulaire))
                $form->setVal('om_utilisateur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('tiers_consulte', $this->retourformulaire))
                $form->setVal('tiers_consulte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

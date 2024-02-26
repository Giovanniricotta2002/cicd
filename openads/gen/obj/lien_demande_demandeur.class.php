<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_demande_demandeur_gen extends om_dbform {

    protected $_absolute_class_name = "lien_demande_demandeur";

    var $table = "lien_demande_demandeur";
    var $clePrimaire = "lien_demande_demandeur";
    var $typeCle = "N";
    var $required_field = array(
        "lien_demande_demandeur"
    );
    
    var $foreign_keys_extended = array(
        "demande" => array("demande", ),
        "demandeur" => array("demandeur", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("petitionnaire_principal");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_demande_demandeur",
            "petitionnaire_principal",
            "demande",
            "demandeur",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande() {
        return "SELECT demande.demande, demande.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."demande ORDER BY demande.dossier_autorisation_type_detaille ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_by_id() {
        return "SELECT demande.demande, demande.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."demande WHERE demande = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur() {
        return "SELECT demandeur.demandeur, demandeur.type_demandeur FROM ".DB_PREFIXE."demandeur ORDER BY demandeur.type_demandeur ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur_by_id() {
        return "SELECT demandeur.demandeur, demandeur.type_demandeur FROM ".DB_PREFIXE."demandeur WHERE demandeur = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_demande_demandeur'])) {
            $this->valF['lien_demande_demandeur'] = ""; // -> requis
        } else {
            $this->valF['lien_demande_demandeur'] = $val['lien_demande_demandeur'];
        }
        if ($val['petitionnaire_principal'] == 1 || $val['petitionnaire_principal'] == "t" || $val['petitionnaire_principal'] == "Oui") {
            $this->valF['petitionnaire_principal'] = true;
        } else {
            $this->valF['petitionnaire_principal'] = false;
        }
        if (!is_numeric($val['demande'])) {
            $this->valF['demande'] = NULL;
        } else {
            $this->valF['demande'] = $val['demande'];
        }
        if (!is_numeric($val['demandeur'])) {
            $this->valF['demandeur'] = NULL;
        } else {
            $this->valF['demandeur'] = $val['demandeur'];
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
            $form->setType("lien_demande_demandeur", "hidden");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("demande", $this->retourformulaire)) {
                $form->setType("demande", "selecthiddenstatic");
            } else {
                $form->setType("demande", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_demande_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "checkbox");
            if ($this->is_in_context_of_foreign_key("demande", $this->retourformulaire)) {
                $form->setType("demande", "selecthiddenstatic");
            } else {
                $form->setType("demande", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_demande_demandeur", "hiddenstatic");
            $form->setType("petitionnaire_principal", "hiddenstatic");
            $form->setType("demande", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_demande_demandeur", "static");
            $form->setType("petitionnaire_principal", "checkboxstatic");
            $form->setType("demande", "selectstatic");
            $form->setType("demandeur", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_demande_demandeur','VerifNum(this)');
        $form->setOnchange('demande','VerifNum(this)');
        $form->setOnchange('demandeur','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_demande_demandeur", 11);
        $form->setTaille("petitionnaire_principal", 1);
        $form->setTaille("demande", 11);
        $form->setTaille("demandeur", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_demande_demandeur", 11);
        $form->setMax("petitionnaire_principal", 1);
        $form->setMax("demande", 11);
        $form->setMax("demandeur", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_demande_demandeur', __('lien_demande_demandeur'));
        $form->setLib('petitionnaire_principal', __('petitionnaire_principal'));
        $form->setLib('demande', __('demande'));
        $form->setLib('demandeur', __('demandeur'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // demande
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demande",
            $this->get_var_sql_forminc__sql("demande"),
            $this->get_var_sql_forminc__sql("demande_by_id"),
            false
        );
        // demandeur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demandeur",
            $this->get_var_sql_forminc__sql("demandeur"),
            $this->get_var_sql_forminc__sql("demandeur_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('demande', $this->retourformulaire))
                $form->setVal('demande', $idxformulaire);
            if($this->is_in_context_of_foreign_key('demandeur', $this->retourformulaire))
                $form->setVal('demandeur', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

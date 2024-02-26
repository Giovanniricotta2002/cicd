<?php
//$Id$ 
//gen openMairie le 30/11/2020 15:48

require_once "../obj/om_dbform.class.php";

class lien_demande_type_etat_gen extends om_dbform {

    protected $_absolute_class_name = "lien_demande_type_etat";

    var $table = "lien_demande_type_etat";
    var $clePrimaire = "lien_demande_type_etat";
    var $typeCle = "N";
    var $required_field = array(
        "demande_type",
        "etat",
        "lien_demande_type_etat"
    );
    
    var $foreign_keys_extended = array(
        "demande_type" => array("demande_type", ),
        "etat" => array("etat", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("demande_type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_demande_type_etat",
            "demande_type",
            "etat",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_type() {
        return "SELECT demande_type.demande_type, demande_type.libelle FROM ".DB_PREFIXE."demande_type ORDER BY demande_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_type_by_id() {
        return "SELECT demande_type.demande_type, demande_type.libelle FROM ".DB_PREFIXE."demande_type WHERE demande_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat ORDER BY etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_by_id() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat WHERE etat = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_demande_type_etat'])) {
            $this->valF['lien_demande_type_etat'] = ""; // -> requis
        } else {
            $this->valF['lien_demande_type_etat'] = $val['lien_demande_type_etat'];
        }
        if (!is_numeric($val['demande_type'])) {
            $this->valF['demande_type'] = ""; // -> requis
        } else {
            $this->valF['demande_type'] = $val['demande_type'];
        }
        $this->valF['etat'] = $val['etat'];
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
            $form->setType("lien_demande_type_etat", "hidden");
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_demande_type_etat", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("demande_type", $this->retourformulaire)) {
                $form->setType("demande_type", "selecthiddenstatic");
            } else {
                $form->setType("demande_type", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_demande_type_etat", "hiddenstatic");
            $form->setType("demande_type", "selectstatic");
            $form->setType("etat", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_demande_type_etat", "static");
            $form->setType("demande_type", "selectstatic");
            $form->setType("etat", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_demande_type_etat','VerifNum(this)');
        $form->setOnchange('demande_type','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_demande_type_etat", 11);
        $form->setTaille("demande_type", 11);
        $form->setTaille("etat", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_demande_type_etat", 11);
        $form->setMax("demande_type", 11);
        $form->setMax("etat", 150);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_demande_type_etat', __('lien_demande_type_etat'));
        $form->setLib('demande_type', __('demande_type'));
        $form->setLib('etat', __('etat'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // demande_type
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "demande_type",
            $this->get_var_sql_forminc__sql("demande_type"),
            $this->get_var_sql_forminc__sql("demande_type_by_id"),
            false
        );
        // etat
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "etat",
            $this->get_var_sql_forminc__sql("etat"),
            $this->get_var_sql_forminc__sql("etat_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('demande_type', $this->retourformulaire))
                $form->setVal('demande_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

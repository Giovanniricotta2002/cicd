<?php
//$Id$ 
//gen openMairie le 07/03/2023 15:41

require_once "../obj/om_dbform.class.php";

class lien_sig_contrainte_evenement_gen extends om_dbform {

    protected $_absolute_class_name = "lien_sig_contrainte_evenement";

    var $table = "lien_sig_contrainte_evenement";
    var $clePrimaire = "lien_sig_contrainte_evenement";
    var $typeCle = "N";
    var $required_field = array(
        "evenement",
        "lien_sig_contrainte_evenement",
        "sig_contrainte"
    );
    var $unique_key = array(
      array("evenement","sig_contrainte"),
    );
    var $foreign_keys_extended = array(
        "evenement" => array("evenement", ),
        "sig_contrainte" => array("sig_contrainte", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("sig_contrainte");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_sig_contrainte_evenement",
            "sig_contrainte",
            "evenement",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte ORDER BY sig_contrainte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_contrainte_by_id() {
        return "SELECT sig_contrainte.sig_contrainte, sig_contrainte.libelle FROM ".DB_PREFIXE."sig_contrainte WHERE sig_contrainte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_sig_contrainte_evenement'])) {
            $this->valF['lien_sig_contrainte_evenement'] = ""; // -> requis
        } else {
            $this->valF['lien_sig_contrainte_evenement'] = $val['lien_sig_contrainte_evenement'];
        }
        if (!is_numeric($val['sig_contrainte'])) {
            $this->valF['sig_contrainte'] = ""; // -> requis
        } else {
            $this->valF['sig_contrainte'] = $val['sig_contrainte'];
        }
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = ""; // -> requis
        } else {
            $this->valF['evenement'] = $val['evenement'];
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
            $form->setType("lien_sig_contrainte_evenement", "hidden");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_sig_contrainte_evenement", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("sig_contrainte", $this->retourformulaire)) {
                $form->setType("sig_contrainte", "selecthiddenstatic");
            } else {
                $form->setType("sig_contrainte", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_sig_contrainte_evenement", "hiddenstatic");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_sig_contrainte_evenement", "static");
            $form->setType("sig_contrainte", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_sig_contrainte_evenement','VerifNum(this)');
        $form->setOnchange('sig_contrainte','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_sig_contrainte_evenement", 11);
        $form->setTaille("sig_contrainte", 11);
        $form->setTaille("evenement", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_sig_contrainte_evenement", 11);
        $form->setMax("sig_contrainte", 11);
        $form->setMax("evenement", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_sig_contrainte_evenement', __('lien_sig_contrainte_evenement'));
        $form->setLib('sig_contrainte', __('sig_contrainte'));
        $form->setLib('evenement', __('evenement'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // evenement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement",
            $this->get_var_sql_forminc__sql("evenement"),
            $this->get_var_sql_forminc__sql("evenement_by_id"),
            false
        );
        // sig_contrainte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_contrainte",
            $this->get_var_sql_forminc__sql("sig_contrainte"),
            $this->get_var_sql_forminc__sql("sig_contrainte_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('sig_contrainte', $this->retourformulaire))
                $form->setVal('sig_contrainte', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

<?php
//$Id$ 
//gen openMairie le 30/11/2020 15:48

require_once "../obj/om_dbform.class.php";

class transition_gen extends om_dbform {

    protected $_absolute_class_name = "transition";

    var $table = "transition";
    var $clePrimaire = "transition";
    var $typeCle = "N";
    var $required_field = array(
        "etat",
        "evenement"
    );
    
    var $foreign_keys_extended = array(
        "etat" => array("etat", ),
        "evenement" => array("evenement", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("etat");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "transition",
            "etat",
            "evenement",
        );
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['transition'])) {
            $this->valF['transition'] = 0; // -> default
        } else {
            $this->valF['transition'] = $val['transition'];
        }
        $this->valF['etat'] = $val['etat'];
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
            $form->setType("transition", "hidden");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("transition", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("transition", "hiddenstatic");
            $form->setType("etat", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("transition", "static");
            $form->setType("etat", "selectstatic");
            $form->setType("evenement", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('transition','VerifNum(this)');
        $form->setOnchange('evenement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("transition", 11);
        $form->setTaille("etat", 30);
        $form->setTaille("evenement", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("transition", 11);
        $form->setMax("etat", 150);
        $form->setMax("evenement", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('transition', __('transition'));
        $form->setLib('etat', __('etat'));
        $form->setLib('evenement', __('evenement'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

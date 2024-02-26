<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_lot_demandeur_gen extends om_dbform {

    protected $_absolute_class_name = "lien_lot_demandeur";

    var $table = "lien_lot_demandeur";
    var $clePrimaire = "lien_lot_demandeur";
    var $typeCle = "N";
    var $required_field = array(
        "lien_lot_demandeur"
    );
    
    var $foreign_keys_extended = array(
        "demandeur" => array("demandeur", ),
        "lot" => array("lot", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("lot");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_lot_demandeur",
            "lot",
            "demandeur",
            "petitionnaire_principal",
        );
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_lot() {
        return "SELECT lot.lot, lot.libelle FROM ".DB_PREFIXE."lot ORDER BY lot.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_lot_by_id() {
        return "SELECT lot.lot, lot.libelle FROM ".DB_PREFIXE."lot WHERE lot = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_lot_demandeur'])) {
            $this->valF['lien_lot_demandeur'] = ""; // -> requis
        } else {
            $this->valF['lien_lot_demandeur'] = $val['lien_lot_demandeur'];
        }
        if (!is_numeric($val['lot'])) {
            $this->valF['lot'] = NULL;
        } else {
            $this->valF['lot'] = $val['lot'];
        }
        if (!is_numeric($val['demandeur'])) {
            $this->valF['demandeur'] = NULL;
        } else {
            $this->valF['demandeur'] = $val['demandeur'];
        }
        if ($val['petitionnaire_principal'] == 1 || $val['petitionnaire_principal'] == "t" || $val['petitionnaire_principal'] == "Oui") {
            $this->valF['petitionnaire_principal'] = true;
        } else {
            $this->valF['petitionnaire_principal'] = false;
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
            $form->setType("lien_lot_demandeur", "hidden");
            if ($this->is_in_context_of_foreign_key("lot", $this->retourformulaire)) {
                $form->setType("lot", "selecthiddenstatic");
            } else {
                $form->setType("lot", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
            $form->setType("petitionnaire_principal", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_lot_demandeur", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("lot", $this->retourformulaire)) {
                $form->setType("lot", "selecthiddenstatic");
            } else {
                $form->setType("lot", "select");
            }
            if ($this->is_in_context_of_foreign_key("demandeur", $this->retourformulaire)) {
                $form->setType("demandeur", "selecthiddenstatic");
            } else {
                $form->setType("demandeur", "select");
            }
            $form->setType("petitionnaire_principal", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_lot_demandeur", "hiddenstatic");
            $form->setType("lot", "selectstatic");
            $form->setType("demandeur", "selectstatic");
            $form->setType("petitionnaire_principal", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_lot_demandeur", "static");
            $form->setType("lot", "selectstatic");
            $form->setType("demandeur", "selectstatic");
            $form->setType("petitionnaire_principal", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_lot_demandeur','VerifNum(this)');
        $form->setOnchange('lot','VerifNum(this)');
        $form->setOnchange('demandeur','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_lot_demandeur", 11);
        $form->setTaille("lot", 11);
        $form->setTaille("demandeur", 11);
        $form->setTaille("petitionnaire_principal", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_lot_demandeur", 11);
        $form->setMax("lot", 11);
        $form->setMax("demandeur", 11);
        $form->setMax("petitionnaire_principal", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_lot_demandeur', __('lien_lot_demandeur'));
        $form->setLib('lot', __('lot'));
        $form->setLib('demandeur', __('demandeur'));
        $form->setLib('petitionnaire_principal', __('petitionnaire_principal'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
        // lot
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "lot",
            $this->get_var_sql_forminc__sql("lot"),
            $this->get_var_sql_forminc__sql("lot_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('demandeur', $this->retourformulaire))
                $form->setVal('demandeur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('lot', $this->retourformulaire))
                $form->setVal('lot', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

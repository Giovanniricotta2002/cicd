<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class quartier_gen extends om_dbform {

    protected $_absolute_class_name = "quartier";

    var $table = "quartier";
    var $clePrimaire = "quartier";
    var $typeCle = "N";
    var $required_field = array(
        "arrondissement",
        "code_impots",
        "libelle",
        "quartier"
    );
    
    var $foreign_keys_extended = array(
        "arrondissement" => array("arrondissement", ),
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
            "quartier",
            "arrondissement",
            "code_impots",
            "libelle",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY arrondissement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement_by_id() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement WHERE arrondissement = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['quartier'])) {
            $this->valF['quartier'] = ""; // -> requis
        } else {
            $this->valF['quartier'] = $val['quartier'];
        }
        if (!is_numeric($val['arrondissement'])) {
            $this->valF['arrondissement'] = ""; // -> requis
        } else {
            $this->valF['arrondissement'] = $val['arrondissement'];
        }
        $this->valF['code_impots'] = $val['code_impots'];
        $this->valF['libelle'] = $val['libelle'];
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
            $form->setType("quartier", "hidden");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            $form->setType("code_impots", "text");
            $form->setType("libelle", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("quartier", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            $form->setType("code_impots", "text");
            $form->setType("libelle", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("quartier", "hiddenstatic");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("code_impots", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("quartier", "static");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("code_impots", "static");
            $form->setType("libelle", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('quartier','VerifNum(this)');
        $form->setOnchange('arrondissement','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("quartier", 11);
        $form->setTaille("arrondissement", 11);
        $form->setTaille("code_impots", 10);
        $form->setTaille("libelle", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("quartier", 11);
        $form->setMax("arrondissement", 11);
        $form->setMax("code_impots", 3);
        $form->setMax("libelle", 40);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('quartier', __('quartier'));
        $form->setLib('arrondissement', __('arrondissement'));
        $form->setLib('code_impots', __('code_impots'));
        $form->setLib('libelle', __('libelle'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // arrondissement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "arrondissement",
            $this->get_var_sql_forminc__sql("arrondissement"),
            $this->get_var_sql_forminc__sql("arrondissement_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('arrondissement', $this->retourformulaire))
                $form->setVal('arrondissement', $idxformulaire);
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
        // Verification de la cle secondaire : affectation_automatique
        $this->rechercheTable($this->f->db, "affectation_automatique", "quartier", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "quartier", $id);
    }


}

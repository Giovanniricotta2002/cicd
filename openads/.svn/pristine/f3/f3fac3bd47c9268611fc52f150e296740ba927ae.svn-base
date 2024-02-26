<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_om_utilisateur_groupe_gen extends om_dbform {

    protected $_absolute_class_name = "lien_om_utilisateur_groupe";

    var $table = "lien_om_utilisateur_groupe";
    var $clePrimaire = "lien_om_utilisateur_groupe";
    var $typeCle = "N";
    var $required_field = array(
        "groupe",
        "lien_om_utilisateur_groupe",
        "login"
    );
    
    var $foreign_keys_extended = array(
        "groupe" => array("groupe", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("login");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_om_utilisateur_groupe",
            "login",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_om_utilisateur_groupe'])) {
            $this->valF['lien_om_utilisateur_groupe'] = ""; // -> requis
        } else {
            $this->valF['lien_om_utilisateur_groupe'] = $val['lien_om_utilisateur_groupe'];
        }
        $this->valF['login'] = $val['login'];
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
            $form->setType("lien_om_utilisateur_groupe", "hidden");
            $form->setType("login", "text");
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
            $form->setType("lien_om_utilisateur_groupe", "hiddenstatic");
            $form->setType("login", "text");
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
            $form->setType("lien_om_utilisateur_groupe", "hiddenstatic");
            $form->setType("login", "hiddenstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("confidentiel", "hiddenstatic");
            $form->setType("enregistrement_demande", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_om_utilisateur_groupe", "static");
            $form->setType("login", "static");
            $form->setType("groupe", "selectstatic");
            $form->setType("confidentiel", "checkboxstatic");
            $form->setType("enregistrement_demande", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_om_utilisateur_groupe','VerifNum(this)');
        $form->setOnchange('groupe','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_om_utilisateur_groupe", 11);
        $form->setTaille("login", 30);
        $form->setTaille("groupe", 11);
        $form->setTaille("confidentiel", 1);
        $form->setTaille("enregistrement_demande", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_om_utilisateur_groupe", 11);
        $form->setMax("login", 30);
        $form->setMax("groupe", 11);
        $form->setMax("confidentiel", 1);
        $form->setMax("enregistrement_demande", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_om_utilisateur_groupe', __('lien_om_utilisateur_groupe'));
        $form->setLib('login', __('login'));
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
    

}

<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_service_om_utilisateur_gen extends om_dbform {

    protected $_absolute_class_name = "lien_service_om_utilisateur";

    var $table = "lien_service_om_utilisateur";
    var $clePrimaire = "lien_service_om_utilisateur";
    var $typeCle = "N";
    var $required_field = array(
        "lien_service_om_utilisateur"
    );
    var $unique_key = array(
      array("om_utilisateur","service"),
    );
    var $foreign_keys_extended = array(
        "om_utilisateur" => array("om_utilisateur", ),
        "service" => array("service", ),
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
            "lien_service_om_utilisateur",
            "om_utilisateur",
            "service",
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
    function get_var_sql_forminc__sql_service() {
        return "SELECT service.service, service.libelle FROM ".DB_PREFIXE."service WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE))) ORDER BY service.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_by_id() {
        return "SELECT service.service, service.libelle FROM ".DB_PREFIXE."service WHERE service = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_service_om_utilisateur'])) {
            $this->valF['lien_service_om_utilisateur'] = ""; // -> requis
        } else {
            $this->valF['lien_service_om_utilisateur'] = $val['lien_service_om_utilisateur'];
        }
        if (!is_numeric($val['om_utilisateur'])) {
            $this->valF['om_utilisateur'] = NULL;
        } else {
            $this->valF['om_utilisateur'] = $val['om_utilisateur'];
        }
        if (!is_numeric($val['service'])) {
            $this->valF['service'] = NULL;
        } else {
            $this->valF['service'] = $val['service'];
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
            $form->setType("lien_service_om_utilisateur", "hidden");
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
            }
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_service_om_utilisateur", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("om_utilisateur", $this->retourformulaire)) {
                $form->setType("om_utilisateur", "selecthiddenstatic");
            } else {
                $form->setType("om_utilisateur", "select");
            }
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_service_om_utilisateur", "hiddenstatic");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("service", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_service_om_utilisateur", "static");
            $form->setType("om_utilisateur", "selectstatic");
            $form->setType("service", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_service_om_utilisateur','VerifNum(this)');
        $form->setOnchange('om_utilisateur','VerifNum(this)');
        $form->setOnchange('service','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_service_om_utilisateur", 11);
        $form->setTaille("om_utilisateur", 20);
        $form->setTaille("service", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_service_om_utilisateur", 11);
        $form->setMax("om_utilisateur", 20);
        $form->setMax("service", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_service_om_utilisateur', __('lien_service_om_utilisateur'));
        $form->setLib('om_utilisateur', __('om_utilisateur'));
        $form->setLib('service', __('service'));
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
        // service
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "service",
            $this->get_var_sql_forminc__sql("service"),
            $this->get_var_sql_forminc__sql("service_by_id"),
            true
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
            if($this->is_in_context_of_foreign_key('service', $this->retourformulaire))
                $form->setVal('service', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

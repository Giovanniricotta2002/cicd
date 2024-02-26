<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class lien_service_service_categorie_gen extends om_dbform {

    protected $_absolute_class_name = "lien_service_service_categorie";

    var $table = "lien_service_service_categorie";
    var $clePrimaire = "lien_service_service_categorie";
    var $typeCle = "N";
    var $required_field = array(
        "lien_service_service_categorie"
    );
    
    var $foreign_keys_extended = array(
        "service" => array("service", ),
        "service_categorie" => array("service_categorie", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("service_categorie");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "lien_service_service_categorie",
            "service_categorie",
            "service",
        );
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

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_categorie() {
        return "SELECT service_categorie.service_categorie, service_categorie.libelle FROM ".DB_PREFIXE."service_categorie ORDER BY service_categorie.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_categorie_by_id() {
        return "SELECT service_categorie.service_categorie, service_categorie.libelle FROM ".DB_PREFIXE."service_categorie WHERE service_categorie = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['lien_service_service_categorie'])) {
            $this->valF['lien_service_service_categorie'] = ""; // -> requis
        } else {
            $this->valF['lien_service_service_categorie'] = $val['lien_service_service_categorie'];
        }
        if (!is_numeric($val['service_categorie'])) {
            $this->valF['service_categorie'] = NULL;
        } else {
            $this->valF['service_categorie'] = $val['service_categorie'];
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
            $form->setType("lien_service_service_categorie", "hidden");
            if ($this->is_in_context_of_foreign_key("service_categorie", $this->retourformulaire)) {
                $form->setType("service_categorie", "selecthiddenstatic");
            } else {
                $form->setType("service_categorie", "select");
            }
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("lien_service_service_categorie", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("service_categorie", $this->retourformulaire)) {
                $form->setType("service_categorie", "selecthiddenstatic");
            } else {
                $form->setType("service_categorie", "select");
            }
            if ($this->is_in_context_of_foreign_key("service", $this->retourformulaire)) {
                $form->setType("service", "selecthiddenstatic");
            } else {
                $form->setType("service", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("lien_service_service_categorie", "hiddenstatic");
            $form->setType("service_categorie", "selectstatic");
            $form->setType("service", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("lien_service_service_categorie", "static");
            $form->setType("service_categorie", "selectstatic");
            $form->setType("service", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('lien_service_service_categorie','VerifNum(this)');
        $form->setOnchange('service_categorie','VerifNum(this)');
        $form->setOnchange('service','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("lien_service_service_categorie", 11);
        $form->setTaille("service_categorie", 11);
        $form->setTaille("service", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("lien_service_service_categorie", 11);
        $form->setMax("service_categorie", 11);
        $form->setMax("service", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('lien_service_service_categorie', __('lien_service_service_categorie'));
        $form->setLib('service_categorie', __('service_categorie'));
        $form->setLib('service', __('service'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
        // service_categorie
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "service_categorie",
            $this->get_var_sql_forminc__sql("service_categorie"),
            $this->get_var_sql_forminc__sql("service_categorie_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('service', $this->retourformulaire))
                $form->setVal('service', $idxformulaire);
            if($this->is_in_context_of_foreign_key('service_categorie', $this->retourformulaire))
                $form->setVal('service_categorie', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

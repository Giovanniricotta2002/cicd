<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class consultation_entrante_gen extends om_dbform {

    protected $_absolute_class_name = "consultation_entrante";

    var $table = "consultation_entrante";
    var $clePrimaire = "consultation_entrante";
    var $typeCle = "N";
    var $required_field = array(
        "consultation_entrante"
    );
    var $unique_key = array(
      "dossier",
    );
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("delai_reponse");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "consultation_entrante",
            "delai_reponse",
            "date_consultation",
            "date_emission",
            "service_consultant_id",
            "service_consultant_libelle",
            "service_consultant_insee",
            "service_consultant_mail",
            "service_consultant_type",
            "service_consultant__siren",
            "etat_consultation",
            "type_consultation",
            "texte_fondement_reglementaire",
            "texte_objet_consultation",
            "dossier",
            "type_delai",
            "objet_consultation",
            "date_production_notification",
            "date_premiere_consultation",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['consultation_entrante'])) {
            $this->valF['consultation_entrante'] = ""; // -> requis
        } else {
            $this->valF['consultation_entrante'] = $val['consultation_entrante'];
        }
        if ($val['delai_reponse'] == "") {
            $this->valF['delai_reponse'] = NULL;
        } else {
            $this->valF['delai_reponse'] = $val['delai_reponse'];
        }
        if ($val['date_consultation'] != "") {
            $this->valF['date_consultation'] = $this->dateDB($val['date_consultation']);
        } else {
            $this->valF['date_consultation'] = NULL;
        }
        if ($val['date_emission'] != "") {
            $this->valF['date_emission'] = $this->dateDB($val['date_emission']);
        } else {
            $this->valF['date_emission'] = NULL;
        }
        if ($val['service_consultant_id'] == "") {
            $this->valF['service_consultant_id'] = NULL;
        } else {
            $this->valF['service_consultant_id'] = $val['service_consultant_id'];
        }
        if ($val['service_consultant_libelle'] == "") {
            $this->valF['service_consultant_libelle'] = NULL;
        } else {
            $this->valF['service_consultant_libelle'] = $val['service_consultant_libelle'];
        }
        if ($val['service_consultant_insee'] == "") {
            $this->valF['service_consultant_insee'] = NULL;
        } else {
            $this->valF['service_consultant_insee'] = $val['service_consultant_insee'];
        }
        if ($val['service_consultant_mail'] == "") {
            $this->valF['service_consultant_mail'] = NULL;
        } else {
            $this->valF['service_consultant_mail'] = $val['service_consultant_mail'];
        }
        if ($val['service_consultant_type'] == "") {
            $this->valF['service_consultant_type'] = NULL;
        } else {
            $this->valF['service_consultant_type'] = $val['service_consultant_type'];
        }
        if ($val['service_consultant__siren'] == "") {
            $this->valF['service_consultant__siren'] = NULL;
        } else {
            $this->valF['service_consultant__siren'] = $val['service_consultant__siren'];
        }
        if ($val['etat_consultation'] == "") {
            $this->valF['etat_consultation'] = NULL;
        } else {
            $this->valF['etat_consultation'] = $val['etat_consultation'];
        }
        if ($val['type_consultation'] == "") {
            $this->valF['type_consultation'] = NULL;
        } else {
            $this->valF['type_consultation'] = $val['type_consultation'];
        }
            $this->valF['texte_fondement_reglementaire'] = $val['texte_fondement_reglementaire'];
            $this->valF['texte_objet_consultation'] = $val['texte_objet_consultation'];
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
        }
        if ($val['type_delai'] == "") {
            $this->valF['type_delai'] = NULL;
        } else {
            $this->valF['type_delai'] = $val['type_delai'];
        }
        if ($val['objet_consultation'] == "") {
            $this->valF['objet_consultation'] = NULL;
        } else {
            $this->valF['objet_consultation'] = $val['objet_consultation'];
        }
        if ($val['date_production_notification'] != "") {
            $this->valF['date_production_notification'] = $this->dateDB($val['date_production_notification']);
        } else {
            $this->valF['date_production_notification'] = NULL;
        }
        if ($val['date_premiere_consultation'] != "") {
            $this->valF['date_premiere_consultation'] = $this->dateDB($val['date_premiere_consultation']);
        } else {
            $this->valF['date_premiere_consultation'] = NULL;
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
            $form->setType("consultation_entrante", "hidden");
            $form->setType("delai_reponse", "text");
            $form->setType("date_consultation", "date");
            $form->setType("date_emission", "date");
            $form->setType("service_consultant_id", "text");
            $form->setType("service_consultant_libelle", "text");
            $form->setType("service_consultant_insee", "text");
            $form->setType("service_consultant_mail", "text");
            $form->setType("service_consultant_type", "text");
            $form->setType("service_consultant__siren", "text");
            $form->setType("etat_consultation", "text");
            $form->setType("type_consultation", "text");
            $form->setType("texte_fondement_reglementaire", "textarea");
            $form->setType("texte_objet_consultation", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("type_delai", "text");
            $form->setType("objet_consultation", "text");
            $form->setType("date_production_notification", "date");
            $form->setType("date_premiere_consultation", "date");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("consultation_entrante", "hiddenstatic");
            $form->setType("delai_reponse", "text");
            $form->setType("date_consultation", "date");
            $form->setType("date_emission", "date");
            $form->setType("service_consultant_id", "text");
            $form->setType("service_consultant_libelle", "text");
            $form->setType("service_consultant_insee", "text");
            $form->setType("service_consultant_mail", "text");
            $form->setType("service_consultant_type", "text");
            $form->setType("service_consultant__siren", "text");
            $form->setType("etat_consultation", "text");
            $form->setType("type_consultation", "text");
            $form->setType("texte_fondement_reglementaire", "textarea");
            $form->setType("texte_objet_consultation", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("type_delai", "text");
            $form->setType("objet_consultation", "text");
            $form->setType("date_production_notification", "date");
            $form->setType("date_premiere_consultation", "date");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("consultation_entrante", "hiddenstatic");
            $form->setType("delai_reponse", "hiddenstatic");
            $form->setType("date_consultation", "hiddenstatic");
            $form->setType("date_emission", "hiddenstatic");
            $form->setType("service_consultant_id", "hiddenstatic");
            $form->setType("service_consultant_libelle", "hiddenstatic");
            $form->setType("service_consultant_insee", "hiddenstatic");
            $form->setType("service_consultant_mail", "hiddenstatic");
            $form->setType("service_consultant_type", "hiddenstatic");
            $form->setType("service_consultant__siren", "hiddenstatic");
            $form->setType("etat_consultation", "hiddenstatic");
            $form->setType("type_consultation", "hiddenstatic");
            $form->setType("texte_fondement_reglementaire", "hiddenstatic");
            $form->setType("texte_objet_consultation", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("type_delai", "hiddenstatic");
            $form->setType("objet_consultation", "hiddenstatic");
            $form->setType("date_production_notification", "hiddenstatic");
            $form->setType("date_premiere_consultation", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("consultation_entrante", "static");
            $form->setType("delai_reponse", "static");
            $form->setType("date_consultation", "datestatic");
            $form->setType("date_emission", "datestatic");
            $form->setType("service_consultant_id", "static");
            $form->setType("service_consultant_libelle", "static");
            $form->setType("service_consultant_insee", "static");
            $form->setType("service_consultant_mail", "static");
            $form->setType("service_consultant_type", "static");
            $form->setType("service_consultant__siren", "static");
            $form->setType("etat_consultation", "static");
            $form->setType("type_consultation", "static");
            $form->setType("texte_fondement_reglementaire", "textareastatic");
            $form->setType("texte_objet_consultation", "textareastatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("type_delai", "static");
            $form->setType("objet_consultation", "static");
            $form->setType("date_production_notification", "datestatic");
            $form->setType("date_premiere_consultation", "datestatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('consultation_entrante','VerifNum(this)');
        $form->setOnchange('date_consultation','fdate(this)');
        $form->setOnchange('date_emission','fdate(this)');
        $form->setOnchange('date_production_notification','fdate(this)');
        $form->setOnchange('date_premiere_consultation','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("consultation_entrante", 11);
        $form->setTaille("delai_reponse", 30);
        $form->setTaille("date_consultation", 12);
        $form->setTaille("date_emission", 12);
        $form->setTaille("service_consultant_id", 30);
        $form->setTaille("service_consultant_libelle", 30);
        $form->setTaille("service_consultant_insee", 30);
        $form->setTaille("service_consultant_mail", 30);
        $form->setTaille("service_consultant_type", 30);
        $form->setTaille("service_consultant__siren", 30);
        $form->setTaille("etat_consultation", 30);
        $form->setTaille("type_consultation", 30);
        $form->setTaille("texte_fondement_reglementaire", 80);
        $form->setTaille("texte_objet_consultation", 80);
        $form->setTaille("dossier", 30);
        $form->setTaille("type_delai", 30);
        $form->setTaille("objet_consultation", 30);
        $form->setTaille("date_production_notification", 12);
        $form->setTaille("date_premiere_consultation", 12);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("consultation_entrante", 11);
        $form->setMax("delai_reponse", 255);
        $form->setMax("date_consultation", 12);
        $form->setMax("date_emission", 12);
        $form->setMax("service_consultant_id", 255);
        $form->setMax("service_consultant_libelle", 255);
        $form->setMax("service_consultant_insee", 255);
        $form->setMax("service_consultant_mail", 255);
        $form->setMax("service_consultant_type", 255);
        $form->setMax("service_consultant__siren", 255);
        $form->setMax("etat_consultation", 255);
        $form->setMax("type_consultation", 255);
        $form->setMax("texte_fondement_reglementaire", 6);
        $form->setMax("texte_objet_consultation", 6);
        $form->setMax("dossier", 255);
        $form->setMax("type_delai", 255);
        $form->setMax("objet_consultation", 255);
        $form->setMax("date_production_notification", 12);
        $form->setMax("date_premiere_consultation", 12);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('consultation_entrante', __('consultation_entrante'));
        $form->setLib('delai_reponse', __('delai_reponse'));
        $form->setLib('date_consultation', __('date_consultation'));
        $form->setLib('date_emission', __('date_emission'));
        $form->setLib('service_consultant_id', __('service_consultant_id'));
        $form->setLib('service_consultant_libelle', __('service_consultant_libelle'));
        $form->setLib('service_consultant_insee', __('service_consultant_insee'));
        $form->setLib('service_consultant_mail', __('service_consultant_mail'));
        $form->setLib('service_consultant_type', __('service_consultant_type'));
        $form->setLib('service_consultant__siren', __('service_consultant__siren'));
        $form->setLib('etat_consultation', __('etat_consultation'));
        $form->setLib('type_consultation', __('type_consultation'));
        $form->setLib('texte_fondement_reglementaire', __('texte_fondement_reglementaire'));
        $form->setLib('texte_objet_consultation', __('texte_objet_consultation'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('type_delai', __('type_delai'));
        $form->setLib('objet_consultation', __('objet_consultation'));
        $form->setLib('date_production_notification', __('date_production_notification'));
        $form->setLib('date_premiere_consultation', __('date_premiere_consultation'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // dossier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier",
            $this->get_var_sql_forminc__sql("dossier"),
            $this->get_var_sql_forminc__sql("dossier_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

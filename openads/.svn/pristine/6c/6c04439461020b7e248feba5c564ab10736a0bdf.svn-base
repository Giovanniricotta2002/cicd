<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class dossier_message_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_message";

    var $table = "dossier_message";
    var $clePrimaire = "dossier_message";
    var $typeCle = "N";
    var $required_field = array(
        "date_emission",
        "destinataire",
        "dossier",
        "dossier_message"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_message",
            "dossier",
            "type",
            "emetteur",
            "date_emission",
            "lu",
            "contenu",
            "categorie",
            "destinataire",
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
        if (!is_numeric($val['dossier_message'])) {
            $this->valF['dossier_message'] = ""; // -> requis
        } else {
            $this->valF['dossier_message'] = $val['dossier_message'];
        }
        $this->valF['dossier'] = $val['dossier'];
        if ($val['type'] == "") {
            $this->valF['type'] = NULL;
        } else {
            $this->valF['type'] = $val['type'];
        }
        if ($val['emetteur'] == "") {
            $this->valF['emetteur'] = NULL;
        } else {
            $this->valF['emetteur'] = $val['emetteur'];
        }
            $this->valF['date_emission'] = $val['date_emission'];
        if ($val['lu'] == 1 || $val['lu'] == "t" || $val['lu'] == "Oui") {
            $this->valF['lu'] = true;
        } else {
            $this->valF['lu'] = false;
        }
            $this->valF['contenu'] = $val['contenu'];
        if ($val['categorie'] == "") {
            $this->valF['categorie'] = NULL;
        } else {
            $this->valF['categorie'] = $val['categorie'];
        }
        $this->valF['destinataire'] = $val['destinataire'];
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
            $form->setType("dossier_message", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("type", "text");
            $form->setType("emetteur", "text");
            $form->setType("date_emission", "text");
            $form->setType("lu", "checkbox");
            $form->setType("contenu", "textarea");
            $form->setType("categorie", "text");
            $form->setType("destinataire", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_message", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("type", "text");
            $form->setType("emetteur", "text");
            $form->setType("date_emission", "text");
            $form->setType("lu", "checkbox");
            $form->setType("contenu", "textarea");
            $form->setType("categorie", "text");
            $form->setType("destinataire", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_message", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("type", "hiddenstatic");
            $form->setType("emetteur", "hiddenstatic");
            $form->setType("date_emission", "hiddenstatic");
            $form->setType("lu", "hiddenstatic");
            $form->setType("contenu", "hiddenstatic");
            $form->setType("categorie", "hiddenstatic");
            $form->setType("destinataire", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_message", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("type", "static");
            $form->setType("emetteur", "static");
            $form->setType("date_emission", "static");
            $form->setType("lu", "checkboxstatic");
            $form->setType("contenu", "textareastatic");
            $form->setType("categorie", "static");
            $form->setType("destinataire", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_message','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_message", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("type", 30);
        $form->setTaille("emetteur", 30);
        $form->setTaille("date_emission", 8);
        $form->setTaille("lu", 1);
        $form->setTaille("contenu", 80);
        $form->setTaille("categorie", 30);
        $form->setTaille("destinataire", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_message", 11);
        $form->setMax("dossier", 255);
        $form->setMax("type", 60);
        $form->setMax("emetteur", 63);
        $form->setMax("date_emission", 8);
        $form->setMax("lu", 1);
        $form->setMax("contenu", 6);
        $form->setMax("categorie", 60);
        $form->setMax("destinataire", 60);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_message', __('dossier_message'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('type', __('type'));
        $form->setLib('emetteur', __('emetteur'));
        $form->setLib('date_emission', __('date_emission'));
        $form->setLib('lu', __('lu'));
        $form->setLib('contenu', __('contenu'));
        $form->setLib('categorie', __('categorie'));
        $form->setLib('destinataire', __('destinataire'));
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

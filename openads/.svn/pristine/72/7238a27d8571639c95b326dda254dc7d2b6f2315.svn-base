<?php
//$Id$ 
//gen openMairie le 06/09/2022 16:16

require_once "../obj/om_dbform.class.php";

class instruction_notification_gen extends om_dbform {

    protected $_absolute_class_name = "instruction_notification";

    var $table = "instruction_notification";
    var $clePrimaire = "instruction_notification";
    var $typeCle = "N";
    var $required_field = array(
        "instruction",
        "instruction_notification"
    );
    
    var $foreign_keys_extended = array(
        "instruction" => array("instruction", "instruction_modale", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("instruction");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "instruction_notification",
            "instruction",
            "automatique",
            "emetteur",
            "date_envoi",
            "destinataire",
            "date_premier_acces",
            "statut",
            "commentaire",
            "courriel",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction() {
        return "SELECT instruction.instruction, instruction.destinataire FROM ".DB_PREFIXE."instruction ORDER BY instruction.destinataire ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction_by_id() {
        return "SELECT instruction.instruction, instruction.destinataire FROM ".DB_PREFIXE."instruction WHERE instruction = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['instruction_notification'])) {
            $this->valF['instruction_notification'] = ""; // -> requis
        } else {
            $this->valF['instruction_notification'] = $val['instruction_notification'];
        }
        if (!is_numeric($val['instruction'])) {
            $this->valF['instruction'] = ""; // -> requis
        } else {
            $this->valF['instruction'] = $val['instruction'];
        }
        if ($val['automatique'] == 1 || $val['automatique'] == "t" || $val['automatique'] == "Oui") {
            $this->valF['automatique'] = true;
        } else {
            $this->valF['automatique'] = false;
        }
        if ($val['emetteur'] == "") {
            $this->valF['emetteur'] = NULL;
        } else {
            $this->valF['emetteur'] = $val['emetteur'];
        }
            $this->valF['date_envoi'] = $val['date_envoi'];
        if ($val['destinataire'] == "") {
            $this->valF['destinataire'] = NULL;
        } else {
            $this->valF['destinataire'] = $val['destinataire'];
        }
            $this->valF['date_premier_acces'] = $val['date_premier_acces'];
        if ($val['statut'] == "") {
            $this->valF['statut'] = NULL;
        } else {
            $this->valF['statut'] = $val['statut'];
        }
        if ($val['commentaire'] == "") {
            $this->valF['commentaire'] = NULL;
        } else {
            $this->valF['commentaire'] = $val['commentaire'];
        }
        if ($val['courriel'] == "") {
            $this->valF['courriel'] = NULL;
        } else {
            $this->valF['courriel'] = $val['courriel'];
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
            $form->setType("instruction_notification", "hidden");
            if ($this->is_in_context_of_foreign_key("instruction", $this->retourformulaire)) {
                $form->setType("instruction", "selecthiddenstatic");
            } else {
                $form->setType("instruction", "select");
            }
            $form->setType("automatique", "checkbox");
            $form->setType("emetteur", "text");
            $form->setType("date_envoi", "text");
            $form->setType("destinataire", "text");
            $form->setType("date_premier_acces", "text");
            $form->setType("statut", "text");
            $form->setType("commentaire", "text");
            $form->setType("courriel", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("instruction_notification", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("instruction", $this->retourformulaire)) {
                $form->setType("instruction", "selecthiddenstatic");
            } else {
                $form->setType("instruction", "select");
            }
            $form->setType("automatique", "checkbox");
            $form->setType("emetteur", "text");
            $form->setType("date_envoi", "text");
            $form->setType("destinataire", "text");
            $form->setType("date_premier_acces", "text");
            $form->setType("statut", "text");
            $form->setType("commentaire", "text");
            $form->setType("courriel", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("instruction_notification", "hiddenstatic");
            $form->setType("instruction", "selectstatic");
            $form->setType("automatique", "hiddenstatic");
            $form->setType("emetteur", "hiddenstatic");
            $form->setType("date_envoi", "hiddenstatic");
            $form->setType("destinataire", "hiddenstatic");
            $form->setType("date_premier_acces", "hiddenstatic");
            $form->setType("statut", "hiddenstatic");
            $form->setType("commentaire", "hiddenstatic");
            $form->setType("courriel", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("instruction_notification", "static");
            $form->setType("instruction", "selectstatic");
            $form->setType("automatique", "checkboxstatic");
            $form->setType("emetteur", "static");
            $form->setType("date_envoi", "static");
            $form->setType("destinataire", "static");
            $form->setType("date_premier_acces", "static");
            $form->setType("statut", "static");
            $form->setType("commentaire", "static");
            $form->setType("courriel", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('instruction_notification','VerifNum(this)');
        $form->setOnchange('instruction','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("instruction_notification", 11);
        $form->setTaille("instruction", 11);
        $form->setTaille("automatique", 1);
        $form->setTaille("emetteur", 30);
        $form->setTaille("date_envoi", 8);
        $form->setTaille("destinataire", 30);
        $form->setTaille("date_premier_acces", 8);
        $form->setTaille("statut", 20);
        $form->setTaille("commentaire", 30);
        $form->setTaille("courriel", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("instruction_notification", 11);
        $form->setMax("instruction", 11);
        $form->setMax("automatique", 1);
        $form->setMax("emetteur", 255);
        $form->setMax("date_envoi", 8);
        $form->setMax("destinataire", 255);
        $form->setMax("date_premier_acces", 8);
        $form->setMax("statut", 20);
        $form->setMax("commentaire", 255);
        $form->setMax("courriel", 60);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('instruction_notification', __('instruction_notification'));
        $form->setLib('instruction', __('instruction'));
        $form->setLib('automatique', __('automatique'));
        $form->setLib('emetteur', __('emetteur'));
        $form->setLib('date_envoi', __('date_envoi'));
        $form->setLib('destinataire', __('destinataire'));
        $form->setLib('date_premier_acces', __('date_premier_acces'));
        $form->setLib('statut', __('statut'));
        $form->setLib('commentaire', __('commentaire'));
        $form->setLib('courriel', __('courriel'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // instruction
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instruction",
            $this->get_var_sql_forminc__sql("instruction"),
            $this->get_var_sql_forminc__sql("instruction_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('instruction', $this->retourformulaire))
                $form->setVal('instruction', $idxformulaire);
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
        // Verification de la cle secondaire : instruction_notification_document
        $this->rechercheTable($this->f->db, "instruction_notification_document", "instruction_notification", $id);
    }


}

<?php
//$Id$ 
//gen openMairie le 21/02/2022 17:12

require_once "../obj/om_dbform.class.php";

class instruction_notification_document_gen extends om_dbform {

    protected $_absolute_class_name = "instruction_notification_document";

    var $table = "instruction_notification_document";
    var $clePrimaire = "instruction_notification_document";
    var $typeCle = "N";
    var $required_field = array(
        "instruction",
        "instruction_notification",
        "instruction_notification_document"
    );
    var $unique_key = array(
      "cle",
    );
    var $foreign_keys_extended = array(
        "instruction_notification" => array("instruction_notification", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("instruction_notification");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "instruction_notification_document",
            "instruction_notification",
            "instruction",
            "cle",
            "annexe",
            "document_id",
            "document_type",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction_notification() {
        return "SELECT instruction_notification.instruction_notification, instruction_notification.instruction FROM ".DB_PREFIXE."instruction_notification ORDER BY instruction_notification.instruction ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instruction_notification_by_id() {
        return "SELECT instruction_notification.instruction_notification, instruction_notification.instruction FROM ".DB_PREFIXE."instruction_notification WHERE instruction_notification = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['instruction_notification_document'])) {
            $this->valF['instruction_notification_document'] = ""; // -> requis
        } else {
            $this->valF['instruction_notification_document'] = $val['instruction_notification_document'];
        }
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
            $this->valF['cle'] = $val['cle'];
        if ($val['annexe'] == 1 || $val['annexe'] == "t" || $val['annexe'] == "Oui") {
            $this->valF['annexe'] = true;
        } else {
            $this->valF['annexe'] = false;
        }
        if (!is_numeric($val['document_id'])) {
            $this->valF['document_id'] = NULL;
        } else {
            $this->valF['document_id'] = $val['document_id'];
        }
        if ($val['document_type'] == "") {
            $this->valF['document_type'] = NULL;
        } else {
            $this->valF['document_type'] = $val['document_type'];
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
            $form->setType("instruction_notification_document", "hidden");
            if ($this->is_in_context_of_foreign_key("instruction_notification", $this->retourformulaire)) {
                $form->setType("instruction_notification", "selecthiddenstatic");
            } else {
                $form->setType("instruction_notification", "select");
            }
            $form->setType("instruction", "text");
            $form->setType("cle", "textarea");
            $form->setType("annexe", "checkbox");
            $form->setType("document_id", "text");
            $form->setType("document_type", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("instruction_notification_document", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("instruction_notification", $this->retourformulaire)) {
                $form->setType("instruction_notification", "selecthiddenstatic");
            } else {
                $form->setType("instruction_notification", "select");
            }
            $form->setType("instruction", "text");
            $form->setType("cle", "textarea");
            $form->setType("annexe", "checkbox");
            $form->setType("document_id", "text");
            $form->setType("document_type", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("instruction_notification_document", "hiddenstatic");
            $form->setType("instruction_notification", "selectstatic");
            $form->setType("instruction", "hiddenstatic");
            $form->setType("cle", "hiddenstatic");
            $form->setType("annexe", "hiddenstatic");
            $form->setType("document_id", "hiddenstatic");
            $form->setType("document_type", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("instruction_notification_document", "static");
            $form->setType("instruction_notification", "selectstatic");
            $form->setType("instruction", "static");
            $form->setType("cle", "textareastatic");
            $form->setType("annexe", "checkboxstatic");
            $form->setType("document_id", "static");
            $form->setType("document_type", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('instruction_notification_document','VerifNum(this)');
        $form->setOnchange('instruction_notification','VerifNum(this)');
        $form->setOnchange('instruction','VerifNum(this)');
        $form->setOnchange('document_id','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("instruction_notification_document", 11);
        $form->setTaille("instruction_notification", 11);
        $form->setTaille("instruction", 11);
        $form->setTaille("cle", 80);
        $form->setTaille("annexe", 1);
        $form->setTaille("document_id", 11);
        $form->setTaille("document_type", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("instruction_notification_document", 11);
        $form->setMax("instruction_notification", 11);
        $form->setMax("instruction", 11);
        $form->setMax("cle", 6);
        $form->setMax("annexe", 1);
        $form->setMax("document_id", 11);
        $form->setMax("document_type", 100);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('instruction_notification_document', __('instruction_notification_document'));
        $form->setLib('instruction_notification', __('instruction_notification'));
        $form->setLib('instruction', __('instruction'));
        $form->setLib('cle', __('cle'));
        $form->setLib('annexe', __('annexe'));
        $form->setLib('document_id', __('document_id'));
        $form->setLib('document_type', __('document_type'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // instruction_notification
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instruction_notification",
            $this->get_var_sql_forminc__sql("instruction_notification"),
            $this->get_var_sql_forminc__sql("instruction_notification_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('instruction_notification', $this->retourformulaire))
                $form->setVal('instruction_notification', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}

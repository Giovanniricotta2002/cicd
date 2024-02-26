<?php
//$Id$ 
//gen openMairie le 23/06/2022 12:32

require_once "../obj/om_dbform.class.php";

class task_gen extends om_dbform {

    protected $_absolute_class_name = "task";

    var $table = "task";
    var $clePrimaire = "task";
    var $typeCle = "N";
    var $required_field = array(
        "task",
        "type"
    );
    
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("type");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "task",
            "type",
            "timestamp_log",
            "state",
            "object_id",
            "dossier",
            "json_payload",
            "stream",
            "category",
            "creation_date",
            "creation_time",
            "last_modification_date",
            "last_modification_time",
            "comment",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['task'])) {
            $this->valF['task'] = ""; // -> requis
        } else {
            $this->valF['task'] = $val['task'];
        }
        $this->valF['type'] = $val['type'];
            $this->valF['timestamp_log'] = $val['timestamp_log'];
        if ($val['state'] == "") {
            $this->valF['state'] = ""; // -> default
        } else {
            $this->valF['state'] = $val['state'];
        }
        if ($val['object_id'] == "") {
            $this->valF['object_id'] = NULL;
        } else {
            $this->valF['object_id'] = $val['object_id'];
        }
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
        }
            $this->valF['json_payload'] = $val['json_payload'];
        if ($val['stream'] == "") {
            $this->valF['stream'] = NULL;
        } else {
            $this->valF['stream'] = $val['stream'];
        }
        if ($val['category'] == "") {
            $this->valF['category'] = NULL;
        } else {
            $this->valF['category'] = $val['category'];
        }
        if ($val['creation_date'] != "") {
            $this->valF['creation_date'] = $this->dateDB($val['creation_date']);
        } else {
            $this->valF['creation_date'] = NULL;
        }
            $this->valF['creation_time'] = $val['creation_time'];
        if ($val['last_modification_date'] != "") {
            $this->valF['last_modification_date'] = $this->dateDB($val['last_modification_date']);
        } else {
            $this->valF['last_modification_date'] = NULL;
        }
            $this->valF['last_modification_time'] = $val['last_modification_time'];
            $this->valF['comment'] = $val['comment'];
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
            $form->setType("task", "hidden");
            $form->setType("type", "text");
            $form->setType("timestamp_log", "textarea");
            $form->setType("state", "text");
            $form->setType("object_id", "text");
            $form->setType("dossier", "text");
            $form->setType("json_payload", "textarea");
            $form->setType("stream", "text");
            $form->setType("category", "text");
            $form->setType("creation_date", "date");
            $form->setType("creation_time", "text");
            $form->setType("last_modification_date", "date");
            $form->setType("last_modification_time", "text");
            $form->setType("comment", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("task", "hiddenstatic");
            $form->setType("type", "text");
            $form->setType("timestamp_log", "textarea");
            $form->setType("state", "text");
            $form->setType("object_id", "text");
            $form->setType("dossier", "text");
            $form->setType("json_payload", "textarea");
            $form->setType("stream", "text");
            $form->setType("category", "text");
            $form->setType("creation_date", "date");
            $form->setType("creation_time", "text");
            $form->setType("last_modification_date", "date");
            $form->setType("last_modification_time", "text");
            $form->setType("comment", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("task", "hiddenstatic");
            $form->setType("type", "hiddenstatic");
            $form->setType("timestamp_log", "hiddenstatic");
            $form->setType("state", "hiddenstatic");
            $form->setType("object_id", "hiddenstatic");
            $form->setType("dossier", "hiddenstatic");
            $form->setType("json_payload", "hiddenstatic");
            $form->setType("stream", "hiddenstatic");
            $form->setType("category", "hiddenstatic");
            $form->setType("creation_date", "hiddenstatic");
            $form->setType("creation_time", "hiddenstatic");
            $form->setType("last_modification_date", "hiddenstatic");
            $form->setType("last_modification_time", "hiddenstatic");
            $form->setType("comment", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("task", "static");
            $form->setType("type", "static");
            $form->setType("timestamp_log", "textareastatic");
            $form->setType("state", "static");
            $form->setType("object_id", "static");
            $form->setType("dossier", "static");
            $form->setType("json_payload", "textareastatic");
            $form->setType("stream", "static");
            $form->setType("category", "static");
            $form->setType("creation_date", "datestatic");
            $form->setType("creation_time", "static");
            $form->setType("last_modification_date", "datestatic");
            $form->setType("last_modification_time", "static");
            $form->setType("comment", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('task','VerifNum(this)');
        $form->setOnchange('creation_date','fdate(this)');
        $form->setOnchange('last_modification_date','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("task", 11);
        $form->setTaille("type", 30);
        $form->setTaille("timestamp_log", 80);
        $form->setTaille("state", 20);
        $form->setTaille("object_id", 30);
        $form->setTaille("dossier", 30);
        $form->setTaille("json_payload", 80);
        $form->setTaille("stream", 10);
        $form->setTaille("category", 30);
        $form->setTaille("creation_date", 12);
        $form->setTaille("creation_time", 8);
        $form->setTaille("last_modification_date", 12);
        $form->setTaille("last_modification_time", 8);
        $form->setTaille("comment", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("task", 11);
        $form->setMax("type", 30);
        $form->setMax("timestamp_log", 6);
        $form->setMax("state", 20);
        $form->setMax("object_id", 30);
        $form->setMax("dossier", 30);
        $form->setMax("json_payload", 6);
        $form->setMax("stream", -5);
        $form->setMax("category", 2000);
        $form->setMax("creation_date", 12);
        $form->setMax("creation_time", 8);
        $form->setMax("last_modification_date", 12);
        $form->setMax("last_modification_time", 8);
        $form->setMax("comment", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('task', __('task'));
        $form->setLib('type', __('type'));
        $form->setLib('timestamp_log', __('timestamp_log'));
        $form->setLib('state', __('state'));
        $form->setLib('object_id', __('object_id'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('json_payload', __('json_payload'));
        $form->setLib('stream', __('stream'));
        $form->setLib('category', __('category'));
        $form->setLib('creation_date', __('creation_date'));
        $form->setLib('creation_time', __('creation_time'));
        $form->setLib('last_modification_date', __('last_modification_date'));
        $form->setLib('last_modification_time', __('last_modification_time'));
        $form->setLib('comment', __('comment'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}
